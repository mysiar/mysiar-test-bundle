<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Reflection;

use ReflectionClass;
use ReflectionException;

class ClassName
{
    /**
     * @param object $object
     * @return string
     * @throws ReflectionException
     */
    public function getClassName(object $object)
    {
        return (new ReflectionClass($object))->getShortName();
    }

    /**
     * @param object $object
     * @return string
     * @throws ReflectionException
     */
    public function getFullClassName(object $object)
    {
        return (new ReflectionClass($object))->getName();
    }
}
