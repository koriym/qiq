<?php
namespace Qiq\Helper\Html;

use ArrayObject;
use stdClass;

class FakeBroken
{
    public function __construct(
        protected ArrayObject|stdClass $object
    ) {
    }
}
