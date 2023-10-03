<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\Service;

use Productsup\BinCdeHeinemann\Export\Application\Exporter;
use Productsup\CDE\Connector\Application\Service\ApplicationService;
use Symfony\Component\Console\Command\Command;

final class ExportService implements ApplicationService
{
    public function __construct(
        private Exporter $exporter,
        private string $filename,
    ) {
    }

    public function run(): int
    {
        $this->exporter->export();
        unlink($this->filename);

        return Command::SUCCESS;
    }
}
