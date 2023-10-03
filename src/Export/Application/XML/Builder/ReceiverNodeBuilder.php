<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use XMLWriter;

final class ReceiverNodeBuilder
{
    public function __construct(
        private string $receiverId,
        private string $receiverEmail
    ) {
    }

    public function addNode(XMLWriter $xmlWriter): void
    {
        $xmlWriter->startElement('Receiver');
        $xmlWriter->writeElement('ID', $this->receiverId);
        $xmlWriter->startElement('EmailAddressID');
        if (!empty($this->receiverEmail)) {
            $xmlWriter->text($this->receiverEmail);
        }
        $xmlWriter->endElement();
        $xmlWriter->endElement();
    }
}
