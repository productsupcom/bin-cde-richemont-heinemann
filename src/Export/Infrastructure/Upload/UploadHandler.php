<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload;

use Productsup\BinCdeHeinemann\Export\Domain\Upload\TransportInterface;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Adapter\AdapterFactory;

class UploadHandler implements TransportInterface
{
    public function __construct(
        private AdapterFactory $adapterFactory
    ) {
    }

    public function upload(): void
    {
        $adapter = $this->adapterFactory->make();
        $adapter->upload();
    }
}
