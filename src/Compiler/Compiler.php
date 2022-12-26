<?php
declare(strict_types=1);

namespace Qiq\Compiler;

use Qiq\TemplateCore;

interface Compiler
{
    public function __invoke(TemplateCore $template, string $source) : string;

    public function clear() : void;
}
