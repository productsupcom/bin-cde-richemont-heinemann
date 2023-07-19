<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use Productsup\BinCdeHeinemann\Export\Application\Transfomer\FlattedData;
use Productsup\BinCdeHeinemann\Export\Application\XML\Helper\XmlFileWriter;
use Productsup\BinCdeHeinemann\Export\Application\XML\Parser\Article;
use Productsup\BinCdeHeinemann\Export\Application\XML\Parser\ArticleHierarchy;
use Productsup\CDE\Connector\Application\Feed\InputFeedForExport;
use XMLWriter;

final class XmlDataNode
{
    public function __construct(
        private Article $article,
        private ArticleHierarchy $articleHierarchy,
        private FlattedData $arrayTransformer,
        private InputFeedForExport $feed,
        private XmlFileWriter $writer,
    ) {
    }

    public function buildDataNodes(XMLWriter $xmlWriter): void
    {
        $count = 0;
        $articleHierarchyData = [];
        foreach ($this->feed->yieldBuffered() as $article) {
            [$productArray, $productHierarchy] = $this->arrayTransformer->toNestedArray($article);
            $this->article->addNode($xmlWriter, $productArray);
            array_push($articleHierarchyData, $productHierarchy);
            $count++;
            $this->writer->conditionalWrite($count, $xmlWriter);
        }

        foreach ($articleHierarchyData as $hierarchy) {
            $this->articleHierarchy->addNode($xmlWriter, $hierarchy);
            $count++;
            $this->writer->conditionalWrite($count, $xmlWriter);
        }
    }
}
