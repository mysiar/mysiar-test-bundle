<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Helper;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;

class FixtureLoader
{
    /** @var ORMExecutor */
    private $executor;

    public function __construct(EntityManagerInterface $em)
    {
        $purger = new ORMPurger($em);
        $this->executor = new ORMExecutor($em, $purger);
    }

    public function loadFixture(string $filePath): void
    {
        $loader = new Loader();
        $loader->loadFromFile($filePath);
        $this->executor->execute($loader->getFixtures(), true);
    }

    public function loadFixtures(array $paths): void
    {
        $loader = $this->multiFixtureLoader($paths);
        $this->executor->execute($loader->getFixtures());
    }

    private function multiFixtureLoader(array $paths): Loader
    {
        $fixtures = [];
        foreach ($paths as $path) {
            $loader = new Loader();
            $lf = $loader->loadFromDirectory($path);
            if (count($lf) > 0) {
                array_push($fixtures, ...$lf);
            }
            $this->executor->execute($loader->getFixtures());
        }
        $loader = new Loader();
        foreach ($fixtures as $f) {
            $loader->addFixture($f);
        }

        return $loader;
    }

    public function reloadFixtures(array $paths): void
    {
        $loader = $this->multiFixtureLoader($paths);
        $purger = new ORMPurger($this->executor->getObjectManager());
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $this->executor->setPurger($purger);
        $this->executor->execute($loader->getFixtures());
    }
}
