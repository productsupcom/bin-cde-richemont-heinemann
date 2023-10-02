<?php

declare(strict_types=1);

namespace Productsup\BinCdeHeinemann\Export\Infrastructure\Upload;

final class S3AdapterFactory
{
    public static function make(SimpleS3Client $client, string $bucket): AsyncAwsS3Adapter
    {
        //TODO check path
        return new League\Flysystem\AsyncAwsS3\AsyncAwsS3Adapter(
            // S3Client
            $client,
            // Bucket name
            'bucket-name'
        );
    }
}
