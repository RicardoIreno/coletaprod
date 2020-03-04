<!DOCTYPE html>
<?php

require 'inc/config.php'; 
require 'inc/functions.php';

if (!empty($_POST)) {
    foreach ($_POST as $key=>$value) {            
        $var_concluido["doc"]["concluido"] = $value;
        $var_concluido["doc"]["doc_as_upsert"] = true; 
        Elasticsearch::update($key, $var_concluido);
    }
    sleep(6);
    header("Refresh:0");
}

// if (isset($_GET["filter"])) {
//     if (!in_array("type:\"Work\"", $_GET["filter"])) {
//         $_GET["filter"][] = "type:\"Work\"";
//     }
// } else {
//     $_GET["filter"][] = "type:\"Work\"";
// }



if (isset($fields)) {
    $_GET["fields"] = $fields;
}
$result_get = Requests::getParser($_GET);
$limit = $result_get['limit'];
$page = $result_get['page'];
$params = [];
$params["index"] = $index_source;
$params["body"] = $result_get['query'];
$cursorTotal = $client->count($params);
$total = $cursorTotal["count"];
if (isset($_GET["sort"])) {
    $result_get['query']["sort"][$_GET["sort"]]["unmapped_type"] = "long";
    $result_get['query']["sort"][$_GET["sort"]]["missing"] = "_last";
    $result_get['query']["sort"][$_GET["sort"]]["order"] = "desc";
    $result_get['query']["sort"][$_GET["sort"]]["mode"] = "max";
} else {
    $result_get['query']['sort']['datePublished.keyword']['order'] = "desc";
    $result_get['query']["sort"]["_uid"]["unmapped_type"] = "long";
    $result_get['query']["sort"]["_uid"]["missing"] = "_last";
    $result_get['query']["sort"]["_uid"]["order"] = "desc";
    $result_get['query']["sort"]["_uid"]["mode"] = "max";
}
$params["body"] = $result_get['query'];
$params["size"] = $limit;
$params["from"] = $result_get['skip'];
$cursor = $client->search($params);

