<!DOCTYPE html>
<?php
// Set directory to ROOT
chdir('../');
// Include essencial files
require 'inc/config.php';
require 'inc/functions.php';

if (!empty($_REQUEST["lattesID"])) {

    if (isset($_GET["filter"])) {
        if (!in_array("type:\"Curriculum\"", $_GET["filter"])) {
            $_GET["filter"][] = "type:\"Curriculum\"";
        }
    } else {
        $_GET["filter"][] = "type:\"Curriculum\"";
    }
    $_GET["filter"][] = 'lattesID:' . $_GET["lattesID"] . '';
    $result_get = Requests::getParser($_GET);
    $limit = $result_get['limit'];
    $page = $result_get['page'];
    $params = [];
    $params["index"] = $index_cv;
    $params["body"] = $result_get['query'];
    $cursorTotal = $client->count($params);
    $total = $cursorTotal["count"];

    $params["body"] = $result_get['query'];
    $params["size"] = $limit;
    $params["from"] = $result_get['skip'];
    $cursor = $client->search($params);
    $profile = $cursor["hits"]["hits"][0]["_source"];



    $filter_works["filter"][] = 'vinculo.lattes_id:"' . $_GET["lattesID"] . '"';
    $result_get_works = Requests::getParser($filter_works);
    $params_works = [];
    $params_works["index"] = $index;
    $params_works["body"] = $result_get_works['query'];

    $worksTotal = $client->count($params_works);
    $totalWorks = $worksTotal["count"];

    $params_works["size"] = 9999;
    $cursor_works = $client->search($params_works);
} else {
    echo "Não foi informado um LattesID";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php
    include('inc/meta-header.php');
    ?>
    <title>Perfil: <?php echo $profile["nome_completo"] ?></title>
    <link rel="stylesheet" href="../inc/css/style.css" />

    <script src="https://vega.github.io/vega/vega.min.js"></script>


</head>

<body>

    <?php
    if (file_exists('inc/google_analytics.php')) {
        include 'inc/google_analytics.php';
    }
    ?>

    <!-- NAV -->
    <?php require 'inc/navbar.php'; ?>
    <!-- /NAV -->
    <br /><br />

    <main role="main">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <h1><?php echo $profile["nome_completo"] ?></h1>
                    <br />
                    <p><?php echo $profile["resumo_cv"]["texto_resumo_cv_rh"] ?></p>
                    <p>Quantidade de registros: <?php echo $totalWorks ?></p>
                    <?php //var_dump($profile); 
                    ?>
                    <?php //var_dump($cursor_works); 
                    ?>

                    <?php
                    $authorfacets = new AuthorFacets();
                    $authorfacets->query = $result_get['query'];

                    if (!isset($_GET)) {
                        $_GET = null;
                    }

                    $authorfacets->authorfacet(basename(__FILE__), "tipo", 100, "Tipo de material", null, "_term", $_GET);
                    echo "<br/><br/>";

                    ?>


                    <div class="embed">
                        <div id="bar-chart" class="view"></div>
                        <a href="./bar-chart.vg.json">View Source</a>
                        <a id="bar-chart-png" href="#">Export PNG</a>
                        <a id="bar-chart-svg" href="#">Export SVG</a>
                    </div>
                    <script>
                        var spec = {
                            "$schema": "https://vega.github.io/schema/vega/v5.json",
                            "width": 1200,
                            "height": 300,
                            "padding": 5,

                            "data": [{
                                "name": "table",
                                "values": [{
                                        "category": "Trabalhos em eventos",
                                        "amount": 1401
                                    },
                                    {
                                        "category": "Artigo publicado",
                                        "amount": 1332
                                    },
                                    {
                                        "category": "Capítulo de livro publicado",
                                        "amount": 81
                                    },
                                    {
                                        "category": "Livro publicado ou organizado",
                                        "amount": 10
                                    },
                                    {
                                        "category": "Textos em jornais de notícias/revistas",
                                        "amount": 7
                                    }
                                ]
                            }],

                            "signals": [{
                                "name": "tooltip",
                                "value": {},
                                "on": [{
                                        "events": "rect:mouseover",
                                        "update": "datum"
                                    },
                                    {
                                        "events": "rect:mouseout",
                                        "update": "{}"
                                    }
                                ]
                            }],

                            "scales": [{
                                    "name": "xscale",
                                    "type": "band",
                                    "domain": {
                                        "data": "table",
                                        "field": "category"
                                    },
                                    "range": "width",
                                    "padding": 0.05,
                                    "round": true
                                },
                                {
                                    "name": "yscale",
                                    "domain": {
                                        "data": "table",
                                        "field": "amount"
                                    },
                                    "nice": true,
                                    "range": "height"
                                }
                            ],

                            "axes": [{
                                    "orient": "bottom",
                                    "scale": "xscale"
                                },
                                {
                                    "orient": "left",
                                    "scale": "yscale"
                                }
                            ],

                            "marks": [{
                                    "type": "rect",
                                    "from": {
                                        "data": "table"
                                    },
                                    "encode": {
                                        "enter": {
                                            "x": {
                                                "scale": "xscale",
                                                "field": "category"
                                            },
                                            "width": {
                                                "scale": "xscale",
                                                "band": 1
                                            },
                                            "y": {
                                                "scale": "yscale",
                                                "field": "amount"
                                            },
                                            "y2": {
                                                "scale": "yscale",
                                                "value": 0
                                            }
                                        },
                                        "update": {
                                            "fill": {
                                                "value": "steelblue"
                                            }
                                        },
                                        "hover": {
                                            "fill": {
                                                "value": "red"
                                            }
                                        }
                                    }
                                },
                                {
                                    "type": "text",
                                    "encode": {
                                        "enter": {
                                            "align": {
                                                "value": "center"
                                            },
                                            "baseline": {
                                                "value": "bottom"
                                            },
                                            "fill": {
                                                "value": "#333"
                                            }
                                        },
                                        "update": {
                                            "x": {
                                                "scale": "xscale",
                                                "signal": "tooltip.category",
                                                "band": 0.5
                                            },
                                            "y": {
                                                "scale": "yscale",
                                                "signal": "tooltip.amount",
                                                "offset": -2
                                            },
                                            "text": {
                                                "signal": "tooltip.amount"
                                            },
                                            "fillOpacity": [{
                                                    "test": "isNaN(tooltip.amount)",
                                                    "value": 0
                                                },
                                                {
                                                    "value": 1
                                                }
                                            ]
                                        }
                                    }
                                }
                            ]
                        };

                        function image(view, type) {
                            return function(event) {
                                event.preventDefault();
                                view.toImageURL(type).then(function(url) {
                                    var link = document.createElement('a');
                                    link.setAttribute('href', url);
                                    link.setAttribute('target', '_blank');
                                    link.setAttribute('download', 'bar-chart.' + type);
                                    link.dispatchEvent(new MouseEvent('click'));
                                }).catch(function(error) {
                                    console.error(error);
                                });
                            };
                        }

                        var view = new vega.View(vega.parse(spec), {
                            loader: vega.loader({
                                baseURL: '/vega/'
                            }),
                            logLevel: vega.Warn,
                            renderer: 'svg'
                        }).initialize('#bar-chart').hover().run();

                        document.querySelector('#bar-chart-png').addEventListener('click', image(view, 'png'));
                        document.querySelector('#bar-chart-svg').addEventListener('click', image(view, 'svg'));
                    </script>
                    <br /><br />

                    <?php
                    foreach ($cursor_works["hits"]["hits"] as $works) {
                        //echo "<br /><br />";
                        //var_dump($works);
                        echo '
                            <div class="card">
                                <h5 class="card-header">' . $works["_source"]["tipo"] . '</h5>
                                <div class="card-body">
                                    <h5 class="card-title">' . $works["_source"]["name"] . '</h5>
                                    <p class="card-text">Data de publicação: ' . $works["_source"]["datePublished"] . '</p>
                            ';
                        if (isset($works["_source"]["EducationEvent"])) {
                            echo '<p class="card-text">Nome do evento: ' . $works["_source"]["EducationEvent"]["name"] . '</p>';
                        }
                        echo '<p class="card-text">País de publicação: ' . $works["_source"]["country"] . '</p>';
                        foreach ($works["_source"]["author"] as $author) {
                            $authors[] = $author["person"]["name"];
                        };
                        echo '<p class="card-text">Autor: ' . implode('; ', $authors) . '</p>';
                        echo '
                                </div>
                            </div>
                            ';
                        echo "<br /><br />";
                        unset($authors);
                    }
                    ?>
                </div>
            </div>

        </div>
    </main>
</body>