<?php
declare(strict_types=1);

namespace Mysiar\TestBundle\Tests\Integration\Helper;

use Mysiar\TestBundle\Helper\FixtureLoader;
use Mysiar\TestBundle\Integration\IntegrationTestCase;

class FixtureLoaderTest extends IntegrationTestCase
{
    /** @var FixtureLoaderTest */
    private $service;

    protected function setUp(): void
    {
        $this->service = $this->getTestContainer()->get('test.fixture_loader');
    }

    public function testDI(): void
    {
        $this->assertInstanceOf(FixtureLoader::class, $this->service);
    }
}
