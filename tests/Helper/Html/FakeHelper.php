<?php
namespace Qiq\Helper\Html;

class FakeHelper extends TagHelper
{
    public function __invoke(string $noun) : string
    {
        return "Hello $noun";
    }
}
