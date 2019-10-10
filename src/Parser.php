<?php
 
namespace POEM;

use Exception;
use \PhpZip\ZipFile;

class Parser
{
    private $supportStandard=["1.0"];
    private $path=null;
    private $type=null;

    private function isJson($string)
    {
        return ((is_string($string) &&
                (is_object(json_decode($string)) ||
                is_array(json_decode($string))))) ? true : false;
    }

    private function getFile($path)
    {
        $file=file_get_contents($path);
        if($file===false) throw new Exception("$path: File Not Found");
        return $file;
    }

    public function parseFile($poemFile, $type)
    {
        parseStream($this->getFile($poemFile), $type);
    }

    public function parseStream($poemStream, $type)
    {
        if(!in_array($this->type,['poetry','poem'])) throw new Exception("Unsupported Type"); 
        $this->type=$type;
        $tmpFolder=__DIR__."/tmp/NOJ".time();
        mkdir($tmpFolder, 0700, true);
        $zipFile = new ZipFile();
        $zipFile->openFromString($poemStream)->extractTo($tmpFolder);
        $this->path=$tmpFolder;
        if(!isJson($this->getFile("$this->path/main.json"))) throw new Exception("Malformed Files");

        return $this;
    }

    public function getProblemList()
    {
        if($this->type!="poetry") throw new Exception("Unsupported Method");
        // get problem list, array with poem parser object
    }

    public function getProblemDetails()
    {
        if($this->type!="poem") throw new Exception("Unsupported Method");
        // get problem details
    }

    public function getTestcases()
    {
        if($this->type!="poem") throw new Exception("Unsupported Method");
        // get problem testcases
    }

    public function getSTDs()
    {
        if($this->type!="poem") throw new Exception("Unsupported Method");
        // get problem stds
    }

    public function getSPJ()
    {
        if($this->type!="poem") throw new Exception("Unsupported Method");
        // get problem spj
    }

    public function getResource()
    {
        if($this->type!="poem") throw new Exception("Unsupported Method");
        // get problem resource
    }

    public function getResources()
    {
        if($this->type!="poem") throw new Exception("Unsupported Method");
        // get problem resources
    }

    public function terminate()
    {
        
    }
}
