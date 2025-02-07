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
                            if (preg_match('/\[(.*?)\]/', $tagName, $matches) || preg_match('/\((.*?)\)/', $tagName, $matches)) {
                                $tagName = str_replace($matches[0], '', $tagName);
                                $writer->writeAttribute('name', $tagName.'_en-UK');
                                $writer->writeAttribute('structure', $matches[1]);
                                $writer->text($value);
                            } else {
                                $writer->writeAttribute('name', $tagName);
                                $writer->text($value);
                            }
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
