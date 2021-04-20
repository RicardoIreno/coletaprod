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
    $params_works["size"] = $limit;
    $params_works["from"] = $result_get_works['skip'];
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

</head>

<body>
    <!-- NAV -->
    <?php require 'inc/navbar.php'; ?>
    <!-- /NAV -->
    <br /><br /><br /><br />

    <main role="main">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <h1><?php echo $profile["nome_completo"] ?></h1>
                    <br /><br /><br /><br />
                    <?php var_dump($profile); ?>
                    <br /><br /><br /><br />
                    <?php //var_dump($cursor_works); ?>
                    <?php
                        foreach ($cursor_works["hits"]["hits"] as $works) {
                            echo "<br /><br />";
                            var_dump($works);
                            echo '
                            <div class="card">
                                <h5 class="card-header">' . $works["_source"]["tipo"] . '</h5>
                                <div class="card-body">
                                    <h5 class="card-title">' . $works["_source"]["name"] . '</h5>
                                    <p class="card-text"></p>
                                </div>
                            </div>
                            '
                            ;
                            echo "<br /><br />";
                        }
                    ?>
                </div>
            </div>

        </div>
    </main>
</body>