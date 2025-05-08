<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application;

use Productsup\BinCdeHeinemann\Export\Application\Events\CreatingFileStarted;
use Productsup\BinCdeHeinemann\Export\Application\Events\FileGeneratedForUpload;
use Productsup\BinCdeHeinemann\Export\Application\Provider\FileNameProvider;
use Productsup\BinCdeHeinemann\Export\Application\Transporter\Transporter;
use Productsup\BinCdeHeinemann\Export\Application\XML\Builder\XmlBuilder;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\Event\ExportSuccessful;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\Event\ProcessStarted;
use Productsup\CDE\Connector\Application\Feed\InputFeedForExport;
use Symfony\Component\Messenger\MessageBusInterface;

final class Exporter
{
    public function __construct(
        private MessageBusInterface $messageBus,
        private XmlBuilder $xmlBuilder,
        private Transporter $uploadHandler,
        private InputFeedForExport $inputFeedForExport,
        private FileNameProvider $fileNameProvider
    ) {
    }
    public function export(): void
    {
        $this->messageBus->dispatch(new ProcessStarted());
        $this->messageBus->dispatch(new CreatingFileStarted());
        $this->xmlBuilder->build($this->inputFeedForExport->yieldBuffered());
        $this->messageBus->dispatch(new FileGeneratedForUpload($this->fileNameProvider->provide()));
        $this->uploadHandler->transport();
        $this->messageBus->dispatch(new ExportSuccessful());
    }
}
