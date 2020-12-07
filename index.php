<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
    <head>
        <?php 
            include('inc/config.php');
            include('inc/meta-header-new.php');
            include('inc/functions.php');
            
            /* Define variables */
            define('authorUSP','authorUSP');
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
        <div class="container bg-light p-5 rounded mt-5">
            <h1 class="display-5"><?php echo $branch; ?></h1>
            <p><?php echo $branch_description; ?></p>

            <?php isset($error_connection_message) ? print_r($error_connection_message) : "" ?>

            <div class="alert alert-warning" role="alert">
                O Coletaprod é uma ferramenta que agrega informações de diversas fontes, mas não realiza um processamento posterior nelas. Antes de fazer um uso da informação, é preciso ter ciência de que há registros duplicados e outras inconsistências que devem ser avaliadas.
            </div>

             <form class="mt-3" action="result.php">
                <label for="searchQuery">Pesquisa por trabalho - <a href="result.php">Navegar por todos</a></label>
                <div class="input-group">
                    <input type="text" name="search" class="form-control" id="searchQuery" aria-describedby="searchHelp" placeholder="Pesquise por termo, autor ou ID do Lattes (16 dígitos)">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                    </div>
                </div>
                <small id="searchHelp" class="form-text text-muted">Dica: Use * para busca por radical. Ex: biblio*.</small>
                <small id="searchHelp" class="form-text text-muted">Dica 2: Para buscas exatas, coloque entre ""</small>
                <small id="searchHelp" class="form-text text-muted">Dica 3: Por padrão, o sistema utiliza o operador booleano OR. Caso necessite deixar a busca mais específica, utilize o operador AND</small>
            </form>
        </div>
    </div>

    <div class="container">
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