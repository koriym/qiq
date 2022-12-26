<?php
namespace Qiq\Html\Helper;

class MetaHttpTest extends HtmlHelperTest
{
    public function test()
    {
        $actual = $this->helper('Location', '/redirect/to/here/');
        $expect = '<meta http-equiv="Location" content="/redirect/to/here/" />';
        $this->assertSame($expect, $actual);
    }
}
