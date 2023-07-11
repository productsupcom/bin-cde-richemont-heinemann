<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application;

use Productsup\BinCdeHeinemann\Export\Application\XML\Builder\XmlBuilder;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\Event\ExportSuccessful;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\Event\ProcessStarted;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Upload\UploadHandler;
use Symfony\Component\Messenger\MessageBusInterface;

final class Exporter
{
    public function __construct(
        private MessageBusInterface $messageBus,
        private XmlBuilder $xml,
        private UploadHandler $uploadHandler
    ) {
    }
    public function export(): void
    {
        $this->messageBus->dispatch(new ProcessStarted());
        $this->xml->build();
        $this->uploadHandler->upload();
        $this->messageBus->dispatch(new ExportSuccessful());
    }
}
