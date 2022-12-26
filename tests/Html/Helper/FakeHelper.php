<?php
namespace Qiq\Html\Helper;

class FakeHelper extends HtmlHelper
{
    public function __invoke(string $noun) : string
    {
        return "Hello $noun";
    }
}
