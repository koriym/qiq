<?php
namespace Qiq\Html\Helper;

class RadioFieldTest extends HtmlHelperTest
{
    public function test()
    {
        $actual = $this->helper([
            'name' => 'foo',
            'value' => 'no',
            '_default' => '',
            '_options' => [
                'yes' => 'Yes',
                'no' => 'No',
                'maybe' => 'May & be'
            ]
        ]);

        $expect = '<input type="hidden" name="foo" value="" />' . PHP_EOL
            . '<label><input type="radio" name="foo" value="yes" />Yes</label>' . PHP_EOL
            . '<label><input type="radio" name="foo" value="no" checked />No</label>' . PHP_EOL
            . '<label><input type="radio" name="foo" value="maybe" />May &amp; be</label>' . PHP_EOL;

        $this->assertSame($expect, $actual);
    }
}
