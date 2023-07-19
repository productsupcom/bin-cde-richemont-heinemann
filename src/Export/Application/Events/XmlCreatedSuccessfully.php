<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\Events;

use Productsup\CDE\Connector\Application\Event\InfoEvent;

final class XmlCreatedSuccessfully implements InfoEvent
{
    public function __construct(private string $filesize)
    {
    }

    public static function forFile(string $filesize): self
    {
        return new self($filesize);
    }

    public function toLogMessage(): string
    {
        return sprintf('XML file created successfully. : %s', $this->filesize);
    }
}
