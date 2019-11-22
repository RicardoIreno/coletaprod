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

if (isset($_GET["filter"])) {
    if (!in_array("type:\"Work\"", $_GET["filter"])) {
        $_GET["filter"][] = "type:\"Work\"";
    }
} else {
    $_GET["filter"][] = "type:\"Work\"";
}



if (isset($fields)) {
    $_GET["fields"] = $fields;
}
$result_get = Requests::getParser($_GET);
$limit = $result_get['limit'];
$page = $result_get['page'];
$params = [];
$params["index"] = $index;
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


// $result_get = Requests::getParser($_GET);
// $query = $result_get['query'];
// $limit = $result_get['limit'];
// $page = $result_get['page'];
// $skip = $result_get['skip'];

// //$query['sort'] = [
// //    ['datePublished' => ['order' => 'desc']],
// //];

// $params = [];
// $params["index"] = $index;
// $params["size"] = $limit;
// $params["from"] = $skip;
// $params["body"] = $query;

// $cursor = $client->search($params);
// $total = $cursor["hits"]["total"];

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
        <title>Lattes USP - Resultado da busca por trabalhos</title>
        
        <script src="http://cdn.jsdelivr.net/g/filesaver.js"></script>
        <script>
              function SaveAsFile(t,f,m) {
                    try {
                        var b = new Blob([t],{type:m});
                        saveAs(b, f);
                    } catch (e) {
                        window.open("data:"+m+"," + encodeURIComponent(t), '_blank','');
                    }
                }
        </script>         
        
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
                    <?php ui::pagination($page, $total, $limit); ?>
                    <!-- Navegador de resultados - Fim -->   

                    <?php foreach ($cursor["hits"]["hits"] as $r) : ?>
                        <?php if (empty($r["_source"]['datePublished'])) {
                            $r["_source"]['datePublished'] = "";
                        }
                        ?>
                        <li>
                            <div class="uk-grid-divider uk-padding-small" uk-grid>
                                <div class="uk-width-1-5@m">                        
                                    <div class="uk-panel uk-h6 uk-text-break">
                                        <a href="result_trabalhos.php?type[]=<?php echo $r["_source"]['tipo'];?>"><?php echo ucfirst(strtolower($r["_source"]['tipo']));?></a>
                                    </div>
                                    <form class="uk-form" method="post">
                                        <?php if(isset($r["_source"]["concluido"])) : ?>
                                            <?php if($r["_source"]["concluido"]== "Sim") : ?>    
                                                
                                                    <label><input type='hidden' value='Não' name="<?php echo $r['_id'];?>"></label>                                     
                                                    <label><input type="checkbox" name="<?php echo $r['_id'];?>" value='Sim' checked>Concluído</label>
                                            
                                            <?php else : ?>
                                                
                                                    <label><input type='hidden' value='Não' name="<?php echo $r['_id'];?>"></label>                                     
                                                    <label><input type="checkbox" name="<?php echo $r['_id'];?>" value='Sim'>Concluído</label>
                                                
                                            <?php endif; ?>                                    
                                        <?php else : ?>
                                                
                                                    <label><input type='hidden' value='Não' name="<?php echo $r['_id'];?>"></label>                                     
                                                    <label><input type="checkbox" name="<?php echo $r['_id'];?>" value='Sim'>Concluído</label>
                                                
                                        <?php endif; ?>
                                        <button class="uk-button-primary">Marcar como concluído</button>
                                    </form>                                     
                                </div>
                                <div class="uk-width-4-5@m">
                                    <article class="uk-article">
                                    <p class="uk-text-lead uk-margin-remove" style="font-size:115%"><?php echo ($r["_source"]['name']);?> (<?php echo $r["_source"]['datePublished']; ?>)</p> 
                                    <ul class="uk-list">
                                        <li class="uk-h6">
                                            Autores:
                                            <?php if (!empty($r["_source"]['author'])) : ?>
                                            <?php foreach ($r["_source"]['author'] as $autores) {
                                                $authors_array[]='<a href="result_trabalhos.php?filter[]=author.person.name:&quot;'.$autores["person"]["name"].'&quot;">'.$autores["person"]["name"].'</a>';
                                            } 
                                            $array_aut = implode(", ",$authors_array);
                                            unset($authors_array);
                                            print_r($array_aut);
                                            ?>
                                            
                                            
                                            <?php endif; ?>                           
                                        </li>
                                        
                                        <?php if (!empty($r["_source"]['artigoPublicado'])) : ?>
                                            <li class="uk-h6">In: <a href="result_trabalhos.php?filter[]=periodico.titulo_do_periodico:&quot;<?php echo $r["_source"]['artigoPublicado']['tituloDoPeriodicoOuRevista'];?>&quot;"><?php echo $r["_source"]['artigoPublicado']['tituloDoPeriodicoOuRevista'];?></a></li>
                                            <li class="uk-h6">ISSN: <a href="result_trabalhos.php?filter[]=periodico.issn:&quot;<?php echo $r["_source"]['artigoPublicado']['issn'];?>&quot;"><?php echo $r["_source"]['artigoPublicado']['issn'];?></a></li>                                        
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($r["_source"]['doi'])) : ?>
                                            <li class="uk-h6"><p>DOI: <a href="https://doi.org/<?php echo $r["_source"]['doi'];?>"><?php echo $r["_source"]['doi'];?></a></p>
                                            <p><a href="doi_to_elastic.php?doi=<?php echo $r['_source']['doi'];?>&tag=<?php echo $r['_source']['tag'][0];?>">Coletar dados da Crossref</a></p></li>                                        
                                        <?php endif; ?>                                        
                                        
                                        <li class="uk-h6">
                                            Assuntos:
                                            <?php if (!empty($r["_source"]['palavras_chave'])) : ?>
                                            <?php foreach ($r["_source"]['palavras_chave'] as $assunto) : ?>
                                                <a href="result_trabalhos.php?filter[]=palavras_chave:&quot;<?php echo $assunto;?>&quot;"><?php echo $assunto;?></a>
                                            <?php endforeach;?>
                                            <?php endif; ?>
                                        </li>
                                        
                                        <?php if (!empty($r["_source"]['ids_match'])) : ?>  
                                        <?php foreach ($r["_source"]['ids_match'] as $id_match) : ?>
                                            <?php compararRegistros::match_id($id_match["id_match"], $id_match["nota"]);?>
                                        <?php endforeach;?>
                                        <?php endif; ?>
                                        
                                        <?php 
                                        if ($instituicao == "USP") {
                                            DadosExternos::query_bdpi($r["_source"]['name'], $r["_source"]['datePublished'], $r['_id']);
                                        }
                                        ?>        
                                        
                                        <li class="uk-h6">
                                            <!-- This is a button toggling the modal -->
                                            <button uk-toggle="target: #<?php echo $r['_id']; ?>" type="button">Ver em tabela</button>

                                            <!-- This is the modal -->
                                            <div id="<?php echo $r['_id']; ?>" uk-modal>
                                                <div class="uk-modal-dialog uk-modal-body">
                                                    <h2 class="uk-modal-title">Tabela</h2>
                                                    <table class="uk-table">
                                                        <caption></caption>
                                                        <thead>
                                                            <tr>
                                                                <th>Titulo</th>
                                                                <th>Autores</th>
                                                                <th>Ano</th>
                                                                <th>Idioma</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo ($r["_source"]['name']);?></td>
                                                                <td><?php echo ($array_aut);?></td>
                                                                <td><?php echo $r["_source"]['datePublished']; ?></td>
                                                                <td><?php echo $r["_source"]['language']; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>                                                
                                                    <button class="uk-modal-close" type="button"></button>
                                                </div>
                                            </div>                                    
                                        
                                        </li>


                                        <li class="uk-h6">
                                        <?php
                                        
                                        if (isset($dspaceRest)) { 
                                            echo '<form action="dspaceConnect.php" method="get">
                                                <input type="hidden" name="createRecord" value="true" />
                                                <input type="hidden" name="_id" value="'.$r['_id'].'" />
                                                <button class="uk-button uk-button-danger" name="btn_submit">Criar registro no DSpace</button>
                                                </form>';  
                                        }
                                        
                                        ?>
                                        </li>
                                        <li class="uk-h6">
                                            <a href="tools/export.php?search[]=_id:<?php echo $r['_id'] ?>&format=alephseq" class="uk-margin-top">Exportar Alephseq</a>
                                        </li>
                                        <li class="uk-h6">
                                            <a href="editor.php?_id=<?php echo $r['_id'] ?>" class="uk-margin-top">Editar registro</a>
                                        </li>                                    
                                        
                                        <p><a href="#" class="uk-margin-top" uk-toggle="target: #citacao<?php echo  $r['_id'];?>">Ver todos os dados deste registro</a></p>
                                        <div id="citacao<?php echo  $r['_id'];?>" hidden>                                        
                                            <li class="uk-h6"> 
                                                <table class="uk-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Nome do campo</th>
                                                            <th>Valor</th>
                                                        </tr>
                                                    </thead>    
                                                    <tbody>
                                                        <?php foreach ($r["_source"] as $key => $value) {
                                                                echo '<tr><td>'.$key.'</td><td>';
                                                                if (is_array($value)) {
                                                                    foreach ($value as $valor) {
                                                                        if (is_array($valor)) {
                                                                                foreach ($valor as $valor1) {
                                                                                    //echo ''.$valor1.'';
                                                                                }
                                                                            } else {
                                                                                echo ''.$valor.''; 
                                                                            }
                                                                        }

                                                                } else {
                                                                    echo ''.$value.'';
                                                                }
                                                                echo '</td>';
                                                                echo '</tr>';
                                                        };?>
                                                    </tbody>
                                                </table>
                                            </li>
                                        </div>    
                                            
                                    </ul>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach;?>


                        <!-- Navegador de resultados - Início -->
                        <?php ui::pagination($page, $total, $limit); ?>
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
                    
                    $facets->facet("Lattes.natureza", 100, "Natureza", null, "_term", $_GET);
                    $facets->facet("tipo", 100, "Tipo de material", null, "_term", $_GET);
                    $facets->facet("tag", 100, "Tag", null, "_term", $_GET);
                    
                    $facets->facet("author.person.name", 100, "Nome completo do autor", null, "_term", $_GET);
                    $facets->facet("lattes_ids", 100, "Número do lattes", null, "_term", $_GET);
                    $facets->facet("USP.codpes",100,"Número USP",null,"_term",$_GET);
                    $facets->facet("USP.unidadeUSP",100,"Unidade USP",null,"_term",$_GET);
                    
                    $facets->facet("country",200,"País de publicação",null,"_term",$_GET);
                    $facets->facet("datePublished",120,"Ano de publicação","desc","_term",$_GET);
                    $facets->facet("language",40,"Idioma",null,"_term",$_GET);
                    $facets->facet("Lattes.meioDeDivulgacao",100,"Meio de divulgação",null,"_term",$_GET);
                    $facets->facet("about",100,"Palavras-chave",null,"_term",$_GET);
                    $facets->facet("agencia_de_fomento",100,"Agências de fomento",null,"_term",$_GET);

                    $facets->facet("Lattes.flagRelevancia",100,"Relevância",null,"_term",$_GET);
                    $facets->facet("Lattes.flagDivulgacaoCientifica",100,"Divulgação científica",null,"_term",$_GET);
                    
                    $facets->facet("area_do_conhecimento.nomeGrandeAreaDoConhecimento", 100, "Nome da Grande Área do Conhecimento", null, "_term", $_GET);
                    $facets->facet("area_do_conhecimento.nomeDaAreaDoConhecimento", 100, "Nome da Área do Conhecimento", null, "_term", $_GET);
                    $facets->facet("area_do_conhecimento.nomeDaSubAreaDoConhecimento", 100, "Nome da Sub Área do Conhecimento", null, "_term", $_GET);
                    $facets->facet("area_do_conhecimento.nomeDaEspecialidade", 100, "Nome da Especialidade", null, "_term", $_GET);
                    
                    $facets->facet("trabalhoEmEventos.classificacaoDoEvento", 100, "Classificação do evento", null, "_term", $_GET); 
                    $facets->facet("EducationEvent.name", 100, "Nome do evento", null, "_term", $_GET);
                    $facets->facet("publisher.organization.location", 100, "Cidade do evento", null, "_term", $_GET);
                    $facets->facet("trabalhoEmEventos.anoDeRealizacao", 100, "Ano de realização do evento", null, "_term", $_GET);
                    $facets->facet("trabalhoEmEventos.tituloDosAnaisOuProceedings", 100, "Título dos anais", null, "_term", $_GET);
                    $facets->facet("trabalhoEmEventos.isbn", 100, "ISBN dos anais", null, "_term", $_GET);
                    $facets->facet("trabalhoEmEventos.nomeDaEditora", 100, "Editora dos anais", null, "_term", $_GET);
                    $facets->facet("trabalhoEmEventos.cidadeDaEditora", 100, "Cidade da editora", null, "_term", $_GET);

                    $facets->facet("midiaSocialWebsiteBlog.formacao_maxima", 100, "Formação máxima - Blogs e mídias sociais", null, "_term", $_GET);
                    
                    $facets->facet("isPartOf.name", 100, "Título do periódico", null, "_term", $_GET);

                    $facets->facet("concluido", 100, "Concluído", null, "_term", $_GET);
                    $facets->facet("bdpi.existe", 100, "Está no DEDALUS?", null, "_term", $_GET);

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
                
        <div class="uk-width-3-4@s uk-width-4-6@m">
        
                 
                    
            <hr class="uk-grid-divider">           
                    
            <div class="uk-width-1-1 uk-margin-top uk-description-list-line">                        
                <ul class="uk-list uk-list-divider">
                   
                    </ul>
                    </div>
                    <hr class="uk-grid-divider">
                    <!-- Navegador de resultados - Início -->
                    <?php ui::pagination($page, $total, $limit, $t); ?>
                    <!-- Navegador de resultados - Fim --> 
                    
                </div>
            </div>
            <hr class="uk-grid-divider">
<?php include('inc/footer.php'); ?>          
        </div>
                


        <script>
        $('[data-uk-pagination]').on('select.uk.pagination', function(e, pageIndex){
            var url = window.location.href.split('&page')[0];
            window.location=url +'&page='+ (pageIndex+1);
        });
        </script>    

<?php include('inc/offcanvas.php'); ?>         
        
    </body>
</html>