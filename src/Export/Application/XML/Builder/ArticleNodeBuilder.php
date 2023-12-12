<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use XMLWriter;

final class ArticleNodeBuilder
{
    public function addNode(XMLWriter $writer, array $row): void
    {
        $articleId = $row['ID'] ?? '';
        unset($row['ID']);

        $this->startAndEndElement(
            $writer,
            'Article',
            function () use ($writer, $row, $articleId) {
                $this->startAndEndElement(
                    $writer,
                    'ID',
                    function () use ($writer, $articleId): void {
                        $writer->text($articleId);
                    }
                );

                foreach ($row as $tagName => $value) {
                    $this->startAndEndElement(
                        $writer,
                        'Field',
                        function () use ($writer, $tagName, $value): void {
                            $writer->writeAttribute('name', $tagName);
                            $writer->text($value);
                        }
                    );
                }
            }
        );
    }

    private function startAndEndElement(XMLWriter $writer, string $elementName, callable $content): void
    {
        $writer->startElement($elementName);
        $content();
        $writer->endElement();
    }
}
