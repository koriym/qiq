<?php
declare(strict_types=1);

namespace Qiq;

use FilesystemIterator;
use Qiq\Compiler\Compiler;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class Catalog
{
    protected array $paths = [];

    protected array $found = [];

    public function __construct(
        array $paths = [],
        protected string $extension = '.php',
    ) {
        $this->setPaths($paths);
    }

    protected function find(string $key) : ?string
    {
        if (isset($this->found[$key])) {
            return $this->found[$key];
        }

        list($collection, $name) = $this->split($key);
        $name = str_replace('/', DIRECTORY_SEPARATOR, $name);

        foreach ($this->paths[$collection] as $path) {
            $file = $path . DIRECTORY_SEPARATOR . $name . $this->extension;
            if (is_readable($file)) {
                $this->found[$key] = $file;
                return $file;
            }
        }

        return null;
    }

    public function has(string $name) : bool
    {
        return $this->find($name) !== null;
    }

    public function get(Compiler $compiler, string $name) : string
    {
        $source = $this->find($name);

        if ($source !== null) {
            return $compiler($source);
        }

        list ($collection, $name) = $this->split($name);

        throw new Exception\FileNotFound(PHP_EOL
            . "Template: $name" . PHP_EOL
            . "Extension: {$this->extension}" . PHP_EOL
            . "Collection: " . ($collection === '' ? '(default)' : $collection) . PHP_EOL
            . "Paths: " . print_r($this->paths[$collection], true)
        );
    }

    public function getPaths() : array
    {
        return $this->paths;
    }

    public function prependPath(string $path) : void
    {
        list ($collection, $path) = $this->split($path);
        array_unshift($this->paths[$collection], $this->fixPath($path));
        $this->found = [];
    }

    public function appendPath(string $path) : void
    {
        list ($collection, $path) = $this->split($path);
        $this->paths[$collection][] = $this->fixPath($path);
        $this->found = [];
    }

    public function setPaths(array $paths) : void
    {
        $this->paths = [];

        foreach ($paths as $path) {
            list ($collection, $path) = $this->split($path);
            $this->paths[$collection][] = $this->fixPath($path);
        }

        $this->found = [];
    }

    public function compile(Compiler $compiler) : array
    {
        $compiled = [];

        foreach ($this->paths as $collection => $paths) {
            foreach ($paths as $path) {
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator(
                        $path,
                        FilesystemIterator::SKIP_DOTS
                    ),
                    RecursiveIteratorIterator::CHILD_FIRST
                );

                /** @var SplFileInfo $file */
                foreach ($files as $file) {
                    $source = $file->getPathname();
                    if (str_ends_with($source, $this->extension)) {
                        $compiled[] = $compiler($source);
                    }
                }
            }
        }

        return $compiled;
    }

    protected function fixPath(string $path) : string
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
        return rtrim($path, DIRECTORY_SEPARATOR);
    }

    protected function split(string $spec) : array
    {
        if (strpos($spec, '..') !== false) {
            throw new Exception\FileNotFound(
                "Double-dots not allowed in file specifications: {$spec}"
            );
        }

        $offset = (PHP_OS_FAMILY === 'Windows') ? 2 : 0;
        $pos = strpos($spec, ':', $offset);

        if (! $pos) {
            // not present, or at character zero
            $collection = '__DEFAULT__';
        } else {
            $collection = substr($spec, 0, $pos);
            $spec = substr($spec, $pos + 1);
        }

        if (! isset($this->paths[$collection])) {
            $this->paths[$collection] = [];
        }

        return [
            $collection,
            $spec
        ];
    }
}
