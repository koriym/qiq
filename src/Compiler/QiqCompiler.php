<?php
declare(strict_types=1);

namespace Qiq\Compiler;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class QiqCompiler implements Compiler
{
    protected array $cached = [];

    protected string $cachePath;

    public function __construct(string $cachePath = null)
    {
        $this->cachePath = $cachePath
            ?? rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'qiq';
    }

    public function __invoke(string $source) : string
    {
        if (isset($this->cached[$source])) {
            return $this->cached[$source];
        }

        $append = (PHP_OS_FAMILY === 'Windows')
            ? substr($source, 2)
            : $source;

        $cached = $this->cachePath . $append;

        if (! $this->isCompiled($source, $cached)) {
            $this->compile($source, $cached);
        }

        return $cached;
    }

    public function clear() : void
    {
        if (! is_dir($this->cachePath)) {
            return;
        }

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $this->cachePath,
                FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }

        $this->cached = [];
    }

    protected function isCompiled(string $source, string $cached) : bool
    {
        $dir = dirname($cached);

        if (! is_dir($dir)) {
            mkdir($dir, 0777, true);
            return false;
        }

        if (! is_readable($cached)) {
            return false;
        }

        if (filemtime($cached) < filemtime($source)) {
            return false;
        }

        return true;
    }

    protected function compile(string $source, string $cached) : void
    {
        $text = (string) file_get_contents($source);

        $parts = preg_split(
            '/(\s*{{.*?}}\s*)/ms',
            $text,
            -1,
            PREG_SPLIT_DELIM_CAPTURE
        );

        $code = '';

        foreach ((array) $parts as $part) {
            $token = $this->newToken((string) $part);
            $code .= $token === null
                ? $this->embrace((string) $part)
                : $token->compile();
        }

        file_put_contents($cached, $code);
        $this->cached[$source] = $cached;
    }

    protected function embrace(string $part) : string
    {
        return strtr($part, [
            '{\\{' => '{{',
            '}\\}' => '}}',
        ]);
    }

    protected function newToken(string $part) : ?QiqToken
    {
        return QiqToken::new($part);
    }
}
