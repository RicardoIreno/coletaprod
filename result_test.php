<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<head>
    <?php
  require 'inc/config.php';
  require 'inc/meta-header.php';
  require 'inc/functions.php';

  if (isset($fields)) {
    $_POST["fields"] = $fields;
  }


  $result_post = Requests::postParser($_POST);
  if (!empty($_POST)) {
    $limit = $result_post['limit'];
    $page = $result_post['page'];
    $params = [];
    $params["index"] = $index;
    $params["body"] = $result_post['query'];
    $cursorTotal = $client->count($params);
    $total = $cursorTotal["count"];
    if (isset($_POST["sort"])) {
        $result_post['query']["sort"][$_POST["sort"]]["unmapped_type"] = "long";
        $result_post['query']["sort"][$_POST["sort"]]["missing"] = "_last";
        $result_post['query']["sort"][$_POST["sort"]]["order"] = "desc";
        $result_post['query']["sort"][$_POST["sort"]]["mode"] = "max";
    } else {
        $result_post['query']['sort']['datePublished.keyword']['order'] = "desc";
        $result_post['query']["sort"]["_uid"]["unmapped_type"] = "long";
        $result_post['query']["sort"]["_uid"]["missing"] = "_last";
        $result_post['query']["sort"]["_uid"]["order"] = "desc";
        $result_post['query']["sort"]["_uid"]["mode"] = "max";
    }
    $params["body"] = $result_post['query'];
    $params["size"] = $limit;
    $params["from"] = $result_post['skip'];
    $cursor = $client->search($params);
  } else {
    $limit = 10;
    $page = 1;
    $total = 0;
    $cursor["hits"]["hits"] = [];
  }

  /*pagination - start*/
  $get_data = $_POST;
  /*pagination - end*/

  ?>
    <meta charset="utf-8" />
    <title><?php echo $branch; ?> - Resultado da busca</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="description" content="Prodmais Unifesp." />
    <meta name="keywords" content="Produção acadêmica, lattes, ORCID" />
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="sass/main.css" />
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

    <div class="result-container">

        <main class="result-main">
            <div class="c-searchterm">Termo pesquisado: </div>

            <?php ui::newpagination($page, $total, $limit, $_POST, 'result_test'); ?>
            <br/>

            <?php if ($total == 0) : ?>
              <br />
              <div class="alert alert-info" role="alert">
                Sua busca não obteve resultado. Você pode refazer sua busca abaixo:<br /><br />
                <form action="result.php">
                  <div class="form-group">
                    <input type="text" name="search" class="form-control" id="searchQuery" aria-describedby="searchHelp"
                      placeholder="Pesquise por termo ou autor">
                    <small id="searchHelp" class="form-text text-muted">Dica: Use * para busca por radical. Ex:
                      biblio*.</small>
                    <small id="searchHelp" class="form-text text-muted">Dica 2: Para buscas exatas, coloque entre ""</small>
                    <small id="searchHelp" class="form-text text-muted">Dica 3: Você também pode usar operadores booleanos:
                      AND, OR</small>
                  </div>
                  <button type="submit" class="btn btn-primary">Pesquisar</button>

                </form>
              </div>
              <br /><br />
            <?php endif; ?>

            <?php foreach ($cursor["hits"]["hits"] as $r) : ?>

            <div class="s-list">
              <div class="s-list-bullet">
                <?php
                  $exemplo = $r["_source"]['tipo'];

                  switch ($exemplo) {
                    case "Artigo publicado":
                      echo '<img class="s-list-ico" 
                            src="inc/images/icons/article-published.svg" 
                            title="Artigo publicado"  />';
                      break;

                    case "Capítulo de livro publicado":
                      echo '<img class="s-list-ico" 
                            src="inc/images/icons/chapter.svg"
                            title="Capítulo de livro publicado" />';
                      break;

                    case "Livro publicado ou organizado":
                      echo '<img class="s-list-ico" 
                            src="inc/images/icons/book.svg"
                            title="Livro publicado ou organizado" />';
                      break;

                    case "Patente":
                      echo '<img class="s-list-ico" 
                            src="inc/images/icons/patent.svg"
                            title="Patente" />';
                      break;

                    case "Software":
                      echo '<img class="s-list-ico" 
                            src="inc/images/icons/softwares.svg"
                            title="Software" />';
                      break;

                    case "Textos em jornais de notícias/revistas":
                      echo '<img class="s-list-ico" 
                            src="inc/images/icons/papers.svg"
                            title="Textos em jornais de notícias/revistas" />';
                      break;

                    case "Trabalhos em eventos":
                      echo '<img class="s-list-ico" 
                            src="inc/images/icons/event.svg"
                            title="Trabalhos em eventos" />';
                      break;

                    case "Tradução":
                      echo '<img class="s-list-ico" 
                            src="inc/images/icons/book.svg"
                            title="Tradução" />';
                      break;

                    default:
                      echo '<img class="s-list-ico" 
                            src="inc/images/icons/default.svg"
                            title="Item" />';
                  }
                ?>
              </div> <!-- end s-list-bullet -->

              <div class="s-list-content">

                  <p class="ty-item"><?php echo $r["_source"]['name']; ?><i> — <?php echo $r["_source"]['tipo']; ?></i><span class="ty-gray"> — <?php echo $r["_source"]['datePublished']; ?></span></p>
                  <p class="ty-gray">
                      <b class="ty-subItem">Autores: </b>
                      <?php if (!empty($r["_source"]['author'])) : ?>
                        <?php foreach ($r["_source"]['author'] as $autores) {
                                  $authors_array[] = '' . $autores["person"]["name"] . '';
                              }
                              $array_aut = implode(", ", $authors_array);
                              unset($authors_array);
                              print_r($array_aut);
                        ?>
                      <?php endif; ?>
                  </p>


                  <div class="s-line ty-gray">

                      <?php if (!empty($r["_source"]['url'])) : ?>
                      <div class="s-line-item">
                          <img class="s-line-icon" src="inc/images/icons/link.svg" alt="representação de um link" />
                          <a href="<?php echo str_replace("]", "", str_replace("[", "", $r["_source"]['url'])); ?>" target="blank">Conteúdo completo</a>
                      </div>
                      <?php endif; ?>

                      <?php if (!empty($r["_source"]['doi'])) : ?>
                      <div class="s-line-item">
                          <img class="s-line-icon" src="inc/images/logos/doi.svg" alt="logo DOI" />
                          <a href="https://doi.org/<?php echo $r["_source"]['doi']; ?>"> DOI: <?php echo $r["_source"]['doi']; ?></a>
                      </div>
                      <?php endif; ?>

                      <?php if (!empty($r["_source"]['isPartOf']['issn'])) : ?>
                      <div class="s-line-item">
                          <a href=""> ISSN: <?php echo $r["_source"]['isPartOf']['issn']; ?></a>
                      </div>
                      <?php endif; ?>

                      <?php if (!empty($r["_source"]['EducationEvent']['name'])) : ?>
                      <div class="s-line-item">
                          <a href=""> Nome do evento: <?php echo $r["_source"]['EducationEvent']['name']; ?></a>
                      </div>
                      <?php endif; ?>

                      

                  </div> <!-- end s-line -->
                  
                  <?php if (!empty($r["_source"]['isPartOf']['name'])) : ?>
                    <p class="ty-right ty-themeLight">Fonte: <?php echo $r["_source"]['isPartOf']['name']; ?></p>
                  <?php endif; ?>

                  <?php DadosInternos::queryProdmais($r["_source"]['name'], $r["_source"]['datePublished'], $r['_id']); ?>

                  <!-- <div class="s-line-item">
                    <img class="s-line-icon" src="inc/images/icons/citation.svg" alt="representação de citação" />
                    <span class="c-pi-citations">Web Of Science: </span>
                    <span class="c-pi-citations">Scopus </span>
                  </div> -->
              </div> <!-- end s-list-content -->
            </div> <!-- end s-list -->

            <?php endforeach; ?>


            <?php ui::newpagination($page, $total, $limit, $_POST, 'result_test'); ?>

        </main>

        <nav class="cc-fbar">
            <div class="cc-fbar-header">
                <b class="ty">Refinar Resultados</b>
            </div>
            <div class="cc-fbloc-wrapper">
                <!-- <div class="gradient"></div> -->

                <?php
                $facets = new FacetsNew();
                $facets->query = $result_post['query'];

                if (!isset($_POST)) {
                    $_POST = null;
                }

                $facets->facet(basename(__FILE__), "vinculo.ppg_nome", 100, "Nome do PPG", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "tipo", 100, "Tipo de material", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "author.person.name", 100, "Nome completo do autor", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "vinculo.nome", 100, "Nome do autor vinculado à instituição", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "vinculo.lattes_id", 100, "ID do Lattes", null, "_term", $_POST);

                $facets->facet(basename(__FILE__), "country", 200, "País de publicação", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "datePublished", 120, "Ano de publicação", "desc", "_term", $_POST);
                $facets->facet(basename(__FILE__), "language", 40, "Idioma", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "lattes.natureza", 100, "Natureza", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "lattes.meioDeDivulgacao", 100, "Meio de divulgação", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "about", 100, "Palavras-chave", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "agencia_de_fomento", 100, "Agências de fomento", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "area_do_conhecimento.nomeGrandeAreaDoConhecimento", 100, "Nome da grande área do conhecimento", null, "_term", $_POST);
                //$facets->facet(basename(__FILE__), "area_do_conhecimento.nomeDaAreaDoConhecimento", 100, "Nome da Área do Conhecimento", null, "_term", $_POST);
                //$facets->facet(basename(__FILE__), "area_do_conhecimento.nomeDaSubAreaDoConhecimento", 100, "Nome da Sub Área do Conhecimento", null, "_term", $_POST);
                //$facets->facet(basename(__FILE__), "area_do_conhecimento.nomeDaEspecialidade", 100, "Nome da Especialidade", null, "_term", $_POST);

                $facets->facet(basename(__FILE__), "trabalhoEmEventos.classificacaoDoEvento", 100, "Classificação do evento", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "EducationEvent.name", 100, "Nome do evento", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "publisher.organization.location", 100, "Cidade", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "trabalhoEmEventos.anoDeRealizacao", 100, "Ano de realização do evento", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "trabalhoEmEventos.tituloDosAnaisOuProceedings", 100, "Título dos anais", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "trabalhoEmEventos.isbn", 100, "ISBN dos anais", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "trabalhoEmEventos.nomeDaEditora", 100, "Editora dos anais", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "trabalhoEmEventos.cidadeDaEditora", 100, "Cidade da editora", null, "_term", $_POST);

                $facets->facet(basename(__FILE__), "isPartOf.name", 100, "Título do periódico", null, "_term", $_POST);

                // $facets->facetExistsField(basename(__FILE__), "ExternalData.crossref.message.title", 100, "Dados coletados da Crossref?", null, "_term", $_POST);
                // $facets->facet(basename(__FILE__), "ExternalData.crossref.message.author.affiliation.name", 100, "Crossref - Afiliação", null, "_term", $_POST);
                // $facets->facet(basename(__FILE__), "ExternalData.crossref.message.funder.name", 100, "Crossref - Agência de financiamento", null, "_term", $_POST);
                // $facets->facet(basename(__FILE__), "ExternalData.crossref.message.funder.DOI", 100, "Crossref - Agência de financiamento - DOI", null, "_term", $_POST);
                // $facets->facet_range(basename(__FILE__), "ExternalData.crossref.message.is-referenced-by-count", 100, "Crossref - Número de citações obtidas", null, "_term", $_POST);

                $facets->facet(basename(__FILE__), "vinculo.campus", 100, "Campus", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "vinculo.desc_gestora", 100, "Gestora", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "vinculo.unidade", 100, "Unidade", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "vinculo.departamento", 100, "Departamento", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "vinculo.divisao", 100, "Divisão", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "vinculo.secao", 100, "Seção", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "vinculo.tipvin", 100, "Tipo de vínculo", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "vinculo.genero", 100, "Gênero", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "vinculo.desc_nivel", 100, "Nível", null, "_term", $_POST);
                $facets->facet(basename(__FILE__), "vinculo.desc_curso", 100, "Curso", null, "_term", $_POST);

                ?>

            </div> <!-- end cc-fbloc -->
        </nav> <!-- end cc-fbar -->
    </div> <!-- end result-container -->

    <?php include('inc/footer.php'); ?>
    <script>
    let fblocs = document.getElementsByClassName('cc-fbloc')

    for (let i = 0; i < fblocs.length; i++) {
        const newBtn = document.createElement('button')
        newBtn.classList.add('cc-fbloc-btn')
        newBtn.innerHTML =
            "<svg class='cc-fbloc-btn-ico' x='0px' y='0px' viewBox='0 0 80 48'> <path d='M72.3,35.5c-0.7,0-1.5-0.2-2.2-0.5L40.3,20.5l-30.6,14c-2.5,1.1-5.5,0-6.6-2.5c-1.1-2.5,0-5.5,2.5-6.6l32.7-15 c1.4-0.6,2.9-0.6,4.3,0.1l32,15.6c2.5,1.2,3.5,4.2,2.3,6.7C76,34.5,74.2,35.5,72.3,35.5z' /> </svg>"
        newBtn.addEventListener("click", function() {
            this.parentNode.removeAttribute("open")
        })
        fblocs[i].appendChild(newBtn)
    }
    </script>
</body>

</html>