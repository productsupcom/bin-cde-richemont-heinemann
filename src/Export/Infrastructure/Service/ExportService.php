<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Service;

use mysql_xdevapi\Exception;
use Productsup\BinCdeHeinemann\Export\Application\Exporter;
use Productsup\CDE\Connector\Application\Service\ApplicationService;
use Symfony\Component\Console\Command\Command;

final class ExportService implements ApplicationService
{
    public function __construct(
        private Exporter $exporter
    ) {
    }

    public function run(): int
    {
        try {
        $this->exporter->export();

        }catch (Exception $e){
            echo $e->getMessage();
        }

        return Command::SUCCESS;
    }
}
