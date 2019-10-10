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

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function createTmpFolder($tries=5)
    {
        $tmpFolder=__DIR__."/tmp/NOJ".time().$this->generateRandomString(6);
        if(is_dir($tmpFolder)) return createTmpFolder(--$tries);
        mkdir($tmpFolder, 0700, true);
        return $tmpFolder;
    }

    private function getFile($path)
    {
        $file=file_get_contents($path);
        if($file===false) throw new Exception("$path: File Not Found");
        return $file;
    }

    public function parseFile($poemFile, $type)
    {
        return $this->parseStream($this->getFile($poemFile), $type);
    }

    public function parseStream($poemStream, $type)
    {
        if(!in_array($type,['poetry','poem'])) throw new Exception("Unsupported Type"); 
        $this->type=$type;
        $tmpFolder=$this->createTmpFolder();
        $zipFile = new ZipFile();
        $zipFile->openFromString($poemStream)->extractTo($tmpFolder);
        $this->path=$tmpFolder;
        if(!$this->isJson($this->getFile("$this->path/main.json"))) throw new Exception("Malformed Files");

        return $this;
    }

    public function getProblemList()
    {
        if($this->type!="poetry") throw new Exception("Unsupported Method");
        $list=json_decode($this->getFile("$this->path/main.json"),true);
        $problems=$list["problems"];
        $list["problems"]=[];
        foreach($problems as $problem){
            $list["problems"][]=(new Parser())->parseFile("$this->path/$problem", "poem");
        }
        return $list;
    }

    public function getProblemDetails()
    {
        if($this->type!="poem") throw new Exception("Unsupported Method");
        return json_decode($this->getFile("$this->path/main.json"), true);
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
