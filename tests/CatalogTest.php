<?php
namespace Qiq;

use Qiq\Compiler\QiqCompiler;
use Qiq\Compiler\FakeCompiler;
use Qiq\Template;

class CatalogTest extends \PHPUnit\Framework\TestCase
{
    protected string $cachePath;

    protected QiqCompiler $compiler;

    protected Catalog $catalog;

    protected function setUp() : void
    {
        $this->catalog = new Catalog();

        $this->cachePath = __DIR__ . DIRECTORY_SEPARATOR . 'cache';
        $this->compiler = new QiqCompiler($this->cachePath);
        $this->compiler->clear();
    }

    public function testGetAndHas() : void
    {
        $this->catalog->setPaths([__DIR__ . '/templates']);

        $this->assertTrue($this->catalog->has('index'));

        $actual = $this->catalog->get($this->compiler, 'index');
        $expect = $this->cachePath
            . str_replace('/', DIRECTORY_SEPARATOR, __DIR__ . '/templates/index.php');
        $this->assertSame($expect, $actual);

        $this->assertFalse($this->catalog->has('no-such-template'));
    }

    public function testDoubleDots() : void
    {
        $this->expectException(Exception\FileNotFound::class);
        $this->expectExceptionMessage("Double-dots not allowed in file specifications");
        $this->catalog->get($this->compiler, 'foo/../bar');
    }

    public function testSetAndGetPaths() : void
    {
        // should be no paths yet
        $expect = [];
        $actual = $this->catalog->getPaths();
        $this->assertSame($expect, $actual);

        // set the paths
        $expect = ['__DEFAULT__' => [
            DIRECTORY_SEPARATOR . 'foo',
            DIRECTORY_SEPARATOR . 'bar',
            DIRECTORY_SEPARATOR . 'baz',
        ]];
        $this->catalog->setPaths(['/foo', '/bar', '/baz']);
        $actual = $this->catalog->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testPrependPath() : void
    {
        $this->catalog->prependPath('/foo');
        $this->catalog->prependPath('/bar');
        $this->catalog->prependPath('/baz');

        $expect = ['__DEFAULT__' => [
            DIRECTORY_SEPARATOR . 'baz',
            DIRECTORY_SEPARATOR . 'bar',
            DIRECTORY_SEPARATOR . 'foo',
        ]];
        $actual = $this->catalog->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testAppendPath() : void
    {
        $this->catalog->appendPath('/foo');
        $this->catalog->appendPath('/bar');
        $this->catalog->appendPath('/baz');

        $expect = ['__DEFAULT__' => [
            DIRECTORY_SEPARATOR . 'foo',
            DIRECTORY_SEPARATOR . 'bar',
            DIRECTORY_SEPARATOR . 'baz',
        ]];
        $actual = $this->catalog->getPaths();
        $this->assertSame($expect, $actual);
    }

    public function testFindFallbacks() : void
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR
            . 'templates' . DIRECTORY_SEPARATOR;

        $catalog = new Catalog([
            $dir . 'foo',
        ]);

        $this->assertOutput('foo', $catalog->get($this->compiler, 'test'));

        $catalog = new Catalog([
            $dir . 'bar',
            $dir . 'foo',
        ]);
        $this->assertOutput('bar', $catalog->get($this->compiler, 'test'));

        $catalog = new Catalog([
            $dir . 'baz',
            $dir . 'bar',
            $dir . 'foo',
        ]);
        $this->assertOutput('baz', $catalog->get($this->compiler, 'test'));

        // get it again for code coverage
        $this->assertOutput('baz', $catalog->get($this->compiler, 'test'));

        // look for a file that doesn't exist
        $catalog = new Catalog();
        $this->expectException(Exception\FileNotFound::class);
        $catalog->get($this->compiler, 'test');
    }

    public function testCollections() : void
    {
        $dir = __DIR__ . '/templates';

        $this->catalog->setPaths([
            "foo:{$dir}/foo",
            "bar:{$dir}/bar",
            "baz:{$dir}/baz",
        ]);

        $this->assertOutput('foo', $this->catalog->get($this->compiler, 'foo:test'));
        $this->assertOutput('bar', $this->catalog->get($this->compiler, 'bar:test'));
        $this->assertOutput('baz', $this->catalog->get($this->compiler, 'baz:test'));
    }

    public function testCompile() : void
    {
        $cachePath = __DIR__ . DIRECTORY_SEPARATOR . 'cache';
        $compiler = new QiqCompiler($cachePath);
        $compiler->clear();

        $sourceDir = __DIR__ . DIRECTORY_SEPARATOR . 'templates-qiq';
        $catalog = new Catalog(
            paths: [$sourceDir],
            extension: '.php',
        );

        $actual = $catalog->compile($compiler);

        foreach ($actual as $file) {
            $this->assertTrue(str_starts_with($file, $cachePath));
        }

        $this->assertCount(10, $actual);
    }

    protected function assertOutput(string $expect, string $file) : void
    {
        ob_start();
        require $file;
        $actual = ob_get_clean();
        $this->assertSame($expect, $actual);
    }
}
