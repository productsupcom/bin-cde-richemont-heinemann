<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload;

use League\Flysystem\Filesystem;
use Productsup\BinCdeHeinemann\Export\Application\Transport;

final class S3Uploader implements Transport
{
    public function __construct(Filesystem $filesystem)
    {
    }

    public function upload(): void
    {
        //todo

    }
}
