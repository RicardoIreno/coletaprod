<?php

require 'inc/config.php';
require 'inc/functions.php';

Class Work
{
    public $type;
    public $source;
    public $lattes_ids;
    public $tag;
    public $name;
    public $author;
    public $datePublished;
    public $language;
    public $url;
    public $doi;
    public $pageStart;
    public $pageEnd;

    function __construct()
    {
        $this->type = "Work";
    }
    function getDoc()
    {
        $doc = $this->type;
        return $doc;
    }
}

Class LattesWork extends Work
{
    public $lattes;
    public function __construct()
    {
        parent::__construct();
        $this->source = "Base Lattes";
    }
}

Class TrabalhosEmEventosLattes extends LattesWork
{
    public $detalhamentoDoTrabalho;
    function __construct()
    {
        parent::__construct();
    }
}

$obra = new TrabalhosEmEventosLattes();
$obra->name = 'Teste';
$obra->lattes["natureza"] = 'Natureza';
print("<pre>".print_r($obra, true)."</pre>");

$json = json_encode(get_object_vars($obra), JSON_PRETTY_PRINT);
echo "JSON:<br/>";
print("<pre>".print_r($json, true)."</pre>");

?>