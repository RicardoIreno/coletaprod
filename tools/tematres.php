<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
    <head>
        <?php
        
        // Set directory to ROOT
        chdir('../');
        require 'inc/config.php';
        require 'inc/functions.php';
        require 'inc/meta-header.php';

        /* Consulta n registros ainda não corrigidos */
        if (isset($_GET["field"])) {
            $field = $_GET["field"];
            $body["query"]["bool"]["must"][]["query_string"]["query"] = "_exists_:$field";
            // $body["query"]["bool"]["must"]["query_string"]["default_field"] = "$field.tematres";
            // $body["query"]["bool"]["must"]["query_string"]["query"] = "false";
        }

        if (isset($_GET["term"])) {
            $body["query"]["bool"]["must"][]["query_string"]["query"] = ''.$field.'.name:'.$_GET["term"].'';
        }

        $params = [];
        $params["index"] = $index;
        $params["body"] = $body;

        $responseCount = $client->count($params);

        if ($_GET["field"] == "author.person.affiliation") {
            $params["_source"] = ["_id","author"];
        } elseif ($_GET["field"] == "funder") {
            $params["_source"] = ["_id","funder"];
        } elseif ($_GET["field"] == "ExternalData.crossref.message.author.affiliation.name") {
            $params["_source"] = ["_id","ExternalData"];
        }
        $params["size"] = 200;
        // if (isset($_GET["field"])) {
        //     $params["from"] = $_GET["from"];
        // }
        $response = $client->search($params);
        //var_dump($response);

        echo 'Total de registros faltantes: '.$responseCount["count"].'';
        ?>
        <title>Autoridades</title>
    </head>
    <body>

        <div class="uk-container uk-container-center uk-margin-large-bottom">

        <?php
        // Pega cada um dos registros da resposta
        foreach ($response["hits"]["hits"] as $record) {

            if ($_GET["field"] == "author.person.affiliation") {

                $i = 0;
                $body_upsert["doc"]["author"] = $record['_source']['author'];
    
                // Para cada autor no registro
                foreach ($record['_source']['author'] as $author) {
    
                    if (isset($author["person"]["affiliation"])) {
                        $i_aff = 0;
                        foreach ($author["person"]["affiliation"] as $affiliation) {
    
                            if (isset($affiliation["tematres"])) {
                                if ($affiliation["tematres"] == "false") {
    
                                    $termCleaned = str_replace("&", "e", $affiliation["name"]);
                                    $result_tematres = Authorities::tematres($termCleaned, $tematres_url);
                                    
                                    if (!empty($result_tematres["found_term"])) {
                                        $body_upsert["doc"]["author"][$i]["person"]["affiliation"][$i_aff]["name"] = $result_tematres["found_term"];
                                        $body_upsert["doc"]["author"][$i]["person"]["affiliation"][$i_aff]["tematres"] = "true";
                                        $body_upsert["doc"]["author"][$i]["person"]["affiliation"][$i_aff]["locationTematres"] = $result_tematres["country"];
                                        $body_upsert["doc_as_upsert"] = true;
                                        echo "<br/>Tem alterações<br/>";
                                    }
    
                                    if (!empty($result_tematres["term_not_found"])) {
                                        echo $result_tematres["term_not_found"];
                                        echo "<br/>";
    
                                    }
    
                                }
                                $i_aff++;
                            }
            
                        }  
                    }  
                    $i++;
                }
    
                $resultado_upsert = Elasticsearch::update($record["_id"], $body_upsert);
                unset($body_upsert);

            } elseif ($_GET['field'] == 'ExternalData.crossref.message.author.affiliation.name') {

                $i = 0;
                $body_upsert['doc']['ExternalData']['crossref']['message']['author'] = $record['_source']['ExternalData']['crossref']['message']['author'];
    
                // Para cada autor no registro
                foreach ($record['_source']['ExternalData']['crossref']['message']['author'] as $author) {
                    //print("<pre>".print_r($author,true)."</pre>");
    
                    if (isset($author["affiliation"])) {
                        $i_aff = 0;
                        foreach ($author["affiliation"] as $affiliation) {
                            $termCleaned = str_replace("&", "e", $affiliation["name"]);
    
                            if (isset($affiliation["tematres"])) {
                                if ($affiliation["tematres"] != "true") {
                                    $result_tematres = Authorities::tematresQuery($termCleaned, $tematres_url);
                                    if ($result_tematres["foundTerm"] != "ND") {
                                        $body_upsert["doc"]['ExternalData']['crossref']['message']['author'][$i]["affiliation"][$i_aff]["name"] = $result_tematres["foundTerm"];
                                        $body_upsert["doc"]['ExternalData']['crossref']['message']['author'][$i]["affiliation"][$i_aff]["tematres"] = "true";
                                    } else {
                                        $body_upsert["doc"]['ExternalData']['crossref']['message']['author'][$i]["affiliation"][$i_aff]["name"] = $result_tematres["termNotFound"];
                                        $body_upsert["doc"]['ExternalData']['crossref']['message']['author'][$i]["affiliation"][$i_aff]["tematres"] = "false";
                                    }
                                }
                            } else {
                                //echo "<br/>";
                                //print_r($termCleaned);
                                //echo "<br/>";
                                $result_tematres = Authorities::tematresQuery($termCleaned, $tematres_url);
                                //print_r($result_tematres);
                                //echo "<br/>";
                                if ($result_tematres["foundTerm"] != "ND") {
                                    $body_upsert["doc"]['ExternalData']['crossref']['message']['author'][$i]["affiliation"][$i_aff]["name"] = $result_tematres["foundTerm"];
                                    $body_upsert["doc"]['ExternalData']['crossref']['message']['author'][$i]["affiliation"][$i_aff]["tematres"] = "true";
                                } else {
                                    $body_upsert["doc"]['ExternalData']['crossref']['message']['author'][$i]["affiliation"][$i_aff]["name"] = $result_tematres["termNotFound"];
                                    $body_upsert["doc"]['ExternalData']['crossref']['message']['author'][$i]["affiliation"][$i_aff]["tematres"] = "false";
                                }
                            }
                            $i_aff++;
                        }
                    }
                $i++;
                }
                //echo "<br/>";
                //echo "<br/>";
                //print("<pre>".print_r($body_upsert,true)."</pre>");
                //echo "<br/>";
                $body_upsert["doc_as_upsert"] = true;
                $resultado_upsert = Elasticsearch::update($record["_id"], $body_upsert);
                unset($body_upsert);

            } elseif ($_GET['field'] == 'ExternalData.crossref.message.funder.name') {

                $i = 0;
                $body_upsert['doc']['ExternalData']['crossref']['message']['funder'] = $record['_source']['ExternalData']['crossref']['message']['funder'];
    
                // Para cada autor no registro
                foreach ($record['_source']['ExternalData']['crossref']['message']['funder'] as $funder) {
                    //print("<pre>".print_r($author,true)."</pre>");
    
                    $termCleaned = str_replace("&", "e", $funder["name"]);

                    if (isset($funder["tematres"])) {
                        if ($funder["tematres"] != "true") {
                            $result_tematres = Authorities::tematresQuery($termCleaned, $tematres_url);
                            if ($result_tematres["foundTerm"] != "ND") {
                                $body_upsert["doc"]['ExternalData']['crossref']['message']['funder'][$i]["name"] = $result_tematres["foundTerm"];
                                $body_upsert["doc"]['ExternalData']['crossref']['message']['funder'][$i]["tematres"] = "true";
                            } else {
                                $body_upsert["doc"]['ExternalData']['crossref']['message']['funder'][$i]["name"] = $result_tematres["termNotFound"];
                                $body_upsert["doc"]['ExternalData']['crossref']['message']['funder'][$i]["tematres"] = "false";
                            }
                        }
                    } else {
                        //echo "<br/>";
                        //print_r($termCleaned);
                        //echo "<br/>";
                        $result_tematres = Authorities::tematresQuery($termCleaned, $tematres_url);
                        //print_r($result_tematres);
                        //echo "<br/>";
                        if ($result_tematres["foundTerm"] != "ND") {
                            $body_upsert["doc"]['ExternalData']['crossref']['message']['funder'][$i]["name"] = $result_tematres["foundTerm"];
                            $body_upsert["doc"]['ExternalData']['crossref']['message']['funder'][$i]["tematres"] = "true";
                        } else {
                            $body_upsert["doc"]['ExternalData']['crossref']['message']['funder'][$i]["name"] = $result_tematres["termNotFound"];
                            $body_upsert["doc"]['ExternalData']['crossref']['message']['funder'][$i]["tematres"] = "false";
                        }
                    }
                }
                $i++;
                //echo "<br/>";
                //echo "<br/>";
                //print("<pre>".print_r($body_upsert,true)."</pre>");
                //echo "<br/>";
                $body_upsert["doc_as_upsert"] = true;
                $resultado_upsert = Elasticsearch::update($record["_id"], $body_upsert);
                unset($body_upsert);
    
            } elseif ($_GET["field"] == "funder") {

                $i = 0;
                $body_upsert["doc"]["funder"] = $record['_source']['funder'];
    
                // Para cada funder no registro
                $i_funder = 0;
                foreach ($record['_source']['funder'] as $funder) {
                    // echo "<br/>";
                    // print_r($funder);
                    // echo "<br/>";

                    if ($funder["tematres"] == "false") {
                        $termCleaned = str_replace("&", "e", $funder["name"]);
                        $result_tematres = Authorities::tematres($termCleaned, $tematres_url);
                        
                        //print_r($result_tematres);

                        if (!empty($result_tematres["found_term"])) {
                            $body_upsert["doc"]["funder"][$i_funder]["name"] = $result_tematres["found_term"];
                            $body_upsert["doc"]["funder"][$i_funder]["tematres"] = "true";
                            $body_upsert["doc"]["funder"][$i_funder]["location"] = $result_tematres["country"];
                            $body_upsert["doc_as_upsert"] = true;
                            echo "<br/>Tem alterações<br/>";
                        }

                        if (!empty($result_tematres["term_not_found"])) {
                            echo $result_tematres["term_not_found"];
                            echo "<br/>";

                        }
                    }
                    $i_funder++;
                    $i++;
                }
                

                //print_r($body_upsert);
                $resultado_upsert = Elasticsearch::update($record["_id"], $body_upsert);
                unset($body_upsert);

            } else {
                echo "Campo não configurado";
            }

        }

        ?>

        </div>
    </body>
</html>