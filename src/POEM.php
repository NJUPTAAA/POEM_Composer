<?php
 
namespace POEM;

use Exception;
use \PhpZip\ZipFile;
 
class POEM
{
    private $workspace=null;
    private $rawJSON=null;
    private $fillable=['title','category','timeLimit','memoryLimit'];
    private $data=[
        "standard"=> "1.0",
        "generator"=> [
            "creator"=>[
                "name"=> "",
                "url"=> "",
                "version"=> ""
            ],
            "producer"=> [
                "name"=> "POEM_Composer",
                "url"=> "https://github.com/NJUPTAAA/POEM_Composer",
                "version"=> "1.1.0"
            ]
        ],
        "title"=> "Untitled Problem",
        "require"=> [],
        "category"=> "OnlineJudge",
        "resourcesFolder"=> "resources",
        "timeLimit"=> 1000,
        "memoryLimit"=> 262144,
        "description"=> null,
        "input"=> null,
        "output"=> null,
        "note"=> null,
        "source"=> [
            "url"=> false,
            "name"=> false
        ],
        "sample"=> [],
        "extra"=> [
            "markdown"=> true,
            "forceRaw"=> false,
            "partial"=> true,
            "totScore"=> 0
        ],
        "testCasesFolder"=> "testcases",
        "specialJudge"=> false,
        "solutions"=> []
    ];

    public function __toString()
    {
        return $this->rawJSON;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    public function __set($name, $value)
    {
        if(in_array($name,$this->fillable)){
            $this->data[$name]=$value;
        }
    }

    public function __construct($workspace=null)
    {
        if(is_null($workspace)){
            $this->workspace=Utils::createTmpFolder();
            mkdir($this->workspace.DIRECTORY_SEPARATOR.'resources', 0700, true);
            mkdir($this->workspace.DIRECTORY_SEPARATOR.'spj', 0700, true);
            mkdir($this->workspace.DIRECTORY_SEPARATOR.'stds', 0700, true);
            mkdir($this->workspace.DIRECTORY_SEPARATOR.'testcases', 0700, true);
        }
        $this->workspace=$workspace;
    }

    public function importJSON($json)
    {
        $this->rawJSON=$json;
        $this->data=json_decode($json);
        return $this;
    }

    
    public function getProblemList()
    {
        if($this->type!="poetry") throw new Exception("Unsupported Method");
        $list=json_decode(Utils::getFile("$this->path/main.json"),true);
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
        if(is_null($this->rawJSON)){
            $this->rawJSON=json_decode(Utils::getFile("$this->path/main.json"), true);
        }
        return $this->rawJSON;
    }

    public function getTestCasesZip()
    {
        if($this->type!="poem") throw new Exception("Unsupported Method");
        // returns ZipFile instance
        return (new ZipFile())->addDir($this->path.DIRECTORY_SEPARATOR.$this->getProblemDetails()['testCasesFolder']);
    }

    public function getSTDs()
    {
        if($this->type!="poem") throw new Exception("Unsupported Method");
        if(is_null($this->solution)){
            $this->solution=$this->getProblemDetails()['solution'];
            foreach($this->solution as &$solution){
                $solution['source']=Utils::getFile($this->path.DIRECTORY_SEPARATOR.$solution['source']);
            }
        }
        return $this->solution;
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
}
