<?php
namespace Qiq;

use Qiq\Helper\Html\FakeHelper;

class ContainerTest extends \PHPUnit\Framework\TestCase
{
    protected $container;

    protected function setUp() : void
    {
        $this->container = new Container();
    }

    public function test()
    {
        $expect = FakeHelper::class;
        $actual = $this->container->get(FakeHelper::class);
        $this->assertInstanceOf($expect, $actual);

        $this->assertFalse($this->container->has(NoSuchClass::class));

        $this->expectException(Exception\ObjectNotFound::class);
        $this->container->get(NoSuchHelper::class);
    }
}
