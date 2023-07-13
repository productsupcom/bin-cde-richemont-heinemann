<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Parser;

use DOMElement;

final class Receiver
{
    private string $tag = 'Receiver';

    public function __construct(private string $receiverId, private string $receiverEmail)
    {
    }

    public function addNode(DOMElement $dom)
    {
        $receiver = new DOMElement($this->tag);
        $dom->appendChild($receiver);
        $receiver = $dom->getElementsByTagName($this->tag)->item(0);
        $receiver->appendChild(new DOMElement('ID', $this->receiverId));
        $receiver->appendChild(new DOMElement('EmailAddressID', $this->receiverEmail));
    }
}
