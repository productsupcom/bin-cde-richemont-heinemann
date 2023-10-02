<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload;

final class FilesystemFactory
{
    public static function make(AsyncAwsS3Adapter $adapter): Filesystem
    {
        return new League\Flysystem\Filesystem($adapter);
    }
}
