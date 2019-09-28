<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Tests\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Mysiar\TestBundle\Tests\Entity\Qqrq;

class QqrqFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $f = new Qqrq();
        $f->setName('QQRQ 1');
        $manager->persist($f);

        $f = new Qqrq();
        $f->setName('QQRQ 2');
        $manager->persist($f);

        $manager->flush();
    }
}
