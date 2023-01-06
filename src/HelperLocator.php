<?php
declare(strict_types=1);

namespace Qiq;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionMethod;
use ReflectionType;
use ReflectionNamedType;
use ReflectionParameter;
use RuntimeException;
use Qiq\Exception;

/**
 * This is a low-powered container to handle only basic constructor DI.
 * You can configure arguments by passing `$config['className']['parameterName']`.
 *
 * Parameter resolution:
 *
 * - First, use a parameter value from $config, if one is available.
 * - Next, try to get an object of the parameter type from the the HelperLocator.
 * - Last, use the default parameter value, if one is defined.
 *
 * If none of these work, you'll get a RuntimeException.
 *
 * @todo use an ParameterNotResolvable execption instead of RuntimeException.
 */
class HelperLocator implements ContainerInterface
{
    /**
     * @var object[]
     */
    protected array $instances = [];

    public function __construct(protected array $config = [])
    {
    }

    /**
     * @template T of object
     * @param class-string<T> $class
     * @return T of object
     */
    public function get(string $class) : object
    {
        if (! isset($this->instances[$class])) {
            $this->instances[$class] = $this->new($class);
        }

        /** @var T of object */
        return $this->instances[$class];
    }

    public function has(string $class) : bool
    {
        return class_exists($class);
    }

    /**
     * @template T of object
     * @param class-string<T> $class
     * @return T of object
     */
    protected function new(string $class) : object
    {
        if (! $this->has($class)) {
            throw new Exception\HelperNotFound(
                "Helper of class '{$class}' does not exist."
            );
        }

        $constructor = (new ReflectionClass($class))->getConstructor();
        $arguments = $constructor
            ? $this->arguments($class, $constructor)
            : [];

        /** @var T of object */
        return new $class(...$arguments);
    }

    protected function arguments(
        string $declaringClass,
        ReflectionMethod $constructor
    ) : array
    {
        $arguments = [];
        $parameters = $constructor->getParameters();

        foreach ($parameters as $parameter) {
            $arguments[] = $this->argument($declaringClass, $parameter);
        }

        return $arguments;
    }

    protected function argument(
        string $declaringClass,
        ReflectionParameter $parameter,
    ) : mixed
    {
        $name = $parameter->getName();

        if (isset($this->config[$declaringClass][$name])) {
            return $this->config[$declaringClass][$name];
        }

        $type = $parameter->getType();

        if (! $type instanceof ReflectionNamedType) {
            return $this->default($declaringClass, $parameter, $name, $type);
        }

        /** @var class-string */
        $parameterClass = $type->getName();

        if ($this->has($parameterClass)) {
            return $this->get($parameterClass);
        }

        return $this->default($declaringClass, $parameter, $name, $type);
    }

    protected function default(
        string $declaringClass,
        ReflectionParameter $parameter,
        string $name,
        ?ReflectionType $type,
    ) : mixed
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        $message = "Cannot create argument for '{$declaringClass}::\${$name}' of type '{$type}'.";
        throw new RuntimeException($message);
    }
}
