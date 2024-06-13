<?php
declare(strict_types=1);

namespace EonX\EasyApiPlatform\Tests;

use EonX\EasyApiPlatform\Tests\Fixtures\App\Kernel\ApplicationKernel;
use EonX\EasyTest\Traits\ContainerServiceTrait;
use EonX\EasyTest\Traits\PrivatePropertyAccessTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractTestCase extends KernelTestCase
{
    use ContainerServiceTrait;
    use PrivatePropertyAccessTrait;

    protected function setUp(): void
    {
        self::bootKernel();
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        return new ApplicationKernel('test', false);
    }
}
