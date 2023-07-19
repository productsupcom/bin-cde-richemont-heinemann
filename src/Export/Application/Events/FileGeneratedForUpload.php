<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\Events;

use Productsup\CDE\Connector\Application\Event\InfoEvent;

class FileGeneratedForUpload implements InfoEvent
{
    public function __construct(private string $remoteFile)
    {
    }

    public function toLogMessage(): string
    {
        return sprintf('File generated for upload : %s', $this->remoteFile);
    }
}
