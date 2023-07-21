<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Productsup\BinCdeHeinemann\Export\Application\XML\Helper\XmlFileWriter;
use XMLWriter;

final class XmlWriterTest extends TestCase
{
    private xmlFilewriter $writer;
    private string $remoteFile;
    private XMLWriter $xmlWriter;

    protected function setUp(): void
    {
        $this->remoteFile = __DIR__.'/../../testfeed.xml';
        $this->writer= new XmlFileWriter($this->remoteFile);
        $this->xmlWriter = new XMLWriter();
        $this->xmlWriter->openMemory();
        $this->xmlWriter->startDocument('1.0', 'UTF-8');
    }

    protected function tearDown(): void
    {
        if (file_exists($this->remoteFile)) {
            unlink($this->remoteFile);
        }
    }

    public function testFlushXml(): void
    {
        $this->xmlWriter->writeElement('test', 'This is a test');
        $this->writer->conditionalWrite(1000, $this->xmlWriter);
        $this->assertStringEqualsFile($this->remoteFile, file_get_contents(__DIR__.'/../Fixtures/flushtestfeed.xml'));
    }
}
