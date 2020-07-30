<?php

# To run: php upload_csv.php FILE SEPARATOR NAME_OF_INDEX_IN_ELASTICSEARCH

require '../../inc/config.php';
require '../../inc/functions.php';


/* Connect to Elasticsearch - Index */
try {
    $client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
    $indexParams['index']  = $argv[3];
    $testIndex = $client->indices()->exists($indexParams);
} catch (Exception $e) {
    echo "Índice no elasticsearch não foi encontrado";
}
if (isset($argv[3]) && $testIndex == false) {
    Elasticsearch::createIndex($argv[3], $client);
    //Elasticsearch::mappingsIndex($index, $client);
}


$row = 1;
if (($handle = fopen($argv[1], "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, $argv[2])) !== FALSE) {
        if (!defined('CONSTANT_ARRAY')) {
            define("CONSTANT_ARRAY", $data);
        } else {
            $num = count($data);
            for ($c=0; $c < $num; $c++) {
                $docArray[CONSTANT_ARRAY[$c]] = $data[$c];
                $doc["doc"] = array_filter($docArray);
                $doc["doc_as_upsert"] = true;
            }
        }
        print_r($doc);
        unset($sha256);
        if (!is_null($doc)) {
            $sha256 = hash('sha256', ''.$doc["doc"]["numero_processo_candidatura"].'');
        }
        if (!is_null($sha256)) {
            $resultado = Elasticsearch::update($sha256, $doc, $argv[3]);
        }
        print_r($resultado);
        unset($doc);
    }
    fclose($handle);
}
?>
