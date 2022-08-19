<!DOCTYPE html>
<?php

require 'inc/config.php';
require 'inc/functions.php';

if (isset($_POST["filter"])) {
    if (!in_array("type:\"Curriculum\"", $_POST["filter"])) {
        $_POST["filter"][] = "type:\"Curriculum\"";
    }
} else {
    $_POST["filter"][] = "type:\"Curriculum\"";
}

if (isset($_POST["query"])) {
    $_POST["search"] = 'nome_completo:' .$_POST['query']. '';
} else {
    $_POST["search"] = '';
}


if (isset($fields)) {
    $_POST["fields"] = $fields;
}
$result_post = Requests::postParser($_POST);
$limit = $result_post['limit'];
$page = $result_post['page'];
$params = [];
$params["index"] = $index_cv;
$params["body"] = $result_post['query'];
$cursorTotal = $client->count($params);
$total = $cursorTotal["count"];
$result_post['query']["sort"]["nome_completo.keyword"]["unmapped_type"] = "long";
$result_post['query']["sort"]["nome_completo.keyword"]["missing"] = "_last";
$result_post['query']["sort"]["nome_completo.keyword"]["order"] = "asc";
$params["body"] = $result_post['query'];
$params["size"] = $limit;
$params["from"] = $result_post['skip'];
$cursor = $client->search($params);

/*pagination - start*/
$get_data = $_GET;
/*pagination - end*/

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include('inc/meta-header.php');
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>

    <title><?php echo $branch; ?> - Resultado da busca por perfil profissional</title>

    <link rel="stylesheet" href="sass/main.css" />
    <link rel="stylesheet" href="inc/css/style.css" />

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


    <div class="p-result-container">
        <main class="p-result-main">
            <form action="result_autores.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data"
                id="searchresearchers">
                <div class="input-group mb-3">
                    <input name="query" type="text" class="form-control"
                        placeholder="Digite parte do nome do pesquisador"
                        aria-label="Digite parte do nome do pesquisador" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" form="searchresearchers"
                        value="Submit">Pesquisar</button>
                </div>
            </form>

            <!-- Navegador de resultados - Início -->
            <?php ui::newpagination($page, $total, $limit, $_POST, 'result_autores'); ?>
            <!-- Navegador de resultados - Fim -->

            <?php foreach ($cursor["hits"]["hits"] as $r) : ?>
                <?php 
                    if (empty($r["_source"]['datePublished'])) {
                        $r["_source"]['datePublished'] = "";
                    }
                ?>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <h5 class="card-title">
                                    <a class="text-dark" href="profile.php?lattesID=<?php echo $r['_source']['lattesID']; ?>">
                                        <?php echo $r["_source"]['nome_completo']; ?>
                                    </a>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Navegador de resultados - Início -->
            <?php ui::newpagination($page, $total, $limit, $_POST, 'result_autores'); ?>
            <!-- Navegador de resultados - Fim -->

        </main>

        <nav class="c-fbar">
            <div class="c-fbar-header">
                <b class="t">Refinar Resultados</b>
            </div>
            <div class="c-fbloc-wrapper">

                <?php
                    $facets = new FacetsNew();
                    $facets->query = $result_post['query'];

                    if (!isset($_POST)) {
                        $_POST = null;
                    }

                    echo($facets->facet(basename(__FILE__), "campus", 100, "Campus", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "desc_gestora", 100, "Gestora", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "unidade", 100, "Unidade", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "departamento", 100, "Departamento", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "divisao", 100, "Divisão", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "secao", 100, "Seção", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "ppg_nome", 100, "Nome do PPG", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "tipvin", 100, "Tipo de vínculo", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "genero", 100, "Genero", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "desc_nivel", 100, "Nível", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "desc_curso", 100, "Curso", null, "_term", $_POST, $index_cv));

                    //echo($facets->facet(basename(__FILE__), "tag", 100, "Tag", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "nacionalidade", 100, "Nacionalidade", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "pais_de_nascimento", 100, "País de nascimento", null, "_term", $_POST, $index_cv));

                    //echo($facets->facet(basename(__FILE__), "endereco.endereco_profissional.nomeInstituicaoEmpresa", 100, "Nome da Instituição ou Empresa", null, "_term", $_POST, $index_cv));
                    //echo($facets->facet(basename(__FILE__), "endereco.endereco_profissional.nomeOrgao", 100, "Nome do orgão", null, "_term", $_POST, $index_cv));
                    //echo($facets->facet(basename(__FILE__), "endereco.endereco_profissional.nomeUnidade", 100, "Nome da unidade", null, "_term", $_POST, $index_cv));
                    //echo($facets->facet(basename(__FILE__), "endereco.endereco_profissional.pais", 100, "País do endereço profissional", null, "_term", $_POST, $index_cv));
                    //echo($facets->facet(basename(__FILE__), "endereco.endereco_profissional.cidade", 100, "Cidade do endereço profissional", null, "_term", $_POST, $index_cv));

                    echo($facets->facet(basename(__FILE__), "formacao_academica_titulacao_graduacao.nomeInstituicao", 100, "Instituição em que cursou graduação", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "formacao_academica_titulacao_graduacao.nomeCurso", 100, "Nome do curso na graduação", null, "_term", $_POST, $index_cv));
                    
                    echo($facets->facet(basename(__FILE__), "formacao_academica_titulacao_mestrado.nomeInstituicao", 100, "Instituição em que cursou mestrado", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "formacao_academica_titulacao_mestrado.nomeCurso", 100, "Nome do curso no mestrado", null, "_term", $_POST, $index_cv));
                    
                    echo($facets->facet(basename(__FILE__), "formacao_academica_titulacao_mestradoProfissionalizante.nomeInstituicao", 100, "Instituição em que cursou mestrado profissional", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "formacao_academica_titulacao_mestradoProfissionalizante.nomeCurso", 100, "Nome do curso no mestrado profissional", null, "_term", $_POST, $index_cv));
                    
                    echo($facets->facet(basename(__FILE__), "formacao_academica_titulacao_doutorado.nomeInstituicao", 100, "Instituição em que cursou doutorado", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "formacao_academica_titulacao_doutorado.nomeCurso", 100, "Nome do curso no doutorado", null, "_term", $_POST, $index_cv));
                    
                    echo($facets->facet(basename(__FILE__), "formacao_academica_titulacao_livreDocencia.nomeInstituicao", 100, "Instituição em que cursou livre docência", null, "_term", $_POST, $index_cv));
                    echo($facets->facet(basename(__FILE__), "formacao_maxima", 10, "Maior formação que iniciou", null, "_term", $_POST, $index_cv));
                                        
                    echo($facets->facet(basename(__FILE__), "data_atualizacao", 100, "Data de atualização do currículo", null, "_term", $_POST, $index_cv));

                ?>



            </div>
        </nav>

    </div>

    <?php include('inc/footer.php'); ?>

</body>

</html>
