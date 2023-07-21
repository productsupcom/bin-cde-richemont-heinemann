<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Parser;

use XMLWriter;

final class Article
{
    private const TAG_NAME = 'Article';
    private const ID_FIELD_NAME = 'ID';
    private const DEFAULT_FIELD_NAME = 'Field';

    public function addNode(XMLWriter $writer, array $row): void
    {
        $id = $row['id'] ?? '';
        unset($row['id']);

        $this->startAndEndElement($writer, self::TAG_NAME, function () use ($writer, $row, $id) {
            $this->startAndEndElement($writer, self::ID_FIELD_NAME, function () use ($writer, $id) {
                $writer->text($id);
            });

            foreach ($row as $tagName => $value) {
                $this->startAndEndElement($writer, self::DEFAULT_FIELD_NAME, function () use ($writer, $tagName, $value) {
                    $writer->writeAttribute('name', $tagName);
                    $writer->text($value);
                });
            }
        });
    }

    private function startAndEndElement(XMLWriter $writer, string $elementName, callable $content): void
    {
        $writer->startElement($elementName);
        $content();
        $writer->endElement();
    }
}
