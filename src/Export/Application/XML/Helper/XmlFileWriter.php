<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Helper;

use XMLWriter;

class XmlFileWriter
{
    public function __construct(private readonly string $tempFilename)
    {
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $content = $xmlWriter->flush();
        file_put_contents($this->tempFilename, $content, FILE_APPEND);
    }

    public function conditionalWrite(int $count, XMLWriter $xmlWriter): void
    {
        if (0 === $count % 1000) {
            $this->write($xmlWriter);
        }
    }
}
