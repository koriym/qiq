<?php
namespace Qiq\Helper\Html;

class BaseTest extends HtmlHelperTest
{
    public function test()
    {
        $href = '/path/to/base';
        $actual = $this->helpers->base($href);
        $expect = '<base href="/path/to/base" />';
        $this->assertSame($expect, $actual);
    }
}
