<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

use Qiq\Indent;

class Ul extends Items
{
    /**
     * @param stringy-array $items
     * @param stringy-array $attr
     */
    public function __invoke(array $items, array $attr = []) : string
    {
        $this->indent->level(+1);
        $list = $this->items($items);
        $this->indent->level(-1);

        if ($list === '') {
            return '';
        }

        return $this->openTag('ul', $attr) . PHP_EOL
            . $list
            . $this->indent->get() . '</ul>';
    }
}
