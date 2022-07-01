<?php

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

  // Totals

  $totalOrientacoes = 0;
  if (isset($profile['orientacoes'])) {
    $totalOrientacoes = $totalOrientacoes + count($profile['orientacoes']);
  }
  if (isset($profile['orientacoesconcluidas'])) {
    $totalOrientacoes = $totalOrientacoes + count($profile['orientacoesconcluidas']);
  }
} else {
  echo '<script>window.location.href = "index.php";</script>';
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
  <link rel="stylesheet" href="sass/main.css" />
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>

<body class="profile-body">

  <!-- NAV -->
  <?php require 'inc/navbar.php'; ?>
  <!-- /NAV -->

  <main class="profile-container">
    <div class="profile-wrapper">
      <div class="profile-inner">
        <div id="top"></div>
        <div class="cc-coregrid">
          <div class="cc-coregrid-one">

            <div class="cc-display">
              <!-- <img class="cc-display-badge" src="inc/images/icons/badges/bolsista-cnpq-1a.svg" /> -->
              <img class="cc-display-pic" src="http://servicosweb.cnpq.br/wspessoa/servletrecuperafoto?tipo=1&amp;bcv=true&amp;id=<?php echo $lattesID10; ?>" />
            </div> <!-- end cc-photo-wrapper -->

          </div> <!-- end core-one -->

          <div class="cc-coregrid-two">
            <h1 class="ty-name">
              <?php echo $profile["nome_completo"] ?>

              <?php if ($profile["nacionalidade"] == "B") : ?>
                <img class="country-flag" src="inc/images/icons/country_flags/br.svg" alt="nacionalidade brasileira" title="nacionalidade brasileira" />
              <?php endif; ?>
            </h1>

            <!-- <div class="u-mb-2  "></div> -->
            <h2 class="ty ty-prof">Universidade Federal de São Paulo</h2>
            <?php if (!empty($profile["unidade"][0])) : ?>
              <p class="ty ty-prof"><?php echo $profile["unidade"][0] ?></p>
            <?php endif; ?>
            <?php if (!empty($profile["departamento"][0])) : ?>
              <p class="ty ty-prof"><?php echo $profile["departamento"][0] ?></p>
            <?php endif; ?>
            <?php if (!empty($profile["ppg_nome"][0])) : ?>
              <?php foreach ($profile["ppg_nome"] as $key => $ppg_nome) : ?>
                <p class="ty ty-prof">Programa de Pós-Graduação: <?php echo $ppg_nome ?></p>
              <?php endforeach; ?>
            <?php endif; ?>
            <!--
            <div class="cc-badgeicons">
              <img class="cc-badgeicons-icon" src="inc/images/icons/badges/bolsista-cnpq-1a.svg" alt="Bolsista CNPQ nível 1A" title="Bolsista CNPQ nível 1A" />
              <img class="cc-badgeicons-icon" src="inc/images/icons/badges/member.svg" alt="Membro de conselho ou comissão" title="Membro de conselho ou comissão" />
              <img class="cc-badgeicons-icon" src="inc/images/icons/badges/leader.svg" alt="Exercedor de cargo de chefia" title="Exercedor de cargo de chefia" />
            </div>
            --> <!-- end cc-badgeicons -->
            <!-- <p class="ty ty-email">bertola@unifesp.br</p> -->

            <hr class="c-line" />

            <div class="cc-numbers">
              <span class="cc-numbers-number">
                <img class="cc-numbers-icon" src="inc/images/icons/article-published.svg" alt="Trabalhos publicados" title="Trabalhos publicados" />
                <?php echo $totalWorks; ?>
              </span>

              <span class="cc-numbers-number">
                <img class="cc-numbers-icon" src="inc/images/icons/orientation.svg" alt="Orientações" title="Oirentações" />
                <?php echo $totalOrientacoes; ?>
              </span>

              <!--
              <span class="cc-numbers-number">
                <img class="cc-numbers-icon" src="inc/images/icons/research.svg" alt="Pesquisas" />
                15
              </span>

              <span class="cc-numbers-number">
                <img class="cc-numbers-icon" src="inc/images/icons/event.svg" alt="Eventos participados" />
                41
              </span>
              -->
            </div> <!-- end cc-numbers -->

          </div> <!-- end core-two -->
          <!--
          <div class="cc-coregrid-three">
            <a class="u-skip" href=”#skipcc-graph”>Pular gráfico</a>

            <div class="cc-graph">
              <div class="cc-graph-line">
                <div class="cc-graph-icon"></div>
                <div class="cc-graph-label">...2021</div>
              </div>

              <div class="cc-graph-line">
                <span class="cc-graph-label">Artigos publicados</span>
                < ?php
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
                < ?php
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
                < ?php
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
                < ?php
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
                < ?php
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
                < ?php
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
                < ?php
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

              <div class="cc-graph-line u-mt-1">
                <div class="cc-graph-icon"></div>
                <div class="cc-graph-unit" data-weight="0"></div>
                <div class="cc-graph-unit" data-weight="1"></div>
                <div class="cc-graph-unit" data-weight="2"></div>
                <div class="cc-graph-unit" data-weight="3"></div>
                <div class="cc-graph-unit" data-weight="4"></div>
              </div>


            </div> //<//!-- end cc-graph --//>


            <div class="cc-graph-info">
            <span class="cc-graph-info-label">+</span>
            <div class="cc-graph-unit" data-weight="4"></div>
            <div class="cc-graph-unit" data-weight="3"></div>
            <div class="cc-graph-unit" data-weight="2"></div>
            <div class="cc-graph-unit" data-weight="1"></div>
            <div class="cc-graph-unit" data-weight="0"></div>
            <span class="cc-graph-info-label">-</span>
          </div>


            <span class="u-skip" id="skipcc-graph”"></span>
          </div> --> <!-- end core-three -->

        </div> <!-- end cc-coregrid  -->
      </div><!-- end profile-inner  -->


      <div id="tabs" class="profile-tabs" onload="changeTab('1')">

        <div class="cc-profmenu">
          <button id="tab-btn-1" class="cc-profmenu-btn" v-on:click="changeTab('1')" title="Sobre mim" alt="Sobre mim">
            <div class="cc-profmenu-ico cc-profmenu-ico-1"></div>
          </button>

          <button id="tab-btn-2" class="cc-profmenu-btn" v-on:click="changeTab('2')" title="Produção Intelectual" alt="Produção Intelectual">
            <div class="cc-profmenu-ico cc-profmenu-ico-2"></div>
          </button>

          <button id="tab-btn-3" class="cc-profmenu-btn" v-on:click="changeTab('3')" title="Atuações profissionais" alt="Atuações profissionais">
            <div class="cc-profmenu-ico cc-profmenu-ico-3"></div>
          </button>

          <?php if ($totalOrientacoes != 0) : ?>
            <button id="tab-btn-4" class="cc-profmenu-btn" v-on:click="changeTab('4')" title="Ensino" alt="Ensino">
              <div class="cc-profmenu-ico cc-profmenu-ico-4"></div>
            </button>
          <?php endif; ?>

          <button id="tab-btn-5" class="cc-profmenu-btn" v-on:click="changeTab('5')" title="Gestão" alt="Gestão">
            <div class="cc-profmenu-ico cc-profmenu-ico-5"></div>
          </button>

          <button id="tab-btn-6" class="cc-profmenu-btn" v-on:click="changeTab('6')" title="Pesquisa" alt="Pesquisa">
            <div class="cc-profmenu-ico cc-profmenu-ico-6"></div>
          </button>
          <!-- <button id="tab-btn-7" class="cc-profmenu-btn" v-on:click="changeTab('7')" title="" alt="">
              bkp atuações
            </button> -->
        </div><!-- end cc-menu  -->


        <div class="profile-inner u-m-2">
          <transition name="tabeffect">
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

              <hr class="c-line u-my-2" />

              <p class="ty ty-subtitle">Perfis na web</p>
              <div class="cc-socialicons">

                <?php if (!empty($profile['lattesID'])) : ?>

                  <a href="https://lattes.cnpq.br/<?php echo $profile['lattesID']; ?>" target="_blank" rel="external"><img class="cc-socialicons-icon" src="inc/images/icons/academic_plataforms/logo_lattes.svg" alt="Lattes" title="Lattes" /></a>
                <?php endif; ?>
                <?php if (!empty($profile['orcid_id'])) : ?>
                  <a href="<?php echo $profile['orcid_id']; ?>" target="_blank" rel="external"><img class="cc-socialicons-icon" src="inc/images/icons/academic_plataforms/logo_research_id.svg" alt="ORCID" title="ORCID" /></a>
                <?php endif; ?>

              </div> <!-- end cc-socialicons -->

              <hr class="c-line u-my-2" />
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
                  <?php foreach ($resultaboutfacet as $t => $tag) {
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


              <?php if (isset($profile["idiomas"])) : ?>
                <div class=" u-left">
                  <h3 class="ty ty-title">Idiomas</h3>
                  <?php foreach ($profile["idiomas"] as $key => $idioma) : ?>

                    <div class="s-list">

                      <div class="s-list-bullet">
                        <?php
                        switch ($idioma["descricaoDoIdioma"]) {
                          case "Inglês":
                            echo "<img class='c-iconlang' src='inc/images/icons/languages/en.svg' />";
                            break;
                          case "Espanhol":
                            echo "<img class='c-iconlang' src='inc/images/icons/languages/es.svg' />";
                            break;
                          case "Português":
                            echo "<img class='c-iconlang' src='inc/images/icons/languages/pt.svg' />";
                            break;
                          case "Italiano":
                            echo "<img class='c-iconlang' src='inc/images/icons/languages/pt.svg' />";
                            break;
                          case "Francês":
                            echo "<img class='c-iconlang' src='inc/images/icons/languages/pt.svg' />";
                            break;
                          case "Alemão":
                            echo "<img class='c-iconlang' src='inc/images/icons/languages/pt.svg' />";
                            break;
                          case "Russo":
                            echo "<img class='c-iconlang' src='inc/images/icons/languages/pt.svg' />";
                            break;
                          case "Mandarin":
                            echo "<img class='c-iconlang' src='inc/images/icons/languages/pt.svg' />";
                            break;
                          default:
                            echo "<img class='c-iconlang' src='inc/images/icons/languages/idioma.svg' />";
                            break;
                        }
                        ?>
                      </div>

                      <div class="s-list-content">
                        <p class="ty ty-item"><?php echo $idioma["descricaoDoIdioma"] ?></p>
                        <p class="ty" style="margin-bottom:10px;">

                          Compreende <?php echo strtolower($idioma["proficienciaDeCompreensao"]) ?>
                          <b class="ty-subItem-light">,</b>

                          Fala <?php echo strtolower($idioma["proficienciaDeFala"]) ?>
                          <b class="ty-subItem-light">,</b>

                          Lê <?php echo strtolower($idioma["proficienciaDeLeitura"]) ?>
                          <b class="ty-subItem-light">,</b>

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
              <?php if (isset($profile["formacao_academica_titulacao_livreDocencia"])) : ?>

                <?php foreach ($profile["formacao_academica_titulacao_livreDocencia"] as $key => $livreDocencia) : ?>

                  <div class="formation-container">
                    <div class="s-list">
                      <div class="s-list-bullet">
                        <img class="s-list-ico" src="inc/images/icons/academic.svg" />
                      </div>

                      <div class="s-list-content">
                        <div class="formation">
                          <p class="ty-item">Livre Docência
                            <i> —
                              <?php echo $livreDocencia["anoDeObtencaoDoTitulo"] ?>
                            </i>
                          </p>

                          <p class="ty">
                            <?php echo $livreDocencia["tituloDoTrabalho"] ?>
                          </p>

                          <p class="ty ty-gray">
                            <?php if (!empty($livreDocencia["area_do_conhecimento"][0]["nomeDaEspecialidade"])) : ?>
                              <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeDaEspecialidade"] ?>
                            <?php endif; ?>

                            <?php if (
                              !empty($livreDocencia["area_do_conhecimento"][0]["nomeDaEspecialidade"]) &&
                              !empty($livreDocencia["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"])
                            ) : ?>
                              <?php echo ', ' ?>
                            <?php endif; ?>

                            <?php if (!empty($livreDocencia["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"])) : ?>
                              <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"] ?>
                            <?php endif; ?>
                          </p>

                          <p class="ty"><?php echo $livreDocencia["nomeInstituicao"] ?></p>

                          <!-- <?php if (!empty($livreDocencia["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"])) : ?>
                            <p class="ty">
                              <b class="ty-subItem">Área do conhecimento:</b>
                              <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"] ?>
                            </p>
                          <?php endif; ?> -->

                          <!-- <?php if (!empty($livreDocencia["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"])) : ?>
                            <p class="ty">
                              <b class="ty-subItem">Grande área:</b>
                              <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"] ?>
                            </p>
                          <?php endif; ?> -->

                        </div> <!-- end formation -->
                      </div> <!-- end s-list-content -->
                    </div> <!-- end s-list -->
                  </div> <!-- end formation-container -->
                <?php endforeach; ?>
              <?php endif; ?>



              <!-- Doutorado -->
              <?php if (isset($profile["formacao_academica_titulacao_doutorado"])) : ?>

                <?php foreach ($profile["formacao_academica_titulacao_doutorado"] as $key => $doutorado) : ?>

                  <div class="formation-container">
                    <div class="s-list">
                      <div class="s-list-bullet">
                        <img class="s-list-ico" src="inc/images/icons/academic.svg" />
                      </div>
                      <div class="s-list-content">
                        <div class="formation">
                          <p class="ty-item">Doutorado em <?php echo $doutorado["nomeCurso"] ?>
                            <i> —
                              <?php echo $doutorado["anoDeInicio"] ?> -
                              <?php echo $doutorado["anoDeConclusao"] ?>
                            </i>
                          </p>
                          <p class="ty">
                            <?php echo $doutorado["tituloDaDissertacaoTese"] ?>
                          </p>


                          <p class="ty ty-gray">

                            <?php if (!empty($doutorado["area_do_conhecimento"][0]["nomeDaEspecialidade"])) : ?>
                              <?php echo $doutorado["area_do_conhecimento"][0]["nomeDaEspecialidade"] ?>
                            <?php endif; ?>

                            <?php if (
                              !empty($doutorado["area_do_conhecimento"][0]["nomeDaEspecialidade"]) &&
                              !empty($doutorado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"])
                            ) : ?>
                              <?php echo ',' ?>
                            <?php endif; ?>

                            <?php if (!empty($doutorado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"])) : ?>
                              <?php echo $doutorado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"] ?>
                            <?php endif; ?>
                          </p>

                          <p class="ty ty-gray">
                            <i>Orientador(a):</i>
                            <?php echo $doutorado["nomeDoOrientador"] ?>,
                            <?php echo $doutorado["nomeInstituicao"] ?>
                          </p>

                          <!-- <?php if (!empty($doutorado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"])) : ?>
                            <p class="ty">
                              <b class="ty-subItem">Grande área:</b>
                              <?php echo $doutorado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"] ?>
                            </p>
                          <?php endif; ?> -->

                          <!-- <?php if (!empty($doutorado["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"])) : ?>
                            <p class="ty">
                              <b class="ty-subItem">Área do conhecimento:</b>
                              <?php echo $doutorado["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"] ?>
                            </p>
                          <?php endif; ?> -->

                        </div> <!-- end formation -->
                      </div> <!-- end s-list-content -->
                    </div> <!-- end s-list -->
                  </div> <!-- end formation-container -->
                <?php endforeach; ?>
              <?php endif; ?>



              <!-- Mestrado -->
              <?php if (isset($profile["formacao_academica_titulacao_mestrado"])) : ?>

                <?php foreach ($profile["formacao_academica_titulacao_mestrado"] as $key => $mestrado) : ?>

                  <div class="formation-container">
                    <div class="s-list">
                      <div class="s-list-bullet">
                        <img class="s-list-ico" src="inc/images/icons/academic.svg" />
                      </div>

                      <div class="s-list-content">
                        <div class="formation">
                          <p class="ty-item">Mestrado em <?php echo $mestrado["nomeCurso"] ?>
                            <i> —
                              <?php echo $mestrado["anoDeInicio"] ?> -
                              <?php echo $mestrado["anoDeConclusao"] ?>
                            </i>
                          </p>

                          <p class="ty">
                            <?php echo $mestrado["tituloDaDissertacaoTese"] ?>
                          </p>

                          <p class="ty ty-gray">
                            <?php if (!empty($mestrado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"])) : ?>
                              <?php echo $mestrado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"] ?>
                            <?php endif; ?>

                            <?php if (
                              !empty($mestrado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"]) &&
                              !empty($mestrado["area_do_conhecimento"][0]["nomeDaEspecialidade"])
                            ) : ?>
                              <?php echo ',' ?>
                            <?php endif; ?>

                            <?php if (!empty($mestrado["area_do_conhecimento"][0]["nomeDaEspecialidade"])) : ?>
                              <?php echo $mestrado["area_do_conhecimento"][0]["nomeDaEspecialidade"] ?>
                            <?php endif; ?>
                          </p>

                          <p class="ty ty-gray">
                            <i>Orientador(a): </i>
                            <?php echo $mestrado["nomeDoOrientador"] ?>,
                            <?php echo $mestrado["nomeInstituicao"] ?>
                          </p>

                          <!-- <?php if (!empty($mestrado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"])) : ?>
                            <p class="ty">
                              <b class="ty-subItem">Grande área: </b>
                              <?php echo $mestrado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"] ?>
                            </p>
                          <?php endif; ?>

                          <?php if (!empty($mestrado["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"])) : ?>
                            <p class="ty">
                              <b class="ty-subItem">Área do conhecimento:</b>
                              <?php echo $mestrado["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"] ?>
                            </p>
                          <?php endif; ?> -->

                        </div> <!-- end formation -->
                      </div> <!-- end s-list-content -->
                    </div> <!-- end s-list -->
                  </div> <!-- end formation-container -->
                <?php endforeach; ?>
              <?php endif; ?>



              <!-- Graduação -->
              <?php if (isset($profile["formacao_academica_titulacao_graduacao"])) : ?>

                <?php foreach ($profile["formacao_academica_titulacao_graduacao"] as $key => $graduacao) : ?>

                  <div class="formation-container">
                    <div class="s-list">
                      <div class="s-list-bullet">
                        <img class="s-list-ico" src="inc/images/icons/academic.svg" />
                      </div>

                      <div class="s-list-content">
                        <div class="formation">
                          <p class="ty-item">Graduação em <?php echo $graduacao["nomeCurso"] ?>
                            <i> —
                              <?php echo $graduacao["anoDeInicio"] ?> -
                              <?php echo $graduacao["anoDeConclusao"] ?>
                            </i>
                          </p>
                          <p class="ty"><?php echo $graduacao["nomeInstituicao"] ?></p>
                          <?php if (!empty($graduacao["tituloDoTrabalhoDeConclusaoDeCurso"])) : ?>
                            <p class="ty ty-gray">
                              <?php echo $graduacao["tituloDoTrabalhoDeConclusaoDeCurso"] ?>
                            </p>
                          <?php endif; ?>
                          <?php if (!empty($graduacao["nomeDoOrientador"])) : ?>
                            <p class="ty ty-gray">
                              <i>Orientador(a): </i>
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
          </transition>

          <transition name="tabeffect">
            <div id="tab-two" class="cc-tab-content" v-if="tabOpened == '2'">
              <div class="profile-pi">

                <h2 class="ty ty-title u-mb-2">Produção Intelectual</h2>

                <?php
                foreach ($cursor_works['hits']['hits'] as $key => $work) {
                  $works[$work['_source']['datePublished']][] = $work;
                }

                for ($i = 2040; $i >= 1900; $i -= 1) {
                  if (!empty($works[$i])) {


                    echo '<hr class="c-line"></hr>
                <h3 class="ty-subtitle c-pi-year">' . $i . '</h3>
                <hr class="c-line u-mb-2"></hr> ';

                    foreach ($works[$i] as $key => $work) {

                      foreach ($work["_source"]["author"] as $author) {
                        $authors[] = $author["person"]["name"];
                      }

                      echo '<div class="c-pi">
            
                    <div class="s-list">
                      <div class="s-list-bullet">';
                      switch ($work['_source']['tipo']) {
                        case "Artigo publicado":
                          echo '<img class="s-list-ico" 
                                  src="inc/images/icons/article-published.svg" 
                                  title="Artigo publicado"
                                  />';
                          break;

                        case "Capítulo de livro publicado":
                          echo '<img class="s-list-ico" 
                                  src="inc/images/icons/chapter.svg"
                                  title="Capítulo de livro publicado"
                                  />';
                          break;

                        case "Livro publicado ou organizado":
                          echo '<img class="s-list-ico" 
                                  src="inc/images/icons/book.svg"
                                  title="Livro publicado ou organizado"
                                  />';
                          break;

                        case "Patente":
                          echo '<img class="s-list-ico" 
                                  src="inc/images/icons/patent.svg"
                                  title="Patente"
                                  />';
                          break;

                        case "Software":
                          echo '<img class="s-list-ico" 
                                  src="inc/images/icons/softwares.svg"
                                  title="Software"
                                  />';
                          break;

                        case "Textos em jornais de notícias/revistas":
                          echo '<img class="s-list-ico" 
                                  src="inc/images/icons/papers.svg"
                                  title="Textos em jornais de notícias/revistas"
                                  />';
                          break;

                        case "Trabalhos em eventos":
                          echo '<img class="s-list-ico" 
                                  src="inc/images/icons/event.svg"
                                  title="Trabalhos em eventos"
                                  />';
                          break;

                        case "Tradução":
                          echo '<img class="s-list-ico" 
                            src="inc/images/icons/book.svg"
                            title="Tradução"
                            />';
                          break;

                        default:
                          echo '<img class="s-list-ico" 
                                  src="inc/images/icons/default.svg"
                                  title="Item"
                                  />';
                      }

                      echo '</div>            

                      <div class="s-list-content">

                        <p class="ty-item">'
                        . $work['_source']['name'] . ' 
                         <i> — ' . $work['_source']['tipo'] . '</i > 
                         </p>
                      
                        <p class="ty-gray"> 
                        <b class="ty-subItem">Autores: </b>' . implode('; ', $authors) . '</p>
                                    
                        <div class="s-line">
                          
                          <!--
                          <div class="s-line-item"> 
                            <img class="s-line-icon"
                              src="inc/images/icons/citation.svg" 
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
                                src="inc/images/icons/link.svg" 
                                alt="representação de um link"
                              />
                              
                              <a href="' . $work['_source']['url'] . '" target="blank">Conteúdo completo</a>
                            </div>
                          ';
                      }

                      if (!empty($work['_source']['doi'])) {
                        echo '
                          <div class="s-line-item">

                            <img 
                            class="s-line-icon"
                            src="inc/images/logos/doi.svg" 
                            alt="logo DOI"
                            />
                            
                            <a href="https://doi.org/' . $work['_source']['doi'] . '"> DOI</a>
                          </div>';
                      };

                      echo '
                          
                        </div>
                        <p class="ty-right ty-themeLight">Fonte: ';
                      echo (!empty($work['_source']['isPartOf']['name'])) ? $work['_source']['isPartOf']['name'] : '';
                      echo (!empty($work['_source']['isPartOf']['volume'])) ? ', v.' . $work['_source']['isPartOf']['volume'] : '';
                      echo (!empty($work['_source']['isPartOf']['fasciculo'])) ? ', n.' . $work['_source']['isPartOf']['fasciculo'] : '';
                      echo (!empty($work['_source']['pageStart'])) ? ', p.' . $work['_source']['pageStart'] : '';
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
          </transition>

          <transition name="tabeffect">
            <div id="tab-three" class="cc-tab-content" v-if="tabOpened == '3'">

              <h2 class="ty ty-title u-mb-2">Atuações profissionais</h2>

              <!-- (tab-three) foreach 1 -->
              <?php foreach ($profile['atuacoes_profissionais'] as $key => $atuacoes_profissionais) : ?>

                <!-- (tab-three) foreach 2 -->
                <?php foreach ($atuacoes_profissionais as $key => $atuacao_profissional) : ?>

                  <h4 class="ty ty-title u-my-2">
                    <?php echo $atuacao_profissional['@attributes']['NOME-INSTITUICAO']; ?>
                  </h4>

                  <!-- (tab-three) if 1 -->
                  <?php if (isset($atuacao_profissional['VINCULOS'])) : ?>

                    <!-- (tab-three) if 2 -->
                    <?php if (count($atuacao_profissional['VINCULOS']) == 1) : ?>


                      <div class="s-list">
                        <div class="s-list-bullet">
                          <img class='s-list-ico-mini' src='inc/images/icons/professional.svg' />
                        </div>
                        <div class="s-list-content-mini">
                          <p class="ty ty-item">
                            <?php echo $atuacao_profissional['VINCULOS']['@attributes']['OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO']; ?>
                            <?php echo $atuacao_profissional['VINCULOS']['@attributes']['OUTRO-VINCULO-INFORMADO']; ?>
                            <i> —
                              <?php echo $atuacao_profissional['VINCULOS']['@attributes']['ANO-INICIO']; ?> -
                              <?php echo $atuacao_profissional['VINCULOS']['@attributes']['ANO-FIM']; ?>
                            </i>
                          </p>
                        </div>
                      </div>

                    <?php else : ?>
                      <!-- (tab-three) else if 2 -->

                      <!-- (tab-three) for 1 -->
                      <?php for ($i_atuacao_profissional = 0; $i_atuacao_profissional <= (count($atuacao_profissional['VINCULOS']) - 1); $i_atuacao_profissional++) : ?>

                        <div class="s-list">
                          <div class="s-list-bullet">
                            <img class='s-list-ico-mini' src='inc/images/icons/professional.svg' />
                          </div>
                          <div class="s-list-content-mini">
                            <p class="ty ty-item">
                              <?php echo $atuacao_profissional['VINCULOS'][$i_atuacao_profissional]['@attributes']['OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO']; ?>
                              <?php echo $atuacao_profissional['VINCULOS'][$i_atuacao_profissional]['@attributes']['OUTRO-VINCULO-INFORMADO']; ?>
                              <i>
                                <?php echo $atuacao_profissional['VINCULOS'][$i_atuacao_profissional]['@attributes']['ANO-INICIO']; ?>
                                -
                                <?php echo $atuacao_profissional['VINCULOS'][$i_atuacao_profissional]['@attributes']['ANO-FIM']; ?>
                              </i>
                            </p>
                          </div>
                        </div>

                      <?php endfor; ?>
                      <!-- (tab-three) end for 1 -->

                    <?php endif; ?>
                    <!-- (tab-three) end if 2 -->

                  <?php endif; ?>
                  <!-- (tab-three) end if 1 -->

                  <hr class="c-line" />
                <?php endforeach; ?>
                <!-- (tab-three) end foreach 2 -->

              <?php endforeach; ?>
              <!-- (tab-three) end foreach 1 -->


            </div> <!-- end tab-three -->
          </transition>

          <transition name="tabeffect">
            <div id="tab-four" class="cc-tab-content" v-if="tabOpened == '4'">
              <h2 class="ty ty-title u-mb-2">Ensino</h2>

              <p>Aqui vão as atividades de ensino</p>

              <h3 class="ty ty-title u-mb-2">Orientações e supervisões</h3>

              <?php if (!empty($profile['orientacoes'])) : ?>


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
                  if (isset($orientacao_andamento_array[$orientacao_andamento_label])) {
                    if (count($orientacao_andamento_array[$orientacao_andamento_label]) > 0) {
                      echo '<h4 class="ty ty-title u-mb-2">' . $orientacao_andamento_label . ' em andamento</h4><ul class="s-nobullet">';
                      foreach ($orientacao_andamento_array[$orientacao_andamento_label] as $orientacao_andamento_echo) {
                        //var_dump($orientacao_andamento_echo);
                        echo '
                      <li>
                        <div class="s-list">
                          <div class="s-list-bullet">
                            <img class="c-iconlang" src="inc/images/icons/orientation.svg" />
                          </div>
      
                          <div class="s-list-content">
      
                            <p class="ty ty-item">
                              <a class="ty-itemLink" href="http://lattes.cnpq.br/' . $orientacao_andamento_echo["numeroIDOrientado"] . '" target="_blank">
                              ' . $orientacao_andamento_echo["nomeDoOrientando"] . '
                              </a>
                              <i> — ' . $orientacao_andamento_echo["ano"] . ' - Em andamento</i>
                            </p>
      
                            <p class="ty">';
                        (!empty($orientacao_andamento_echo["titulo"])) ?
                          print_r('' . $orientacao_andamento_echo["titulo"]) : "";
                        echo '
                            </p>
                            <p class="ty ty-gray">';
                        (!empty($orientacao_andamento_echo["nomeDoCurso"])) ?
                          print_r('' . $orientacao_andamento_echo["nomeDoCurso"]) : "";

                        if (
                          $orientacao_andamento_echo["nomeDoCurso"] &&
                          $orientacao_andamento_echo["flagBolsa"] == "SIM"
                        )
                          print_r(', ');

                        ($orientacao_andamento_echo["flagBolsa"] == "SIM") ?
                          print_r('' . $orientacao_andamento_echo["nomeDaAgencia"] . '') : "";

                        echo '</p>';
                        echo '<p class="ty ty-gray">' . $orientacao_andamento_echo["nomeDaInstituicao"] . '';


                        echo '
                          </div> <!-- end-grid-right -->
                        </div><!-- end-grid -->
                      </li>';
                      }
                      echo '</ul>';
                    }
                  }
                  unset($orientacao_andamento_array);
                }
                ?>

              <?php endif; ?>

              <?php if (!empty($profile['orientacoesconcluidas'])) : ?>



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
                  if (isset($orientacao_concluidas_array)) {
                    if (count($orientacao_concluidas_array[$orientacao_concluidas_label]) > 0) {
                      echo '<h4 class="ty ty-title u-mb-2">' . $orientacao_concluidas_label . ' concluídas</h4><ul class="s-nobullet">';
                      foreach ($orientacao_concluidas_array[$orientacao_concluidas_label] as $orientacao_concluidas_echo) {
                        //var_dump($orientacao_concluidas_echo);
                        echo '
                    <li>
                    
                    <div class="s-list">
                      <div class="s-list-bullet">
                        <img class="s-list-ico" src="inc/images/icons/orientation.svg" />
                      </div>
  
                      <div class="s-list-content">
  
                        <p class="ty ty-item">
                          <a class="ty-itemLink" href="http://lattes.cnpq.br/' . $orientacao_concluidas_echo["numeroIDOrientado"] . '" target="_blank">
                          ' . $orientacao_concluidas_echo["nomeDoOrientando"] . '
                          </a>
                          <i> — ' . $orientacao_concluidas_echo["ano"] . '</i>
                        </p>
  
                        <p class="ty">';
                        (!empty($orientacao_concluidas_echo["titulo"])) ?
                          print_r('' . $orientacao_concluidas_echo["titulo"]) : "";
                        echo '
                        </p>
                        <p class="ty ty-gray">';

                        (!empty($orientacao_concluidas_echo["nomeDoCurso"])) ?
                          print_r('' . $orientacao_concluidas_echo["nomeDoCurso"]) : "";

                        if (
                          $orientacao_concluidas_echo["nomeDoCurso"] &&
                          $orientacao_concluidas_echo["flagBolsa"] == "SIM"
                        )
                          print_r(', ');

                        ($orientacao_concluidas_echo["flagBolsa"] == "SIM") ?
                          print_r('' . $orientacao_concluidas_echo["nomeDaAgencia"] . '') : "";

                        echo '
                        </p>';

                        echo '<p class="ty ty-gray">' . $orientacao_concluidas_echo["nomeDaInstituicao"] . '</p>';

                        echo '

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
          </transition>

          <transition name="tabeffect">
            <div id="tab-five" class="cc-tab-content" v-if="tabOpened == '5'">

              <h2 class="ty ty-title u-mb-2">Atividades de gestão</h2>

              <!-- (tab-five) foreach 1 -->
              <?php foreach ($profile['atuacoes_profissionais'] as $key => $atuacoes_profissionais) : ?>

                <!-- (tab-five) foreach 2 -->
                <?php foreach ($atuacoes_profissionais as $key => $atuacao_profissional) : ?>

                  <!-- (tab-five) if 3 -->
                  <?php if (isset($atuacao_profissional['ATIVIDADES-DE-DIRECAO-E-ADMINISTRACAO'])) : ?>


                    <h4 class="ty ty-title u-my-2">
                      <?php echo $atuacao_profissional['@attributes']['NOME-INSTITUICAO']; ?>
                    </h4>

                    <!-- (tab-five) if 1 -->
                    <?php if (isset($atuacao_profissional['VINCULOS'])) : ?>


                      <!-- (tab-five) for 1 -->
                      <?php for ($i_atuacao_profissional = 0; $i_atuacao_profissional <= (count($atuacao_profissional['VINCULOS']) - 1); $i_atuacao_profissional++) : ?>



                        <!-- (tab-five) foreach 3 -->
                        <?php foreach ($atuacao_profissional['ATIVIDADES-DE-DIRECAO-E-ADMINISTRACAO']['DIRECAO-E-ADMINISTRACAO'] as $key => $direcao_e_administracao) : ?>

                          <div class="s-list u-mb-2">
                            <div class="s-list-bullet">
                              <img class='c-iconlang' src='inc/images/icons/managing.svg' />
                            </div>

                            <div class="s-list-content">

                              <p class="ty ty-item"><?php echo $direcao_e_administracao['@attributes']['CARGO-OU-FUNCAO']; ?>
                                <i> —
                                  <?php echo $direcao_e_administracao['@attributes']['ANO-INICIO']; ?> -
                                  <?php echo $direcao_e_administracao['@attributes']['ANO-FIM']; ?></i>
                              </p>

                              <?php if (!empty($direcao_e_administracao['@attributes']['NOME-ORGAO'])) : ?>
                                <p class="ty ty-gray"><?php echo $direcao_e_administracao['@attributes']['NOME-ORGAO']; ?></p>
                              <?php endif; ?>

                              <?php if (!empty($direcao_e_administracao['@attributes']['NOME-UNIDADE'])) : ?>
                                <p class="ty ty-gray"><?php echo $direcao_e_administracao['@attributes']['NOME-UNIDADE']; ?></p>
                              <?php endif; ?>


                            </div>
                          </div>

                        <?php endforeach; ?>
                        <!-- (tab-five) end foreach 3 -->


                      <?php endfor; ?>
                      <!-- (tab-five) end for 1 -->


                    <?php endif; ?>
                    <!-- (tab-five) end if 1 -->

                  <?php endif; ?>
                  <!-- (tab-five) end if 3 -->

                <?php endforeach; ?>
                <!-- (tab-five) end foreach 2 -->

              <?php endforeach; ?>
              <!-- (tab-five) end foreach 1 -->
              
              <!--
              <h2 class="ty ty-title u-mb-2">Conselhos, Comissões e Consultoria</h2>

              <div class="s-list">
                <div class="s-list-bullet">
                  <img class='s-list-ico' src='inc/images/icons/reunion.svg' />
                </div>
                <div class="s-list-content">
                  <p class="ty ty-item">titulo — 2000 - 2001</p>
                  <p class="ty">Alguma coisa</p>
                  <p class="ty ty-gray">Alguma outra coisa</p>
                </div>
              </div>


              <h2 class="ty ty-title u-mb-2">Estágio</h2>

              <div class="s-list">
                <div class="s-list-bullet">
                  <img class='s-list-ico' src='inc/images/icons/internship.svg' />
                </div>
                <div class="s-list-content">
                  <p class="ty ty-item">titulo — 2000 - 2001</p>
                  <p class="ty">Alguma coisa</p>
                  <p class="ty ty-gray">Alguma outra coisa</p>
                </div>
              </div>

              <h2 class="ty ty-title u-mb-2">Serviço Técnico Especializado</h2>

              <div class="s-list">
                <div class="s-list-bullet">
                  <img class='s-list-ico' src='inc/images/icons/specialist.svg' />
                </div>
                <div class="s-list-content">
                  <p class="ty ty-item">titulo — 2000 - 2001</p>
                  <p class="ty">Alguma coisa</p>
                  <p class="ty ty-gray">Alguma outra coisa</p>
                </div>
              </div>
              -->


            </div> <!-- end tab-five -->
          </transition>

          <transition name="tabeffect">
            <div id="tab-six" class="cc-tab-content" v-if="tabOpened == '6'">

              <h2 class="ty ty-title u-mb-2">Projetos de pesquisa</h2>

              <!-- (tab-six) foreach 1 -->
              <?php foreach ($profile['atuacoes_profissionais'] as $key => $atuacoes_profissionais) : ?>

                <!-- (tab-six) foreach 2 -->
                <?php foreach ($atuacoes_profissionais as $key => $atuacao_profissional) : ?>


                  <!-- (tab-six) if 4 -->
                  <?php if (isset($atuacao_profissional['ATIVIDADES-DE-PARTICIPACAO-EM-PROJETO']['PARTICIPACAO-EM-PROJETO'])) : ?>



                    <!-- <h4 class="ty ty-title u-my-2">
            <?php echo $atuacao_profissional['@attributes']['NOME-INSTITUICAO']; ?>
          </h4> -->


                    <!-- (tab-six) for 1 -->
                    <?php for ($i_atuacao_profissional = 0; $i_atuacao_profissional <= (count($atuacao_profissional['VINCULOS']) - 1); $i_atuacao_profissional++) : ?>


                      <!-- (tab-six) foreach 4 -->
                      <?php foreach ($atuacao_profissional['ATIVIDADES-DE-PARTICIPACAO-EM-PROJETO']['PARTICIPACAO-EM-PROJETO'] as $key => $participacao_em_projeto) : ?>


                        <!-- (tab-six) if 6 -->
                        <?php if (isset($participacao_em_projeto['PROJETO-DE-PESQUISA'])) : ?>

                          <!-- (tab-six) foreach 5 -->
                          <?php foreach ($participacao_em_projeto['PROJETO-DE-PESQUISA'] as $key => $projeto_de_pesquisa) : ?>


                            <!-- (tab-six) if 7 -->
                            <?php if (!empty($projeto_de_pesquisa['@attributes'])) : ?>

                              <div class="s-list u-mb-2">
                                <div class="s-list-bullet">
                                  <img class='s-list-ico' src='inc/images/icons/research.svg' />
                                </div>
                                <div class="s-list-content">

                                  <p class="ty ty-item">
                                    <?php echo $projeto_de_pesquisa['@attributes']['NOME-DO-PROJETO']; ?>
                                    <i> —
                                      <?php echo $projeto_de_pesquisa['@attributes']['ANO-INICIO']; ?> -
                                      <?php echo $projeto_de_pesquisa['@attributes']['ANO-FIM']; ?>
                                    </i>
                                  </p>
                                  <?php if (!empty($projeto_de_pesquisa['@attributes']['DESCRICAO-DO-PROJETO'])) : ?>
                                    <p class="ty u-mb-1">
                                      <?php echo $projeto_de_pesquisa['@attributes']['DESCRICAO-DO-PROJETO']; ?>
                                    </p>
                                  <?php endif; ?>

                                  <?php
                                  unset($integrantes_do_projeto);
                                  foreach ($projeto_de_pesquisa['EQUIPE-DO-PROJETO']['INTEGRANTES-DO-PROJETO'] as $key => $integrante_do_projeto) {
                                    //echo "<pre>".print_r($integrante_do_projeto, true)."</pre>"; 
                                    if (isset($integrante_do_projeto['@attributes']['NOME-COMPLETO'])) {
                                      $integrantes_do_projeto[] = $integrante_do_projeto['@attributes']['NOME-COMPLETO'];
                                    }
                                  }
                                  ?>

                                  <?php if (!empty($integrantes_do_projeto)) : ?>
                                    <p class="ty u-mb-1">
                                      <b class="ty-subItem">Integrantes:</b>
                                      <span class="ty-gray"><?php echo implode(', ', $integrantes_do_projeto); ?></span>
                                    </p>
                                  <?php endif; ?>

                                </div> <!-- end-grid-right -->

                              </div><!-- end-grid -->

                              <!-- else do if 7 -->
                            <?php else : ?>
                              <?php
                              if (isset($projeto_de_pesquisa['INTEGRANTES-DO-PROJETO'])) {
                                unset($integrantes_do_projeto);
                                //echo "<pre>".print_r($projeto_de_pesquisa['INTEGRANTES-DO-PROJETO'], true)."</pre>";
                                if (isset($projeto_de_pesquisa['INTEGRANTES-DO-PROJETO']['@attributes'])) {
                                  $integrantes_do_projeto[] = $projeto_de_pesquisa['INTEGRANTES-DO-PROJETO']['@attributes']['NOME-COMPLETO'];
                                } else {
                                  foreach ($projeto_de_pesquisa['INTEGRANTES-DO-PROJETO'] as $key => $integrante_do_projeto) {
                                    $integrantes_do_projeto[] = $integrante_do_projeto['@attributes']['NOME-COMPLETO'];
                                  }
                                }
                              }
                              ?>
                              <!-- end else do if 7 -->


                              <!-- (tab-six) if 8 -->
                              <?php if (isset($projeto_de_pesquisa['NOME-DO-PROJETO'])) : ?>

                                <div class="s-list">
                                  <div class="s-list-bullet">
                                    <img class='c-iconlang' src='inc/images/icons/research.svg' />
                                  </div>

                                  <div class="s-list-content">

                                    <p class="ty ty-item"><?php echo $projeto_de_pesquisa['NOME-DO-PROJETO']; ?>
                                      <i> —
                                        <?php echo $projeto_de_pesquisa['ANO-INICIO']; ?> -
                                        <?php echo $projeto_de_pesquisa['ANO-FIM']; ?>
                                      </i>
                                    </p>
                                    <?php if (!empty($projeto_de_pesquisa['DESCRICAO-DO-PROJETO'])) : ?>
                                      <p class="ty u-mb-1">
                                        <?php echo $projeto_de_pesquisa['DESCRICAO-DO-PROJETO']; ?>
                                      </p>
                                    <?php endif; ?>


                                    <?php if (isset($integrantes_do_projeto)) : ?>
                                      <p class="ty u-mb-1">
                                        <b class="ty-subItem">Integrantes:</b>
                                        <span class="ty-gray"><?php echo implode(', ', $integrantes_do_projeto); ?></span>
                                      </p>
                                    <?php endif; ?>


                                  </div> <!-- end-grid-right -->
                                </div><!-- end-grid -->

                              <?php endif; ?>
                              <!-- (tab-six) end if 8 -->


                            <?php endif; ?>
                            <!-- (tab-six) end if 7 -->

                          <?php endforeach; ?>
                          <!-- (tab-six) end foreach 5 -->

                        <?php endif; ?>
                        <!-- (tab-six) end if 6 -->

                      <?php endforeach; ?>
                      <!-- (tab-six) end foreach 4 -->


                    <?php endfor; ?>
                    <!-- (tab-six) end for 1 -->

                  <?php endif; ?>
                  <!-- (tab-six) end if 4 -->


                <?php endforeach; ?>
                <!-- (tab-six) end foreach 2 -->

              <?php endforeach; ?>
              <!-- (tab-six) end foreach 1 -->

              <h3 class="ty ty-title u-mb-2">Outras atividades técnico científicas</h3>



            </div> <!-- end tab-six -->
          </transition>

          <transition name="tabeffect">
            <div id="tab-seven" class="cc-tab-content" v-if="tabOpened == '7'">

              <h2 class="ty ty-title u-mb-2">Atuações profissionais</h2>

              <!-- (tab-seven) foreach 1 -->
              <?php foreach ($profile['atuacoes_profissionais'] as $key => $atuacoes_profissionais) : ?>

                <!-- (tab-seven) foreach 2 -->
                <?php foreach ($atuacoes_profissionais as $key => $atuacao_profissional) : ?>


                  <h4 class="ty ty-title u-my-2">
                    <?php echo $atuacao_profissional['@attributes']['NOME-INSTITUICAO']; ?>
                  </h4>

                  <!-- (tab-seven) if 1 -->
                  <?php if (isset($atuacao_profissional['VINCULOS'])) : ?>

                    <!-- (tab-seven) if 2 -->
                    <?php if (count($atuacao_profissional['VINCULOS']) == 1) : ?>

                      <p class="ty ty-item u-mb-2">
                        <?php echo $atuacao_profissional['VINCULOS']['@attributes']['OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO']; ?>
                        <?php echo $atuacao_profissional['VINCULOS']['@attributes']['OUTRO-VINCULO-INFORMADO']; ?>
                        <i> —
                          <?php echo $atuacao_profissional['VINCULOS']['@attributes']['ANO-INICIO']; ?> -
                          <?php echo $atuacao_profissional['VINCULOS']['@attributes']['ANO-FIM']; ?>
                        </i>
                      </p>

                    <?php else : ?>
                      <!-- (tab-seven) else if 2 -->

                      <!-- (tab-seven) for 1 -->
                      <?php for ($i_atuacao_profissional = 0; $i_atuacao_profissional <= (count($atuacao_profissional['VINCULOS']) - 1); $i_atuacao_profissional++) : ?>

                        <p class="ty ty-item">
                          <?php echo $atuacao_profissional['VINCULOS'][$i_atuacao_profissional]['@attributes']['OUTRO-ENQUADRAMENTO-FUNCIONAL-INFORMADO']; ?>
                          <?php echo $atuacao_profissional['VINCULOS'][$i_atuacao_profissional]['@attributes']['OUTRO-VINCULO-INFORMADO']; ?>
                          <i> —
                            <?php echo $atuacao_profissional['VINCULOS'][$i_atuacao_profissional]['@attributes']['ANO-INICIO']; ?>
                            -
                            <?php echo $atuacao_profissional['VINCULOS'][$i_atuacao_profissional]['@attributes']['ANO-FIM']; ?>
                          </i>
                        </p>

                        <!-- (tab-seven) if 3 -->
                        <?php if (isset($atuacao_profissional['ATIVIDADES-DE-DIRECAO-E-ADMINISTRACAO'])) : ?>

                          <h6 class="ty ty-title u-mb-2">Atividades de gestão</h6>

                          <!-- (tab-seven) foreach 3 -->
                          <?php foreach ($atuacao_profissional['ATIVIDADES-DE-DIRECAO-E-ADMINISTRACAO']['DIRECAO-E-ADMINISTRACAO'] as $key => $direcao_e_administracao) : ?>

                            <div class="s-list u-mb-2">
                              <div class="s-list-bullet">
                                <img class='c-iconlang' src='inc/images/icons/managing.svg' />
                              </div>

                              <div class="s-list-content">

                                <p class="ty ty-item"><?php echo $direcao_e_administracao['@attributes']['CARGO-OU-FUNCAO']; ?>
                                  <i> —
                                    <?php echo $direcao_e_administracao['@attributes']['ANO-INICIO']; ?> -
                                    <?php echo $direcao_e_administracao['@attributes']['ANO-FIM']; ?>
                                  </i>
                                </p>
                                <?php if (!empty($direcao_e_administracao['@attributes']['NOME-UNIDADE'])) : ?>
                                  <p>Unidade: <?php echo $direcao_e_administracao['@attributes']['NOME-UNIDADE']; ?></p>
                                <?php endif; ?>

                                <?php if (!empty($direcao_e_administracao['@attributes']['NOME-ORGAO'])) : ?>
                                  <p>Órgão: <?php echo $direcao_e_administracao['@attributes']['NOME-ORGAO']; ?></p>
                                <?php endif; ?>

                              </div> <!-- end-grid-right -->
                            </div><!-- end-grid -->

                          <?php endforeach; ?>
                          <!-- (tab-seven) end foreach 3 -->

                        <?php endif; ?>
                        <!-- (tab-seven) end if 3 -->

                        <!-- (tab-seven) if 4 -->
                        <?php if (isset($atuacao_profissional['ATIVIDADES-DE-PARTICIPACAO-EM-PROJETO']['PARTICIPACAO-EM-PROJETO'])) : ?>

                          <h5 class="ty ty-title u-mb-2">Projetos de pesquisa</h5>

                          <!-- (tab-seven) foreach 4 -->
                          <?php foreach ($atuacao_profissional['ATIVIDADES-DE-PARTICIPACAO-EM-PROJETO']['PARTICIPACAO-EM-PROJETO'] as $key => $participacao_em_projeto) : ?>

                            <!-- (tab-seven) if 5 -->
                            <?php if (isset($participacao_em_projeto['@attributes']['NOME-ORGAO'])) : ?>



                              <p class="ty ty-item">
                                <?php if (!empty($participacao_em_projeto['@attributes']['NOME-ORGAO'])) : ?>
                                  <?php echo $participacao_em_projeto['@attributes']['NOME-ORGAO']; ?>
                                <?php endif; ?>
                                <?php if (!empty($participacao_em_projeto['@attributes']['NOME-UNIDADE'])) : ?>
                                  — <?php echo $participacao_em_projeto['@attributes']['NOME-UNIDADE']; ?>
                                <?php endif; ?>
                                <i> —
                                  <?php echo $participacao_em_projeto['@attributes']['ANO-INICIO']; ?> -
                                  <?php echo $participacao_em_projeto['@attributes']['ANO-FIM']; ?>
                                </i>
                              </p>



                            <?php endif; ?>
                            <!-- (tab-seven) end if 5 -->

                            <!-- (tab-seven) if 6 -->
                            <?php if (isset($participacao_em_projeto['PROJETO-DE-PESQUISA'])) : ?>

                              <!-- (tab-seven) foreach 5 -->
                              <?php foreach ($participacao_em_projeto['PROJETO-DE-PESQUISA'] as $key => $projeto_de_pesquisa) : ?>


                                <!-- (tab-seven) if 7 -->
                                <?php if (!empty($projeto_de_pesquisa['@attributes'])) : ?>

                                  <div class="s-list u-mb-2">
                                    <div class="s-list-bullet">
                                      <img class='c-iconlang' src='inc/images/icons/research.svg' />
                                    </div>

                                    <div class="s-list-content">

                                      <p class="ty ty-item">
                                        <?php echo $projeto_de_pesquisa['@attributes']['NOME-DO-PROJETO']; ?>
                                        <i> —
                                          <?php echo $projeto_de_pesquisa['@attributes']['ANO-INICIO']; ?> -
                                          <?php echo $projeto_de_pesquisa['@attributes']['ANO-FIM']; ?>
                                        </i>
                                      </p>
                                      <?php if (!empty($projeto_de_pesquisa['@attributes']['DESCRICAO-DO-PROJETO'])) : ?>
                                        <p class="ty u-mb-1">
                                          <?php echo $projeto_de_pesquisa['@attributes']['DESCRICAO-DO-PROJETO']; ?>
                                        </p>
                                      <?php endif; ?>

                                      <?php
                                      unset($integrantes_do_projeto);
                                      foreach ($projeto_de_pesquisa['EQUIPE-DO-PROJETO']['INTEGRANTES-DO-PROJETO'] as $key => $integrante_do_projeto) {
                                        //echo "<pre>".print_r($integrante_do_projeto, true)."</pre>"; 
                                        if (isset($integrante_do_projeto['@attributes']['NOME-COMPLETO'])) {
                                          $integrantes_do_projeto[] = $integrante_do_projeto['@attributes']['NOME-COMPLETO'];
                                        }
                                      }
                                      ?>

                                      <?php if (!empty($integrantes_do_projeto)) : ?>
                                        <p class="ty u-mb-1">
                                          <b class="ty-subItem">Integrantes:</b>
                                          <span class="ty-gray"><?php echo implode(', ', $integrantes_do_projeto); ?></span>
                                        </p>
                                      <?php endif; ?>

                                    </div> <!-- end-grid-right -->

                                  </div><!-- end-grid -->

                                  <!-- else do if 7 -->
                                <?php else : ?>
                                  <?php
                                  if (isset($projeto_de_pesquisa['INTEGRANTES-DO-PROJETO'])) {
                                    unset($integrantes_do_projeto);
                                    //echo "<pre>".print_r($projeto_de_pesquisa['INTEGRANTES-DO-PROJETO'], true)."</pre>";
                                    if (isset($projeto_de_pesquisa['INTEGRANTES-DO-PROJETO']['@attributes'])) {
                                      $integrantes_do_projeto[] = $projeto_de_pesquisa['INTEGRANTES-DO-PROJETO']['@attributes']['NOME-COMPLETO'];
                                    } else {
                                      foreach ($projeto_de_pesquisa['INTEGRANTES-DO-PROJETO'] as $key => $integrante_do_projeto) {
                                        $integrantes_do_projeto[] = $integrante_do_projeto['@attributes']['NOME-COMPLETO'];
                                      }
                                    }
                                  }
                                  ?>
                                  <!-- end else do if 7 -->


                                  <!-- (tab-seven) if 8 -->
                                  <?php if (isset($projeto_de_pesquisa['NOME-DO-PROJETO'])) : ?>

                                    <div class="s-list">
                                      <div class="s-list-bullet">
                                        <img class='c-iconlang' src='inc/images/icons/research.svg' />
                                      </div>

                                      <div class="s-list-content">

                                        <p class="ty ty-item"><?php echo $projeto_de_pesquisa['NOME-DO-PROJETO']; ?>
                                          <i> —
                                            <?php echo $projeto_de_pesquisa['ANO-INICIO']; ?> -
                                            <?php echo $projeto_de_pesquisa['ANO-FIM']; ?>
                                          </i>
                                        </p>
                                        <?php if (!empty($projeto_de_pesquisa['DESCRICAO-DO-PROJETO'])) : ?>
                                          <p class="ty u-mb-1">
                                            <?php echo $projeto_de_pesquisa['DESCRICAO-DO-PROJETO']; ?>
                                          </p>
                                        <?php endif; ?>


                                        <?php if (isset($integrantes_do_projeto)) : ?>
                                          <p class="ty u-mb-1">
                                            <b class="ty-subItem">Integrantes:</b>
                                            <span class="ty-gray"><?php echo implode(', ', $integrantes_do_projeto); ?></span>
                                          </p>
                                        <?php endif; ?>


                                      </div> <!-- end-grid-right -->
                                    </div><!-- end-grid -->

                                  <?php endif; ?>
                                  <!-- (tab-seven) end if 8 -->


                                <?php endif; ?>
                                <!-- (tab-seven) end if 7 -->

                              <?php endforeach; ?>
                              <!-- (tab-seven) end foreach 5 -->

                            <?php endif; ?>
                            <!-- (tab-seven) end if 6 -->

                          <?php endforeach; ?>
                          <!-- (tab-seven) end foreach 4 -->

                        <?php endif; ?>
                        <!-- (tab-seven) end if 4 -->

                      <?php endfor; ?>
                      <!-- (tab-seven) end for 1 -->

                    <?php endif; ?>
                    <!-- (tab-seven) end if 2 -->

                  <?php endif; ?>
                  <!-- (tab-seven) end if 1 -->

                <?php endforeach; ?>
                <!-- (tab-seven) end foreach 2 -->

              <?php endforeach; ?>
              <!-- (tab-seven) end foreach 1 -->



            </div> <!-- end tab seven -->
          </transition>

          <p class="ty ty-lastUpdate u-right">Atualização Lattes em
            <?php echo $profile['data_atualizacao']; ?></p>
          <p class="ty ty-lastUpdate u-right">Processado em <?php echo $profile['dataDeColeta']; ?></p>
        </div> <!-- end profile-inner -->
      </div> <!-- end #tabs -->

      <a class="c-back-to-top" href="#top" title="Voltar ao topo">
        <div class="back-to"></div>
      </a>

    </div> <!-- end profile-wrapper -->
  </main>


  <?php include('inc/footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

  <script>
    var app = new Vue({
      el: '#tabs',
      data: {
        tabOpened: '1',
        isActive: false

      },
      methods: {
        changeTab(tab) {
          this.tabOpened = tab
          var tabs = document.getElementsByClassName("cc-profmenu-btn")

          for (i = 0; i < tabs.length; i++)
            tabs[i].className = tabs[i].className.replace("cc-profmenu-active", "")

          tabs[Number(tab) - 1].className += " cc-profmenu-active"
        }
      },
      mounted: function() {
        this.changeTab(1)
      },
    })
  </script>

</body>

</html>