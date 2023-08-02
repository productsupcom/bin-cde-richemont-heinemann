<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Unit;

use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Sftp\SftpAdapter;
use PHPUnit\Framework\TestCase;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Adapter\AdapterFactory;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp\Configuration;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp\FtpUploader;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Sftp\SftpUploader;
use Symfony\Component\Messenger\MessageBusInterface;

class AdapterFactoryTest extends TestCase
{
    private $ftpMock;
    private $sftpMock;
    private $configMock;
    private $msgBusMock;

    protected function setUp(): void
    {
        $this->ftpMock = $this->createMock(Ftp::class);
        $this->sftpMock = $this->createMock(SftpAdapter::class);
        $this->configMock = $this->createMock(Configuration::class);
        $this->msgBusMock = $this->createMock(MessageBusInterface::class);
    }

    public function testMakeSftp(): void
    {
        $this->configMock
            ->method('getProtocol')
            ->willReturn('sftp');

        $adapterFactory = new AdapterFactory($this->ftpMock, $this->sftpMock, $this->configMock, $this->msgBusMock, '/remote/file');

        $this->assertInstanceOf(SftpUploader::class, $adapterFactory->make());
    }

    public function testMakeFtp(): void
    {
        $this->configMock
            ->method('getProtocol')
            ->willReturn('ftp');

        $adapterFactory = new AdapterFactory($this->ftpMock, $this->sftpMock, $this->configMock, $this->msgBusMock, '/remote/file');

        $this->assertInstanceOf(FtpUploader::class, $adapterFactory->make());
    }
}
