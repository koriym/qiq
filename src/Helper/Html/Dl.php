<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

use Qiq\Indent;

class Dl extends TagHelper
{
    /**
     * @param string[] $terms
     * @param array<string, string|string[]> $attr
     */
    public function __invoke(array $terms, array $attr = []) : string
    {
        $this->indent->level(+1);
        $list = $this->terms($terms);
        $this->indent->level(-1);

        if ($list === '') {
            return '';
        }

        return $this->openTag('dl', $attr) . PHP_EOL
            . $list
            . $this->indent->get() . '</dl>';
    }

    /**
     * @param string[] $terms
     */
    protected function terms(array $terms) : string
    {
        $html = '';

        foreach ($terms as $term => $defs) {
            $html .= $this->indent->get() . $this->fullTag('dt', [], $term) . PHP_EOL;

            foreach ((array) $defs as $def) {
                $html .= $this->indent->get(+1) . $this->fullTag('dd', [], $def) . PHP_EOL;
            }
        }

        return $html;
    }
}