/*pagination - start*/
$get_data = $_GET;    
/*pagination - end*/      

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include('inc/meta-header-new.php'); 
        ?>        
        <title>Coletaprod - Resultado da busca por trabalhos</title>
        
    </head>
    <body>

        <!-- NAV -->
        <?php require 'inc/navbar.php'; ?>
        <!-- /NAV -->
        <br/><br/><br/><br/>

        <main role="main">
            <div class="container">

            <div class="row">
                <div class="col-8">    

                    <!-- Navegador de resultados - Início -->
                    <?php ui::pagination($page, $total, $limit, "result_source.php"); ?>
                    <!-- Navegador de resultados - Fim -->   

                    <?php foreach ($cursor["hits"]["hits"] as $r) : ?>

                        <?php //print_r($r); ?>
                        <?php if (empty($r["_source"]['datePublished'])) {
                            $r["_source"]['datePublished'] = "";
                        }
                        ?>

                        <div class="card">
                            <div class="card-body">

                                <h6 class="card-subtitle mb-2 text-muted"><?php isset($r["_source"]['source']) ? $r["_source"]['source'] : ""; ?></h6>
                                <h5 class="card-title text-dark"><?php echo $r["_source"]['name']; ?> (<?php echo $r["_source"]['datePublished'];?>)</h5>

                                <p class="text-muted"><b>Autores:</b>
                                    <?php if (!empty($r["_source"]['author'])) : ?>
                                        <?php foreach ($r["_source"]['author'] as $autores) {
                                            $authors_array[]='<a href="result.php?filter[]=author.person.name:&quot;'.$autores["person"]["name"].'&quot;">'.$autores["person"]["name"].'</a>';
                                        } 
                                        $array_aut = implode(", ",$authors_array);
                                        unset($authors_array);
                                        print_r($array_aut);
                                        ?>
                                    <?php endif; ?>
                                </p>
                                
   
                                <?php if (!empty($r["_source"]['isPartOf']['name'])) : ?>                                        
                                    <p class="text-muted"><b>In:</b> <a href="result.php?filter[]=isPartOf.name:&quot;<?php echo $r["_source"]['isPartOf']['name'];?>&quot;"><?php echo $r["_source"]['isPartOf']['name'];?></a></p>
                                <?php endif; ?>
                                <?php if (!empty($r["_source"]['isPartOf']['issn'])) : ?>
                                    <p class="text-muted"><b>ISSN:</b> <a href="result.php?filter[]=isPartOf.issn:&quot;<?php echo $r["_source"]['isPartOf']['issn'];?>&quot;"><?php echo $r["_source"]['isPartOf']['issn'];?></a></li>                                        
                                <?php endif; ?>
                                <?php if (!empty($r["_source"]['EducationEvent']['name'])) : ?>
                                    <p class="text-muted"><b>Nome do evento:</b> <?php echo $r["_source"]['EducationEvent']['name'];?></p>
                                <?php endif; ?>                                   
                                
                                <?php if (!empty($r["_source"]['doi'])) : ?>
                                    <p class="text-muted"><b>DOI:</b>    <a href="https://doi.org/<?php echo $r["_source"]['doi'];?>"><span id="<?php echo $r['_id'] ?>"><?php echo $r["_source"]['doi'];?></span></a> <button class="btn btn-info" onclick="copyToClipboard('#<?=$r['_id']?>')">Copiar DOI</button> <a class="btn btn-warning" href="doi_to_elastic.php?doi=<?php echo $r['_source']['doi'];?>&tag=<?php echo $r['_source']['tag'][0];?>">Coletar dados da Crossref</a></p>                                        
                                <?php endif; ?>

                                <?php if (!empty($r["_source"]['url'])) : ?>
                                    <p class="text-muted"><b>URL:</b> <a href="<?php echo str_replace("]", "", str_replace("[", "", $r["_source"]['url'])); ?>"><?php echo str_replace("]", "", str_replace("[", "", $r["_source"]['url']));?></a></p>
                                <?php endif; ?>                                                                             
                                
                                <?php if (!empty($r["_source"]['ids_match'])) : ?>  
                                    <?php foreach ($r["_source"]['ids_match'] as $id_match) : ?>
                                        <?php compararRegistros::match_id($id_match["id_match"], $id_match["nota"]);?>
                                    <?php endforeach;?>
                                <?php endif; ?>                                     


                  

                            </div>
                        </div>
                        <?php endforeach;?>


                        <!-- Navegador de resultados - Início -->
                        <?php ui::pagination($page, $total, $limit, "result_source.php"); ?>
                        <!-- Navegador de resultados - Fim -->  

                </div>
                <div class="col-4">
                
                <hr>
                <h3>Refinar meus resultados</h3>    
                <hr>
                <?php
                    $facets = new facets();
                    $facets->query = $result_get['query'];

                    if (!isset($_GET)) {
                        $_GET = null;                                    
                    }                       
                    
                    $facets->facet("tipo", 100, "Tipo de material", null, "_term", $_GET, $index_source);
                    $facets->facet("author.person.name", 100, "Nome completo do autor", null, "_term", $_GET, $index_source);
                    $facets->facet("datePublished", 120, "Ano de publicação", "desc", "_term", $_GET, $index_source);
                    $facets->facet("language", 40, "Idioma", null, "_term", $_GET, $index_source);
                    $facets->facet("about", 100, "Palavras-chave", null, "_term", $_GET, $index_source);
                    $facets->facet("publisher.organization.name", 100, "Editora", null, "_term", $_GET, $index_source);
                    $facets->facet("isPartOf.name", 100, "Título do periódico", null, "_term", $_GET, $index_source);
                    $facets->facet("isPartOf.issn", 50, "ISSN", null, "_term", $_GET, $index_source);

                ?>
                </ul>
                <!-- Limitar por data - Início -->
                <form action="result.php?" method="GET">
                    <h5 class="mt-3">Filtrar por ano de publicação</h5>
                    <?php 
                        parse_str($_SERVER["QUERY_STRING"], $parsedQuery);
                        foreach ($parsedQuery as $k => $v) {
                            if (is_array($v)) {
                                foreach ($v as $v_unit) {
                                    echo '<input type="hidden" name="'.$k.'[]" value="'.htmlentities($v_unit).'">';
                                }
                            } else {
                                if ($k == "initialYear") {
                                    $initialYearValue = $v;
                                } elseif ($k == "finalYear") {
                                    $finalYearValue = $v;
                                } else {
                                    echo '<input type="hidden" name="'.$k.'" value="'.htmlentities($v).'">';
                                }                                    
                            }
                        }

                        if (!isset($initialYearValue)) {
                            $initialYearValue = "";
                        }                            
                        if (!isset($finalYearValue)) {
                            $finalYearValue = "";
                        }

                    ?>
                    <div class="form-group">
                        <label for="initialYear">Ano inicial</label>
                        <input type="text" class="form-control" id="initialYear" name="initialYear" pattern="\d{4}" placeholder="Ex. 2010" value="<?php echo $initialYearValue; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="finalYear">Ano final</label>
                        <input type="text" class="form-control" id="finalYear" name="finalYear" pattern="\d{4}" placeholder="Ex. 2020" value="<?php echo $finalYearValue; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>   
                <!-- Limitar por data - Fim -->
                <hr>     
                        
            </div>
        </div>
                

        <?php include('inc/footer.php'); ?>

        </div>

        <script>
            function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            }
        </script>
        
    </body>
</html>