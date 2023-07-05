<?php

namespace Productsup\BinCdeHeinemann\Export\Application;

use Productsup\CDE\Connector\Application\Feed\InputFeedForExport;
use Symfony\Component\Messenger\MessageBusInterface;

final class Exporter
{
    public function __construct(
        private MessageBusInterface $messageBus,
        private InputFeedForExport $feed,
    ) {
    }
    public function export(): void
    {

    }
}