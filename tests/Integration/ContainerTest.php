<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Tests\Integration;

use Doctrine\ORM\EntityManagerInterface;
use Mysiar\TestBundle\Integration\IntegrationTestCase;

class ContainerTest extends IntegrationTestCase
{
    public function test(): void
    {
        $this->assertInstanceOf(
            EntityManagerInterface::class,
            $this->getTestContainer()->get('mysiar_test_bundle_entity_manager_interface')
        );

        $this->assertInstanceOf(
            EntityManagerInterface::class,
            $this->getTestContainer()->get(EntityManagerInterface::class)
        );
    }
}
