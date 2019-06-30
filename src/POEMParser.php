<?php
 
namespace POEMParser;

class POEMParser
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

    public function parse($poemRaw, $type="auto", $resourceProc=null, $testCaseProc=null)
    {
        $this->poemRaw=$poemRaw;
        if ($type=="auto") {
            $type=$this->isJson($this->poemRaw)?"poem":"poetry";
        }

        if ($type=="poem") {
            $ret=json_decode($poemRaw, true);
            if(!is_array($ret)) $ret=[];
        } elseif ($type=="poetry") {
            
        }

        return $ret;
    }
}
