<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder\Transfomer;

final class DataFlattener
{
    public function toNestedArray(array $articleData): array
    {
        $articleFields = [];
        $articleHierarchyFields = [];
        foreach ($articleData as $key => $value) {
            if (str_starts_with($key, 'article.')) {
                $fieldKey = substr($key, strlen('article.'));
                $articleFields[$fieldKey] = $value;
            } elseif (str_starts_with(strtolower($key), 'articlehierarchy.')) {
                $fieldKey = substr(strtolower($key), strlen('articlehierarchy.'));
                $articleHierarchyFields[$fieldKey] = $value;
            }
        }

        return [$articleFields, $articleHierarchyFields];
    }
}
