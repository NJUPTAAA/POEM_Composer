<?php
 
namespace POEM;

use \PhpZip\ZipFile;

class Parser
{
    private $poemRaw="{}";

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
            var_dump($listFiles);
        }

        // foreach($ret["problems"] as $prob) {
        //     // main proc
        // }

        return $ret;
    }
}
