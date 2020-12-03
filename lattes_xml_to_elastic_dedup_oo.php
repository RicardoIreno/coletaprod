<?php

require 'inc/config.php';
require 'inc/functions.php';

Class Obra
{
    public $name;
    function __construct() {
        $this->type = "Work";
    }
    function getDoc() {
        $doc = $this->type;
        return $doc;
    }
}

Class TrabalhosEmEventos extends Obra
{
    function __construct() {

    }
}

$obra = new Obra();
print("<pre>".print_r($obra, true)."</pre>");
var_dump($obra);

?>