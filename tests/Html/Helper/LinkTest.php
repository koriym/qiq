<?php
namespace Qiq\Html\Helper;

class LinkTest extends HtmlHelperTest
{
    public function test()
    {
        $actual = $this->helper('prev', '/path/to/prev', ['foo' => 'bar']);
        $expect = '<link rel="prev" href="/path/to/prev" foo="bar" />';
        $this->assertSame($expect, $actual);
    }
}
