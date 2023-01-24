<?php
namespace Qiq\Helper\Html;

class LinkStylesheetTest extends HtmlHelperTest
{
    public function test()
    {
        $actual = $this->helpers->linkStylesheet('style.css');
        $expect = '<link rel="stylesheet" href="style.css" type="text/css" media="screen" />';
        $this->assertSame($expect, $actual);
    }
}
