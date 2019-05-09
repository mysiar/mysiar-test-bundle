<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Tests\Unit;

use Doctrine\ORM\EntityManager;
use Mysiar\TestBundle\Integration\IntegrationTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Kernel;

class IntegrationTestCaseTest extends IntegrationTestCase
{
    public function testGetters(): void
    {
        $this->assertInstanceOf(Kernel::class, $this->getKernel());
        $this->assertInstanceOf(Container::class, $this->getContainer());
        $this->assertInstanceOf(Container::class, $this->getTestContainer());
        $this->assertInstanceOf(EntityManager::class, $this->getEntityManager());
    }
}
