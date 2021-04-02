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
        if ($value == "CAMARA_NOME") {
            $rowNum["CAMARA_NOME"] = $key;
        }
        if ($value == "SEXO") {
            $rowNum["SEXO"] = $key;
        }
        if ($value == "PPG_NOME (PROGRAMA)") {
            $rowNum["PPG_NOME (PROGRAMA)"] = $key;
        }
        if ($value == "DESCRICAO") {
            $rowNum["DESCRICAO"] = $key;
        }
        if ($value == "DESC_GESTORA") {
            $rowNum["DESC_GESTORA"] = $key;
        }
        if ($value == "DESC_ACADEMICA") {
            $rowNum["DESC_ACADEMICA"] = $key;
        }
        if ($value == "DESC_DEPTO") {
            $rowNum["DESC_DEPTO"] = $key;
        }
        if ($value == "DESC_DIV") {
            $rowNum["DESC_DIV"] = $key;
        }
        if ($value == "DESC_SEC") {
            $rowNum["DESC_SEC"] = $key;
        }
        if ($value == "DESCR_CURSO") {
            $rowNum["DESCR_CURSO"] = $key;
        }
    }

    while (($row = fgetcsv($fh, 108192, "\t")) !== false) {
        var_dump($row);
        echo "<br/><br/>";
        $paramsFunction["COD_LATTES_16"] = $row[$rowNum["COD_LATTES_16"]];

        if ($row[$rowNum["CPF"]] == "000000000000") {
            if (!empty($row[$rowNum["COD_LATTES_16"]])) {
                echo 'Sim';
                echo "<br/><br/>";
            }
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

    if (!empty($r["_source"]["tag"])) {
        $queryParams[] = '&tag=' . $r['_source']['tag'] . '';
    }
    if (!empty($r["_source"]["unidade"][0])) {
        $queryParams[] = '&unidade=' . $r['_source']['unidade'][0] . '';
    }
    if (!empty($r["_source"]["departamento"][0])) {
        $queryParams[] = '&departamento=' . $r['_source']['departamento'][0] . '';
    }
    if (!empty($r["_source"]["tipvin"][0])) {
        $queryParams[] = '&tipvin=' . $r['_source']['tipvin'][0] . '';
    }
    if (!empty($r["_source"]["divisao"][0])) {
        $queryParams[] = '&divisao=' . $r['_source']['divisao'][0] . '';
    }
    if (!empty($r["_source"]["secao"][0])) {
        $queryParams[] = '&secao=' . $r['_source']['secao'][0] . '';
    }
    if (!empty($r["_source"]["ppg_nome"][0])) {
        $queryParams[] = '&ppg_nome=' . $r['_source']['ppg_nome'][0] . '';
    }
    if (!empty($r["_source"]["genero"][0])) {
        $queryParams[] = '&genero=' . $r['_source']['genero'][0] . '';
    }
    if (!empty($r["_source"]["desc_nivel"][0])) {
        $queryParams[] = '&desc_nivel=' . $r['_source']['desc_nivel'][0] . '';
    }
    if (!empty($r["_source"]["desc_curso"][0])) {
        $queryParams[] = '&desc_curso=' . $r['_source']['desc_curso'][0] . '';
    }
    if (!empty($r["_source"]["campus"][0])) {
        $queryParams[] = '&campus=' . $r['_source']['campus'][0] . '';
    }
    if (!empty($r["_source"]["desc_gestora"][0])) {
        $queryParams[] = '&desc_gestora=' . $r['_source']['desc_gestora'][0] . '';
    }
    var_dump(implode('', $queryParams));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'localhost/unifesp_coletaprod/import_lattes_to_elastic_dedup.php?lattesID=' . $r["_id"] . '');
    curl_setopt($ch, CURLOPT_POSTFIELDS, implode('', $queryParams));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    var_dump($output);
    curl_close($ch);
}