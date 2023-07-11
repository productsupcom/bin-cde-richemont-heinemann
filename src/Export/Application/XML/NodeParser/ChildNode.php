<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\NodeParser;

use SimpleXMLElement;

class ChildNode
{
    public function addChild(SimpleXMLElement $xml, array $row)
    {
        $articles = $xml->addChild('Article');
        $articles->addChild('ID', $row['key']);

        foreach ($row as $tagName => $value) {
            $articles->addChild('Field', $value, '')->addAttribute('name', $tagName);
        }
    }
}
