<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Exception;

use Productsup\CDE\Connector\Exception\EngineeringLevelException;
use Throwable;

final class ExportException extends EngineeringLevelException
{
    public static function dueToPrevious(Throwable $previous): self
    {
        return new self(
            message: $previous->getMessage(),
            previous: $previous
        );
    }
}
