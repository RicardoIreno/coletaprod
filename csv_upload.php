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
        $paramsFunction["COD_LATTES_16"] = $row[$rowNum["COD_LATTES_16"]];

        if ($row[$rowNum["CPF"]] == "000000000000") {
            if (!empty($row[$rowNum["COD_LATTES_16"]])) {
                $IDLattes = $row[$rowNum["COD_LATTES_16"]];
            }
        } else {
            $url = 'http://200.133.208.25/api/proxy_cpf/'.substr($row[$rowNum["CPF"]], 1, 11).'';
            $IDLattes = file_get_contents('http://200.133.208.25/api/proxy_cpf/'.substr($row[$rowNum["CPF"]], 1, 11).'');
        }

        if (!empty($_REQUEST["tag"])) {
            $queryParams[] = '&tag=' . $_REQUEST["tag"] . '';
        } else {
            $queryParams[] = '&tag=""';
        }
        if (!empty($row[$rowNum["CAMARA_NOME"]])) {
            $queryParams[] = '&unidade=' . $row[$rowNum["CAMARA_NOME"]] . '';
        } else {
            $queryParams[] = '&unidade=""';
        }

        if (!empty($row[$rowNum["DESC_DEPTO"]])) {
            $queryParams[] = '&departamento=' . $row[$rowNum["DESC_DEPTO"]] . '';
        } else {
            $queryParams[] = '&departamento=""';
        }

        if (!empty($row[$rowNum["CARGO_REDUZIDO_VINCS"]])) {
            $queryParams[] = '&tipvin=' . $row[$rowNum["CARGO_REDUZIDO_VINCS"]] . '';
        } else {
            $queryParams[] = '&tipvin=""';
        }

        if (!empty($row[$rowNum["DESC_DIV"]])) {
            $queryParams[] = '&divisao=' . $row[$rowNum["DESC_DIV"]] . '';
        } else {
            $queryParams[] = '&divisao=""';
        }

        if (!empty($row[$rowNum["DESC_SEC"]])) {
            $queryParams[] = '&secao=' . $row[$rowNum["DESC_SEC"]] . '';
        } else {
            $queryParams[] = '&secao=""';
        }

        if (!empty($row[$rowNum["PPG_NOME (PROGRAMA)"]])) {
            $queryParams[] = '&ppg_nome=' . $row[$rowNum["PPG_NOME (PROGRAMA)"]] . '';
        } else {
            $queryParams[] = '&ppg_nome=""';
        }

        if (!empty($row[$rowNum["SEXO"]])) {
            $queryParams[] = '&genero=' . $row[$rowNum["SEXO"]] . '';
        } else {
            $queryParams[] = '&genero=""';
        }

        if (!empty($r["_source"]["desc_nivel"][0])) {
            $queryParams[] = '&desc_nivel=' . $r['_source']['desc_nivel'][0] . '';
        } else {
            $queryParams[] = '&desc_nivel=""';
        }

        if (!empty($row[$rowNum["DESCR_CURSO"]])) {
            $queryParams[] = '&desc_curso=' . $row[$rowNum["DESCR_CURSO"]] . '';
        } else {
            $queryParams[] = '&desc_curso=""';
        }

        if (!empty($row[$rowNum["CAMPUS_NOME"]])) {
            $queryParams[] = '&campus=' . $row[$rowNum["CAMPUS_NOME"]] . '';
        } else {
            $queryParams[] = '&campus=""';
        }

        if (!empty($row[$rowNum["DESC_GESTORA"]])) {
            $queryParams[] = '&desc_gestora=' . $row[$rowNum["DESC_GESTORA"]] . '';
        } else {
            $queryParams[] = '&desc_gestora=""';
        }
        $queryParams[] = '&numfuncional='. $IDLattes. '';

        if (isset($IDLattes)) {
            curlLattes($url_base, $IDLattes, $queryParams);
        }
    }
    fclose($fh);
}

function curlLattes($url_base, $IDLattes, $queryParams) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, ''. $url_base .'/import_lattes_to_elastic_dedup.php?lattesID=' . $IDLattes . '');
    curl_setopt($ch, CURLOPT_POSTFIELDS, implode('', $queryParams));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    var_dump($output);
    curl_close($ch);
}