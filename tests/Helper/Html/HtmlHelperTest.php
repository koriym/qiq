<?php
namespace Qiq\Helper\Html;

use Qiq\HelperLocator;
use Qiq\Indent;

abstract class HtmlHelperTest extends \PHPUnit\Framework\TestCase
{
    protected $helper;

    protected $helperLocator;

    protected function setUp() : void
    {
        parent::setUp();
        $this->helperLocator = new HelperLocator();
        $this->helperLocator->get(Indent::class)->set('');
        $class = substr(get_class($this), 0, -4);
        $this->helper = $this->helperLocator->get($class);
    }

    protected function helper(...$args)
    {
        return ($this->helper)(...$args);
    }
}
