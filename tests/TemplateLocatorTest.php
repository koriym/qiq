<?php
namespace Qiq;

use Qiq\Compiler\QiqCompiler;
use Qiq\Compiler\FakeCompiler;
use Qiq\Html\HtmlTemplate;

class TemplateLocatorTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp() : void
    {
        $this->template = Template::new();
        $this->templateLocator = $this->newTemplateLocator();
        $this->templateLocator->clear();
    }

    protected function newTemplateLocator(array $paths = [])
    {
        return new TemplateLocator($paths, '.php', new FakeCompiler());
    }

    public function testHasGet()
    {
        $this->templateLocator->setPaths([__DIR__ . '/templates']);

        $this->assertTrue($this->templateLocator->has('index'));
        $actual = $this->templateLocator->get($this->template, 'index');

        $expect = str_replace('/', DIRECTORY_SEPARATOR, __DIR__ . '/templates/index.php');
        $this->assertSame($expect, $actual);

        $this->assertFalse($this->templateLocator->has('no-such-template'));
        $this->expectException(Exception\TemplateNotFound::class);
        $this->templateLocator->get($this->template,'no-such-template');
    }

    public function testDoubleDots()
    {
        $this->expectException(Exception\TemplateNotFound::class);
        $this->expectExceptionMessage("Double-dots not allowed in template specifications");
        $this->templateLocator->get($this->template, 'foo/../bar');
    }

    public function testSetAndGetPaths()
    {
        // should be no paths yet
        $expect = [];
        $actual = $this->templateLocator->getPaths();
        $this->assertSame($expect, $actual);

        // set the paths
        $expect = ['__DEFAULT__' => [
            DIRECTORY_SEPARATOR . 'foo',
            DIRECTORY_SEPARATOR . 'bar',
            DIRECTORY_SEPARATOR . 'baz',
        ]];
        $this->templateLocator->setPaths(['/foo', '/bar', '/baz']);
        $actual = $this->templateLocator->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testPrependPath()
    {
        $this->templateLocator->prependPath('/foo');
        $this->templateLocator->prependPath('/bar');
        $this->templateLocator->prependPath('/baz');

        $expect = ['__DEFAULT__' => [
            DIRECTORY_SEPARATOR . 'baz',
            DIRECTORY_SEPARATOR . 'bar',
            DIRECTORY_SEPARATOR . 'foo',
        ]];
        $actual = $this->templateLocator->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testAppendPath()
    {
        $this->templateLocator->appendPath('/foo');
        $this->templateLocator->appendPath('/bar');
        $this->templateLocator->appendPath('/baz');

        $expect = ['__DEFAULT__' => [
            DIRECTORY_SEPARATOR . 'foo',
            DIRECTORY_SEPARATOR . 'bar',
            DIRECTORY_SEPARATOR . 'baz',
        ]];
        $actual = $this->templateLocator->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testFindFallbacks()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR
            . 'templates' . DIRECTORY_SEPARATOR;

        $templateLocator = $this->newTemplateLocator([
            $dir . 'foo',
        ]);

        $this->assertOutput('foo', $templateLocator->get($this->template, 'test'));

        $templateLocator = $this->newTemplateLocator([
            $dir . 'bar',
            $dir . 'foo',
        ]);
        $this->assertOutput('bar', $templateLocator->get($this->template, 'test'));

        $templateLocator = $this->newTemplateLocator([
            $dir . 'baz',
            $dir . 'bar',
            $dir . 'foo',
        ]);
        $this->assertOutput('baz', $templateLocator->get($this->template, 'test'));

        // get it again for code coverage
        $this->assertOutput('baz', $templateLocator->get($this->template, 'test'));

        // look for a file that doesn't exist
        $templateLocator->setExtension('.phtml');
        $this->expectException(Exception\TemplateNotFound::class);
        $templateLocator->get($this->template, 'test');
    }

    public function testCollections()
    {
        $dir = __DIR__ . '/templates';

        $this->templateLocator->setPaths([
            "foo:{$dir}/foo",
            "bar:{$dir}/bar",
            "baz:{$dir}/baz",
        ]);

        $this->assertOutput('foo', $this->templateLocator->get($this->template, 'foo:test'));
        $this->assertOutput('bar', $this->templateLocator->get($this->template, 'bar:test'));
        $this->assertOutput('baz', $this->templateLocator->get($this->template, 'baz:test'));
    }

    public function testCompileAll()
    {
        $cachePath = __DIR__ . DIRECTORY_SEPARATOR . 'cache';
        $compiler = new QiqCompiler($cachePath);

        $sourceDir = __DIR__ . DIRECTORY_SEPARATOR . 'templates-qiq';
        $htmlTemplate = HtmlTemplate::new(
            paths: [$sourceDir],
            extension: '.php',
            compiler: $compiler
        );

        $compiler->clear();
        $actual = $htmlTemplate->getTemplateLocator()->compileAll($htmlTemplate);
        var_dump($actual);
    }

    protected function assertOutput(string $expect, string $file) : void
    {
        ob_start();
        require $file;
        $actual = ob_get_clean();
        $this->assertSame($expect, $actual);
    }
}
