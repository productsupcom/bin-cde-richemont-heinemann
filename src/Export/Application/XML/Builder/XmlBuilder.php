<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use Productsup\BinCdeHeinemann\Export\Application\XML\Helper\XmlFileWriter;
use Traversable;
use XMLWriter;

final class XmlBuilder
{
    public function __construct(
        private ReceiverNodeBuilder $receiver,
        private XmlFileWriter $writer,
        private XmlDataNodeBuilder $dataNode
    ) {
    }

    public function build(Traversable $feed): void
    {
        $xmlWriter = $this->getXmlWriter();

        $this->receiver->addNode($xmlWriter);
        $this->dataNode->buildDataNodes($xmlWriter, $feed);
        $xmlWriter->endElement();
        $this->writer->write($xmlWriter);
    }

    private function getXmlWriter(): XMLWriter
    {
        $xmlWriter = new XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->setIndent(true);
        $xmlWriter->startDocument('1.0', 'UTF-8');
        $xmlWriter->startElementns('n0', 'ArticleBulkRequest', 'http://montblanc.de/xi/ERP/MDM');
        $xmlWriter->writeAttribute('xmlns:prx', 'urn:sap.com:proxy:MBP:/1SAI/TAS81A8E819F7B96D2C6D2F:750');
        $xmlWriter->endAttribute();

        return $xmlWriter;
    }
}
