<?php
namespace Qiq\Html\Helper;

class MetaTest extends HtmlHelperTest
{
    public function test()
    {
        $actual = $this->helper(['charset' => 'utf-8']);
        $expect = '<meta charset="utf-8" />';
        $this->assertSame($expect, $actual);
    }
}
