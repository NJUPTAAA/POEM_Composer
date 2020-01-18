<?php

namespace POEM;

use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Utils
{
    const VERSION = '1.1.0';

    public static function isJson($string)
    {
        return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
    }

    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function createTmpFolder($tries = 5)
    {
        if($tries == 0) return false;
        $tmpFolder = __DIR__ . "/tmp/NOJ" . time() . self::generateRandomString(6);
        if (is_dir($tmpFolder)) return self::createTmpFolder(--$tries);
        mkdir($tmpFolder, 0700, true);
        return $tmpFolder;
    }

    public static function getFile($path)
    {
        $file = file_get_contents($path);
        if ($file === false) throw new Exception("$path: File Not Found");
        return $file;
    }

    public static function removeDir($dir)
    {
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }
}
