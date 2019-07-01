<?php
 
namespace POEM;

use \PhpZip\ZipFile;

class Parser
{
    private $poemRaw="{}";
    private $supportStandard=["1.0"];

    public function poemRaw()
    {
        return $this->poemRaw;
    }

    private function isJson($string)
    {
        return ((is_string($string) &&
                (is_object(json_decode($string)) ||
                is_array(json_decode($string))))) ? true : false;
    }

    public function parse($poemRaw, $type="auto")
    {
        $this->poemRaw=$poemRaw;
        if ($type=="auto") {
            $type=$this->isJson($this->poemRaw)?"poem":"poetry";
        }

        if ($type=="poem") {
            $ret=json_decode($poemRaw, true);
            if(!is_array($ret)) $ret=[];
        } elseif ($type=="poetry") {
            $zipFile = new ZipFile();
            $zipFile->openFromString($poemRaw);
            $listFiles = $zipFile->getListFiles();
            $contents = $zipFile[$listFiles[0]];
            $ret=json_decode($contents, true);
            if(!is_array($ret)) $ret=[];
        }

        return $ret;
    }
}
