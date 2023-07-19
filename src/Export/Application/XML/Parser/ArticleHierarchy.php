<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Parser;

use XMLWriter;

final class ArticleHierarchy
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
