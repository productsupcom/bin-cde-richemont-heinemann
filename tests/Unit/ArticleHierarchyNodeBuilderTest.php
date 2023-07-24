<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Productsup\BinCdeHeinemann\Export\Application\XML\Parser\ArticleHierarchyNodeBuilder;
use XMLWriter;

final class ArticleHierarchyNodeBuilderTest extends TestCase
{
    private const BASE_FIXTURES_PATH = __DIR__.'/../Fixtures/';

    public function testAddNodeGeneratesValidXml(): void
    {
        $xmlWriter = new XMLWriter();

        $xmlWriter->openMemory();

        $articleHierarchy = new ArticleHierarchyNodeBuilder();

        $row = [
            'id' => '44',
            'parentid' => '4124',
            'function' => '44',
            'text' => '44',
        ];

        $articleHierarchy->addNode($xmlWriter, $row);

        $xmlContent = $xmlWriter->outputMemory(true);

        $this->assertXmlStringEqualsXmlString(file_get_contents(self::BASE_FIXTURES_PATH.'ArticleHierarchyExpectedXml.xml'), $xmlContent);
    }
}
