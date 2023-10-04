<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Transporter\Exception;

use Productsup\CDE\Connector\Exception\ClientLevelException;
use Throwable;

final class ConnectionException extends ClientLevelException
{
    public static function dueToPrevious(Throwable $previous): self
    {
        return new self(
            message: $previous->getMessage(),
            previous: $previous
        );
    }
}
