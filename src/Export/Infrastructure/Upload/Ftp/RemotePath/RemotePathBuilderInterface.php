<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp\RemotePath;

interface RemotePathBuilderInterface
{
    public function build(string $directory, string $file): string;
}
