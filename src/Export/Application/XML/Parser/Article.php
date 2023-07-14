<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Parser;

use XMLWriter;

final class Article
{
    private string $tag = 'Article';

    public function addNode(XMLWriter $writer, array $row)
    {

        $writer->startElement($this->tag);

        $writer->startElement('ID');
        $writer->text($row['id']);
        $writer->endElement();
        unset($row['id']);

        foreach ($row as $tagName => $value) {
            $writer->startElement('Field');
            $writer->text($value);
            $writer->writeAttribute('name', $tagName);
            $writer->endElement();
        }
        $writer->endElement();
    }
}
