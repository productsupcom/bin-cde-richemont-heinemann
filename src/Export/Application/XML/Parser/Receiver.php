<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Parser;

use XMLWriter;

final class Receiver
{
    private string $tag = 'Receiver';

    public function __construct(private string $receiverId, private string $receiverEmail)
    {
    }

    public function addNode(XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement($this->tag);
        $xmlWriter->writeElement('ID', $this->receiverId);
        $xmlWriter->startElement('EmailAddressID');
        $receiverEmail ?? $xmlWriter->text($this->receiverEmail);
        $xmlWriter->endElement();
        $xmlWriter->endElement();
    }
}
