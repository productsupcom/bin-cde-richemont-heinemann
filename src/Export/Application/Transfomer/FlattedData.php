<?php

namespace Productsup\BinCdeHeinemann\Export\Application\Transfomer;

class FlattedData
{
public function toNestedArray(array $articleData): array
{
    $articleFields = [];
    $articleHierarchyFields = [];
    var_dump($articleData);
    foreach ($articleData as $key => $value) {
        var_dump($key, $value);

        if (strpos($key, 'article.') === 0) {
            $fieldKey = substr($key, strlen('article.'));
            $articleFields[$fieldKey] = $value;
        } elseif (strpos($key, 'articlehierarchy.') === 0) {
            $fieldKey = substr($key, strlen('articlehierarchy.'));
            $articleHierarchyFields[$fieldKey] = $value;
        }
    }
    return [$articleFields, $articleHierarchyFields];
}
}