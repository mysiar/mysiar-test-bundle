<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Integration;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class IntegrationTestCase extends WebTestCase
{
    protected function getKernel(): KernelInterface
    {
        if (null === static::$kernel || null === static::$kernel->getContainer()) {
            static::bootKernel();
        }
        return static::$kernel;
    }

    protected function getTestContainer(): ContainerInterface
    {
        return $this->getContainer()->get('test.service_container');
    }

    protected function getContainer(): ContainerInterface
    {
        return $this->getKernel()->getContainer();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->getContainer()->get('doctrine.orm.default_entity_manager');
    }

    protected static function ensureKernelShutdown(): void
    {
        parent::ensureKernelShutdown();
        static::$kernel = null;
    }
}
