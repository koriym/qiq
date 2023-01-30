<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

use Qiq\Indent;

class Items extends TagHelper
{
    /**
     * @param string[] $items
     */
    public function __invoke(array $items) : string
    {
        return $this->items($items);
    }

    /**
     * @param string[] $items
     */
    protected function items(array $items) : string
    {
        $html = '';

        foreach ($items as $item) {
            $html .= $this->indent->get() . $this->fullTag('li', [], $item) . PHP_EOL;
        }

        return $html;
    }
}
