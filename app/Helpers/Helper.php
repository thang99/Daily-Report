<?php

namespace App\Helpers;

class Helper
{

    /**
     * Upload image
     *
     * @param $file file  from  request
     * @param string $folder name of folder want to save
     *
     * @return string
     */
    public static function uploadImage($file, string $folder)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $path = 'images/' . $folder;
        $file->move($path, $filename);
        return $filename;
    }

    public static function downloadImageFromUrl($url)
    {


    }
}
