<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Parser;

use DOMAttr;
use DOMElement;
use SimpleXMLElement;

final class Article
{
    private string $tag = 'Article';

    public function addNode(DOMElement $dom, array $row)
    {
        $article = new DOMElement($this->tag);
        $dom->appendChild($article);
        //$article = $dom->getElementsByTagName($this->tag)->item(0);
        $article->appendChild(new DOMElement('ID',  $row['id']));
        unset($row['id']);
        foreach ($row as $tagName => $value) {
            $test = new DOMElement('Field', $value);
            $article->appendChild($test);
            $test->setAttribute('name', $tagName);
        }
    }
}
