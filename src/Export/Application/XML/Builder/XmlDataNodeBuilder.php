<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use Productsup\BinCdeHeinemann\Export\Application\Events\DebugContent;
use Productsup\BinCdeHeinemann\Export\Application\XML\Builder\Transfomer\DataFlattener;
use Productsup\BinCdeHeinemann\Export\Application\XML\Helper\XmlFileWriter;
use Productsup\CDE\ContainerApi\BaseClient\Client;
use Productsup\CDE\ContainerApi\BaseClient\Runtime\Client\Client as ClientAlias;
use Symfony\Component\Messenger\MessageBusInterface;
use Traversable;
use XMLWriter;

final class XmlDataNodeBuilder
{
    public function __construct(
        private ArticleNodeBuilder $articleNodeBuilder,
        private ArticleHierarchyNodeBuilder $articleHierarchyNodeBuilder,
        private DataFlattener $arrayTransformer,
        private XmlFileWriter $writer,
        private Client $client,
        private MessageBusInterface $messageBus,
    ) {
    }

    public function buildDataNodes(XMLWriter $xmlWriter, Traversable $feed): void
    {
        $count = 0;
        $articleHierarchyData = [];
        $order = json_decode($this->client->showColumnOrder(ClientAlias::FETCH_RESPONSE)->getBody()->getContents(), true) ?? [];

        foreach ($feed as $article) {
            [$productArray, $productHierarchy] = $this->arrayTransformer->toNestedArray($article, $order['data']['order']);
            $this->messageBus->dispatch(new DebugContent(json_encode($productArray)));
            $this->messageBus->dispatch(new DebugContent(json_encode($productHierarchy)));
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
}
