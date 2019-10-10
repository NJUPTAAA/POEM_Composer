<?php

namespace POEM;

use Exception;
use \PhpZip\ZipFile;

class POETRY
{
    private $workspace = null;
    private $rawJSON = [];
    private $problemCounter = 0;
    private $fillable = ['description'];
    private $data = [];

    public function __toString()
    {
        return json_encode($this->rawJSON);
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

        $this->data = $this->rawJSON = [
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
                    "version" => "1.1.0"
                ]
            ],
            "description" => "",
            "problems" => []
        ];

        if (is_null($workspace)) {
            $this->workspace = Utils::createTmpFolder();
        }
        $this->workspace = $workspace;
    }

    public function importJSON($json)
    {
        $this->rawJSON = $this->data = json_decode($json, true); // limit fields
        $problems = $this->rawJSON["problems"];
        $this->data["problems"] = [];
        foreach ($problems as $problem) {
            $this->data["problems"][] = (new Parser())->parseFile("$this->workspace/$problem", "poem");
        }
        return $this;
    }

    public function addProblem($workspace = null)
    {
        if (is_null($workspace)) {
            $workspace = Utils::createTmpFolder();
        }
        $problemCounter = ++$this->problemCounter;
        $this->rawJSON['problems'][] = "PROB_$problemCounter.md";
        $poem = new POEM($workspace);
        $this->data['problems'][] = $poem;
        return $poem;
    }

    public function removeProblem()
    { }

    public function close()
    {
        foreach ($this->data['problems'] as $problem) {
            $problem->close();
        }
        Utils::removeDir($this->workspace);
    }
}
