<?php
namespace Qiq\Html\Helper;

class BaseTest extends HtmlHelperTest
{
    public function test()
    {
        $href = '/path/to/base';
        $actual = $this->helper($href);
        $expect = '<base href="/path/to/base" />';
        $this->assertSame($expect, $actual);
    }
}