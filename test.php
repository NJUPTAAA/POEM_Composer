<?php  
require_once __DIR__ . '/vendor/autoload.php';  

use POEM\Parser;  

$parser=new Parser();

var_dump($parser->parse("[]"));