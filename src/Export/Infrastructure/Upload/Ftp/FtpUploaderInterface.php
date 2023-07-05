<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp;

interface FtpUploaderInterface
{
    public function upload(string $file): void;
}
