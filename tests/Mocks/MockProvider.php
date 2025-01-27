<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Mocks;

use Exception;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use Productsup\CDE\ContainerApi\BaseClient\Client;

trait MockProvider
{
    private function getFileSystemMock(): Filesystem
    {
        return $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getErrorFilesystemMock(): Filesystem
    {
        $ftp = $this->createMock(Filesystem::class);
        $ftp->method('writeStream')
            ->willThrowException(
                new class ('error') extends Exception implements FilesystemException {}
            );

        return $ftp;
    }

    private function getClientMock(): Client
    {
        $client = $this->createMock(Client::class);
        $client->method('showColumnOrder')->willReturn([]);
        return $client;
    }
}
