<?php
namespace Qiq\Html\Helper;

class LinkStylesheetTest extends HtmlHelperTest
{
    public function test()
    {
        $actual = $this->helper('style.css');
        $expect = '<link rel="stylesheet" href="style.css" type="text/css" media="screen" />';
        $this->assertSame($expect, $actual);
    }
}
