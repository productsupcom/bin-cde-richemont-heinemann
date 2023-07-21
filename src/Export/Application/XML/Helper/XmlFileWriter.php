<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Helper;

use XMLWriter;

class XmlFileWriter
{
    private string $filePath;

    public function __construct(string $remoteFile)
    {
        $this->filePath = $remoteFile;
    }

    public function write(XMLWriter $xmlWriter): void
    {
        $content = $xmlWriter->flush(true);
        file_put_contents($this->filePath, $content, FILE_APPEND);
    }

    public function conditionalWrite(int $count, XMLWriter $xmlWriter): void
    {
        if (0 === $count % 1000) {
            $this->write($xmlWriter);
        }
    }
}
