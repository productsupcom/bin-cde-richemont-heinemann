<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Adapter;

use League\Flysystem\Adapter\Ftp;

final class FtpAdapterFactory
{
    public static function make(): Ftp
    {
        return new Ftp([]);
    }
}
