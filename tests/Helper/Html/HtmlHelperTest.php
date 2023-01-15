<?php
namespace Qiq\Helper\Html;

use Qiq\Container;
use Qiq\Indent;

abstract class HtmlHelperTest extends \PHPUnit\Framework\TestCase
{
    protected $helper;

    protected $container;

    protected function setUp() : void
    {
        parent::setUp();
        $this->container = new Container();
        $this->container->get(Indent::class)->set('');
        $class = substr(get_class($this), 0, -4);
        $this->helper = $this->container->get($class);
    }

    protected function helper(...$args)
    {
        return ($this->helper)(...$args);
    }
}
