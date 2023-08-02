<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Unit;

use League\Flysystem\Sftp\SftpAdapter;
use PHPUnit\Framework\TestCase;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Adapter\SftpAdapterFactory;

final class SftpAdapterFactoryTest extends TestCase
{
    public function testMake(): void
    {
        $factory = SftpAdapterFactory::make();

        $this->assertInstanceOf(SftpAdapter::class, $factory);
    }
}
