<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Parser;

use SimpleXMLElement;

final class Receiver
{
    public function __construct(private string $receiverId, private string $receiverEmail)
    {
    }

    public function addNode(SimpleXMLElement $xml): SimpleXMLElement
    {
        $receiver = $xml->addChild('Receiver');
        $receiver->addChild('ID', $this->receiverId);
        $receiver->addChild('EmailAddressID', $this->receiverEmail);

        return $receiver;
    }
}
