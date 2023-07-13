<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Parser;

use SimpleXMLElement;

final class ArticleHierarchy
{
    public function addNode(SimpleXMLElement $xml, array $row)
    {
        $articleHierarchy = $xml->addChild(qualifiedName: 'ArticleHierarchy', namespace: '');

        $articleHierarchy->addChild(qualifiedName: 'Node', namespace: '');
        foreach ($row as $tagName => $value) {
            $articleHierarchy->addChild(qualifiedName: $tagName, value: $value, namespace: '');
        }
    }
}
