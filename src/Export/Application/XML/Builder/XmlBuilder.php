<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use Productsup\BinCdeHeinemann\Export\Application\Transfomer\FlattedData;
use Productsup\BinCdeHeinemann\Export\Application\XML\Parser\Article;
use Productsup\BinCdeHeinemann\Export\Application\XML\Parser\ArticleHierarchy;
use Productsup\BinCdeHeinemann\Export\Application\XML\Parser\Receiver;
use Productsup\CDE\Connector\Application\Feed\InputFeedForExport;
use XMLWriter;

final class XmlBuilder
{
    public function __construct(
        private Article $article,
        private ArticleHierarchy $articleHierarchy,
        private FlattedData $arrayTransformer,
        private Receiver $receiver,
        private InputFeedForExport $feed,
        private string $remoteFile = 'feed.xml'
    ) {
    }

    public function build(): void
    {
        $xmlWriter = new XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->setIndent(true);
        $xmlWriter->startDocument('1.0', 'UTF-8');
        $xmlWriter->startElementns('n0', 'ArticleBulkRequest', 'http://montblanc.de/xi/ERP/MDM');
        $xmlWriter->writeAttribute('xmlns:prx', 'urn:sap.com:proxy:MBP:/1SAI/TAS81A8E819F7B96D2C6D2F:750');
        $xmlWriter->endAttribute();

        $this->receiver->addNode($xmlWriter);
        $count = 0;
        $articleHierarchyData = [];
        foreach ($this->feed->yieldBuffered()as $article) {
            [$productArray, $productHierarchy] = $this->arrayTransformer->toNestedArray($article);
            $this->article->addNode($xmlWriter, $productArray);
            array_push($articleHierarchyData, $productHierarchy);
            $count++;
            if (0 == $count%1000) {
                $this->saveXml($xmlWriter);
            }
        }

        foreach ($articleHierarchyData as $hierarchy)
        {
            $this->articleHierarchy->addNode($xmlWriter, $hierarchy);
            $count++;
            if (0 == $count%1000) {
                $this->saveXml($xmlWriter);
            }
        }
        $xmlWriter->endElement();
        $this->saveXml($xmlWriter);

    }
    private function saveXml($xmlWriter): void
    {
        file_put_contents($this->remoteFile, $xmlWriter->flush(true), FILE_APPEND);
    }
}
