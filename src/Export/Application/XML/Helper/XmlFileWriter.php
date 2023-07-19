<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Helper;

use XMLWriter;
use RuntimeException;

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
        if ($count % 1000 === 0) {
            $this->write($xmlWriter);
        }
    }
}