<?php
if ($_SERVER["REQUEST_URI"] == "/") {
    header("Location: http://unifesp.br/coletaprod/index.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<head>
    <?php
    require 'inc/config.php';
    require 'inc/meta-header.php';
    require 'inc/functions.php';
    ?>
    <title><?php echo $branch ?></title>
    <!-- Facebook Tags - START -->
    <meta property="og:locale" content="pt_BR">
    <meta property="og:url" content="<?php echo $url_base ?>">
    <meta property="og:title" content="<?php echo $branch ?> - Página Principal">
    <meta property="og:site_name" content="<?php echo $branch ?>">
    <meta property="og:description" content="<?php echo $branch_description ?>">
    <meta property="og:image" content="<?php echo $facebook_image ?>">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">
    <meta property="og:type" content="website">
    <!-- Facebook Tags - END -->

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .jumbotron {
            background-image: url("<?php echo $background_1 ?>");
            background-size: 100%;
            background-repeat: no-repeat;
        }
    </style>

</head>

<body>



    <!-- NAV -->
    <?php require 'inc/navbar.php'; ?>
    <!-- /NAV -->


    <div class="jumbotron">
        <br />
        <div class="container bg-light rounded p-5 mt-5 mb-5">
            <h1 class="display-5"><?php echo $branch; ?></h1>
            <p><?php echo $branch_description; ?></p>

            <?php isset($error_connection_message) ? print_r($error_connection_message) : "" ?>

            <div class="alert alert-warning" role="alert">
                O COLETAPROD é uma ferramenta de busca da produção docente e discente (pós-graduação) desenvolvida pela UNIFESP.
                Ela agrega informações do Currículo Lattes (Docentes após a data de ingresso na UNIFESP e Discentes que ingressaram após 2014),
                sendo possível buscá-las por meio de palavras, pesquisadores e Programas de Pós-Graduação, com a utilização de filtros bem como de termos conjugados.
                Aqui se acede à informação na forma de artigos, livros (e capítulos), além de trabalhos apresentados em eventos.
                Como se tratam de informações não processadas, duplicações podem ocasionalmente aparecer.
                <br/>
                Caso encontre algum erro, por favor <a href="https://docs.google.com/forms/d/e/1FAIpQLScmHGNgM_1z9sntKJo1uhIwIrxRt6qDdMZiPs0hvx8BMKuTmQ/viewform?usp=sf_link">use nosso formuário</a> para reportá-los.
            </div>

            <form class="mt-3" action="result.php">
                <label for="searchQuery">Pesquisa por palavras - <a href="result.php">Navegar por todos</a></label>
                <div class="form-group">
                    <input type="text" name="search" class="form-control" id="searchQuery" aria-describedby="searchHelp" placeholder="Pesquise por termo, autor ou ID do Lattes (16 dígitos)">
                    <label>Filtrar por Nome do Programa de Pós-Graduação (Opcional):</label>
                    <?php paginaInicial::filter_select("vinculo.ppg_nome"); ?>
                </div>
                <label>Filtrar por data (Opcional):</label>
                <div class="input-group">
                    <div class="form-group">
                        <label for="initialYear">Ano inicial</label>
                        <input type="text" class="form-control" id="initialYear" name="initialYear" pattern="\d{4}" placeholder="Ex. 2010" value="">
                    </div>
                    <div class="form-group">
                        <label for="finalYear">Ano final</label>
                        <input type="text" class="form-control" id="finalYear" name="finalYear" pattern="\d{4}" placeholder="Ex. 2020" value="">
                    </div>
                </div>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                </div>
                <small id="searchHelp" class="form-text text-muted">Dica: Use * para busca por radical. Ex: biblio*.</small>
                <small id="searchHelp" class="form-text text-muted">Dica 2: Para buscas exatas, coloque entre "". Ex: "Direito civil"</small>
                <small id="searchHelp" class="form-text text-muted">Dica 3: Por padrão, o sistema utiliza o operador booleano OR. Caso necessite deixar a busca mais específica, utilize o operador AND (em maiúscula)</small>

        </div>
        </form>
        <br />
    </div>

    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <h2>Nome do Programa de Pós-Graduação</h2>
                <ul class="list-group">
                    <?php paginaInicial::unidade_inicio("vinculo.ppg_nome"); ?>
                </ul>
                <!--
                <h2 class="uk-h3">Unidade</h2>
                <ul class="list-group">
                    < ?php paginaInicial::unidade_inicio("vinculo.unidade"); ?>
                </ul>
                <h2>Departamento</h2>
                <ul class="list-group">
                    < ?php paginaInicial::unidade_inicio("vinculo.departamento"); ?>
                </ul>
                <h2>Tags</h2>
                <ul class="list-group">
                    < ?php paginaInicial::unidade_inicio("tag"); ?>
                </ul>
                -->
            </div>
            <div class="col-md-3">
                <h2>Tipo de vínculo</h2>
                <ul class="list-group">
                    <?php paginaInicial::unidade_inicio("vinculo.tipvin"); ?>
                </ul>
                <h2 class="uk-h3">Tipo de material</h2>
                <ul class="list-group">
                    <?php paginaInicial::tipo_inicio(); ?>
                </ul>

            </div>
            <div class="col-md-3">
                <h2 class="uk-h3">Fonte</h2>
                <ul class="list-group">
                    <?php paginaInicial::fonte_inicio(); ?>
                </ul>
            </div>
            <div class="col-md-3">
                <h2 class="uk-h3">Estatísticas</h2>
                <ul class="list-group">
                    <li class="list-group-item"><?php echo paginaInicial::contar_registros_indice($index); ?> registros</li>
                    <li class="list-group-item"><?php echo paginaInicial::contar_registros_indice($index_cv);; ?> currículos</li>
                    <!--
                    <li class="list-group-item">< ?php echo paginaInicial::contar_registros_indice($index_source); ?> registros no Repositório Institucional</li>
                    <li class="list-group-item">< ?php echo paginaInicial::possui_lattes(); ?>% sem ID no Lattes</li>
                    -->
                </ul>
            </div>
        </div>
    </div>


    <?php include('inc/footer.php'); ?>


</body>

</html>