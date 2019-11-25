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
        <meta property="og:url" content="http://coletaprod.sibi.usp.br/coletaprod">
        <meta property="og:title" content="Coleta Produção USP - Página Principal">
        <meta property="og:site_name" content="Coleta Produção USP">
        <meta property="og:description" content="Sistema de coleta de produção em diversas fontes.">
        <meta property="og:image" content="http://www.imagens.usp.br/wp-content/uploads/USP.jpg">
        <meta property="og:image:type" content="image/jpeg">
        <meta property="og:image:width" content="800"> 
        <meta property="og:image:height" content="600"> 
        <meta property="og:type" content="website">
        <!-- Facebook Tags - END -->
        
    </head>

    <body>



    <!-- NAV -->
    <?php require 'inc/navbar.php'; ?>
    <!-- /NAV --> 

    <div class="jumbotron">
        <div class="container">
            <h1 class="display-5 mt-3"><?php echo $branch; ?></h1>
            <p>Coleta produção de diversas fontes para preenchimento do Cadastro de Produção Intelectual, para uso interno da Biblioteca da Escola de Comunicações e Artes da Universidade de São Paulo</p>

            <?php isset($error_connection_message) ? print_r($error_connection_message) : "" ?>

            <!-- Modal Inclusão -->
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bd-example-modal-xl">Inclusão</button>

            <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content container">

                    <h1 class="display-5 mt-3">Inclusão</h1>

                    <form action="lattes_json_to_elastic.php" method="get">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Lattes ID</span>
                            </div>
                            <input type="text" placeholder="Insira o ID do Curriculo" class="form-control" name="id_lattes" data-validation="required">
                            <input type="text" placeholder="TAG para formar um grupo" class="form-control" name="tag">
                            <input type="text" placeholder="Número USP" class="form-control" name="codpes">
                            <input type="text" placeholder="Unidade USP" class="form-control" name="unidadeUSP">
                            <button class="btn btn-primary" type="submit">Button</button>
                        </div>  
                    </form>




                <form class="uk-form" action="lattes_json_to_elastic.php" method="get">
    <fieldset data-uk-margin>
        <legend>Inserir ID do Currículo Lattes que deseja incluir</legend>
        <input type="text" placeholder="Insira o ID do Curriculo" class="uk-form-width-medium" name="id_lattes" data-validation="required">
        <input type="text" placeholder="TAG para formar um grupo" class="uk-form-width-medium" name="tag">
        <input type="text" placeholder="Número USP" class="uk-form-width-medium" name="codpes">
        <input type="text" placeholder="Unidade USP" class="uk-form-width-medium" name="unidadeUSP">
        <button class="uk-button-primary">Incluir</button><br/>                                    
    </fieldset>
</form>
<br/>
<form class="uk-form" action="lattes_xml_to_elastic.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <fieldset data-uk-margin>
        <legend>Inserir XML do Currículo Lattes que deseja incluir</legend>
        <input type="file" name="file">
        <input type="text" placeholder="TAG para formar um grupo" class="uk-form-width-medium" name="tag">
        <input type="text" placeholder="Número USP" class="uk-form-width-medium" name="codpes">
        <input type="text" placeholder="Unidade USP" class="uk-form-width-medium" name="unidadeUSP">
        <button class="uk-button-primary">Incluir</button><br/>                                    
    </fieldset>
