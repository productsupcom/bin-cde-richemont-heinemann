<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use XMLWriter;

final class ArticleHierarchyNodeBuilder
{
    private string $tag = 'ArticleHierarchy';

    public function addNode(XMLWriter $writer, array $row)
    {
        $writer->startElement($this->tag);
        $writer->startElement('Node');
        foreach ($row as $tagName => $value) {
            $writer->writeElement($tagName, $value);
        }
        $writer->endElement();
        $writer->endElement();
    }
}