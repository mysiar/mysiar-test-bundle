<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Tests\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Mysiar\TestBundle\Tests\Entity\Boo;

class BooFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $f = new Boo();
        $f->setName('Boo 1');
        $f->setDescription('Boo 1 fixture');
        $manager->persist($f);

        $f = new Boo();
        $f->setName('Boo 2');
        $f->setDescription('Boo 2 fixture');
        $manager->persist($f);

        $manager->flush();
    }
}
