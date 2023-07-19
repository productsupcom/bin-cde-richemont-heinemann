<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use Productsup\BinCdeHeinemann\Export\Application\XML\Helper\XmlFileWriter;
use Productsup\BinCdeHeinemann\Export\Application\XML\Parser\Receiver;
use XMLWriter;

final class XmlBuilder
{
    public function __construct(
        private Receiver    $receiver,
        private XmlFileWriter   $writer,
        private XmlDataNode $dataNode
    ) {}

    public function build(): void
    {
        $xmlWriter = $this->getXMLWriter();

        $this->receiver->addNode($xmlWriter);
        $this->dataNode->buildDataNodes($xmlWriter);

        $xmlWriter->endElement();
        $this->writer->write($xmlWriter);
    }

    private function getXMLWriter()
    {
        $xmlWriter = new XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->setIndent(true);
        $xmlWriter->startDocument('1.0', 'UTF-8');
        $xmlWriter->startElementns('n0', 'ArticleBulkRequest', 'test');
        $xmlWriter->writeAttribute('xmlns:prx', 'urn:sap.com:proxy:MBP:/test:333');
        $xmlWriter->endAttribute();

        return $xmlWriter;
    }
}