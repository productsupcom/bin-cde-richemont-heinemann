<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Ftp\RemotePath;

final class RemotePathBuilder implements RemotePathBuilderInterface
{
    public function build(string $directory, string $file): string
    {
        return ltrim(sprintf('%s/%s', $directory, $file), ' /');
    }
}
