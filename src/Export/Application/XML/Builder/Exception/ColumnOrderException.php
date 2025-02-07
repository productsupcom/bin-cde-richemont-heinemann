<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder\Exception;

use Productsup\CDE\Connector\Exception\EngineeringLevelException;
use Throwable;

final class ColumnOrderException extends EngineeringLevelException
{
    public static function dueToPrevious(Throwable $exception): self
    {
        return new self(
            message: 'Exception encountered while getting export column order.',
            previous: $exception
        );
    }

    public static function unexpectedStatusCode(string $message): self
    {
        return new self(
            message: $message
        );
    }

    public static function invalidJson(): self
    {
        return new self(
            message: 'Invalid json'
        );
    }
}
