<?php
namespace Qiq\Helper\Html;

class MetaNameTest extends HtmlHelperTest
{
    public function test()
    {
        $actual = $this->helpers->metaName('foo', 'bar');
        $expect = '<meta name="foo" content="bar" />';
        $this->assertSame($expect, $actual);
    }
}
