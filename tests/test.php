<?php
require_once __DIR__ . '/../vendor/autoload.php';

use POEM\Parser;

$parser=new Parser();

$poetryRaw=file_get_contents(__DIR__ . "/A+B.poetry");

$problems=$parser->parseStream($poetryRaw, "poetry")->getProblemList()["problems"];

foreach($problems as $prob){
    var_dump($prob->getProblemDetails());
}