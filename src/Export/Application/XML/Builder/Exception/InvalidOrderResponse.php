<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder\Exception;

use Productsup\CDE\Connector\Exception\EngineeringLevelException;
use Throwable;

final class InvalidOrderResponse extends EngineeringLevelException
{
    public static function dueToPrevious(Throwable $exception): self
    {
        return new self(
            message: 'Invalid orders response.',
            previous: $exception
        );
    }

    public static function invalid(string $message): self
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
