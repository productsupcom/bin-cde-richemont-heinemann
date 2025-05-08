<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use Productsup\BinCdeHeinemann\Export\Application\Provider\DateTimeProvider;
use XMLWriter;

final class ReceiverNodeBuilder
{
    private const RECEIVER_ID = 'HEINEMANN-API';

    public function __construct(
        private DateTimeProvider $dateTimeProvider
    ) {
    }

    public function addNode(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement('Receiver');
        $xmlWriter->writeElement('ID', self::RECEIVER_ID);
        $xmlWriter->startElement('EmailAddressID');
        $xmlWriter->text($this->dateTimeProvider->getCurrent('Y-m-dH:i:s'));
        $xmlWriter->endElement();
        $xmlWriter->endElement();
    }
}
