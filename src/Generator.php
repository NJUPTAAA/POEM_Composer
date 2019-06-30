<?php
 
namespace POEM;

class Generator
{
    private function isJson($string)
    {
        return ((is_string($string) &&
                (is_object(json_decode($string)) ||
                is_array(json_decode($string))))) ? true : false;
    }

    public function generate($data, $type="poem")
    {
        if ($type=="poem") {
            $ret=json_encode($data);
            if(!isJson($ret)) $ret="{}";
        } elseif ($type=="poetry") {
            //unzip it
        }
        return $ret;
    }
}
