<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\Events;

use Productsup\CDE\Connector\Application\Event\InfoEvent;

final class CreatingFileStarted implements InfoEvent
{
    public function toLogMessage(): string
    {
        return 'Creating XML file.';
    }
}
