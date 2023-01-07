<?php
namespace Qiq\Helper\Html;

class FakeHelper extends HtmlHelper
{
    public function __invoke(string $noun) : string
    {
        return "Hello $noun";
    }
}
