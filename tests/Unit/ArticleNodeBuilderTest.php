<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Productsup\BinCdeHeinemann\Export\Application\XML\Builder\ArticleNodeBuilder;
use XMLWriter;

final class ArticleNodeBuilderTest extends TestCase
{
    private const BASE_FIXTURES_PATH = __DIR__.'/../Fixtures/';

    public function testAddNodeGeneratesValidXml(): void
    {
        $xmlWriter = new XMLWriter();
        $xmlWriter->openMemory();
        $article = new ArticleNodeBuilder();
        $row = [
            'id' => 'SOME ID 0',
            'TREXCL' => '',
            'RECEXCL' => '',
            'ASSORT' => '',
            'LOEVM' => '',
            'DISCDATE' => '',
            'DATAB' => '00000000',
        ];

        $article->addNode($xmlWriter, $row);
        $xmlContent = $xmlWriter->outputMemory(true);
        $this->assertXmlStringEqualsXmlString(file_get_contents(self::BASE_FIXTURES_PATH.'ArticleExpectedXml.xml'), $xmlContent);
    }
}
