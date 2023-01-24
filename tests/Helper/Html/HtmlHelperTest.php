<?php
namespace Qiq\Helper\Html;

use Qiq\Container;
use Qiq\Indent;

abstract class HtmlHelperTest extends \PHPUnit\Framework\TestCase
{
    protected $helpers;

    protected $container;

    protected function setUp() : void
    {
        parent::setUp();
        $this->container = new Container();
        $this->container->get(Indent::class)->set('');
        $this->helpers = $this->container->get(HtmlHelpers::class);
    }
}
