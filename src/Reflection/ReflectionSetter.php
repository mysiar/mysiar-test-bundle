<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Reflection;

use ReflectionClass;

class ReflectionSetter
{
    /**
     * @param string $objectClassName
     * @param object $object
     * @param string $propertyName
     * @param mixed $value
     * @throws
     */
    public static function setProperty(
        string $objectClassName,
        object $object,
        string $propertyName,
        $value
    ): void {
        $reflection = new ReflectionClass($objectClassName);
        $reflectionProperty = $reflection->getProperty($propertyName);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $value);
    }
}
