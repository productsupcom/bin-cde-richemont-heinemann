<?php

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Adapter;

interface Uploader
{
    public function upload(): void;
}