<?php

namespace Phprestful\Middleware;

class RemoveExifImage
{
    public static function removeExif($imagePath)
    {
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);

        if ($extension == 'jpeg' or $extension == 'jpg') {
            $pngFile = pathinfo($imagePath, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($imagePath, PATHINFO_FILENAME) . '.png';
            $img = imagecreatefromjpeg($imagePath);
            imagepng($img, $pngFile);
            $imagePath = $pngFile;
        }

        return $imagePath;
    }
}