<?php
namespace Qiq\Html\Helper;

class FormTest extends HtmlHelperTest
{
    public function test()
    {
        $actual = $this->helper([
            'method' => 'post',
            'action' => 'http://example.com/',
        ]);
        $expect = '<form method="post" action="http://example.com/" enctype="multipart/form-data">';
        $this->assertSame($actual, $expect);
    }
}
