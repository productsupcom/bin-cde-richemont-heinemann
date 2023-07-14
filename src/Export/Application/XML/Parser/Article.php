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
//
//        $article = new DOMElement($this->tag);
//        $dom->appendChild($article);
//        //$article = $dom->getElementsByTagName($this->tag)->item(0);
//        $article->appendChild(new DOMElement('ID',  $row['id']));
//        unset($row['id']);
//        foreach ($row as $tagName => $value) {
//            $test = new DOMElement('Field', $value);
//            $article->appendChild($test);
//            $test->setAttribute('name', $tagName);
//        }
    }
}
