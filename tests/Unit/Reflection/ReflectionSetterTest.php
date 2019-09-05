<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Tests\Unit\Reflection;

use Mysiar\TestBundle\Reflection\ReflectionSetter;
use Mysiar\TestBundle\Tests\Entity\Foo;
use Mysiar\TestBundle\Unit\UnitTestCase;
use Ramsey\Uuid\Uuid;

class ReflectionSetterTest extends UnitTestCase
{
    public function test(): void
    {
        $object = new Foo();
        $id = Uuid::uuid4();
        ReflectionSetter::setProperty(Foo::class, $object, 'id', $id);
        $this->assertEquals($id, $object->getId());
    }
}
