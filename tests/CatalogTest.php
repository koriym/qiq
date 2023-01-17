<?php
namespace Qiq;

use Qiq\Compiler\QiqCompiler;
use Qiq\Compiler\FakeCompiler;
use Qiq\HtmlTemplate;

class CatalogTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp() : void
    {
        $this->catalog = $this->newCatalog();
        $this->catalog->clear();
    }

    protected function newCatalog(array $paths = [])
    {
        return new Catalog($paths, '.php', new FakeCompiler());
    }

    public function testHasGet()
    {
        $this->catalog->setPaths([__DIR__ . '/templates']);

        $actual = $this->catalog->get('index');

        $expect = str_replace('/', DIRECTORY_SEPARATOR, __DIR__ . '/templates/index.php');
        $this->assertSame($expect, $actual);
    }

    public function testDoubleDots()
    {
        $this->expectException(Exception\FileNotFound::class);
        $this->expectExceptionMessage("Double-dots not allowed in file specifications");
        $this->catalog->get('foo/../bar');
    }

    public function testSetAndGetPaths()
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

    public function testPrependPath()
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

    public function testAppendPath()
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

    public function testFindFallbacks()
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR
            . 'templates' . DIRECTORY_SEPARATOR;

        $catalog = $this->newCatalog([
            $dir . 'foo',
        ]);

        $this->assertOutput('foo', $catalog->get('test'));

        $catalog = $this->newCatalog([
            $dir . 'bar',
            $dir . 'foo',
        ]);
        $this->assertOutput('bar', $catalog->get('test'));

        $catalog = $this->newCatalog([
            $dir . 'baz',
            $dir . 'bar',
            $dir . 'foo',
        ]);
        $this->assertOutput('baz', $catalog->get('test'));

        // get it again for code coverage
        $this->assertOutput('baz', $catalog->get('test'));

        // look for a file that doesn't exist
        $catalog->setExtension('.phtml');
        $this->expectException(Exception\FileNotFound::class);
        $catalog->get('test');
    }

    public function testCollections()
    {
        $dir = __DIR__ . '/templates';

        $this->catalog->setPaths([
            "foo:{$dir}/foo",
            "bar:{$dir}/bar",
            "baz:{$dir}/baz",
        ]);

        $this->assertOutput('foo', $this->catalog->get('foo:test'));
        $this->assertOutput('bar', $this->catalog->get('bar:test'));
        $this->assertOutput('baz', $this->catalog->get('baz:test'));
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
        $actual = $htmlTemplate->getCatalog()->compileAll($htmlTemplate);
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
