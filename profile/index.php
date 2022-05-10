<?php
// Set directory to ROOT
chdir('../');
// Include essencial files
require 'inc/config.php';
require 'inc/functions.php';
include_once '_fakedata.php';

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
//echo "<pre>".print_r($profile, true)."</pre>";
?>

<!DOCTYPE HTML>

<html lang="pt-br">

<head>
  <title>Prodmais — Perfil do usuário - <?php echo $profile["nome_completo"] ?></title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta name="description" content="Prodmais Unifesp." />
  <meta name="keywords" content="Produção acadêmica, lattes, ORCID" />
  <link rel="stylesheet" href="../sass/main.css" />
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>

<body class="profile-body">

  <!-- NAV -->
  <?php require 'inc/navbar.php'; ?>
  <!-- /NAV -->

  <main class="profile-container">
    <div class="profile-wrapper">



      <div class="cc-coregrid">
        <div class="cc-coregrid-one">

          <div class="cc-display">
            <img class="cc-display-badge" src="../inc/images/badges/bolsista-cnpq-1a.svg" />
            <div class="cc-display-mask">
              <img class="cc-display-photo"
                src="http://servicosweb.cnpq.br/wspessoa/servletrecuperafoto?tipo=1&amp;bcv=true&amp;id=<?php echo $lattesID10; ?>" />
            </div>
          </div> <!-- end cc-photo-wrapper -->


          <div class="cc-badgeicons">
            <img class="cc-badgeicons-icon" src="../inc/images/badges/bolsista-cnpq-1a.svg" alt="Bolsista CNPQ nível 1A"
              title="Bolsista CNPQ nível 1A" />

            <img class="cc-badgeicons-icon" src="../inc/images/badges/member.svg" alt="Membro de conselho ou comissão"
              title="Membro de conselho ou comissão" />

            <img class="cc-badgeicons-icon" src="../inc/images/badges/leader.svg" alt="Exercedor de cargo de chefia"
              title="Exercedor de cargo de chefia" />
          </div> <!-- end cc-badgeicons -->

        </div> <!-- end core-one -->

        <div class="cc-coregrid-two">
          <h1 class="ty-name">
            <?php echo $profile["nome_completo"] ?>

            <?php if($profile["nacionalidade"]=="B") : ?>
            <img class="country-flag" src="../inc/images/country_flags/br.svg" alt="nacionalidade brasileira"
              title="nacionalidade brasileira" />
            <?php endif; ?>
          </h1>

          <!-- <div class="u-mb-2  "></div> -->
          <h2 class="ty ty-prof">Universidade Federal de São Paulo</h2>
          <?php if(!empty($profile["unidade"][0])) : ?>
          <p class="ty ty-prof"><?php echo $profile["unidade"][0] ?></p>
          <?php endif; ?>
          <?php if(!empty($profile["departamento"][0])) : ?>
          <p class="ty ty-prof"><?php echo $profile["departamento"][0] ?></p>
          <?php endif; ?>
          <?php if(!empty($profile["ppg_nome"][0])): ?>
          <?php foreach ($profile["ppg_nome"] as $key => $ppg_nome): ?>
          <p class="ty ty-prof">Programa de Pós-Graduação: <?php echo $ppg_nome ?></p>
          <?php endforeach; ?>
          <?php endif; ?>
          <!-- <p class="ty ty-email">bertola@unifesp.br</p> -->
          <div class="u-mb-1"></div>


          <h3 class="ty ty-title">Perfis na web</h3>
          <div class="cc-socialicons">

            <?php if(!empty($profile['lattesID'])) : ?>

            <a href="https://lattes.cnpq.br/<?php echo $profile['lattesID']; ?>" target="_blank" rel="external"><img
                class="cc-socialicons-icon" src="../inc/images/academic_plataforms/logo_lattes.svg" alt="Lattes"
                title="Lattes" /></a>
            <?php endif; ?>
            <?php if(!empty($profile['orcid_id'])) : ?>
            <a href="<?php echo $profile['orcid_id']; ?>" target="_blank" rel="external"><img
                class="cc-socialicons-icon" src="../inc/images/academic_plataforms/logo_research_id.svg" alt="ORCID"
                title="ORCID" /></a>
            <?php endif; ?>

          </div> <!-- end cc-socialicons -->

        </div> <!-- end core-two -->

        <div class="cc-coregrid-three">

          <div class="cc-numbers">
            <span class="cc-numbers-number">
              <img class="cc-numbers-icon" src="../inc/images/icons/article-published.svg" alt="Artigos publicados" />
              45
            </span>

            <span class="cc-numbers-number">
              <img class="cc-numbers-icon" src="../inc/images/icons/article-aproved.svg" alt="Artigos aprovados" />
              35
            </span>

            <span class="cc-numbers-number">
              <img class="cc-numbers-icon" src="../inc/images/icons/orientation.svg" alt="Orientações" />
              12
            </span>

            <span class="cc-numbers-number">
              <img class="cc-numbers-icon" src="../inc/images/icons/research.svg" alt="Pesquisas" />
              15
            </span>

            <span class="cc-numbers-number">
              <img class="cc-numbers-icon" src="../inc/images/icons/event.svg" alt="Eventos participados" />
              41
            </span>

          </div> <!-- end profile-numbers -->


          <a class="u-skip" href=”#skipcc-graph”>Pular gráfico</a>

          <div class="cc-graph">

            <div class="cc-graph-line">
              <span class="cc-graph-label">Artigos publicados</span>
              <?php 
                foreach ($artigos_publicados as $i => $j) {
                  echo 
                  "<div 
                    class='cc-graph-unit' 
                    data-weight='{$j['total']}'
                    title='{$j['year']} — total: {$j['total']}'
                  ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="cc-graph-line">
              <span class="cc-graph-label">Livros e capítulos</span>
              <?php 
                foreach ($livros_e_capitulos as $i => $j) {
                  echo 
                    "<div 
                      class='cc-graph-unit' 
                      data-weight='{$j['total']}'
                      title='{$j['year']} — total: {$j['total']}'
                    ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="cc-graph-line cc-graph-division">
              <span class="cc-graph-label">Orientações de mestrado</span>
              <?php 
                foreach ($orientacoes_mestrado as $i => $j) {
                  echo 
                    "<div 
                      class='cc-graph-unit' 
                      data-weight='{$j['total']}'
                      title='{$j['year']} — total: {$j['total']}'
                    ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="cc-graph-line">
              <span class="cc-graph-label">Orientações de doutorado</span>
              <?php 
                foreach ($orientacoes_doutorado as $i => $j) {
                  echo 
                    "<div 
                      class='cc-graph-unit' 
                      data-weight='{$j['total']}'
                      title='{$j['year']} — total: {$j['total']}'
                    ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="cc-graph-line">
              <span class="cc-graph-label">Ensino</span>
              <?php 
                foreach ($ensino as $i => $j) {
                  echo 
                    "<div 
                      class='cc-graph-unit' 
                      data-weight='{$j['total']}'
                      title='{$j['year']} — total: {$j['total']}'
                    ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="cc-graph-line cc-graph-division">
              <span class="cc-graph-label">Softwares e patentes</span>
              <?php 
                foreach ($softwares_patentes as $i => $j) {
                  echo 
                    "<div 
                      class='cc-graph-unit' 
                      data-weight='{$j['total']}'
                      title='{$j['year']} — total: {$j['total']}'
                    ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="cc-graph-line">
              <span class="cc-graph-label">Participações em eventos</span>
              <?php 
                foreach ($participacoes_eventos as $i => $j) {
                echo 
                  "<div 
                    class='cc-graph-unit' 
                    data-weight='{$j['total']}'
                    title='{$j['year']} — total: {$j['total']}'
                  ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="cc-graph-line">
              <div class="cc-graph-icon"></div>
              <div class="cc-graph-label">2021 ————— 2015</div>
            </div>

          </div> <!-- end cc-graph -->


          <div class="cc-graph-info">
            <span class="cc-graph-info-label">+</span>
            <div class="cc-graph-unit" data-weight="4"></div>
            <div class="cc-graph-unit" data-weight="3"></div>
            <div class="cc-graph-unit" data-weight="2"></div>
            <div class="cc-graph-unit" data-weight="1"></div>
            <div class="cc-graph-unit" data-weight="0"></div>
            <span class="cc-graph-info-label">-</span>
          </div>


        </div> <!-- end core-three -->


      </div> <!-- end cc-coregrid  -->


      <span class="u-skip" id="skipcc-graph”" class="ty ty-lastUpdate">Atualizado em
        <?php echo $profile['data_atualizacao']; ?></span>



      <div id="tabs" class="profile-tabs">


        <div class="cc-tab-bar">
          <button id="tab-btn-1" class="cc-tab-btn" v-on:click="changeTab('1')">Sobre Mim</button>
          <button id="tab-btn-2" class="cc-tab-btn" v-on:click="changeTab('2')">Produção Intelectual</button>
          <button id="tab-btn-3" class="cc-tab-btn" v-on:click="changeTab('3')">Pesquisa</button>
          <button id="tab-btn-4" class="cc-tab-btn" v-on:click="changeTab('4')">Orientações</button>
        </div>



        <div id="tab-one" class="cc-tab-content" v-if="tabOpened == '1'">


          <div class="u-justify">
            <h3 class="ty ty-title">Resumo</h3>
            <p class="ty">
              <?php echo $profile["resumo_cv"]["texto_resumo_cv_rh"] ?>
            </p>
            <p class="ty-right ty-themeLight">Fonte: Lattes CNPq</p>

          </div>

          <h3 class="ty ty-title">Nomes em citações bibliográficas</h3>

          <p class="ty-prof"><?php echo $profile["nome_em_citacoes_bibliograficas"] ?></p>




          <h3 class="ty ty-title">Tags mais usadas</h3>
          <?php
              $authorfacets = new AuthorFacets();
              $authorfacets->query = $result_get['query'];

              if (!isset($_GET)) {
                  $_GET = null;
              }

              $resultaboutfacet = json_decode($authorfacets->authorfacet(basename(__FILE__), "about", 120, "Palavras-chave do autor", null, "_term", $_GET), true);
              shuffle($resultaboutfacet);
          ?>

          <div>
            <ul class="tag-cloud" role="navigation" aria-label="Tags mais usadas">
              <?php foreach ($resultaboutfacet as $t=> $tag) {
                echo
                "<li>
                  <a class='tag' data-weight={$tag['amount']}>
                    {$tag['category']}</a>
                </li>";
                }
                unset($t);
                unset($category);
                unset($amount);
                ?>
            </ul>
          </div> <!-- end -->

          <hr class="c-line u-my-2" />


          <?php if(isset($profile["idiomas"])): ?>
          <div class=" u-left">
            <h3 class="ty ty-title">Idiomas</h3>
            <?php foreach ($profile["idiomas"] as $key => $idioma): ?>

            <div class="s-list">

              <div class="s-list-bullet">
                <?php 
                  switch ($idioma["descricaoDoIdioma"]) {
                    case "Inglês":
                      echo "<img class='c-iconlang' src='../inc/images/icons/languages/en.svg' />";
                      break;
                    case "Espanhol":
                      echo "<img class='c-iconlang' src='../inc/images/icons/languages/es.svg' />";
                      break;
                    case "Português":
                      echo "<img class='c-iconlang' src='../inc/images/icons/languages/pt.svg' />";
                      break;
                    case "Italiano":
                      echo "<img class='c-iconlang' src='../inc/images/icons/languages/pt.svg' />";
                      break;
                    case "Francês":
                      echo "<img class='c-iconlang' src='../inc/images/icons/languages/pt.svg' />";
                      break;
                    case "Alemão":
                      echo "<img class='c-iconlang' src='../inc/images/icons/languages/pt.svg' />";
                      break;
                    case "Russo":
                      echo "<img class='c-iconlang' src='../inc/images/icons/languages/pt.svg' />";
                      break;
                    case "Mandarin":
                      echo "<img class='c-iconlang' src='../inc/images/icons/languages/pt.svg' />";
                      break;
                    default:
                      echo "<img class='c-iconlang' src='../inc/images/icons/languages/idioma.svg' />";
                      break;

                  }
                ?>
              </div>

              <div class="s-list-content">
                <p class="ty ty-item"><?php echo $idioma["descricaoDoIdioma"] ?></p>
                <p class="ty" style="margin-bottom:10px;">

                  Compreende <?php echo strtolower($idioma["proficienciaDeCompreensao"]) ?>
                  <b class="ty-subItem-light">/</b>

                  Fala <?php echo strtolower($idioma["proficienciaDeFala"]) ?>
                  <b class="ty-subItem-light">/</b>

                  Lê <?php echo strtolower($idioma["proficienciaDeLeitura"]) ?>
                  <b class="ty-subItem-light">/</b>

                  Escreve <?php echo strtolower($idioma["proficienciaDeEscrita"]) ?>
                </p>

              </div>
            </div> <!-- end s-list -->
            <?php endforeach; ?>
          </div> <!-- end u-left -->
          <?php endif; ?>

          <hr class="c-line u-my-2" />

          <h3 class="ty ty-title">Formação</h3>

          <!-- Livre Docência -->
          <?php if(isset($profile["formacao_academica_titulacao_livreDocencia"])): ?>

          <?php foreach ($profile["formacao_academica_titulacao_livreDocencia"] as $key => $livreDocencia): ?>

          <div class="formation-container">
            <div class="s-list">
              <div class="s-list-bullet">
                <img class="s-list-ico" src="../inc/images/icons/academic.svg" />
              </div>

              <div class="s-list-content">
                <div class="formation">
                  <p class="ty-item">Livre Docência
                    <span class="ty c-date-range"><?php echo $livreDocencia["anoDeObtencaoDoTitulo"] ?></span>
                  </p>
                  <p class="ty"><?php echo $livreDocencia["nomeInstituicao"] ?></p>
                  <div class="u-mb-1"></div>
                  <p class="ty">
                    <b class="ty-subItem">Título:</b>
                    <?php echo $livreDocencia["tituloDoTrabalho"] ?>
                  </p>

                  <?php if(!empty($livreDocencia["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Grande área:</b>
                    <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"] ?>
                  </p>
                  <?php endif; ?>
                  <?php if(!empty($livreDocencia["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Área do conhecimento:</b>
                    <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"] ?>
                  </p>
                  <?php endif; ?>
                  <?php if(!empty($livreDocencia["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Sub área:</b>
                    <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"] ?>
                  </p>
                  <?php endif; ?>
                  <?php if(!empty($livreDocencia["area_do_conhecimento"][0]["nomeDaEspecialidade"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Especialidade:</b>
                    <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeDaEspecialidade"] ?>
                  </p>
                  <?php endif; ?>

                </div> <!-- end formation -->
              </div> <!-- end s-list-content -->
            </div> <!-- end s-list -->
          </div> <!-- end formation-container -->
          <?php endforeach; ?>
          <?php endif; ?>



          <!-- Doutorado -->
          <?php if(isset($profile["formacao_academica_titulacao_doutorado"])): ?>

          <?php foreach ($profile["formacao_academica_titulacao_doutorado"] as $key => $doutorado): ?>

          <div class="formation-container">
            <div class="s-list">
              <div class="s-list-bullet">
                <img class="s-list-ico" src="../inc/images/icons/academic.svg" />
              </div>
              <div class="s-list-content">
                <div class="formation">
                  <p class="ty-item">Doutorado em <?php echo $doutorado["nomeCurso"] ?>
                    <span class="ty c-date-range"><?php echo $doutorado["anoDeInicio"] ?> -
                      <?php echo $doutorado["anoDeConclusao"] ?></span>
                  </p>
                  <p class="ty"><?php echo $doutorado["nomeInstituicao"] ?></p>
                  <div class="u-mb-1"></div>

                  <p class="ty">
                    <b class="ty-subItem">Título:</b> <?php echo $doutorado["tituloDaDissertacaoTese"] ?>
                  </p>

                  <p class="ty">
                    <b class="ty-subItem">Orientador(a):</b> <?php echo $doutorado["nomeDoOrientador"] ?>
                  </p>

                  <?php if(!empty($doutorado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Grande área:</b>
                    <?php echo $doutorado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"] ?>
                  </p>
                  <?php endif; ?>

                  <?php if(!empty($doutorado["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Área do conhecimento:</b>
                    <?php echo $doutorado["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"] ?>
                  </p>
                  <?php endif; ?>
                  <?php if(!empty($doutorado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Sub área:</b>
                    <?php echo $doutorado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"] ?>
                  </p>
                  <?php endif; ?>
                  <?php if(!empty($doutorado["area_do_conhecimento"][0]["nomeDaEspecialidade"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Especialidade:</b>
                    <?php echo $doutorado["area_do_conhecimento"][0]["nomeDaEspecialidade"] ?>
                  </p>
                  <?php endif; ?>
                </div> <!-- end formation -->
              </div> <!-- end s-list-content -->
            </div> <!-- end s-list -->
          </div> <!-- end formation-container -->
          <?php endforeach; ?>
          <?php endif; ?>



          <!-- Mestrado -->
          <?php if(isset($profile["formacao_academica_titulacao_mestrado"])): ?>

          <?php foreach ($profile["formacao_academica_titulacao_mestrado"] as $key => $mestrado): ?>

          <div class="formation-container">
            <div class="s-list">
              <div class="s-list-bullet">
                <img class="s-list-ico" src="../inc/images/icons/academic.svg" />
              </div>

              <div class="s-list-content">
                <div class="formation">
                  <p class="ty-item">Mestrado em <?php echo $mestrado["nomeCurso"] ?>
                    <span class="ty c-date-range"><?php echo $mestrado["anoDeInicio"] ?> -
                      <?php echo $mestrado["anoDeConclusao"] ?></span>
                  </p>
                  <p class="ty"><?php echo $mestrado["nomeInstituicao"] ?></p>
                  <div class="u-mb-1"></div>

                  <p class="ty">
                    <b class="ty-subItem">Título:</b>
                    <?php echo $mestrado["tituloDaDissertacaoTese"] ?>
                  </p>
                  <p class="ty">
                    <b class="ty-subItem">Orientador(a): </b>
                    <?php echo $mestrado["nomeDoOrientador"] ?>
                  </p>

                  <?php if(!empty($mestrado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Grande área: </b>
                    <?php echo $mestrado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"] ?>
                  </p>
                  <?php endif; ?>

                  <?php if(!empty($mestrado["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Área do conhecimento:</b>
                    <?php echo $mestrado["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"] ?>
                  </p>
                  <?php endif; ?>

                  <?php if(!empty($mestrado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Sub área:</b>
                    <?php echo $mestrado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"] ?>
                  </p>
                  <?php endif; ?>
                  <?php if(!empty($mestrado["area_do_conhecimento"][0]["nomeDaEspecialidade"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Especialidade:</b>
                    <?php echo $mestrado["area_do_conhecimento"][0]["nomeDaEspecialidade"] ?>
                  </p>
                  <?php endif; ?>

                </div> <!-- end formation -->
              </div> <!-- end s-list-content -->
            </div> <!-- end s-list -->
          </div> <!-- end formation-container -->
          <?php endforeach; ?>
          <?php endif; ?>



          <!-- Graduação -->
          <?php if(isset($profile["formacao_academica_titulacao_graduacao"])): ?>

          <?php foreach ($profile["formacao_academica_titulacao_graduacao"] as $key => $graduacao): ?>

          <div class="formation-container">
            <div class="s-list">
              <div class="s-list-bullet">
                <img class="s-list-ico" src="../inc/images/icons/academic.svg" />
              </div>

              <div class="s-list-content">
                <div class="formation">
                  <p class="ty-item">Graduação em <?php echo $graduacao["nomeCurso"] ?>
                    <span class="ty c-date-range"><?php echo $graduacao["anoDeInicio"] ?> -
                      <?php echo $graduacao["anoDeConclusao"] ?></span>
                  </p>
                  <p class="ty"><?php echo $graduacao["nomeInstituicao"] ?></p>
                  <div class="u-mb-1"></div>
                  <?php if(!empty($graduacao["tituloDoTrabalhoDeConclusaoDeCurso"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Título:</b>
                    <?php echo $graduacao["tituloDoTrabalhoDeConclusaoDeCurso"] ?>
                  </p>
                  <?php endif; ?>
                  <?php if(!empty($graduacao["nomeDoOrientador"])): ?>
                  <p class="ty">
                    <b class="ty-subItem">Orientador(a): </b>
                    <?php echo $graduacao["nomeDoOrientador"] ?>
                  </p>
                  <?php endif; ?>
                </div> <!-- end formation -->
              </div> <!-- end s-list-content -->
            </div> <!-- end s-list -->
          </div> <!-- end formation-container -->
          <?php endforeach; ?>
          <?php endif; ?>

        </div> <!-- end tab-one -->


        <div id="tab-two" class="cc-tab-content" v-if="tabOpened == '2'">
          <div class="profile-pi">

            <h2 class="ty ty-title">Produção Intelecual</h2>

            <?php 
            foreach ($cursor_works['hits']['hits'] as $key => $work) {
              $works[$work['_source']['datePublished']][] = $work;
            }

            for ($i = 2040; $i >= 1900; $i -= 1) {
              if (!empty($works[$i])) {


                echo '<hr class="c-line"></hr>
                <h3 class="ty-subtitle c-pi-year">'.$i.'</h3>
                <hr class="c-line"></hr> ';

                foreach ($works[$i] as $key => $work) {

                  foreach ($work["_source"]["author"] as $author) {
                    $authors[] = $author["person"]["name"];
                  }
                  
                  echo '<div class="c-pi">
            
                    <div class="s-list">
                      <div class="s-list-bullet">        
                          <img class="s-list-ico" src="../inc/images/icons/article-published.svg" />            
                      </div>            

                      <div class="s-list-content">
                        <span class="c-typetag">'.$work['_source']['tipo'].'</span> 

                        <h5 class="ty-item">'.$work['_source']['name'].'</h5>
                        
                        <span class="u-sr-only">Autores</span>
                        <p class="ty-gray">' . implode('; ', $authors) . '</p>
                                    
                        <div class="s-line">
                          
                          <!--
                          <div class="s-line-item"> 
                            <img class="s-line-icon"
                              src="../inc/images/icons/citation.svg" 
                              alt="representação de citação" 
                            />
                            
                            <span class="c-pi-citations">Web Of Science: </span>
                            
                            <span class="c-pi-citations">Scopus </span>
                            
                          </div>
                          -->
                          ';
                          if (!empty($work['_source']['url'])) {
                            echo '              
                            <div class="s-line-item"> 
                              <img 
                                class="s-line-icon"
                                src="../inc/images/icons/link.svg" 
                                alt="representação de um link"
                              />
                              
                              <a href="'.$work['_source']['url'].'" target="blank">Conteúdo completo</a>
                            </div>
                          ';
                        }
                        
                        if (!empty($work['_source']['doi'])) {
                          echo '
                          <div class="s-line-item">

                            <img 
                            class="s-line-icon"
                            src="../inc/images/logos/doi.svg" 
                            alt="logo DOI"
                            />
                            
                            <a href="https://doi.org/'.$work['_source']['doi'].'"> DOI</a>
                          </div>';
                        };
                          
                          echo '
                          
                        </div>
                        <p class="ty-right ty-themeLight">Fonte: '; 
                        echo  (!empty($work['_source']['isPartOf']['name'])) ? $work['_source']['isPartOf']['name'] : '';
                        echo (!empty($work['_source']['isPartOf']['volume'])) ? ', v.'.$work['_source']['isPartOf']['volume'] : '';
                        echo (!empty($work['_source']['isPartOf']['fasciculo'])) ? ', n.'.$work['_source']['isPartOf']['fasciculo'] : '';
                        echo (!empty($work['_source']['pageStart'])) ? ', p.'.$work['_source']['pageStart'] : '';
                        echo '
                        </p>
                            
                        <hr class="c-line"/>
                      </div>

                    </div>
                      
                  </div>';
                  //echo "<pre>".print_r($work, true)."</pre>";

                }
                unset($authors);
              }
            }
            ?>

          </div> <!-- end profile-pi -->
        </div> <!-- end tab-two -->


        <div id="tab-three" class="cc-tab-content" v-if="tabOpened == '3'">
          <h3 class="ty ty-title u-mb-2">Projetos de Pesquisa</h3>

          <hr class="c-line u-mb-2">

          <div class="s-list">
            <div class="s-list-bullet">
              <img class='c-iconlang' src='../inc/images/icons/research.svg' />
            </div>

            <div class="s-list-content">

              <p class="ty ty-item u-mb-1">Projeto de Pesquisa X <span class="ty c-date-range"> 2019 - 2022</span>
              </p>
              <p class="ty u-mb-1">
                <b class="ty-subItem">Sobre o projeto:</b>
                A infertilidade masculina é multifatorial. Diversos estudos de nossos e outros grupos
                demonstraram que a varicocele, por exemplo, diminui a qualidade seminal, a qualidade funcional dos
                espermatozoides e altera o perfil proteômico do plasma seminal. Comisso, torna-se fundamental
                compreender quais são os mecanismos intrínsecos da transferência proteica presentes no sêmen. Os
                espermatozoides são expostos a microvesículas e exossomos durante o trânsito epididimário e após a
                ejaculação. Essas microvesículas apresentamcomposição proteica própria o que pode ser fundamental para o
                transporte e transferência proteica.
              </p>

              <p class="ty u-mb-1">
                <b class="ty-subItem">Integrantes:</b>
                <span class="ty-gray">
                  Ricardo Pimenta Bertolla - Coordenador / Mariana Camargo - Integrante / Paula Intasqui Lopes -
                  Integrante / ANTONIASSI, M. P. - Integrante / Larissa Berloffa Belardin
                </span>
              </p>


            </div> <!-- end-grid-right -->

          </div><!-- end-grid -->

        </div> <!-- end tab-three -->


        <div id="tab-four" class="cc-tab-content" v-if="tabOpened == '4'">

          <h3 class="ty ty-title u-mb-2">Orientações e supervisões</h3>

          <?php if(!empty($profile['orientacoes'] )): ?>

          <hr class="c-line" />
          <?php 
                $orientacoes_andamento_labels = ['Supervisão de pós-doutorado', 'Tese de doutorado', 'Dissertação de mestrado'];
                foreach ($orientacoes_andamento_labels as $orientacao_andamento_label) {
                  $i_orientacao_andamento = 0;
                  foreach ($profile['orientacoes'] as $orientacao_andamento) {                    
                    if ($orientacao_andamento['natureza'] == $orientacao_andamento_label) {
                      $orientacao_andamento_array[$orientacao_andamento_label][$i_orientacao_andamento] = $orientacao_andamento;
                    }
                    $i_orientacao_andamento++;
                  }
                  if(count($orientacao_andamento_array[$orientacao_andamento_label]) > 0) {
                    echo '<h4 class="ty ty-title u-mb-2">'.$orientacao_andamento_label.' em andamento</h4><ul class="s-nobullet">';
                    foreach ($orientacao_andamento_array[$orientacao_andamento_label] as $orientacao_andamento_echo) {
                      //var_dump($orientacao_andamento_echo);
                      echo '
                      <li>
                      <hr class="c-line u-mb-2"></hr>
                      <div class="s-list">
                        <div class="s-list-bullet">
                          <img class="c-iconlang" src="../inc/images/icons/orientation.svg" />
                        </div>
    
                        <div class="s-list-content">
    
                          <p class="ty ty-item">
                            <a class="ty-itemLink" href="http://lattes.cnpq.br/'.$orientacao_andamento_echo["numeroIDOrientado"].'" target="_blank">
                            '.$orientacao_andamento_echo["nomeDoOrientando"].'
                            </a>
                            <span class="ty c-date-range">'.$orientacao_andamento_echo["ano"].' - Em andamento</span>
                          </p>
    
                          <p class="ty ty-gray">';
                          (!empty($orientacao_andamento_echo["titulo"])) ? print_r(''.$orientacao_andamento_echo["titulo"]) : "";
                          echo'
                          </p>
    
                          <p class="ty u-mb-1">'.$orientacao_andamento_echo["nomeDaInstituicao"].'';
                          (!empty($orientacao_andamento_echo["nomeDoCurso"])) ? print_r(' — <b class="ty-subItem">Curso:</b> '.$orientacao_andamento_echo["nomeDoCurso"]) : "";
                          
                          ($orientacao_andamento_echo["flagBolsa"] == "SIM") ? print_r('<br/><b class="ty-subItem">Bolsa:</b> '.$orientacao_andamento_echo["nomeDaAgencia"].'') : "";
                          echo '</p>

    
                        </div> <!-- end-grid-right -->
    
                      </div><!-- end-grid -->
    
                    </li>
                      
                      ';
                    }
                    echo '</ul>';
                  }
                  unset($orientacao_andamento_array);
                }    
            ?>

          <?php endif; ?>

          <?php if(!empty($profile['orientacoesconcluidas'] )): ?>


          <hr class="c-line" />
          <?php 
              $orientacoes_concluidas_labels = ['Supervisão de pós-doutorado', 'Tese de doutorado', 'Dissertação de mestrado'];
              foreach ($orientacoes_concluidas_labels as $orientacao_concluidas_label) {
                $i_orientacao_concluidas = 0;
                foreach ($profile['orientacoesconcluidas'] as $orientacao_concluidas) {                    
                  if ($orientacao_concluidas['natureza'] == $orientacao_concluidas_label) {
                    $orientacao_concluidas_array[$orientacao_concluidas_label][$i_orientacao_concluidas] = $orientacao_concluidas;
                  }
                  $i_orientacao_concluidas++;
                }
                if(isset($orientacao_concluidas_array)) {
                if(count($orientacao_concluidas_array[$orientacao_concluidas_label]) > 0) {
                  echo '<h4 class="ty ty-title u-mb-2">'.$orientacao_concluidas_label.' concluídas</h4><ul class="s-nobullet">';
                  foreach ($orientacao_concluidas_array[$orientacao_concluidas_label] as $orientacao_concluidas_echo) {
                    //var_dump($orientacao_concluidas_echo);
                    echo '
                    <li>
                    <hr class="c-line u-mb-2"></hr>
                    <div class="s-list">
                      <div class="s-list-bullet">
                        <img class="c-iconlang" src="../inc/images/icons/orientation.svg" />
                      </div>
  
                      <div class="s-list-content">
  
                        <p class="ty ty-item">
                          <a class="ty-itemLink" href="http://lattes.cnpq.br/'.$orientacao_concluidas_echo["numeroIDOrientado"].'" target="_blank">
                          '.$orientacao_concluidas_echo["nomeDoOrientando"].'
                          </a>
                          <span class="ty c-date-range">'.$orientacao_concluidas_echo["ano"].'</span>
                        </p>
  
                        <p class="ty ty-gray">';
                        (!empty($orientacao_concluidas_echo["titulo"])) ? print_r(''.$orientacao_concluidas_echo["titulo"]) : "";
                        echo'
                        </p>
  
                        <p class="ty u-mb-1">'.$orientacao_concluidas_echo["nomeDaInstituicao"].'';
                        (!empty($orientacao_concluidas_echo["nomeDoCurso"])) ? print_r(' — <b class="ty-subItem">Curso:</b> '.$orientacao_concluidas_echo["nomeDoCurso"]) : "";
                        
                        ($orientacao_concluidas_echo["flagBolsa"] == "SIM") ? print_r('<br/><b class="ty-subItem">Bolsa:</b> '.$orientacao_concluidas_echo["nomeDaAgencia"].'') : "";
                        echo '</p>

  
                      </div> <!-- end-grid-right -->
  
                    </div><!-- end-grid -->
  
                  </li>
                    
                    ';
                  }
                  echo '</ul>';
                }
                unset($orientacao_concluidas_array);
              }
              }    
          ?>

          <?php endif; ?>

        </div> <!-- end tab-four -->




      </div> <!-- end #tabs -->

    </div> <!-- end profile-wrapper -->
  </main>


  <?php include('inc/footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

  <script>
  var app = new Vue({
    el: '#tabs',
    data: {
      tabOpened: '4',
      isActive: false

    },
    methods: {
      changeTab(tab) {
        this.tabOpened = tab
        var tabs = document.getElementsByClassName("cc-tab-btn")

        for (i = 0; i < tabs.length; i++)
          tabs[i].className = tabs[i].className.replace("tab-active", "")

        tabs[Number(tab) - 1].className += " cc-tab-active"
      }
    }
  })
  </script>

</body>

</html>