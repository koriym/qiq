<?php
namespace Qiq\Helper\Html;

class ImageTest extends HtmlHelperTest
{
    public function test()
    {
        $src = '/images/example.gif';
        $actual = $this->helper($src);
        $expect = '<img src="/images/example.gif" alt="example.gif" />';
        $this->assertSame($actual, $expect);
    }
}