<?php
namespace Qiq\Html\Helper;

class MetaNameTest extends HtmlHelperTest
{
    public function test()
    {
        $actual = $this->helper('foo', 'bar');
        $expect = '<meta name="foo" content="bar" />';
        $this->assertSame($expect, $actual);
    }
}
