<?php

namespace Phprestful\Middleware;

use Aws\S3\S3Client;

class FileMover
{
    public static function move($imagePath, $app)
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'eu-west-2'
        ]);

        try {
            $s3->putObject([
                'Bucket' => 'my-bucket',
                'Key' => 'my-object',
                'Body' => fopen($imagePath, 'r'),
                'ACL' => 'public-read'
            ]);
        } catch (\Exception $e) {
            $app->abort(400);
        }

        return $imagePath;
    }
}