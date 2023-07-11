<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Exception;

use Productsup\CDE\Connector\Exception\EngineeringLevelException;
use Throwable;

class UploadException extends EngineeringLevelException
{
    public static function failedUpload(string $filename, string $host, int $port, ?Throwable $previous = null): self
    {
        return new self(
            message: sprintf(
                'Failed to upload file "%s" to %s:%u',
                $filename,
                $host,
                $port
            ),
            previous: $previous
        );
    }
}
