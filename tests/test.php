<?php
    require_once __DIR__ . '/../vendor/autoload.php';

    use POEM\Parser;

    $parser=new Parser();

    $poetry=$parser->parseFile(__DIR__ . "/A+B.poetry", "poetry");

    foreach($poetry->problems as $prob){
        var_dump($prob->description);
    }

    $poetry->close();