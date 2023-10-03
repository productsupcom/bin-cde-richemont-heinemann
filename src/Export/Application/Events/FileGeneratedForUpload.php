<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\Events;

use Productsup\CDE\Connector\Application\Event\InfoEvent;

final class FileGeneratedForUpload implements InfoEvent
{
    public function __construct(private readonly string $remoteFile)
    {
    }

    public function toLogMessage(): string
    {
        return sprintf('File generated for upload: %s', $this->remoteFile);
    }
}
