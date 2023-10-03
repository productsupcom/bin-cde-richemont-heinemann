<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Transporter\Exception;

use Productsup\CDE\Connector\Exception\EngineeringLevelException;
use Throwable;

final class UploadFailed extends EngineeringLevelException
{
    public static function dueToPrevious(Throwable $exception): self
    {
        return new self(
            message: 'Upload failed.',
            previous: $exception
        );
    }
}
