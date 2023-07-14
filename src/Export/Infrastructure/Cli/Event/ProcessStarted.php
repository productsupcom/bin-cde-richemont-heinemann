<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\Event;

use Productsup\CDE\Connector\Application\Event\InfoEvent;

final class ProcessStarted implements InfoEvent
{
    public function toLogMessage(): string
    {
        return 'Starting the export.';
    }
}
