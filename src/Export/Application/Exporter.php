<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application;

use Productsup\BinCdeHeinemann\Export\Application\Events\CreatingFileStarted;
use Productsup\BinCdeHeinemann\Export\Application\Events\FileGeneratedForUpload;
use Productsup\BinCdeHeinemann\Export\Application\XML\Builder\XmlBuilder;
use Productsup\BinCdeHeinemann\Export\Domain\Upload\TransportInterface;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\Event\ExportSuccessful;
use Productsup\BinCdeHeinemann\Export\Infrastructure\Cli\Event\ProcessStarted;
use Symfony\Component\Messenger\MessageBusInterface;

final class Exporter
{
    public function __construct(
        private MessageBusInterface $messageBus,
        private XmlBuilder $xml,
        private TransportInterface $uploadHandler,
        private string $remoteFile
    ) {
    }
    public function export(): void
    {
        $this->messageBus->dispatch(new ProcessStarted());
        $this->messageBus->dispatch(new CreatingFileStarted());
        $this->xml->build();
        $this->messageBus->dispatch(new FileGeneratedForUpload($this->remoteFile));
        $this->uploadHandler->upload();
        $this->messageBus->dispatch(new ExportSuccessful());
    }
}
