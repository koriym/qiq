<?php
declare(strict_types=1);

namespace Qiq;

/**
 * statics will be a problem with mutiple templates.
 * this may need to be a helper.
 *
 * hm, except compiler needs it, and maybe different formats need it.
 * make it a Template method directly?
 */
class Indent
{
    protected string $indent = '    ';

    protected string $base = '';

    protected int $level = 0;

    public function set(string $base) : void
    {
        $this->base = $base;
    }

    public function level(int $level) : void
    {
        $this->level += $level;
    }

    public function get(int $add = 0) : string
    {
        return $this->base
            . str_repeat($this->indent, $this->level + $add);
    }
}
