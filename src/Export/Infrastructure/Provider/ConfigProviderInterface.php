<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Provider;

interface ConfigProviderInterface
{
    public function getRemoteFile(): string;

    public function getDirectory(): string;

    public function getFeedName(): string;

    public function getHost(): string;
}
