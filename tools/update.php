<?php

// Set directory to ROOT
chdir('../');
// Include essencial files
require 'inc/config.php';
require 'inc/functions.php';

$query["query"]["query_string"]["query"] = "*";
$params = [];
$params["index"] = $index_cv;
$params["size"] = 50;
$params["scroll"] = "30s";
//$params["_source"] = ["doi","name","author","datePublished","type","language","country","isPartOf","unidade","releasedEvent","USP.titleSearchCrossrefDOI"];
$params["body"] = $query;

$cursor = $client->search($params);

foreach ($cursor["hits"]["hits"] as $r) {
    //var_dump($r);
    //var_dump($r["_source"]["data_atualizacao"]);
    $formattedRecordDate = date_format(date_create_from_format('Y-m', $r["_source"]["data_atualizacao"]), 'Y-m-d');
    var_dump($formattedRecordDate);
    $lattesDate = substr(file_get_contents('http://200.133.208.25/api/proxy_data_atualizacao/'.$r["_id"].''), 0, 10);
    //var_dump($lattesDate);
    $formattedLattesDate = date_format(date_create_from_format('d/m/Y', $lattesDate), 'Y-m-d');
    var_dump($formattedLattesDate);
    if ($formattedRecordDate > $formattedLattesDate) {
        echo "sim";
    } else {
        echo "não";
    }
}


while (isset($cursor['hits']['hits']) && count($cursor['hits']['hits']) > 0) {
    $scroll_id = $cursor['_scroll_id'];
    $cursor = $client->scroll(
        [
            "scroll_id" => $scroll_id,
            "scroll" => "30s"
        ]
    );

    foreach ($cursor["hits"]["hits"] as $r) {
        var_dump($r);
    }
}