<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use Exception;
use JsonException;
use Productsup\BinCdeHeinemann\Export\Application\XML\Builder\Exception\ColumnOrderException;
use Productsup\BinCdeHeinemann\Export\Application\XML\Builder\Transfomer\DataFlattener;
use Productsup\BinCdeHeinemann\Export\Application\XML\Helper\XmlFileWriter;
use Productsup\CDE\ContainerApi\BaseClient\Client;
use Traversable;
use XMLWriter;

class XmlDataNodeBuilder
{
    public function __construct(
        private ArticleNodeBuilder $articleNodeBuilder,
        private ArticleHierarchyNodeBuilder $articleHierarchyNodeBuilder,
        private DataFlattener $arrayTransformer,
        private XmlFileWriter $writer,
        private Client $client
    ) {
    }

    public function buildDataNodes(XMLWriter $xmlWriter, Traversable $feed): void
    {
        $count = 0;
        $articleHierarchyData = [];
        $order = $this->getOrder();
        foreach ($feed as $article) {
            [$productArray, $productHierarchy] = $this->arrayTransformer->toNestedArray($article, $order);
            $this->articleNodeBuilder->addNode($xmlWriter, $productArray);
            array_push($articleHierarchyData, $productHierarchy);
            $count++;
            $this->writer->conditionalWrite($count, $xmlWriter);
        }

        $this->articleHierarchyNodeBuilder->startArticleHierarchy($xmlWriter);
        foreach ($articleHierarchyData as $hierarchy) {
            $this->articleHierarchyNodeBuilder->addNode($xmlWriter, $hierarchy);
            $count++;
            $this->writer->conditionalWrite($count, $xmlWriter);
        }
        $this->articleHierarchyNodeBuilder->endArticleHierarchy($xmlWriter);
    }

    private function getOrder(): array
    {
        try {
            $response = $this->client->showColumnOrder(Client::FETCH_RESPONSE);

            if (!in_array($response->getStatusCode(), [200, 202])) {
                throw ColumnOrderException::unexpectedStatusCode($response->getReasonPhrase());
            }

            $contents = $response->getBody()->getContents();
            $order = json_decode(json: $contents, associative: true, flags: JSON_THROW_ON_ERROR);

            return $order['data']['order'] ?? [];
        } catch (JsonException) {
            throw ColumnOrderException::invalidJson();
        } catch (Exception $exception) {
            throw ColumnOrderException::dueToPrevious($exception);
        }
    }
}
