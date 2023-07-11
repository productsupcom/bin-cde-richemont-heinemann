<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Parser;

use SimpleXMLElement;

final class Article
{
    public function addNode(SimpleXMLElement $xml, array $row): SimpleXMLElement
    {
        $article = $xml->addChild('Article');
        $article->addChild('ID', $row['key']);

        foreach ($row as $tagName => $value) {
            $article->addChild('Field', $value, '')->addAttribute('name', $tagName);
        }

        return $article;
    }
}
