<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use XMLWriter;

final class ArticleHierarchyNodeBuilder
{
    public function addNode(XMLWriter $writer, array $row): void
    {
        $writer->startElement('ArticleHierarchy');
        $writer->startElement('Node');
        foreach ($row as $tagName => $value) {
            $writer->writeElement($tagName, $value);
        }
        $writer->endElement();
        $writer->endElement();
    }
}
