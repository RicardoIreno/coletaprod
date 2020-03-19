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

            <!-- Modal Inclusão -->
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bd-example-modal-xl">Inclusão</button>

            <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content container">

                    <h1 class="display-5 mt-3">Inclusão</h1>

                    <!--
                    <form action="lattes_json_to_elastic.php" method="get">
                        <legend>Inserir um ID do Lattes</legend>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Lattes ID</span>
                            </div>
                            <input type="text" placeholder="Insira o ID do Curriculo" class="form-control" name="id_lattes" data-validation="required">
                            <input type="text" placeholder="TAG para formar um grupo" class="form-control" name="tag">
                            <input type="text" placeholder="Número funcional" class="form-control" name="numfuncional">                            
                            <input type="text" placeholder="Unidade" class="form-control" name="unidade">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Enviar</button>
                            </div>    
                        </div>  
                    </form>
                    -->

                    <form class="m-3" action="lattes_xml_to_elastic.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <legend>Inserir um XML do Lattes</legend>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">XML Lattes</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileXML" aria-describedby="fileXML" name="file">
                                <label class="custom-file-label" for="fileXML">Escolha o arquivo</label>
                            </div>
                            <input type="text" placeholder="TAG" class="form-control" name="tag">
                            <input type="text" placeholder="Núm. funcional" class="form-control" name="numfuncional">                            
                            <input type="text" placeholder="Unidade" class="form-control" name="unidade">
                            <input type="text" placeholder="Departamento" class="form-control" name="departamento">
                            <input type="text" placeholder="Divisão" class="form-control" name="divisao">
                            <input type="text" placeholder="Seção" class="form-control" name="secao">
                            <input type="text" placeholder="Nome do PPG" class="form-control" name="ppg_nome">
                            <input type="text" placeholder="Tipo de vínculo" class="form-control" name="tipvin">
                            <input type="text" placeholder="Genero" class="form-control" name="genero">
                            <input type="text" placeholder="Nível" class="form-control" name="desc_nivel">
                            <input type="text" placeholder="Curso" class="form-control" name="desc_curso">
                            <input type="text" placeholder="Campus" class="form-control" name="campus">
                            <input type="text" placeholder="Gestora" class="form-control" name="desc_gestora">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Incluir</button>
                            </div>    
                        </div>  
                    </form> 


                    <form class="m-3" action="doi_to_elastic.php" method="get">
                        <legend>Inserir um DOI de artigo que queira incluir (sem http://doi.org/)</legend>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">DOI</span>
                            </div>
                            <input type="text" placeholder="Insira um DOI" class="form-control" name="doi" data-validation="required">
                            <input type="text" placeholder="TAG para formar um grupo" class="form-control" name="tag">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Enviar</button>
                            </div>    
                        </div>  
                    </form>

                    <form class="m-3" action="wos_upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <legend>Enviar um arquivo da Web of Science (UTF-8, separado por tabulações)</legend>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Web of Science</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileXML" aria-describedby="fileXML" name="file">
                                <label class="custom-file-label" for="fileXML">Escolha o arquivo</label>
                            </div>
                            <input type="text" placeholder="TAG para formar um grupo" class="form-control" name="tag">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Upload</button>
                            </div>    
                        </div>  
                    </form>

                    <form class="m-3" action="incites_upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <legend>Enviar um arquivo do INCITES (CSV)</legend>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">INCITES</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileXML" aria-describedby="fileXML" name="file">
                                <label class="custom-file-label" for="fileXML">Escolha o arquivo</label>
                            </div>
                            <input type="text" placeholder="TAG para formar um grupo" class="form-control" name="tag">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Upload</button>
                            </div>    
                        </div>  
                    </form>

                    <form class="m-3" action="scopus_upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <legend>Enviar um arquivo do Scopus (CSV - All available information)</legend>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Scopus</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileXML" aria-describedby="fileXML" name="file">
                                <label class="custom-file-label" for="fileXML">Escolha o arquivo</label>
                            </div>
                            <input type="text" placeholder="TAG para formar um grupo" class="form-control" name="tag">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Upload</button>
                            </div>    
                        </div>  
                    </form>

                    <form class="m-3" action="scival_upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <legend>Enviar um arquivo do SCIVAL (CSV - All available information)</legend>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SCIVAL</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileXML" aria-describedby="fileXML" name="file">
                                <label class="custom-file-label" for="fileXML">Escolha o arquivo</label>
                            </div>
                            <input type="text" placeholder="TAG para formar um grupo" class="form-control" name="tag">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Upload</button>
                            </div>    
                        </div>  
                    </form>
                    <div class="m-2">&nbsp;</div>

                    <!--
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

                    -->
                    <form class="m-3" action="openlibrary.php" method="get" accept-charset="utf-8">
                        <legend>Consulta na API do OpenLibrary</legend>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">API</span>
                            </div>
                                <input type="text" placeholder="Insira um ISBN válido" class="form-control" name="isbn" size="13"><br/>
                                <input type="text" placeholder="Ou codigo do OpenLibrary" class="form-control" name="sysno" size="13"><br/>
                                <input type="text" placeholder="Ou pesquisar por título" class="form-control" name="title" size="200"><br/>
                                <input type="text" placeholder="e autor" class="form-control" name="author" size="100"><br/>
                                <input type="text" placeholder="e ano" class="form-control" name="year" size="4"><br/>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Pesquisar no OpenLibrary</button>
                            </div>    
                        </div>
                    </form>                    
                    <form class="m-3" action="z3950.php" method="get" accept-charset="utf-8">
                        <legend>Consulta no Z39.50</legend>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Z39.50</span>
                            </div>
                                <input type="text" placeholder="Insira um ISBN válido" class="form-control" name="isbn" size="13"><br/>
                                <input type="text" placeholder="Ou número do sistema" class="form-control" name="sysno" size="13"><br/>
                                <input type="text" placeholder="Ou pesquisar por título" class="form-control" name="title" size="200"><br/>
                                <input type="text" placeholder="e autor" class="form-control" name="author" size="100"><br/>
                                <input type="text" placeholder="e ano" class="form-control" name="year" size="4"><br/>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Pesquisa Z39.50</button>
                            </div>    
                        </div>
                    </form>
                    <!--
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

                    -->
                
                </div>
            </div>
            </div>


            <!-- Modal Inclusão -->
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#source">Fonte para comparativo</button>

            <div class="modal fade bd-example-modal-x1" id="source" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content container">

                    <h1 class="display-5 mt-3">Fonte para comparativo</h1>

                    <form class="m-3" action="tools/harvester_source.php" method="get">
                        <legend>Harvesting OAI-PMH</legend>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">OAI-PMH</span>
                            </div>
                            <input type="text" placeholder="URL do OAI-PMH" class="form-control" name="oai">
                            <input type="text" placeholder="Set (Opcional)" class="form-control" name="set">  
                            <select class="form-control" id="format" name="metadataFormat">
                                <option selected>Formato</option>
                                <option value="oai_dc">oai_dc</option>
                                <option value="nlm">nlm</option>
                                <option value="dim">dim</option>
                            </select>                 
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Coletar OAI</button>
                            </div>    
                        </div>  
                    </form>

                    <!--
                    <form class="m-3" action="wos_upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <legend>Upload MARC</legend>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">MARC</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileXML" aria-describedby="fileXML" name="file">
                                <label class="custom-file-label" for="fileXML">Escolha o arquivo</label>
                            </div>
                            <input type="text" placeholder="TAG para formar um grupo" class="form-control" name="tag">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Upload</button>
                            </div>    
                        </div>  
                    </form>
                    -->                 
                
                </div>
            </div>
            </div>            

            <a class="btn btn-info" href="result_source.php">Ver registros na fonte</a>





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
                    <?php paginaInicial::unidade_inicio("Instituicao.unidade"); ?>
                </ul>
                <h2>Departamento</h2>
                <ul class="list-group">
                    <?php paginaInicial::unidade_inicio("Instituicao.departamento"); ?>
                </ul>
                <h2>Tags</h2>
                <ul class="list-group">
                    <?php paginaInicial::unidade_inicio("tag"); ?>
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