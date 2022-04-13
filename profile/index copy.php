<?php
// Set directory to ROOT
chdir('../');
// Include essencial files
require 'inc/config.php';
require 'inc/functions.php';

function lattesID10($lattesID16)
{
    $url = 'http://lattes.cnpq.br/' . $lattesID16 . '';

    $headers = @get_headers($url);

    $lattesID10 = "";
    foreach ($headers as $h) {
        if (substr($h, 0, 87) == 'Location: http://buscatextual.cnpq.br/buscatextual/visualizacv.do?metodo=apresentar&id=') {
            $lattesID10 = trim(substr($h, 87));
            break;
        }
    }
    return $lattesID10;
}

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

    // $result_get['query']["sort"]["datePublished"]["missing"] = "_last";
    // $result_get['query']["sort"]["datePublished"]["order"] = "asc";
    // $result_get['query']["sort"]["datePublished"]["mode"] = "max";


    // $result_get['query']["sort"]["_uid"]["unmapped_type"] = "long";
    // $result_get['query']["sort"]["_uid"]["missing"] = "_last";
    // $result_get['query']["sort"]["_uid"]["order"] = "desc";
    // $result_get['query']["sort"]["_uid"]["mode"] = "max";

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


    $lattesID10 = lattesID10($_GET["lattesID"]);
} else {
    header("Location: https://unifesp.br/prodmais/index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php include('inc/meta-header.php'); ?>
    <title>Perfil: <?php echo $profile["nome_completo"] ?></title>
    <link rel="stylesheet" href="../sass/main.css" />
    <script src="../inc/js/vega.min.js"></script>
</head>

<body class="profile-body">

    <?php if (file_exists('inc/google_analytics.php')) {
        include 'inc/google_analytics.php'; }
    ?>

    <?php require 'inc/navbar.php'; ?>

    <main role="main" class="profile-container">
      <div class="profile-wrapper">
        <?php require 'profile/profile-core.php'; ?>

        <div id="tabs" class="profile-tabs">

        <div class="tab-bar">
          <button id="tab-btn-1" class="tab-btn" v-on:click="changeTab('1')">Sobre Mim</button>
          <button id="tab-btn-2" class="tab-btn" v-on:click="changeTab('2')">Produção Intelectual</button>
          <button id="tab-btn-3" class="tab-btn" v-on:click="changeTab('3')">Atuação Profissional</button>
          <!-- <button id="tab-btn-3" class="tab-btn" v-on:click="changeTab('3')">Pesquisa</button> -->
          <!-- <button id="tab-btn-4" class="tab-btn" v-on:click="changeTab('4')">Orientações</button> -->
        </div>


        <div class="tab-container">
          <div id="tab-one" class="tab-content" v-if="tabOpened == '1'">
            <?php require 'profile/profile-desc.php'; ?>
          </div>

          <div id="tab-two" class="tab-content" v-if="tabOpened == '2'">
            <?php require 'profile/profile-pi.php'; ?>
          </div>

          <div id="tab-three" class="tab-content" v-if="tabOpened == '3'">
            <?php require 'profile/profile-pp.php'; ?>
          </div>

'          <!-- <div id="tab-four" class="tab-content" v-if="tabOpened == '4'">

          </div>' -->
        </div>
      </div> <!-- profile-wrapper end -->

      <?php echo "<pre>".print_r($profile,true)."</pre>"; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    
    <script>

      var app = new Vue({
        el: '#tabs',
        data: {
          tabOpened: '1',
          isActive: false
      
        },
        methods: {
          changeTab(tab) {
            this.tabOpened = tab
            var tabs = document.getElementsByClassName("tab-btn")

            for (i = 0; i < tabs.length; i++ )
              tabs[i].className = tabs[i].className.replace("tab-active", "")

            tabs[Number(tab)-1].className += " tab-active"
          }
        }
      })
    </script>  
</body>