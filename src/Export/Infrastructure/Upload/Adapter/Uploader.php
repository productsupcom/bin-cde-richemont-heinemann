<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Adapter;

interface Uploader
{
    public function upload(): void;
}
