<?php
namespace Qiq\Helper\Html;

class LabelTest extends HtmlHelperTest
{
    public function test()
    {
        $attr = [
            'for' => 'bar',
            'class' => 'zim'
        ];
        $actual = $this->helper('Foo', $attr);
        $expect = '<label for="bar" class="zim">Foo</label>';
        $this->assertSame($actual, $expect);
    }
}
