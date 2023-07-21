<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Service;

use Exception;
use Productsup\BinCdeHeinemann\Export\Application\Exporter;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\Exception\ExceptionHandler;
use Productsup\CDE\Connector\Application\Service\ApplicationService;
use Symfony\Component\Console\Command\Command;

final class ExportService implements ApplicationService
{
    public function __construct(
        private Exporter $exporter,
        private ExceptionHandler $exceptionHandler
    ) {
    }

    public function run(): int
    {
        try {
            $this->exporter->export();
        } catch (Exception $e) {
            $this->exceptionHandler->handle($e);
        }

        return Command::SUCCESS;
    }
}
