<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\Service;

use Productsup\BinCdeHeinemann\Export\Application\Events\DebugContent;
use Productsup\BinCdeHeinemann\Export\Application\Exporter;
use Productsup\CDE\Connector\Application\Service\ApplicationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class ExportService implements ApplicationService
{
    public function __construct(
        private Exporter $exporter,
        private MessageBusInterface $messageBus
    ) {
    }

    public function run(): int
    {

        try {
            $this->exporter->export();
        } catch (Throwable $exception) {
            $this->messageBus->dispatch(new DebugContent($exception->getPrevious()->getMessage()));
            $this->messageBus->dispatch(new DebugContent($exception->getTraceAsString()));
        }

        return Command::SUCCESS;
    }
}
