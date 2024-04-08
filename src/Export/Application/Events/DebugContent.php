<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\Events;

use Productsup\CDE\Connector\Application\Event\DebugEvent;

final class DebugContent implements DebugEvent
{
    public function __construct(private string $content)
    {
    }

    public function toLogMessage(): string
    {
        return $this->content;
    }
}
