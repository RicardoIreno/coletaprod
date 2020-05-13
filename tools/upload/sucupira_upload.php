<?php

require '../../inc/config.php';
require '../../inc/functions.php';

if (isset($_FILES['file'])) {

    $fh = fopen($_FILES['file']['tmp_name'], 'r+');
    $row = fgetcsv($fh, 8192, "\t");

    foreach ($row as $key => $value) {
        if ($value == "NM_PRODUCAO") {
            $rowNum["NM_PRODUCAO"] = $key;
        }
        if ($value == "ID_PRODUCAO_INTELECTUAL") {
            $rowNum["ID_PRODUCAO_INTELECTUAL"] = $key;
        }
    }

    while (($row = fgetcsv($fh, 8192, "\t")) !== false) {
        //print_r($row);
        $doc = Record::Build($row, $rowNum, $_POST["tag"]);
        //if (!is_null($doc["doc"]["name"]) & !is_null($doc["doc"]["datePublished"])) {
            //$doc["doc"]["bdpi"] = DadosExternos::query_bdpi_index($doc["doc"]["name"], $doc["doc"]["datePublished"]);
        //}
        $sha256 = hash('sha256', ''.$doc["doc"]["source_id"].'');
        print_r($sha256);
        print_r($doc);
        // if (!is_null($sha256)) {
        //     $resultado_scopus = Elasticsearch::update($sha256, $doc);
        // }
        // print_r($resultado_scopus);
        // print_r($doc["doc"]["source_id"]);
        // echo "<br/><br/><br/>";
        flush();

    }
}

//sleep(5);
//echo '<script>window.location = \'result.php?filter[]=type:"Work"&filter[]=tag:"'.$_POST["tag"].'"\'</script>';

class Record
{
    public static function build($row, $rowNum, $tag = "")
    {
        $doc["doc"]["type"] = "Work";
        $doc["doc"]["source"] = "Sucupira";
        $doc["doc"]["match"]["tag"][] = "Sucupira";
        $doc["doc"]["name"] = str_replace('"', '', $row[$rowNum["NM_PRODUCAO"]]);
        // $doc["doc"]["datePublished"] = $row[$rowNum["year"]];
        $doc["doc"]["source_id"] = $row[$rowNum["ID_PRODUCAO_INTELECTUAL"]];
        $doc["doc"]["tag"][] = $tag;
        // if (!empty($row[$rowNum["DOI"]]) && $row[$rowNum["DOI"]] != "") {
        //   $doc["doc"]["doi"] = $row[$rowNum["DOI"]];
        // }
        // $doc["doc"]["language"] = $row[$rowNum["language"]];
        // $doc["doc"]["description"] = $row[$rowNum["Abstract"]];

        // $doc["doc"]["tipo"] = $row[$rowNum["type"]];

        // $doc["doc"]["isPartOf"]["name"] = strtoupper($row[$rowNum["sourceTitle"]]);
        // $doc["doc"]["isPartOf"]["volume"] = $row[$rowNum["Volume"]];
        // $doc["doc"]["isPartOf"]["fasciculo"] = $row[$rowNum["Issue"]];
        // $doc["doc"]["pageStart"] = $row[$rowNum["PageStart"]];
        // $doc["doc"]["pageEnd"] = $row[$rowNum["PageEnd"]];
        // $doc["doc"]["isPartOf"]["issn"] = $row[$rowNum["ISSN"]];
        // $doc["doc"]["publisher"]["organization"]["name"] = $row[$rowNum["Publisher"]];
        // $doc["doc"]["citedby"] = $row[$rowNum["CitedBy"]];
        // $doc["doc"]["scopus"]["citedby"] = $row[$rowNum["CitedBy"]];
        // $doc["doc"]["scopus"]["references"] = $row[$rowNum["References"]];


        // // Agência de fomento
        // $agencia_de_fomento_array = explode(";", $row[$rowNum["FundingDetails"]]);
        // $i_funder = 0;
        // foreach ($agencia_de_fomento_array as $funder) {
        //     $funderArray = explode(",", $funder);
        //     if (count($funderArray) > 2) {
        //         $doc["doc"]["funder"][$i_funder]["projectNumber"] = $funderArray[0];
        //         $doc["doc"]["funder"][$i_funder]["name"] = ''.$funderArray[2].' ('.$funderArray[1].')';
        //     } elseif (count($funderArray) > 1) {
        //         $doc["doc"]["funder"][$i_funder]["name"] = ''.$funderArray[1].' ('.$funderArray[0].')';
        //     } else {
        //         $doc["doc"]["funder"][$i_funder]["name"] = $funderArray[0];
        //     }
        //     $i_funder++;
        // }

        // // Palavras chave
        // $palavras_chave_authors = explode(";", $row[$rowNum["AuthorKeywords"]]);
        // $palavras_chave_scopus = explode(";", $row[$rowNum["IndexKeywords"]]);
        // $doc["doc"]["about"] = array_merge($palavras_chave_authors, $palavras_chave_scopus);

        // // Autores
        // $authorsArray = explode(";", $row[$rowNum["AuthorsWithAffiliations"]]);
        // $i_autAff=0;
        // foreach ($authorsArray as $autAff) {
        //     $autAffArray = explode("., ", $autAff);
        //     $doc["doc"]["author"][$i_autAff]["person"]["name"] = $autAffArray[0];
        //     $doc["doc"]["author"][$i_autAff]["person"]["affiliation"]["name"] = $autAffArray[1];
        //     $doc["doc"]["institutions"][] = $autAffArray[1];
        //     $i_autAff++;
        // }
        // $autores_nome_array = explode(",", $row[0]);
        // $autores_afiliacao_array = explode(";", $row[$rowNum["Affiliations"]]);
        // for ($i=0;$i<count($autores_nome_array);$i++) {
        //     $doc["doc"]["autores"][$i]["nomeCompletoDoAutor"] = $autores_nome_array[$i];
        //     $doc["doc"]["autores"][$i]["nomeAfiliacao"] = $autores_afiliacao_array[$i];
        // }

        $doc["doc_as_upsert"] = true;
        return $doc;



    }
}

?>
