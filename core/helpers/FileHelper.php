<?php
/**
 * @author oba.ou
 */
namespace app\core\helpers;


class FileHelper extends \yii\helpers\FileHelper
{
    public static function find($fileArray){
        $return = [];
        foreach($fileArray as $file){
            $file = new \SplFileObject($file);
            $return[] = substr($file->getFilename(),0,strlen($file->getFilename())-(strlen($file->getExtension())+1));
        }
        return $return;
    }
}