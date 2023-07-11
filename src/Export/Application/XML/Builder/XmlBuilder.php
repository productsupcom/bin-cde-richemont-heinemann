<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Application\XML\Builder;

use Productsup\BinCdeHeinemann\Export\Application\XML\Parser\Article;
use Productsup\BinCdeHeinemann\Export\Application\XML\Parser\Receiver;
use Productsup\CDE\Connector\Application\Feed\InputFeedForExport;
use SimpleXMLElement;

final class XmlBuilder
{
    public function __construct(private Article $article, private Receiver $receiver, private InputFeedForExport $feed, private string $header, private string $filename = 'feed.xml')
    {
    }

    public function build(): bool
    {
        $header = '<?xml version="1.0" encoding="utf-8"?><n0:ArticleBulkRequest xmlns:n0="http://montblanc.de/xi/ERP/MDM" xmlns:prx="urn:sap.com:proxy:MBP:/1SAI/TAS81A8E819F7B96D2C6D2F:750"></n0:ArticleBulkRequest>';
        $xml = new SimpleXMLElement($header, LIBXML_NOERROR, false, 'n0', true);

        $xml = $this->receiver->addNode($xml);

        foreach ($this->feed->yieldBuffered() as $article) {
            $xml = $this->article->addNode($xml, $article);
        }

        return $xml->asXML($this->filename);
    }
}
