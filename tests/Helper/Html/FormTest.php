<?php
namespace Qiq\Helper\Html;

class FormTest extends HtmlHelperTest
{
    public function test()
    {
        $actual = $this->helpers->form([
            'method' => 'post',
            'action' => 'http://example.com/',
        ]);
        $expect = '<form method="post" action="http://example.com/" enctype="multipart/form-data">';
        $this->assertSame($actual, $expect);
    }
}
