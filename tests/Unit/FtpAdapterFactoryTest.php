<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Unit;

use League\Flysystem\Adapter\Ftp;
use PHPUnit\Framework\TestCase;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Adapter\FtpAdapterFactory;

final class FtpAdapterFactoryTest extends TestCase
{
    public function testMake(): void
    {
        $factory = FtpAdapterFactory::make();

        $this->assertInstanceOf(Ftp::class, $factory);
    }
}
