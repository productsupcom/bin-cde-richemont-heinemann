<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use Productsup\BinCdeHeinemann\Export\Application\Transfomer\FlattedData;
use Productsup\BinCdeHeinemann\Export\Application\XML\Parser\Article;
use Productsup\BinCdeHeinemann\Export\Application\XML\Parser\ArticleHierarchy;
use Productsup\BinCdeHeinemann\Export\Application\XML\Parser\Receiver;
use Productsup\CDE\Connector\Application\Feed\InputFeedForExport;
use Productsup\Serializer\Normalizers\ExportChannelDenormalizer;
use Productsup\Serializer\Transformer\ArrayType\ArrayTransformerInterface;
use Productsup\Serializer\Transformer\ArrayType\FlatToNestedArrayTransformer;
use SimpleXMLElement;
use Symfony\Component\Serializer\Serializer;

final class XmlBuilder
{
    public function __construct(
        private Article $article,
        private ArticleHierarchy $articleHierarchy,
        private FlattedData $arrayTransformer,
        private Receiver $receiver,
        private InputFeedForExport $feed,
        private string $header,
        private string $remoteFile = 'feed.xml')
    {
    }

    public function build(): bool
    {
        $xml = new SimpleXMLElement($this->header, LIBXML_NOERROR, false, '', true);
        $dom = dom_import_simplexml($xml);
        $this->receiver->addNode($dom);

        $articlesData = [
            [
                'article.id' => 'SOME ID 0',
                'article.TREXCL' => '',
                'article.RECEXCL' => '',
                'article.ASSORT' => '',
                'article.LOEVM' => '',
                'article.DISCDATE' => '',
                'article.DATAB' => '00000000',
                'articlehierarchy.id' => '44',
                'articlehierarchy.parentid' => '4124',
                'articlehierarchy.function' => '44',
                'articlehierarchy.text' => '44',
            ],
            [
                'article.id' => 'SOME ID 1',
                'article.TREXCL' => '',
                'article.RECEXCL' => '',
                'article.ASSORT' => '',
                'article.LOEVM' => '',
                'article.DISCDATE' => '',
                'article.DATAB' => '00000000',
                'articlehierarchy.id' => '44',
                'articlehierarchy.parentid' => '4124',
                'articlehierarchy.function' => '44',
                'articlehierarchy.text' => '44',
            ],
        ];
        foreach ($articlesData as $article) {
            [$productArray, $productHierarchy] = $this->arrayTransformer->toNestedArray($article);
            $this->article->addNode($dom, $productArray);
            //$this->articleHierarchy->addNode($xml, $productHierarchy);
        }

        return $xml->asXML($this->remoteFile);
    }
}
