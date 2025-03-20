<?php

namespace common\Helper;

// use common\models\Image;

use common\models\UserPosts;
use Moderation;
use yii\web\UploadedFile;

class FsHelper
{

    /**
     * Save UploadedFile.
     * ! Important: This function uploads this model filename to keep consistency of the model.
     * 
     * @param UploadedFile $file Uploaded file to save
     * @param string $attribute Attribute name where the uploaded filename name will be saved
     * @param string $fileName Name which file will be saved. If empty will use the name from $file
     * @param bool $autoExtension true to automatically append or replace the extension to the file name. Default is true
     * 
     * @return void
     */
    public static function saveUploadedFile(UploadedFile $file, $filePath,  $fileName = '', $autoExtension = true)
    {

        if (empty($fileName)) {
            $fileName = $file->name;
        }
        if ($autoExtension) {
            $_file    = (string) pathinfo($fileName, PATHINFO_FILENAME);
            $fileName = $_file . '.' . $file->extension;
        }

        // $this->{$attribute} = $fileName;
        // if (!$this->validate($attribute)) {
        //     return;
        // }
        // $filePath  = 'images/' . $fileName;
        $localPath = $file->tempName;
        $handle    = fopen($localPath, 'r');
        $contents  = fread($handle, filesize($localPath));
        fclose($handle);

        $filesystem = \Yii::$app->get('fs');

        $filesystem->write($filesystem->normalizePath($filePath), $contents);
        return $checksum = $filesystem->checksum($filePath); // etag or md5

    }

    /**
     * Delete model file attribute.
     * 
     * @param string $attribute Attribute name which holds the filename
     * 
     * @return void
     */
    public static function removeFile($filePath)
    {
        if (empty($filePath)) {
            return;
        }
        $filePath   = $filePath;
        $filesystem = \Yii::$app->get('fs');
        return $filesystem->delete($filesystem->normalizePath($filePath));
    }




    // public static function UploadFile(UploadedFile $file, $fullpath, $name, $caption = NULL, $alt = NULL, $master_image_source_code = \common\models\masters\MasterImageSource::DIRECT_IMAGE_SOURCE, $owner_id = NULL, $agent_id = NULL)
    // {


    //     $_file    = (string) pathinfo($file->name, PATHINFO_FILENAME);
    //     $filename = $file . '' . time() . '.' . $file->extension;

    //     // $etag =  FsHelper::saveUploadedFile($file, $fullpath, $filename, true);
    //     $filemodel = new Image();
    //     $bytesize = $file->size;
    //     $extension = $file->extension;
    //     // list($width, $height) = getimagesize($file->tempName);

    //     if ($extension === 'svg') {
    //         $width = 0; // SVG width is not defined in the same way as raster images
    //         $height = 0; // SVG height is not defined in the same way as raster images
    //     } else {
    //         list($width, $height) = getimagesize($file->tempName);
    //     }

    //     $filemodel->master_image_source_code = $master_image_source_code;
    //     $filemodel->name = !empty($name) ? $name : $filename;
    //     $filemodel->caption = $caption;
    //     $filemodel->alt = $alt;
    //     $filemodel->extension = $extension;
    //     $filemodel->bytesize = $bytesize;

    //     $filemodel->height =  $height;
    //     $filemodel->width = $width;

    //     $filemodel->filename = $filename;
    //     $filemodel->owner_id = $owner_id;
    //     $filemodel->agent_id = $agent_id;



    //     // $filemodel->filepath = $fullpath . '/' . $filename;
    //     $filemodel->save(false);
    //     $etag =  FsHelper::saveUploadedFile($file,  $filename = $filemodel->id . '.' . $file->extension, true);
    //     return  $filemodel->id;
    //     return false;
    // }

    public static function RemoveSpecialChar($str)
    {

        // Using str_replace() function
        // to replace the word
        $res = str_replace(array(
            '\'', '"',
            ',', ';', '<', '>'
        ), ' ', $str);

        // Returning the result
        return $res;
    }

    public static function UserPostUploadFile($file, $fullpath, $name, $caption = NULL,  $owner_id = NULL,)
    {

        // $_file    = (string) pathinfo($file->name, PATHINFO_FILENAME);
        $filename = $name;

        // $etag =  FsHelper::saveUploadedFile($file, $fullpath, $filename, true);
        $filemodel = new UserPosts();
        // $bytesize = $file->size;
        $extension = $file->extension;
        // list($width, $height) = getimagesize($file->tempName);

        if ($extension === 'svg') {
            $width = 0; // SVG width is not defined in the same way as raster images
            $height = 0; // SVG height is not defined in the same way as raster images
        } else {
            list($width, $height) = getimagesize($file->tempName);
        }

        // $filemodel->master_image_source_code = $master_image_source_code;
        $filemodel->file = !empty($name) ? $name : $filename;
        $filemodel->caption = $caption;
        // $filemodel->alt = $alt;
        // $filemodel->extension = $extension;
        // $filemodel->bytesize = $bytesize;

        $filemodel->height =  $height;
        $filemodel->width = $width;

        // $filemodel->filename = $filename;
        $filemodel->user_id = $owner_id;
        // $filemodel->agent_id = $agent_id;



        // $filemodel->filepath = $fullpath . '/' . $filename;
        // $filemodel->save(false);
        $etag =  FsHelper::saveUploadedFile($file,  $filename, true);
        return  $filemodel->file;
        return false;
    }

    public static function ModerationFile($file, $fullpath, $name, $caption = NULL,  $owner_id = NULL,)
    {
        $filename = $name;
        $filemodel = new Moderation();
        $extension = $file->extension;
        $filemodel->video = !empty($name) ? $name : $filename;
        $etag =  FsHelper::saveUploadedFile($file,  $filename, true);
        return  $filemodel->file;
        return false;
    }


    private function createThumbnail($path)
    {
        \yii\imagine\Image::frame($path, 5, '666', 0)->save('path/to/destination/image.jpg', ['jpeg_quality' => 50]);
    }
}
