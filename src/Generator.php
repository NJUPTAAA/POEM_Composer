<?php

namespace POEM;

class Generator
{

    public function generate($data, $type = "poem")
    {
        if ($type == "poem") {
            $ret = json_encode($data);
            if (!Utils::isJson($ret)) $ret = "{}";
        } elseif ($type == "poetry") {
            //unzip it
        }
        return $ret;
    }
}
