<?php
namespace Qiq;

use Qiq\Helper\Html\FakeBroken;
use Qiq\Helper\Html\FakeHello;

class ContainerTest extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $container = new Container();

        $expect = FakeHello::class;
        $actual = $container->get(FakeHello::class);
        $this->assertInstanceOf($expect, $actual);

        $this->assertSame("Hello World", $actual("World"));

        $this->assertFalse($container->has(NoSuchClass::class));

        $this->expectException(Exception\ObjectNotFound::class);
        $container->get(NoSuchHelper::class);
    }

    public function testConfig()
    {
        $container = new Container([
            FakeHello::class => [
                'suffix' => ' !!!',
            ]
        ]);

        $actual = $container->get(FakeHello::class);
        $this->assertSame("Hello World !!!", $actual("World"));
    }

    public function testCannotInstantiate()
    {
        $container = new Container();
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Cannot create argument for 'Qiq\Helper\Html\FakeBroken::\$object' of type 'ArrayObject|stdClass");
        $container->get(FakeBroken::class);
    }
}
