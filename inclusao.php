<?php
    session_start();
    if ($_SESSION["login"] === true) {

    } else {
        header("Location: login.php");
        die();
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
    <title><?php echo $branch ?> - Inclusão</title>

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
            <h1 class="display-5"><?php echo $branch; ?> - Inclusão</h1>
            <p><?php echo $branch_description; ?></p>

            <?php isset($error_connection_message) ? print_r($error_connection_message) : "" ?>

            <h1 class="display-5 mt-3">Inclusão</h1>

            <form class="m-3" action="lattes_xml_to_elastic_dedup.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
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
                </div>
                <div class="input-group">
                    <input type="text" placeholder="Departamento" class="form-control" name="departamento">
                    <input type="text" placeholder="Divisão" class="form-control" name="divisao">
                    <input type="text" placeholder="Seção" class="form-control" name="secao">
                    <input type="text" placeholder="Nome do PPG" class="form-control" name="ppg_nome">
                    <input type="text" placeholder="Tipo de vínculo" class="form-control" name="tipvin">
                </div>
                <div class="input-group">
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

            <form class="m-3" action="import_lattes_to_elastic_dedup.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <legend>Inserir um ID do Lattes</legend>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">ID do Lattes</span>
                    </div>
                    <div class="custom-file">
                        <input type="text" placeholder="ID do lattes (13 dígitos)" class="form-control" name="lattesID">
                    </div>
                    <input type="text" placeholder="TAG" class="form-control" name="tag">
                    <input type="text" placeholder="Núm. funcional" class="form-control" name="numfuncional">
                    <input type="text" placeholder="Unidade" class="form-control" name="unidade">
                </div>
                <div class="input-group">
                    <input type="text" placeholder="Departamento" class="form-control" name="departamento">
                    <input type="text" placeholder="Divisão" class="form-control" name="divisao">
                    <input type="text" placeholder="Seção" class="form-control" name="secao">
                    <input type="text" placeholder="Nome do PPG" class="form-control" name="ppg_nome">
                    <input type="text" placeholder="Tipo de vínculo" class="form-control" name="tipvin">
                </div>
                <div class="input-group">
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

            <form class="m-3" action="csv_upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <legend>Enviar um arquivo CSV</legend>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">CSV</span>
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

            <form class="m-3" action="lattesid_by_cpf.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <legend>Enviar um arquivo com os CPFs</legend>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Obter Lattes IDs usando o CPF</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="fileXML" aria-describedby="fileXML" name="file">
                        <label class="custom-file-label" for="fileXML">Escolha o arquivo</label>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Upload</button>
                    </div>
                </div>
            </form>

            <form class="m-3" action="tools/upload/upload_json_ufscar.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <legend>Enviar um arquivo JSON criado pela UFSCar</legend>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">JSON</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="fileXML" aria-describedby="file" name="file">
                        <label class="custom-file-label" for="fileXML">Escolha o arquivo</label>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Upload</button>
                    </div>
                </div>
            </form>

            <!--

                    <form class="m-3" action="tools/upload/sucupira_upload.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <legend>Enviar um arquivo do SUCUPIRA</legend>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SUCUPIRA</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileCSVSucupira" aria-describedby="fileCSVSucupira" name="file">
                                <label class="custom-file-label" for="fileCSVSucupira">Escolha o arquivo</label>
                            </div>
                            <input type="text" placeholder="TAG para formar um grupo" class="form-control" name="tag">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Upload</button>
                            </div>    
                        </div>  
                    </form>
                    <div class="m-2">&nbsp;</div>

                    
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
                    -->
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

        </div>
    </div>

    <div class="container">
        <div class="row">


        </div>
    </div>
    </div>


    <?php include('inc/footer.php'); ?>


</body>

</html>

<?php session_destroy(); ?>