<?php
namespace Qiq;

use ParseError;
use Qiq\Compiler\Compiler;
use Qiq\Helper\Html\HtmlHelpers;

class TemplateTest extends \PHPUnit\Framework\TestCase
{
    protected FakeTemplate $template;

    protected function setUp() : void
    {
        $this->template = FakeTemplate::new();
        $catalog = $this->template->getCatalog();
        $catalog->setPaths([__DIR__ . '/templates']);
    }

    public function testMagicMethods() : void
    {
        $this->assertFalse(isset($this->template->foo));

        $this->template->foo = 'bar';
        $this->assertTrue(isset($this->template->foo));
        $this->assertSame('bar', $this->template->foo);

        unset($this->template->foo);
        $this->assertFalse(isset($this->template->foo));

        $actual = $this->template->h('foo & bar');
        $this->assertSame('foo &amp; bar', $actual);
    }

    public function testGetters() : void
    {
        $this->assertInstanceOf(Catalog::class, $this->template->getCatalog());
        $this->assertInstanceOf(Compiler::class, $this->template->getCompiler());
        $this->assertInstanceOf(Helpers::class, $this->template->getHelpers());
    }

    public function testSetIndent() : void
    {
        $container = new Container();
        $indent = $container->get(Indent::class);

        $template = Template::new(helpers: new Helpers($container));

        $expect = 'foo';
        $template->setIndent($expect);
        $actual = $indent->get();
        $this->assertSame($expect, $actual);
    }

    public function testSetAddAndGetData() : void
    {
        $data = ['foo' => 'bar'];
        $this->template->setData($data);

        $data = ['baz' => 'dib'];
        $this->template->addData($data);

        $expect = ['foo' => 'bar', 'baz' => 'dib'];
        $actual = (array) $this->template->getData();
        $this->assertSame($expect, $actual);
    }

    public function testInvokeOneStep() : void
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

    public function testInvokeTwoStep() : void
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

    public function testPartial() : void
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

    public function testSections() : void
    {
        $this->template->setView('sections');
        $actual = ($this->template)();
        $expect = 'false' . PHP_EOL
            . 'true' . PHP_EOL
            . 'bazfoobar';
        $this->assertSame($expect, $actual);
    }

    public function testException() : void
    {
        $this->template->setView('exception');
        $this->expectException(ParseError::class);
        $actual = ($this->template)();
    }
}
