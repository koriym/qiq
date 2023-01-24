<?php
namespace Qiq\Helper\Html;

class LinkTest extends HtmlHelperTest
{
    public function test()
    {
        $actual = $this->helpers->link('prev', '/path/to/prev', ['foo' => 'bar']);
        $expect = '<link rel="prev" href="/path/to/prev" foo="bar" />';
        $this->assertSame($expect, $actual);
    }
}
