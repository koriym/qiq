<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

use Qiq\Indent;

class Items extends TagHelper
{
    /**
     * @param stringy-array $items
     */
    public function __invoke(array $items) : string
    {
        return $this->items($items);
    }

    /**
     * @param stringy-array $items
     */
    protected function items(array $items) : string
    {
        $html = '';

        /** @var stringy $item */
        foreach ($items as $item) {
            $html .= $this->indent->get() . $this->fullTag('li', [], $item) . PHP_EOL;
        }

        return $html;
    }
}
