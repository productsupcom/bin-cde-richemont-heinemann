<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use Productsup\BinCdeHeinemann\Export\Application\Events\DebugContent;
use Productsup\BinCdeHeinemann\Export\Application\XML\Builder\Transfomer\DataFlattener;
use Productsup\BinCdeHeinemann\Export\Application\XML\Helper\XmlFileWriter;
use Productsup\CDE\ContainerApi\BaseClient\Client;
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
        $order = json_decode($this->client->showColumnOrder()->getBody()->getContents(),true);
        $this->messageBus->dispatch(new DebugContent(json_encode($order)));

        foreach ($feed as $article) {
            [$productArray, $productHierarchy] = $this->arrayTransformer->toNestedArray($article);
            //build new array based on received order array
            $productArray = array_merge(array_flip($order['data']['order']), $productArray);
            $this->messageBus->dispatch(new DebugContent(json_encode($productArray)));
            $productHierarchy = array_merge(array_flip($order['data']['order']), $productHierarchy);
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
