<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Domain\Upload;

interface TransportInterface
{
    public function upload(array $createdFiles): void;
}
