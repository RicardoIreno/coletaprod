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

             <form class="mt-3" action="result.php">
                <label for="searchQuery">Pesquisa por trabalho - <a href="result.php">Ver todos</a></label>
                <div class="input-group">
                    <input type="text" name="search" class="form-control" id="searchQuery" aria-describedby="searchHelp" placeholder="Pesquise por termo ou autor">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                    </div>
                </div>                       
                <small id="searchHelp" class="form-text text-muted">Dica: Use * para busca por radical. Ex: biblio*.</small>
                <small id="searchHelp" class="form-text text-muted">Dica 2: Para buscas exatas, coloque entre ""</small>
                <small id="searchHelp" class="form-text text-muted">Dica 3: Você também pode usar operadores booleanos: AND, OR</small>
            </form>
            <form class="mt-3" action="result.php" method="get">
                <label for="tagSearch">Pesquisa por TAG</label>
                <div class="input-group">
                    <input type="text" placeholder="Pesquise por tag" class="form-control" id="tagSearch" name="filter[]" value="tag:">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Buscar TAG</button>
                    </div>
                </div>
            </form>
            <form class="mt-3" action="result_autores.php" method="get">
                <label for="authorSearch">Pesquisa por autor - <a href="result_autores.php">Ver todos</a></label>
                <div class="input-group">
                    <input type="text" placeholder="Pesquise por nome do autor ou Número funcional" class="form-control" id="authorSearch" name="search">
                    <input type="hidden" name="fields[]" value="nome_completo">
                    <input type="hidden" name="fields[]" value="nome_em_citacoes_bibliograficas">
                    <input type="hidden" name="fields[]" value="endereco.endereco_profissional.nomeInstituicaoEmpresa">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Buscar autor</button>
                    </div>   
                </div>
            </form>
        </div>
    </div>    

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="uk-h3">Unidade</h2>
                <ul class="list-group">
                    <?php paginaInicial::unidade_inicio("instituicao.unidade"); ?>
                </ul>
                <h2>Departamento</h2>
                <ul class="list-group">
                    <?php paginaInicial::unidade_inicio("instituicao.departamento"); ?>
                </ul>
                <h2>Tags</h2>
                <ul class="list-group">
                    <?php paginaInicial::unidade_inicio("tag"); ?>
                </ul>
            </div>
            <div class="col-md-3">
                <h2>Tipo de vínculo</h2>
                <ul class="list-group">
                    <?php paginaInicial::unidade_inicio("instituicao.tipvin"); ?>
                </ul>
                <h2 class="uk-h3">Tipo de material</h2>
                <ul class="list-group">
                    <?php paginaInicial::tipo_inicio(); ?>
                </ul>
                <h2>Nome do PPG</h2>
                <ul class="list-group">
                    <?php paginaInicial::unidade_inicio("instituicao.ppg_nome"); ?>
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
                    <li class="list-group-item"><?php echo paginaInicial::contar_registros_indice($index_source); ?> registros na fonte</li>
                    <li class="list-group-item"><?php echo paginaInicial::possui_lattes(); ?>% sem ID no Lattes</li>
                </ul>
            </div>
        </div>
    </div>


        <?php include('inc/footer.php'); ?>


    </body>
</html>