<?php
declare(strict_types=1);

namespace Qiq\Html\Helper;

use Qiq\Indent;

class Items extends HtmlHelper
{
    public function __invoke(array $items) : string
    {
        return $this->items($items);
    }

    protected function items(array $items) : string
    {
        $html = '';

        foreach ($items as $item) {
            $html .= $this->indent->get() . $this->fullTag('li', [], $item) . PHP_EOL;
        }

        return $html;
    }
}
