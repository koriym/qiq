<?php
namespace Qiq;

use ParseError;

class TemplateTest extends \PHPUnit\Framework\TestCase
{
    protected $template;

    protected function setUp() : void
    {
        $this->template = Template::new();
        $templateLocator = $this->template->getTemplateLocator();
        $templateLocator->setPaths([__DIR__ . '/templates']);
    }

    public function testMagicMethods()
    {
        $this->assertFalse(isset($this->template->foo));

        $this->template->foo = 'bar';
        $this->assertTrue(isset($this->template->foo));
        $this->assertSame('bar', $this->template->foo);

        unset($this->template->foo);
        $this->assertFalse(isset($this->template->foo));
    }

    public function testGetters()
    {
        $this->assertInstanceOf(TemplateLocator::class, $this->template->getTemplateLocator());
        $this->assertInstanceOf(HelperLocator::class, $this->template->getHelperLocator());
        $this->assertInstanceOf(Indent::class, $this->template->getHelper(Indent::class));
    }

    public function testSetIndent()
    {
        $expect = 'foo';
        $this->template->setIndent($expect);
        $actual = $this->template->getHelper(Indent::class)->get();
        $this->assertSame($expect, $actual);
    }
    public function testSetAddAndGetData()
    {
        $data = ['foo' => 'bar'];
        $this->template->setData($data);
        $this->assertSame('bar', $this->template->foo);

        $data = ['baz' => 'dib'];
        $this->template->addData($data);
        $this->assertSame('dib', $this->template->baz);

        $expect = ['foo' => 'bar', 'baz' => 'dib'];
        $actual = (array) $this->template->getData();
        $this->assertSame($expect, $actual);
    }

    public function testInvokeOneStep()
    {
        $this->template->setData([
            'name' => 'Index',
            'title' => 'Title'
        ]);
        $this->template->setView('index');
        $actual = ($this->template)();
        $expect = "Hello Index!";
        $this->assertSame($expect, $actual);
    }

    public function testInvokeTwoStep()
    {
        // also tests that "assigned" vars are shared
        $this->template->setData([
            'name' => 'Index',
            'title' => 'Title'
        ]);
        $this->template->setView('index');
        $this->template->setLayout('layout/default');
        $actual = ($this->template)();
        $expect = "Changed Title -- before -- Hello Index! -- after";
        $this->assertSame($expect, $actual);
    }

    public function testPartial()
    {
        // also tests that "local" vars are not shared
        $this->template->setView('master');
        $actual = ($this->template)();
        $expect = "foo = bar" . PHP_EOL
                . "foo = baz" . PHP_EOL
                . "foo = dib" . PHP_EOL
                . 'dib' . PHP_EOL;
        $this->assertSame($expect, $actual);
    }

    public function testSections()
    {
        $this->template->setView('sections');
        $actual = ($this->template)();
        $expect = 'false' . PHP_EOL
            . 'true' . PHP_EOL
            . 'bazfoobar';
        $this->assertSame($expect, $actual);
    }

    public function testException()
    {
        $this->template->setView('exception');
        $this->expectException(ParseError::class);
        $actual = ($this->template)();
    }

    public function testHasTemplate()
    {
        $this->assertTrue($this->template->hasTemplate('master'));
        $this->assertFalse($this->template->hasTemplate('nonesuch'));
    }
}
