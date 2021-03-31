<?php

require 'inc/config.php';
require 'inc/functions.php';

if (isset($_FILES['file'])) {

    $fh = fopen($_FILES['file']['tmp_name'], 'r+');
    $row = fgetcsv($fh, 108192, "\t");

    foreach ($row as $key => $value) {
        if ($value == "CPF") {
            $rowNum["CPF"] = $key;
        }
        if ($value == "COD_LATTES_16") {
            $rowNum["COD_LATTES_16"] = $key;
        }
        if ($value == "CARGO_REDUZIDO_VINCS") {
            $rowNum["CARGO_REDUZIDO_VINCS"] = $key;
        }
        if ($value == "CAMPUS_NOME") {
            $rowNum["CAMPUS_NOME"] = $key;
        }        
        if ($value == "PPG_NOME (PROGRAMA)") {
            $rowNum["PPG_NOME (PROGRAMA)"] = $key;
        }
        if ($value == "DESCRICAO") {
            $rowNum["DESCRICAO"] = $key;
        }
    }


    while (($row = fgetcsv($fh, 108192, "\t")) !== false) {
        var_dump($row);
        echo "<br/><br/>";
        $COD_LATTES_16 = $row[$rowNum["COD_LATTES_16"]];

        if ($row[$rowNum["CPF"]] == "000000000000") {
            echo 'Sim';
            echo "<br/><br/>";
        } else {
            echo 'Não';
            echo "<br/>";
            $url = 'http://200.133.208.25/api/proxy_cpf/'.substr($row[$rowNum["CPF"]], 1, 11).'';
            var_dump($url);
            $idLattes = file_get_contents('http://200.133.208.25/api/proxy_cpf/'.substr($row[$rowNum["CPF"]], 1, 11).'');
            echo "ID Lattes: ";
            var_dump($idLattes);
            echo "<br/><br/>";
        }
        $doc["doc"]["CPF"] = $row[$rowNum["CPF"]];
        $doc["doc"]["COD_LATTES_16"] = $row[$rowNum["COD_LATTES_16"]];
        var_dump($doc);
        echo "<br/><br/>";
        unset($doc);
    }
    fclose($fh);
}

function curlLattes() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'localhost/unifesp_coletaprod/import_lattes_to_elastic_dedup.php?lattesID=' . $r["_id"] . '');
    curl_setopt($ch, CURLOPT_POSTFIELDS, implode('', $queryParams));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    var_dump($output);
    curl_close($ch);
}