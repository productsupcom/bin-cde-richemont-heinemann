<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Event;

use Productsup\CDE\Connector\Application\Event\DebugEvent;

class UnableToUploadFile implements DebugEvent
{
    private const DEFAULT_MESSAGE = 'Upload function resulted false value';

    public function __construct(
        private string $fileName,
        private string $message
    ) {
    }

    public static function logReason(string $fileName, string $message = self::DEFAULT_MESSAGE): self
    {
        return new self($fileName, $message);
    }

    public function toLogMessage(): string
    {
        return "Error while uploading file {$this->fileName} and exception message is {$this->message}";
    }
}
