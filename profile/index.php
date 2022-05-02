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



      <div class="core">
        <div class="cc-coregrid-one">

          <div class="co-photo-wrapper">
            <img class="co-bestBagde" src="../inc/images/badges/bolsista-cnpq-1a.svg" />
            <div class="co-photo-container">
              <img class="co-photo"
                src="http://servicosweb.cnpq.br/wspessoa/servletrecuperafoto?tipo=1&amp;bcv=true&amp;id=<?php echo $lattesID10; ?>" />
            </div>
          </div> <!-- end co-photo-wrapper -->


          <div class="co-badgeIcons">
            <img class="co-badgeIcons-icon" src="../inc/images/badges/bolsista-cnpq-1a.svg" alt="Bolsista CNPQ nível 1A"
              title="Bolsista CNPQ nível 1A" />

            <img class="co-badgeIcons-icon" src="../inc/images/badges/member.svg" alt="Membro de conselho ou comissão"
              title="Membro de conselho ou comissão" />

            <img class="co-badgeIcons-icon" src="../inc/images/badges/leader.svg" alt="Exercedor de cargo de chefia"
              title="Exercedor de cargo de chefia" />
          </div> <!-- end co-badgeIcons -->

        </div> <!-- end core-one -->

        <div class="cc-coregrid-two">
          <h1 class="ty-name">
            <?php echo $profile["nome_completo"] ?>

            <?php if($profile["nacionalidade"]=="B") : ?>
            <img class="country-flag" src="../inc/images/country_flags/br.svg" alt="nacionalidade brasileira"
              title="nacionalidade brasileira" />
            <?php endif; ?>
          </h1>

          <!-- <div class="u-spacer-2  "></div> -->
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
          <div class="u-spacer-1"></div>


          <h3 class="ty ty-title">Perfis na web</h3>
          <div class="co-socialIcons">

            <?php if(!empty($profile['lattesID'])) : ?>

            <a href="https://lattes.cnpq.br/<?php echo $profile['lattesID']; ?>" target="_blank" rel="external"><img
                class="co-socialIcons-icon" src="../inc/images/academic_plataforms/logo_lattes.svg" alt="Lattes"
                title="Lattes" /></a>
            <?php endif; ?>
            <?php if(!empty($profile['orcid_id'])) : ?>
            <a href="<?php echo $profile['orcid_id']; ?>" target="_blank" rel="external"><img
                class="co-socialIcons-icon" src="../inc/images/academic_plataforms/logo_research_id.svg" alt="ORCID"
                title="ORCID" /></a>
            <?php endif; ?>

          </div> <!-- end co-socialIcons -->

        </div> <!-- end core-two -->

        <div class="cc-coregrid-three">

          <div class="co-numbers">
            <span class="co-numbers-number">
              <img class="co-numbers-icon" src="../inc/images/icons/article-published.svg" alt="Artigos publicados" />
              45
            </span>

            <span class="co-numbers-number">
              <img class="co-numbers-icon" src="../inc/images/icons/article-aproved.svg" alt="Artigos aprovados" />
              35
            </span>

            <span class="co-numbers-number">
              <img class="co-numbers-icon" src="../inc/images/icons/orientation.svg" alt="Orientações" />
              12
            </span>

            <span class="co-numbers-number">
              <img class="co-numbers-icon" src="../inc/images/icons/research.svg" alt="Pesquisas" />
              15
            </span>

            <span class="co-numbers-number">
              <img class="co-numbers-icon" src="../inc/images/icons/event.svg" alt="Eventos participados" />
              41
            </span>

          </div> <!-- end profile-numbers -->


          <a class="u-skip" href=”#skipgraph”>Pular gráfico</a>

          <div class="graph">

            <div class="graph-line">
              <span class="graph-label">Artigos publicados</span>
              <?php 
                foreach ($artigos_publicados as $i => $j) {
                  echo 
                  "<div 
                    class='graph-unit' 
                    data-weight='{$j['total']}'
                    title='{$j['year']} — total: {$j['total']}'
                  ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="graph-line">
              <span class="graph-label">Livros e capítulos</span>
              <?php 
                foreach ($livros_e_capitulos as $i => $j) {
                  echo 
                    "<div 
                      class='graph-unit' 
                      data-weight='{$j['total']}'
                      title='{$j['year']} — total: {$j['total']}'
                    ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="graph-line graph-division">
              <span class="graph-label">Orientações de mestrado</span>
              <?php 
                foreach ($orientacoes_mestrado as $i => $j) {
                  echo 
                    "<div 
                      class='graph-unit' 
                      data-weight='{$j['total']}'
                      title='{$j['year']} — total: {$j['total']}'
                    ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="graph-line">
              <span class="graph-label">Orientações de doutorado</span>
              <?php 
                foreach ($orientacoes_doutorado as $i => $j) {
                  echo 
                    "<div 
                      class='graph-unit' 
                      data-weight='{$j['total']}'
                      title='{$j['year']} — total: {$j['total']}'
                    ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="graph-line">
              <span class="graph-label">Ensino</span>
              <?php 
                foreach ($ensino as $i => $j) {
                  echo 
                    "<div 
                      class='graph-unit' 
                      data-weight='{$j['total']}'
                      title='{$j['year']} — total: {$j['total']}'
                    ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="graph-line graph-division">
              <span class="graph-label">Softwares e patentes</span>
              <?php 
                foreach ($softwares_patentes as $i => $j) {
                  echo 
                    "<div 
                      class='graph-unit' 
                      data-weight='{$j['total']}'
                      title='{$j['year']} — total: {$j['total']}'
                    ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="graph-line">
              <span class="graph-label">Participações em eventos</span>
              <?php 
                foreach ($participacoes_eventos as $i => $j) {
                echo 
                  "<div 
                    class='graph-unit' 
                    data-weight='{$j['total']}'
                    title='{$j['year']} — total: {$j['total']}'
                  ></div>";
                }
                unset($i);
                unset($j);
              ?>
            </div>

            <div class="graph-line">
              <div class="graph-icon"></div>
              <div class="graph-label">2021 ————— 2015</div>
            </div>

          </div> <!-- end graph -->


          <div class="graph-info">
            <span class="graph-info-label">+</span>
            <div class="graph-unit" data-weight="4"></div>
            <div class="graph-unit" data-weight="3"></div>
            <div class="graph-unit" data-weight="2"></div>
            <div class="graph-unit" data-weight="1"></div>
            <div class="graph-unit" data-weight="0"></div>
            <span class="graph-info-label">-</span>
          </div>


        </div> <!-- end core-three -->


      </div> <!-- end core -->


      <span class="u-skip" id="skipgraph”" class="ty ty-lastUpdate">Atualizado em
        <?php echo $profile['data_atualizacao']; ?></span>



      <div id="tabs" class="profile-tabs">


        <div class="tab-bar">
          <button id="tab-btn-1" class="tab-btn" v-on:click="changeTab('1')">Sobre Mim</button>
          <button id="tab-btn-2" class="tab-btn" v-on:click="changeTab('2')">Produção Intelectual</button>
          <button id="tab-btn-3" class="tab-btn" v-on:click="changeTab('3')">Pesquisa</button>
          <button id="tab-btn-4" class="tab-btn" v-on:click="changeTab('4')">Orientações</button>
        </div>



        <div id="tab-one" class="tab-content" v-if="tabOpened == '1'">


          <div class="p-description">
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

          <div class="p-tags">
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
          </div> <!-- end p-tags -->

          <hr class="c-line u-margin-b-2" />


          <?php if(isset($profile["idiomas"])): ?>
          <div class=" p-language">
            <h3 class="ty ty-title">Idiomas</h3>
            <?php foreach ($profile["idiomas"] as $key => $idioma): ?>

            <div class="u-grid">

              <div class="u-grid-left">
                <?php 
                  switch ($idioma["descricaoDoIdioma"]) {
                    case "Inglês":
                      echo "<img class='pi-iconlang' src='../inc/images/icons/languages/en.svg' />";
                      break;
                    case "Espanhol":
                      echo "<img class='pi-iconlang' src='../inc/images/icons/languages/es.svg' />";
                      break;
                    case "Português":
                      echo "<img class='pi-iconlang' src='../inc/images/icons/languages/pt.svg' />";
                      break;
                    case "Italiano":
                      echo "<img class='pi-iconlang' src='../inc/images/icons/languages/pt.svg' />";
                      break;
                    case "Francês":
                      echo "<img class='pi-iconlang' src='../inc/images/icons/languages/pt.svg' />";
                      break;
                    case "Alemão":
                      echo "<img class='pi-iconlang' src='../inc/images/icons/languages/pt.svg' />";
                      break;
                    case "Russo":
                      echo "<img class='pi-iconlang' src='../inc/images/icons/languages/pt.svg' />";
                      break;
                    case "Mandarin":
                      echo "<img class='pi-iconlang' src='../inc/images/icons/languages/pt.svg' />";
                      break;
                    default:
                      echo "<img class='pi-iconlang' src='../inc/images/icons/languages/idioma.svg' />";
                      break;

                  }
                ?>
              </div>

              <div class="u-grid-right">
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
            </div> <!-- end u-grid -->
            <?php endforeach; ?>
          </div> <!-- end p-language -->
          <?php endif; ?>

          <hr class="c-line u-margin-b-2" />

          <h3 class="ty ty-title">Formação</h3>

          <!-- Livre Docência -->
          <?php if(isset($profile["formacao_academica_titulacao_livreDocencia"])): ?>

          <?php foreach ($profile["formacao_academica_titulacao_livreDocencia"] as $key => $livreDocencia): ?>

          <div class="formation-container">
            <div class="u-grid">
              <div class="u-grid-left">
                <img class="pi-icon" src="../inc/images/icons/academic.svg" />
              </div>

              <div class="u-grid-right">
                <div class="formation">
                  <p class="ty-item">Livre Docência
                    <span class="ty u-date-range"><?php echo $livreDocencia["anoDeObtencaoDoTitulo"] ?></span>
                  </p>
                  <p class="ty"><?php echo $livreDocencia["nomeInstituicao"] ?></p>
                  <div class="u-spacer-1"></div>
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
              </div> <!-- end u-grid-right -->
            </div> <!-- end u-grid -->
          </div> <!-- end formation-container -->
          <?php endforeach; ?>
          <?php endif; ?>



          <!-- Doutorado -->
          <?php if(isset($profile["formacao_academica_titulacao_doutorado"])): ?>

          <?php foreach ($profile["formacao_academica_titulacao_doutorado"] as $key => $doutorado): ?>

          <div class="formation-container">
            <div class="u-grid">
              <div class="u-grid-left">
                <img class="pi-icon" src="../inc/images/icons/academic.svg" />
              </div>
              <div class="u-grid-right">
                <div class="formation">
                  <p class="ty-item">Doutorado em <?php echo $doutorado["nomeCurso"] ?>
                    <span class="ty u-date-range"><?php echo $doutorado["anoDeInicio"] ?> -
                      <?php echo $doutorado["anoDeConclusao"] ?></span>
                  </p>
                  <p class="ty"><?php echo $doutorado["nomeInstituicao"] ?></p>
                  <div class="u-spacer-1"></div>

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
              </div> <!-- end u-grid-right -->
            </div> <!-- end u-grid -->
          </div> <!-- end formation-container -->
          <?php endforeach; ?>
          <?php endif; ?>



          <!-- Mestrado -->
          <?php if(isset($profile["formacao_academica_titulacao_mestrado"])): ?>

          <?php foreach ($profile["formacao_academica_titulacao_mestrado"] as $key => $mestrado): ?>

          <div class="formation-container">
            <div class="u-grid">
              <div class="u-grid-left">
                <img class="pi-icon" src="../inc/images/icons/academic.svg" />
              </div>

              <div class="u-grid-right">
                <div class="formation">
                  <p class="ty-item">Mestrado em <?php echo $mestrado["nomeCurso"] ?>
                    <span class="ty u-date-range"><?php echo $mestrado["anoDeInicio"] ?> -
                      <?php echo $mestrado["anoDeConclusao"] ?></span>
                  </p>
                  <p class="ty"><?php echo $mestrado["nomeInstituicao"] ?></p>
                  <div class="u-spacer-1"></div>

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
              </div> <!-- end u-grid-right -->
            </div> <!-- end u-grid -->
          </div> <!-- end formation-container -->
          <?php endforeach; ?>
          <?php endif; ?>



          <!-- Graduação -->
          <?php if(isset($profile["formacao_academica_titulacao_graduacao"])): ?>

          <?php foreach ($profile["formacao_academica_titulacao_graduacao"] as $key => $graduacao): ?>

          <div class="formation-container">
            <div class="u-grid">
              <div class="u-grid-left">
                <img class="pi-icon" src="../inc/images/icons/academic.svg" />
              </div>

              <div class="u-grid-right">
                <div class="formation">
                  <p class="ty-item">Graduação em <?php echo $graduacao["nomeCurso"] ?>
                    <span class="ty u-date-range"><?php echo $graduacao["anoDeInicio"] ?> -
                      <?php echo $graduacao["anoDeConclusao"] ?></span>
                  </p>
                  <p class="ty"><?php echo $graduacao["nomeInstituicao"] ?></p>
                  <div class="u-spacer-1"></div>
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
              </div> <!-- end u-grid-right -->
            </div> <!-- end u-grid -->
          </div> <!-- end formation-container -->
          <?php endforeach; ?>
          <?php endif; ?>

        </div> <!-- end tab-one -->


        <div id="tab-two" class="tab-content" v-if="tabOpened == '2'">
          <div class="profile-pi">

            <h2 class="ty ty-title">Produção Intelecual</h2>

            <?php 
            foreach ($cursor_works['hits']['hits'] as $key => $work) {
              $works[$work['_source']['datePublished']][] = $work;
            }

            for ($i = 2040; $i >= 1900; $i -= 1) {
              if (!empty($works[$i])) {


                echo '<hr class="c-line"></hr>
                <h3 class="ty-subtitle pi-year">'.$i.'</h3>
                <hr class="c-line"></hr> ';

                foreach ($works[$i] as $key => $work) {

                  foreach ($work["_source"]["author"] as $author) {
                    $authors[] = $author["person"]["name"];
                  }
                  
                  echo '<div class="pi">
                  
                    <div class="u-grid">

                      <div class="u-grid-left">        
                        
                          <img class="pi-icon" src="../inc/images/icons/article-published.svg" />            

                      </div>            

                      <div class="u-grid-right">

                        <div class="pi-separator">
                          <span class="pi-type">'.$work['_source']['tipo'].'</span> 
                          <hr class="pi-separator-ln"></hr>
                        </div>
                        <h5 class="ty-item">'.$work['_source']['name'].'</h5>
                        
                        <span class="u-sr-only">Autores</span>
                        <p class="ty-gray">' . implode('; ', $authors) . '</p>
                                    
                        <div class="pi-moreinfo">
                          
                          <!--
                          <div class="pi-moreinfo-item"> 
                            <img class="pi-moreinfo-icon"
                              src="../inc/images/icons/citation.svg" 
                              alt="representação de citação" 
                            />
                            
                            <span class="pi-citations">Web Of Science: 12</span>
                            
                            <span class="pi-citations">Scopus 8</span>
                            
                          </div>
                          -->
                          ';
                          if (!empty($work['_source']['url'])) {
                            echo '              
                            <div class="pi-moreinfo-item"> 
                              <img 
                                class="pi-moreinfo-icon"
                                src="../inc/images/icons/link.svg" 
                                alt="representação de um link"
                              />
                              
                              <a href="'.$work['_source']['url'].'" target="blank">Conteúdo completo</a>
                            </div>
                          ';
                        }
                        
                        if (!empty($work['_source']['doi'])) {
                          echo '
                          <div class="pi-moreinfo-item">

                            <img 
                            class="pi-moreinfo-icon"
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


        <div id="tab-three" class="tab-content" v-if="tabOpened == '3'">
          <h3 class="ty ty-title u-spacer-2">Projetos de Pesquisa</h3>

          <hr class="c-line u-spacer-2">

          <div class="u-grid">
            <div class="u-grid-left">
              <img class='pi-iconlang' src='../inc/images/icons/research.svg' />
            </div>

            <div class="u-grid-right">

              <p class="ty ty-item u-spacer-1">Projeto de Pesquisa X <span class="ty u-date-range"> 2019 - 2022</span>
              </p>
              <p class="ty u-spacer-1">
                <b class="ty-subItem">Sobre o projeto:</b>
                A infertilidade masculina é multifatorial. Diversos estudos de nossos e outros grupos
                demonstraram que a varicocele, por exemplo, diminui a qualidade seminal, a qualidade funcional dos
                espermatozoides e altera o perfil proteômico do plasma seminal. Comisso, torna-se fundamental
                compreender quais são os mecanismos intrínsecos da transferência proteica presentes no sêmen. Os
                espermatozoides são expostos a microvesículas e exossomos durante o trânsito epididimário e após a
                ejaculação. Essas microvesículas apresentamcomposição proteica própria o que pode ser fundamental para o
                transporte e transferência proteica.
              </p>

              <p class="ty u-spacer-1">
                <b class="ty-subItem">Integrantes:</b>
                <span class="ty-gray">
                  Ricardo Pimenta Bertolla - Coordenador / Mariana Camargo - Integrante / Paula Intasqui Lopes -
                  Integrante / ANTONIASSI, M. P. - Integrante / Larissa Berloffa Belardin
                </span>
              </p>


            </div> <!-- end-grid-right -->

          </div><!-- end-grid -->

        </div> <!-- end tab-three -->


        <div id="tab-four" class="tab-content" v-if="tabOpened == '4'">

          <h3 class="ty ty-title u-spacer-2">Orientações e supervisões</h3>

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
                    echo '<h4 class="ty ty-title u-spacer-2">'.$orientacao_andamento_label.' em andamento</h4><ul class="orientation">';
                    foreach ($orientacao_andamento_array[$orientacao_andamento_label] as $orientacao_andamento_echo) {
                      //var_dump($orientacao_andamento_echo);
                      echo '
                      <li>
                      <hr class="pi-separator-ln u-spacer-2"></hr>
                      <div class="u-grid">
                        <div class="u-grid-left">
                          <img class="pi-iconlang" src="../inc/images/icons/orientation.svg" />
                        </div>
    
                        <div class="u-grid-right">
    
                          <p class="ty ty-item">
                            <a class="ty-itemLink" href="http://lattes.cnpq.br/'.$orientacao_andamento_echo["numeroIDOrientado"].'" target="_blank">
                            '.$orientacao_andamento_echo["nomeDoOrientando"].'
                            </a>
                            <span class="ty u-date-range">'.$orientacao_andamento_echo["ano"].' - Em andamento</span>
                          </p>
    
                          <p class="ty ty-gray">';
                          (!empty($orientacao_andamento_echo["titulo"])) ? print_r(''.$orientacao_andamento_echo["titulo"]) : "";
                          echo'
                          </p>
    
                          <p class="ty u-spacer-1">'.$orientacao_andamento_echo["nomeDaInstituicao"].'';
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
                  echo '<h4 class="ty ty-title u-spacer-2">'.$orientacao_concluidas_label.' concluídas</h4><ul class="orientation">';
                  foreach ($orientacao_concluidas_array[$orientacao_concluidas_label] as $orientacao_concluidas_echo) {
                    //var_dump($orientacao_concluidas_echo);
                    echo '
                    <li>
                    <hr class="pi-separator-ln u-spacer-2"></hr>
                    <div class="u-grid">
                      <div class="u-grid-left">
                        <img class="pi-iconlang" src="../inc/images/icons/orientation.svg" />
                      </div>
  
                      <div class="u-grid-right">
  
                        <p class="ty ty-item">
                          <a class="ty-itemLink" href="http://lattes.cnpq.br/'.$orientacao_concluidas_echo["numeroIDOrientado"].'" target="_blank">
                          '.$orientacao_concluidas_echo["nomeDoOrientando"].'
                          </a>
                          <span class="ty u-date-range">'.$orientacao_concluidas_echo["ano"].'</span>
                        </p>
  
                        <p class="ty ty-gray">';
                        (!empty($orientacao_concluidas_echo["titulo"])) ? print_r(''.$orientacao_concluidas_echo["titulo"]) : "";
                        echo'
                        </p>
  
                        <p class="ty u-spacer-1">'.$orientacao_concluidas_echo["nomeDaInstituicao"].'';
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

          <!--

          <hr class="c-line" />
          <h4 class="ty ty-title u-spacer-2">Supervisões de pós-doutorado em andamento</h4>


          <div class="u-grid">
            <div class="u-grid-left">
              <img class='pi-iconlang' src='../inc/images/icons/orientation.svg' />
            </div>

            <div class="u-grid-right">

              <p class="ty ty-item">
                <a href="http://lattes.cnpq.br/4527664839744803" target="blank">
                  Mika Alexia Miyazaki.
                </a>
                <span class="ty u-date-range">2019</span>
              </p>

              <p class="ty ty-gray">
                INFLUÊNCIA DA FRAGMENTAÇÃO DE DNA ESPERMÁTICO NO INÍCIO DO DESENVOLVIMENTO EMBRIONÁRIO INICIAL.
              </p>

              <p class="ty u-spacer-1">
                Universidade Federal de São Paulo —
                <b class="ty-subItem">Curso:</b>
                Medicina (Urologia)
              </p>

            </div> 

          </div>

          <div class="u-spacer-2"></div>


          <hr class="c-line" />
          <h4 class="ty ty-title u-spacer-2">Dissertações de mestrado concluídas</h4>

          <ul class="orientation">
            <li>
              <div class="u-grid">
                <div class="u-grid-left">
                  <img class='pi-iconlang' src='../inc/images/icons/orientation.svg' />
                </div>

                <div class="u-grid-right">

                  <p class="ty ty-item">
                    <a class="ty-itemLink" href="http://lattes.cnpq.br/4527664839744803" target="blank">
                      Mika Alexia Miyazaki
                    </a>
                    <span class="ty u-date-range">2019</span>
                  </p>

                  <p class="ty ty-gray">
                    INFLUÊNCIA DA FRAGMENTAÇÃO DE DNA ESPERMÁTICO NO INÍCIO DO DESENVOLVIMENTO EMBRIONÁRIO INICIAL.
                  </p>

                  <p class="ty u-spacer-1">
                    Universidade Federal de São Paulo —
                    <b class="ty-subItem">Curso:</b>
                    Medicina (Urologia)
                  </p>

                </div> 

              </div>

            </li>
          </ul>



          <hr class="c-line" />
          <h4 class="ty ty-title u-spacer-2">Teses de doutorado concluídas</h4>


          <div class="u-grid">
            <div class="u-grid-left">
              <img class='pi-iconlang' src='../inc/images/icons/orientation.svg' />
            </div>

            <div class="u-grid-right">

              <p class="ty ty-item">
                <a href="http://lattes.cnpq.br/4527664839744803" target="blank">
                  Mika Alexia Miyazaki.
                </a>
                <span class="ty u-date-range">2019</span>
              </p>

              <p class="ty ty-gray">
                INFLUÊNCIA DA FRAGMENTAÇÃO DE DNA ESPERMÁTICO NO INÍCIO DO DESENVOLVIMENTO EMBRIONÁRIO INICIAL.
              </p>

              <p class="ty u-spacer-1">
                Universidade Federal de São Paulo —
                <b class="ty-subItem">Curso:</b>
                Medicina (Urologia)
              </p>

            </div> 

          </div>


          <hr class="c-line" />
          <h4 class="ty ty-title u-spacer-2">Iniciações científicas concluídas</h4>


          <div class="u-grid">
            <div class="u-grid-left">
              <img class='pi-iconlang' src='../inc/images/icons/orientation.svg' />
            </div>

            <div class="u-grid-right">

              <p class="ty ty-item">
                <a href="http://lattes.cnpq.br/4527664839744803" target="blank">
                  Mika Alexia Miyazaki.
                </a>
                <span class="ty u-date-range">2019</span>
              </p>

              <p class="ty ty-gray">
                INFLUÊNCIA DA FRAGMENTAÇÃO DE DNA ESPERMÁTICO NO INÍCIO DO DESENVOLVIMENTO EMBRIONÁRIO INICIAL.
              </p>

              <p class="ty u-spacer-1">
                Universidade Federal de São Paulo —
                <b class="ty-subItem">Curso:</b>
                Medicina (Urologia)
              </p>

            </div> 

          </div>



          <hr class="c-line" />
          <h4 class="ty ty-title u-spacer-2">Orientações de outra natureza concluídas</h4>


          <div class="u-grid">
            <div class="u-grid-left">
              <img class='pi-iconlang' src='../inc/images/icons/orientation.svg' />
            </div>

            <div class="u-grid-right">

              <p class="ty ty-item">
                <a href="http://lattes.cnpq.br/4527664839744803" target="blank">
                  Mika Alexia Miyazaki.
                </a>
                <span class="ty u-date-range">2019</span>
              </p>

              <p class="ty ty-gray">
                INFLUÊNCIA DA FRAGMENTAÇÃO DE DNA ESPERMÁTICO NO INÍCIO DO DESENVOLVIMENTO EMBRIONÁRIO INICIAL.
              </p>

              <p class="ty u-spacer-1">
                Universidade Federal de São Paulo —
                <b class="ty-subItem">Curso:</b>
                Medicina (Urologia)
              </p>

            </div> 

          </div> -->


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
        var tabs = document.getElementsByClassName("tab-btn")

        for (i = 0; i < tabs.length; i++)
          tabs[i].className = tabs[i].className.replace("tab-active", "")

        tabs[Number(tab) - 1].className += " tab-active"
      }
    }
  })
  </script>

</body>

</html>