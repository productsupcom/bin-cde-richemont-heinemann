<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use Productsup\BinCdeHeinemann\Export\Application\XML\Builder\Transfomer\DataFlattener;
use Productsup\BinCdeHeinemann\Export\Application\XML\Helper\XmlFileWriter;
use Traversable;
use XMLWriter;

final class XmlDataNodeBuilder
{
    public function __construct(
        private ArticleNodeBuilder $articleNodeBuilder,
        private ArticleHierarchyNodeBuilder $articleHierarchyNodeBuilder,
        private DataFlattener $arrayTransformer,
        private XmlFileWriter $writer,
    ) {
    }

    public function buildDataNodes(XMLWriter $xmlWriter, Traversable $feed): void
    {
        $count = 0;
        $articleHierarchyData = [];

        foreach ($feed as $article) {
            [$productArray, $productHierarchy] = $this->arrayTransformer->toNestedArray($article);
            $this->articleNodeBuilder->addNode($xmlWriter, $productArray);
            array_push($articleHierarchyData, $productHierarchy);
            $count++;
            $this->writer->conditionalWrite($count, $xmlWriter);
        }

        foreach ($articleHierarchyData as $hierarchy) {
            $this->articleHierarchyNodeBuilder->addNode($xmlWriter, $hierarchy);
            $count++;
            $this->writer->conditionalWrite($count, $xmlWriter);
        }
    }
}
