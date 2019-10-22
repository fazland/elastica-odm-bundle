<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Tests\Fixtures\DependencyInjection\AppKernel;

class ElasticaODMBundleTest extends TestCase
{
    /**
     * @group functional
     */
    public function testCanBoot(): void
    {
        $kernel = new AppKernel('test', true);
        $kernel->boot();

        self::assertTrue(true);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        $fs = new Filesystem();
        $fs->remove(__DIR__.'/../var/cache');
        $fs->remove(__DIR__.'/../var/log');
    }
}
