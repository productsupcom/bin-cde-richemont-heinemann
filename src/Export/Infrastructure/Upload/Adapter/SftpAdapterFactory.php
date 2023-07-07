<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Service\Upload\Adapter;

use League\Flysystem\Sftp\SftpAdapter;

final class SftpAdapterFactory
{
    public static function make(): SftpAdapter
    {
        return new SftpAdapter([]);
    }
}
