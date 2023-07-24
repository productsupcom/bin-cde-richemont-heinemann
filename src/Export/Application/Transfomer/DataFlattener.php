<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\Transfomer;

final class DataFlattener
{
    public function toNestedArray(array $articleData): array
    {
        $articleFields = [];
        $articleHierarchyFields = [];
        foreach ($articleData as $key => $value) {
            if (0 === strpos($key, 'article.')) {
                $fieldKey = substr($key, strlen('article.'));
                $articleFields[$fieldKey] = $value;
            } elseif (0 === strpos($key, 'articlehierarchy.')) {
                $fieldKey = substr($key, strlen('articlehierarchy.'));
                $articleHierarchyFields[$fieldKey] = $value;
            }
        }

        return [$articleFields, $articleHierarchyFields];
    }
}
