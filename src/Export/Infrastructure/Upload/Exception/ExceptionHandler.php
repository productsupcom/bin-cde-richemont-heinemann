<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Exception;

use Exception;
use League\Flysystem\ConnectionRuntimeException;

final class ExceptionHandler
{
    public function handle(Exception $exception): void
    {
        if ($exception instanceof ConnectionRuntimeException) {
            throw ConnectionException::dueToPrevious($exception);
        }

        throw ExportException::dueToPrevious($exception);
    }
}
