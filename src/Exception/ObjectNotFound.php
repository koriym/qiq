<?php
declare(strict_types=1);

namespace Qiq\Exception;

use Psr\Container\NotFoundExceptionInterface;

class ObjectNotFound extends Exception implements NotFoundExceptionInterface
{
}
