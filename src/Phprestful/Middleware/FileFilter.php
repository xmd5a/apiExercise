<?php

namespace Phprestful\Middleware;

class FileFilter
{
    protected $allowedFiles = ['image/jpeg', 'image/png'];

    public function filter($filesArray, $app)
    {
        $newFile = $filesArray['file'];

        if (!in_array($newFile['type'], $this->allowedFiles)) {
            $app->abort(415);
        }

        $uploadedFilename = time() . '.' . pathinfo($newFile['name'], PATHINFO_EXTENSION);
        $imagePath = "resources/images/$uploadedFilename";
        move_uploaded_file($newFile['tmp_name'], $imagePath);

        return $imagePath;
    }
}