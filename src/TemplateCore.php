<?php
declare(strict_types=1);

namespace Qiq;

use Psr\Container\ContainerInterface;
use Qiq\Compiler\Compiler;
use Qiq\Compiler\QiqCompiler;
use stdClass;

abstract class TemplateCore
{
    static public function new(
        string|array $paths = [],
        string $extension = '.php',
        HelperLocator $helperLocator = null,
        Compiler $compiler = null,
    ) : static
    {
        $helperLocator ??= new HelperLocator();
        $compiler ??= new QiqCompiler();
        $templateLocator = new TemplateLocator(
            (array) $paths,
            $extension,
            $compiler,
        );

        return new static(
            $templateLocator,
            $helperLocator
        );
    }

    private Indent $indent;

    private string $content = '';

    private array $data = [];

    private ?string $layout = null;

    private array $sections = [];

    private array $sectionStack = [];

    private ?string $view = null;

    public function __construct(
        private TemplateLocator $templateLocator,
        private ContainerInterface $helperLocator
    ) {
        /** @phpstan-ignore-next-line PHPStan fails to recognize the type. */
        $this->indent = $this->helperLocator->get(Indent::class);
    }

    public function __invoke() : string
    {
        $view = $this->getView();
        $this->content = ($view === null) ? '' : $this->render($view);
        $layout = $this->getLayout();

        if ($layout === null) {
            return $this->content;
        }

        return $this->render($layout);
    }

    public function __get(string $key) : mixed
    {
        return $this->data[$key];
    }

    public function __set(string $key, mixed $val) : void
    {
        $this->data[$key] = $val;
    }

    public function __isset(string $key) : bool
    {
        return isset($this->data[$key]);
    }

    public function __unset(string $key) : void
    {
        unset($this->data[$key]);
    }

    public function setIndent(string $base) : void
    {
        $this->indent->set($base);
    }

    public function setData(array|stdClass $data) : void
    {
        $this->data = (array) $data;
    }

    public function addData(array|stdClass $data) : void
    {
        $this->data = array_replace($this->data, (array) $data);
    }

    public function getData() : array
    {
        return $this->data;
    }

    public function &refData() : array
    {
        return $this->data;
    }

    /**
     * @template T of object
     * @param class-string<T> $class
     * @return T of object
     */
    public function getHelper(string $class) : object
    {
        /** @var T of object */
        return $this->helperLocator->get($class);
    }

    public function setLayout(?string $layout) : void
    {
        $this->layout = $layout;
    }

    public function getLayout() : ?string
    {
        return $this->layout;
    }

    public function setView(?string $view) : void
    {
        $this->view = $view;
    }

    public function getView() : ?string
    {
        return $this->view;
    }

    public function getHelperLocator() : ContainerInterface
    {
        return $this->helperLocator;
    }

    public function getTemplateLocator() : TemplateLocator
    {
        return $this->templateLocator;
    }

    public function hasTemplate(string $name) : bool
    {
        return $this->templateLocator->has($name);
    }

    public function getTemplate(string $name) : string
    {
        return $this->templateLocator->get($this, $name);
    }

    public function getContent() : string
    {
        return $this->content;
    }

    public function hasSection(string $name) : bool
    {
        return isset($this->sections[$name]);
    }

    public function getSection(string $name) : ?string
    {
        return $this->sections[$name] ?? null;
    }

    public function setSection(string $name) : void
    {
        $this->sectionStack[] = [__FUNCTION__, $name];
        ob_start();
    }

    public function appendSection(string $name) : void
    {
        $this->sectionStack[] = [__FUNCTION__, $name];
        ob_start();
    }

    public function prependSection(string $name) : void
    {
        $this->sectionStack[] = [__FUNCTION__, $name];
        ob_start();
    }

    public function endSection() : void
    {
        list($func, $name) = array_pop($this->sectionStack);
        $buffer = (string) ob_get_clean();

        if (! $this->hasSection($name)) {
            $this->sections[$name] = '';
        }

        switch ($func) {
            case 'appendSection':
                $this->sections[$name] .= $buffer;
                return;
            case 'prependSection':
                $this->sections[$name] = $buffer . $this->sections[$name];
                return;
            default:
                $this->sections[$name] = $buffer;
                return;
        }
    }

    abstract public function render(
        string $__NAME__,
        array $__LOCAL__ = []
    ) : string;
}
