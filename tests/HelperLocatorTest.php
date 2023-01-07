<?php
namespace Qiq;

use Qiq\Helper\Html\FakeHelper;

class HelperLocatorTest extends \PHPUnit\Framework\TestCase
{
    protected $helperLocator;

    protected function setUp() : void
    {
        $this->helperLocator = new HelperLocator();
    }

    public function test()
    {
        $expect = FakeHelper::class;
        $actual = $this->helperLocator->get(FakeHelper::class);
        $this->assertInstanceOf($expect, $actual);

        $this->assertFalse($this->helperLocator->has(NoSuchClass::class));

        $this->expectException(Exception\HelperNotFound::class);
        $this->helperLocator->get(NoSuchHelper::class);
    }
}
