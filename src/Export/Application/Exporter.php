<?php

namespace Productsup\BinCdeHeinemann\Export\Application;

use DOMDocument;
use Productsup\CDE\Connector\Application\Feed\InputFeedForExport;
use Symfony\Component\Messenger\MessageBusInterface;
use XMLWriter;

final class Exporter
{
    public function __construct(
        private MessageBusInterface $messageBus,
        private InputFeedForExport $feed,
    ) {
    }
    public function export(): void
    {

// Create a new DOM document
        $dom = new DOMDocument('1.0', 'utf-8');

// Create the root element
        $root = $dom->createElementNS('http://montblanc.de/xi/ERP/MDM', 'n0:ArticleBulkRequest');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:prx', 'urn:sap.com:proxy:MBP:/1SAI/TAS81A8E819F7B96D2C6D2F:750');
        $dom->appendChild($root);

// Create the Receiver element
        $receiver = $dom->createElement('Receiver');
        $root->appendChild($receiver);

// Create the ID element within the Receiver element
        $id = $dom->createElement('ID', 'ID-API');
        $receiver->appendChild($id);

// Create the EmailAddressID element within the Receiver element
        $emailAddressID = $dom->createElement('EmailAddressID');
        $receiver->appendChild($emailAddressID);

// Create the first Article element
        $article1 = $dom->createElement('Article');
        $root->appendChild($article1);

// Create the ID element within the first Article element
        $id1 = $dom->createElement('ID', 'SOME ID 0');
        $article1->appendChild($id1);

// Create the second Article element
        $article2 = $dom->createElement('Article');
        $root->appendChild($article2);

// Create the ID element within the second Article element
        $id2 = $dom->createElement('ID', 'SOME ID 1');
        $article2->appendChild($id2);

// Output the XML document as a string
        $dom->formatOutput = true;
        $xmlString = $dom->saveXML();

        echo $xmlString;


    }
}