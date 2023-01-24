<?php
namespace Qiq\Helper\Html;

class TextareaTest extends HtmlHelperTest
{
    public function test()
    {
        $actual = $this->helpers->textarea([
            'name' => 'field',
            'value' => "the quick & brown fox",
        ]);

        $expect = '<textarea name="field">the quick &amp; brown fox</textarea>';

        $this->assertSame($expect, $actual);
    }
}
