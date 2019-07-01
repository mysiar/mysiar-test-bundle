<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Reflection;

use ReflectionClass;

class ClassName
{
    public function getClassName(object $object): string
    {
        return (new ReflectionClass($object))->getShortName();
    }

    public function getFullClassName(object $object): string
    {
        return (new ReflectionClass($object))->getName();
    }
}
