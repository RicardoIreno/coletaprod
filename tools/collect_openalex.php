<!DOCTYPE html>
<?php

    require '../inc/config.php';
    require '../inc/functions.php';

    
    //$query["query"]["bool"]["must"]["exists"]["field"] = "doi";
    //$query["query"]["bool"]["must_not"]["exists"]["field"] = "ExternalData";
    //$query["query"]["query_string"]["query"] = "_exists_:doi -_exists_:ExternalData.openalex";
    //$query["query"]["nested"]["path"] = "ExternalData";
    //$query["query"]["nested"]["query"]["bool"]["must_not"][0]["exists"]["field"] = "ExternalData";

    $query = '
    
    { "query": {
        "bool": {
          "must": [
            {
              "bool": {
                "must": [
                  {
                    "bool": {
                      "should": [
                        {
                          "exists": {
                            "field": "doi"
                          }
                        }
                      ],
                      "minimum_should_match": 1
                    }
                  },
                  {
                    "bool": {
                      "must_not": {
                        "nested": {
                          "path": "ExternalData",
                          "query": {
                            "bool": {
                              "should": [
                                {
                                  "exists": {
                                    "field": "ExternalData.openalex"
                                  }
                                }
                              ],
                              "minimum_should_match": 1
                            }
                          },
                          "score_mode": "none"
                        }
                      }
                    }
                  }
                ]
              }
            }
          ],
          "filter": [],
          "should": [],
          "must_not": []
        }
      }
    }

    ';
    $query = json_decode($query);

    $params = [];
    $params["index"] = $index;
    $params["body"] = $query; 

    $cursorTotal = $client->count($params);
    $total = $cursorTotal["count"];

    echo "Registros restantes: $total<br/><br/>";

    $params["size"] = 100;
    $params["from"] = 0;
    $cursor = $client->search($params);

    foreach ($cursor["hits"]["hits"] as $r) {   


        $url = 'https://api.openalex.org/works/https://doi.org/' . $r["_source"]["doi"] . '?mailto=tiago.murakami@unifesp.br';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        
        if ($httpcode == 200) {

            $work = file_get_contents($url);
            //$work_converted = json_decode($work);
 
            $body["doc"]["ExternalData"]["openalex"] = $work;
            $body["doc_as_upsert"] = true;
            //echo "<pre>".print_r($body, true)."</pre>";     
            //unset($body["doc"]["ExternalData"]["openalex"]["message"]["assertion"]);
            //var_dump($body);
            $resultado_openalex = Elasticsearch::update($r["_id"], $body);
            print_r($resultado_openalex);
            //sleep(2);
            ob_flush();
            flush();

        } else {

            $body["doc"]["ExternalData"]["openalex"]["notFound"] = true;
            //unset($body["doc"]["ExternalData"]["openalex"]["notFound"]["message"]["assertion"]);
            $body["doc_as_upsert"] = true;
            $resultado_openalex = Elasticsearch::update($r["_id"], $body);
            print_r($resultado_openalex);
            //sleep(2);
            ob_flush();
            flush();
        }

    }
?>