</form>
<br/>
<form class="uk-form" action="doi_to_elastic.php" method="get">
    <fieldset data-uk-margin>
        <legend>Inserir um DOI de artigo que queira incluir (sem http://doi.org/)</legend>
        <input type="text" placeholder="Insira um DOI" class="uk-form-width-medium" name="doi" data-validation="required">
        <input type="text" placeholder="TAG para formar um grupo" class="uk-form-width-medium" name="tag">
        <button class="uk-button-primary">Incluir</button><br/>                                    
    </fieldset>
</form>
<br/>
<form class="uk-form" action="wos_upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <fieldset data-uk-margin>
        <legend>Enviar um arquivo da Web of Science (UTF-8, separado por tabulações)</legend>
        <input type="file" name="file">
        <input type="text" placeholder="Tag para formar um grupo" class="uk-form-width-medium" name="tag">
        <button class="uk-button-primary" name="btn_submit">Upload</button><br/>                                    
    </fieldset>
</form>                         
<br/>
<form class="uk-form" action="incites_upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <fieldset data-uk-margin>
        <legend>Enviar um arquivo do INCITES (CSV)</legend>
        <input type="file" name="file">
        <input type="text" placeholder="Tag para formar um grupo" class="uk-form-width-medium" name="tag">
        <button class="uk-button-primary" name="btn_submit">Upload</button><br/>                                    
    </fieldset>
</form>
<br/>
<form class="uk-form" action="scopus_upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <fieldset data-uk-margin>
        <legend>Enviar um arquivo do Scopus (CSV - All available information)</legend>
        <input type="file" name="file">
        <input type="text" placeholder="Tag para formar um grupo" class="uk-form-width-medium" name="tag">
        <button class="uk-button-primary" name="btn_submit">Upload</button><br/>                                    
    </fieldset>
</form>
<br/>
<form class="uk-form" action="scival_upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <fieldset data-uk-margin>
        <legend>Enviar um arquivo do SCIVAL (CSV - All available information)</legend>
        <input type="file" name="file">
        <input type="text" placeholder="Tag para formar um grupo" class="uk-form-width-medium" name="tag">
        <button class="uk-button-primary" name="btn_submit">Upload</button><br/>                                    
    </fieldset>
</form>
<br/>
<form class="uk-form" action="harvester_oai.php" method="get" accept-charset="utf-8" enctype="multipart/form-data">
    <fieldset data-uk-margin>
        <legend>Incluir um URL OAI-PMH</legend>
        <input type="text" placeholder="Insira um URL OAI válido" class="uk-form-width-medium" name="oai" data-validation="required">
        <input type="text" placeholder="Formato de metadados" class="uk-form-width-medium" name="metadataPrefix">
        <input type="text" placeholder="Set (opcional)" class="uk-form-width-medium" name="set">
        <input type="text" placeholder="Fonte" class="uk-form-width-medium" name="source">
        <input type="text" placeholder="Tag para formar um grupo" class="uk-form-width-medium" name="tag">
        <button class="uk-button-primary" name="btn_submit">Incluir</button><br/>                                    
    </fieldset>
</form>
<br/>
<form class="uk-form-stacked" action="z3950.php" method="get" accept-charset="utf-8">
    <div class="uk-margin" uk-grid>
    <label class="uk-form-label" for="form-stacked-text">Consulta no Z39.50</a></label>
        <div class="uk-form-controls">
            <input type="text" placeholder="Insira um ISBN válido" class="uk-input uk-form-width-large" name="isbn" size="13"><br/>
            <input type="text" placeholder="Ou número do sistema" class="uk-input uk-form-width-large" name="sysno" size="13"><br/>
            <input type="text" placeholder="Ou pesquisar por título" class="uk-input uk-form-width-large" name="title" size="200"><br/>
            <input type="text" placeholder="e autor" class="uk-input uk-form-width-large" name="author" size="100"><br/>
            <input type="text" placeholder="e ano" class="uk-input uk-form-width-large" name="year" size="4"><br/>
        </div>
        <div>    
            <button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom" name="btn_submit">Pesquisa Z39.50</button><br/>
        </div>
        <div><p>A busca só aceita 2 critérios simultâneos nos campos de titulo, autor e ano</p></div>                                
    </div>
</form>
<br/>
<form class="uk-form" action="grobid.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <fieldset data-uk-margin>
        <legend>PDF para Aleph Sequencial</legend>
        <input type="file" name="file">        
        <button class="uk-button-primary" name="btn_submit">Upload</button><br/>                                    
    </fieldset>
</form>
<br/>
<form class="uk-form" action="grobid.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <fieldset data-uk-margin>
        <legend>URL de PDF para Aleph Sequencial</legend>
        <input type="text" placeholder="Insira um URL de PDF válido" class="uk-form-width-medium" name="url" data-validation="required">
        <button class="uk-button-primary" name="btn_submit">Incluir</button><br/>                         
    </fieldset>
</form>
<br/>
<form class="uk-form" action="grobidtojats.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <fieldset data-uk-margin>
        <legend>PDF para JATS</legend>
        <input type="file" name="file">        
        <button class="uk-button-primary" name="btn_submit">Upload</button><br/>                                    
    </fieldset>
</form>
<br/>    





                
                </div>
            </div>
            </div>

            <form action="result.php">
                <div class="form-group">
                    <label for="searchQuery">Pesquisa por trabalho - <a href="result.php">Ver todos</a></label>
                    <input type="text" name="search" class="form-control" id="searchQuery" aria-describedby="searchHelp" placeholder="Pesquise por termo ou autor">
                    <small id="searchHelp" class="form-text text-muted">Dica: Use * para busca por radical. Ex: biblio*.</small>
                    <small id="searchHelp" class="form-text text-muted">Dica 2: Para buscas exatas, coloque entre ""</small>
                    <small id="searchHelp" class="form-text text-muted">Dica 3: Você também pode usar operadores booleanos: AND, OR</small>
                </div>                       
                <button type="submit" class="btn btn-primary">Pesquisar</button>
                
            </form>
            <form action="result.php" method="get">
                <div class="form-group mt-3">
                    <label for="tagSearch">Pesquisa por TAG</label>
                    <input type="text" placeholder="Pesquise por tag" class="form-control" id="tagSearch" name="filter[]" value="tag:">
                </div>
                <button type="submit" class="btn btn-primary">Buscar TAG</button>   
            </form>
            <form action="result.php" method="get">
                <div class="form-group mt-3">
                    <label for="codpesSearch">Pesquisa por Número USP</label>
                    <input type="text" placeholder="Pesquise por tag" class="form-control" id="codpesSearch" name="filter[]" value="USP.codpes:">
                </div>
                <button type="submit" class="btn btn-primary">Buscar Número USP</button>   
            </form>
            <form action="result_autores.php" method="get">
                <div class="form-group mt-3">
                    <label for="authorSearch">Pesquisa por autor - <a href="result_autores.php">Ver todos</a></label>
                    <input type="text" placeholder="Pesquise por nome do autor ou número USP" class="form-control" id="authorSearch" name="search">
                    <input type="hidden" name="fields[]" value="nome_completo">                                
                    <input type="hidden" name="fields[]" value="nome_em_citacoes_bibliograficas">
                    <input type="hidden" name="fields[]" value="endereco.endereco_profissional.nomeInstituicaoEmpresa">                   
                </div>
                <button type="submit" class="btn btn-primary">Buscar autor</button>   
            </form>
        </div>
    </div>    

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="uk-h3">Unidade USP</h2>
                <ul class="list-group">
                    <?php paginaInicial::unidadeUSP_inicio(); ?>
                </ul>
                <h2>Departamentos</h2>
                <ul class="list-group">
                    <?php  ?>
                </ul>          
            </div>
            <div class="col-md-3">
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
                <h2 class="uk-h3">Alguns números</h2>
                <ul class="list-group">
                    <li><?php echo paginaInicial::contar_tipo_de_registro("Work"); ?> registros</li> 
                    <li><?php echo paginaInicial::contar_tipo_de_registro("Curriculum"); ?> currículos</li>
                </ul>     
            </div>          
        </div>
    </div>


        <?php include('inc/footer.php'); ?>
            
        
    </body>
</html>