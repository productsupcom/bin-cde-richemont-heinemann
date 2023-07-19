<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Mocks;

use League\Flysystem\Adapter\Ftp;
use League\Flysystem\ConnectionRuntimeException;
use League\Flysystem\Sftp\SftpAdapter;

trait MockProvider
{
    private function getFtpMock(): Ftp
    {
        $ftp = $this->createMock(Ftp::class);
        $ftp->method('writeStream')->willReturn(true);

        return $ftp;
    }

    private function getConnectionExceptionFtpMock(): Ftp
    {
        $ftp = $this->createMock(Ftp::class);
        $ftp->method('connect')->willThrowException(new ConnectionRuntimeException());

        return $ftp;
    }

    private function getSftpMock(): SftpAdapter
    {
        $sftp = $this->createMock(SftpAdapter::class);
        $sftp->method('writeStream')->willReturn(true);

        return $sftp;
    }
}
