<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder\Transfomer;

final class DataFlattener
{
    public function toNestedArray(array $articleData, array $order): array
    {
        $article = [];
        if (empty($order)) {
            return $this->splitFields($articleData);
        }
        foreach ($order as $key) {
            if (array_key_exists($key, $articleData)) {
                $article[$key] = $articleData[$key];
            }
        }

        return $this->splitFields($article);

    }

    private function splitFields(array $order): array
    {
        $articleFields = [];
        $articleHierarchyFields = [];
        foreach ($order as $key => $value) {
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
