<?php
namespace Qiq\Compiler;

use Qiq\TemplateCore;

class FakeCompiler implements Compiler
{
    public function __invoke(string $source) : string
    {
        return $source;
    }

    public function clear() : void
    {
    }
}
