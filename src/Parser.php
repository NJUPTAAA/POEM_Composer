<?php
 
namespace POEM;

use Exception;
use \PhpZip\ZipFile;

class Parser
{
    private $supportStandard=["1.0"];
    private $path=null;
    private $type=null;

    public function parseFile($poemFile, $type)
    {
        return $this->parseStream(Utils::getFile($poemFile), $type);
    }

    public function parseStream($poemStream, $type)
    {
        if(!in_array($type,['poetry','poem'])) throw new Exception("Unsupported Type"); 
        $this->type=$type;
        $tmpFolder=Utils::createTmpFolder();
        $zipFile = new ZipFile();
        $zipFile->openFromString($poemStream)->extractTo($tmpFolder);
        $this->path=$tmpFolder;
        $json=Utils::getFile("$this->path/main.json");
        if(!Utils::isJson($json)) throw new Exception("Malformed Files");
        return $type=='poem'?(new POEM($this->path))->importJSON($json):(new POETRY($this->path))->importJSON($json);
    }

    public function terminate()
    {
        Utils::removeDir($this->path);
    }
}
