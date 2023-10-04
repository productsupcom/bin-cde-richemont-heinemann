<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Transporter\Factory;

use AsyncAws\SimpleS3\SimpleS3Client;

final class S3ClientFactory
{
    public static function make(string $accessKeyId, string $secretAccessKey, string $region): SimpleS3Client
    {
        return new SimpleS3Client([
            'accessKeyId' => $accessKeyId,
            'accessKeySecret' => $secretAccessKey,
            'region' => $region,
            'debug' => true,
        ]);
    }
}
