<?php

namespace POEM;

use Exception;
use \PhpZip\ZipFile;

class POEM
{
    private $workspace = null;
    private $rawJSON = [];
    private $fillable = ['title', 'category', 'timeLimit', 'memoryLimit'];
    private $data = [];

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
            E_USER_NOTICE
        );
        return null;
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->fillable)) {
            $this->data[$name] = $value;
        }
    }

    public function __construct($workspace = null)
    {
        $this->rawJSON = $this->data = [
            "standard" => "1.0",
            "generator" => [
                "creator" => [
                    "name" => "",
                    "url" => "",
                    "version" => ""
                ],
                "producer" => [
                    "name" => "POEM_Composer",
                    "url" => "https://github.com/NJUPTAAA/POEM_Composer",
                    "version" => Utils::VERSION
                ]
            ],
            "title" => "Untitled Problem",
            "require" => [
                "MathJax" => true
            ],
            "category" => "OnlineJudge",
            "resourcesFolder" => "resources",
            "testCasesFolder" => "testcases",
            "stdFolder" => "stds",
            "spjFolder" => "spj",
            "timeLimit" => 1000,
            "memoryLimit" => 262144,
            "description" => null,
            "input" => null,
            "output" => null,
            "note" => null,
            "source" => [
                "url" => false,
                "name" => false
            ],
            "sample" => [],
            "extra" => [
                "markdown" => true,
                "forceRaw" => false,
                "partial" => true,
                "totScore" => 0
            ],
            "specialJudge" => [
                "enable" => false,
                "lcode" => null,
                "source" => null,
            ],
            "solutions" => []
        ];
        if (is_null($workspace)) {
            $this->workspace = Utils::createTmpFolder();
            mkdir($this->workspace . DIRECTORY_SEPARATOR . 'resources', 0700, true);
            mkdir($this->workspace . DIRECTORY_SEPARATOR . 'spj', 0700, true);
            mkdir($this->workspace . DIRECTORY_SEPARATOR . 'stds', 0700, true);
            mkdir($this->workspace . DIRECTORY_SEPARATOR . 'testcases', 0700, true);
        }
        $this->workspace = $workspace;
    }

    public function importJSON($json)
    {
        $this->rawJSON = $this->data = json_decode($json, true); // limit field
        foreach ($this->data['solutions'] as &$solution) {
            $solution['source'] = Utils::getFile($this->workspace . DIRECTORY_SEPARATOR . $this->stdFolder . DIRECTORY_SEPARATOR . $solution['source']);
        }
        $this->data['description'] = $this->data['input'] = $this->data['output'] = $this->data['note'] = null;
        if($this->rawJSON['description']) $this->data['description'] = Utils::getFile($this->workspace . DIRECTORY_SEPARATOR . $this->rawJSON['description']);
        if($this->rawJSON['input']) $this->data['input'] = Utils::getFile($this->workspace . DIRECTORY_SEPARATOR . $this->rawJSON['input']);
        if($this->rawJSON['output']) $this->data['output'] = Utils::getFile($this->workspace . DIRECTORY_SEPARATOR . $this->rawJSON['output']);
        if($this->rawJSON['note']) $this->data['note'] = Utils::getFile($this->workspace . DIRECTORY_SEPARATOR . $this->rawJSON['note']);
        if ($this->data['specialJudge']['enable']) {
            $this->data['specialJudge']['source'] = Utils::getFile($this->workspace . DIRECTORY_SEPARATOR . $this->spjFolder . DIRECTORY_SEPARATOR . $this->rawJSON['specialJudge']['source']);
        }
        return $this;
    }

    public function getTestCasesPackage()
    {
        return (new ZipFile())->addDir($this->workspace . DIRECTORY_SEPARATOR . $this->testCasesFolder);
    }

    public function getResourcesPackage()
    {
        return (new ZipFile())->addDir($this->workspace . DIRECTORY_SEPARATOR . $this->resourcesFolder);
    }

    public function close()
    {
        Utils::removeDir($this->workspace);
    }
}
