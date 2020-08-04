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
}

$line = fgets(fopen($argv[1], 'r'));
$mappingsArray = explode($argv[2], $line);
define("CONSTANT_ARRAY", $mappingsArray);

foreach ($mappingsArray as $mappingString) {
    $mappingsParamsArray[$mappingString]["type"] = "text";
}

$mappingsParams["index"] = $argv[3];
$mappingsParams["body"]["properties"] = $mappingsParamsArray;
$client->indices()->putMapping($mappingsParams);

$row = 1;
if (($handle = fopen($argv[1], "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, $argv[2])) !== FALSE) {
        $num = count($data);
        for ($c=1; $c < $num; $c++) {
            $docArray[CONSTANT_ARRAY[$c]] = $data[$c];
            $doc["doc"] = array_filter($docArray);
            $doc["doc_as_upsert"] = true;
        }
        unset($sha256);
        $sha256 = hash('sha256', ''.$doc["doc"]["nome"].''.$doc["doc"]["ano_eleicao"].''.$doc["doc"]["sigla_uf"].''.$doc["doc"]["cpf"].''.$doc["doc"]["titulo_eleitoral"].'');
        if (!is_null($doc)) {
            $resultado = Elasticsearch::update($sha256, $doc, $argv[3]);
        }
        print_r($resultado);
        unset($doc);
    }
    fclose($handle);
}
?>
