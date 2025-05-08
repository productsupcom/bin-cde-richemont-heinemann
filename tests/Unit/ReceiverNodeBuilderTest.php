<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Productsup\BinCdeHeinemann\Export\Application\XML\Builder\ReceiverNodeBuilder;
use Productsup\BinCdeHeinemann\Tests\Mocks\DateProviderForTests;
use XMLWriter;

final class ReceiverNodeBuilderTest extends TestCase
{
    /**
     * @var XMLWriter
     */
    private $xmlWriter;
    private const BASE_FIXTURES_PATH = __DIR__.'/../Fixtures/';

    /**
     * Setup XMLWriter instance for testing
     */
    public function setUp(): void
    {
        $this->xmlWriter = new XMLWriter();
        $this->xmlWriter->openMemory();
        $this->xmlWriter->startDocument('1.0', 'UTF-8');
    }

    /**
     * Check if Receiver is correctly translating to XML
     */
    public function testAddNode(): void
    {
        $receiver = new ReceiverNodeBuilder(new DateProviderForTests());
        $receiver->addNode($this->xmlWriter);
        $xml = $this->xmlWriter->outputMemory();

        $this->assertXmlStringEqualsXmlString(file_get_contents(self::BASE_FIXTURES_PATH.'ReceiverExpectedXml.xml'), $xml);
    }
}
