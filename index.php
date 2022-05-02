<?php
// if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
//     $location = 'https://unifesp.br/prodmais/index.php';
//     header('HTTP/1.1 301 Moved Permanently');
//     header('Location: ' . $location);
//     exit;
// }
if ($_SERVER["REQUEST_URI"] == "/") {
    header("Location: https://unifesp.br/prodmais/index.php");
}

/*

Este arquivo é parte do programa Prodmais

Prodmais é um software livre; você pode redistribuí-lo e/ou
modificá-lo dentro dos termos da Licença Pública Geral GNU como
publicada pela Free Software Foundation (FSF); na versão 3 da
Licença, ou (a seu critério) qualquer versão posterior.

Este programa é distribuído na esperança de que possa ser útil,
mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO
a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
Licença Pública Geral GNU para maiores detalhes.

Você deve ter recebido uma cópia da Licença Pública Geral GNU junto
com este programa, Se não, veja <http://www.gnu.org/licenses/>.

*/

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
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta name="description" content="Indicadores de dados referentes à Unifesp." />
  <meta name="keywords" content="Produção acadêmica, lattes, ORCID" />
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

  <link rel="stylesheet" href="sass/main.css" />
  <!-- <link rel="stylesheet" href="inc/css/style.css" /> -->

  <script src="inc/js/vue.js"></script><!-- https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js -->
  <script src="inc/js/axios.min.js"></script><!-- https://unpkg.com/axios/dist/axios.min.js -->

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

  <main class="wrapper">

    <?php require $logo_image; ?>

    <h2 class="u-textbox">
      Uma ferramenta de busca da produção científica de pesquisadores da UNIFESP.
    </h2>

    <?php if (paginaInicial::contar_registros_indice($index) == 0) : ?>
    <div class="alert alert-warning" role="alert">
      O Prod+ está em manutenção!
    </div>
    <?php endif; ?>

    <div id="mySearch" class="search">

      <form class="search-form" class="" action="result.php" title="Pesquisa simples">

        <div class="u-div-v">
          <input class="search-input" type="search" placeholder="Pesquise por palavra chave" aria-label="Pesquisar"
            name="search">
        </div>

        <button type="button" v-on:click="changeSearchMode()" class="btn search-btn" title="Alternar modo de pesquisa">
          <span v-if="searchPage == 'simple'">
            <svg class="btn-ico" x="0px" y="0px" viewBox="0 0 80 48">
              <path class="st0" d="M7.7,10c0.7,0,1.5,0.2,2.2,0.5L39.7,25l30.6-14c2.5-1.1,5.5,0,6.6,2.5c1.1,2.5,0,5.5-2.5,6.6l-32.7,15
                  c-1.4,0.6-2.9,0.6-4.3-0.1l-32-15.6C3,18.2,2,15.2,3.2,12.8C4,11,5.8,10,7.7,10z" />
            </svg>
          </span>
          <span v-if="searchPage == 'advanced'">
            <svg class="btn-ico" x="0px" y="0px" viewBox="0 0 80 48">
              <path class="st0" d="M72.3,35.5c-0.7,0-1.5-0.2-2.2-0.5L40.3,20.5l-30.6,14c-2.5,1.1-5.5,0-6.6-2.5c-1.1-2.5,0-5.5,2.5-6.6l32.7-15
                  c1.4-0.6,2.9-0.6,4.3,0.1l32,15.6c2.5,1.2,3.5,4.2,2.3,6.7C76,34.5,74.2,35.5,72.3,35.5z" />
            </svg>
          </span>
        </button>

        <div class="u-div-v" v-if="searchPage == 'advanced'">

          <label class="u-info">Mais opções de pesquisa:</label>

          <?php paginaInicial::filter_select("vinculo.ppg_nome"); ?>

          <input class="search-input" type="search"
            placeholder="Filtrar por Nome do Programa de Pós-Graduação (Opcional)" aria-label="Mudar" name="search">

          <input class="search-input" list="datalistOptions" id="authorsDataList"
            placeholder="Filtrar por nome ou ID Lattes do autor" name="filter[]" v-model="query" @input="searchCV()">

          <datalist class="search-input" id="datalistOptions">
            <option v-for="author in authors" :key="author._id" :value="'vinculo.lattes_id:' + author._id">
              {{author._source.nome_completo}}
            </option>
          </datalist>

          <label class="u-info">Filtrar por data:</label>
          <div class="u-div-h">
            <input type="text" class="search-date" id="initialYear" name="initialYear" pattern="\d{4}"
              placeholder="Data inicial" />
            <span> à </span>
            <input type="text" class="search-date" id="finalYear" name="finalYear" pattern="\d{4}"
              placeholder="Data final" />

          </div>


        </div> <!-- advanced -->

        <button type="submit" class="btn-search" title="Buscar">
          <svg class="btn-search-ico" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 100 100">
            <path
              d="M98.6,86.5L79.2,67c-0.9-0.9-2.1-1.4-3.3-1.4h-3.2c5.4-6.9,8.6-15.6,8.6-25C81.3,18.2,63.1,0,40.6,0
                S0,18.2,0,40.6s18.2,40.6,40.6,40.6c9.4,0,18.1-3.2,25-8.6v3.2c0,1.3,0.5,2.4,1.4,3.3l19.5,19.5c1.8,1.8,4.8,1.8,6.6,0l5.5-5.5
                C100.5,91.3,100.5,88.3,98.6,86.5z M40.6,65.6c-13.8,0-25-11.2-25-25s11.2-25,25-25s25,11.2,25,25S54.5,65.6,40.6,65.6z" />
          </svg>
        </button>

        <small class="u-info"><b>Dicas</b></small>
        <small class="u-info">1: Use * para busca por radical. Ex: biblio*.</small>
        <small class="u-info">2: Para buscas exatas, coloque entre "". Ex: "Direito civil"</small>
        <small class="u-info">3: Por padrão, o sistema utiliza o operador booleano OR. Caso necessite deixar a busca
          mais específica, utilize o operador AND (em maiúscula)</small>

    </div>
    </form>
    <!-- app -->

    <hr />
    <hr />
    <h3>Navegação por categorias</h3>
    <div class="u-spacer-2"></div>

    <div class="two">
      <div class="container mt-4">
        <div class="row">
          <div class="col-md-3">
            <h4 class="uk-h3">Programa de Pós-Graduação</h4>
            <div class="accordion" id="accordionPPGs">
              <div class="accordion-item">
                <h4 class="accordion-header" id="headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Programa de Pós-Graduação
                  </button>
                </h4>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                  data-bs-parent="#accordionPPGs">
                  <div class="accordion-body">
                    <ul class="list-group">
                      <?php paginaInicial::unidade_inicio("vinculo.ppg_nome"); ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h4 class="uk-h3">Tipo de vínculo / material</h4>
            <div class="accordion" id="accordionExample">
              <div class="accordion-item">
                <h4 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Tipo de vínculo
                  </button>
                </h4>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                  data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <ul class="list-group">
                      <?php paginaInicial::unidade_inicio("vinculo.tipvin"); ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h4 class="accordion-header" id="headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Tipo de material
                  </button>
                </h4>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                  data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <ul class="list-group">
                      <?php paginaInicial::tipo_inicio(); ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h4 class="uk-h3">Fonte</h4>
            <ul class="list-group">
              <?php paginaInicial::fonte_inicio(); ?>
            </ul>
          </div>
          <div class="col-md-3">
            <h4 class="uk-h3">Estatísticas</h4>
            <ul class="list-group">
              <li class="list-group-item"><?php echo paginaInicial::contar_registros_indice($index); ?> registros</li>
              <li class="list-group-item"><?php echo paginaInicial::contar_registros_indice($index_cv);; ?> currículos
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <br /><br />

    </div>
    </div>´

    <!-- <a class="u-skip" href="#mainseach">Voltar à barra de pesquisa principal</a> -->
  </main>
  <?php include('inc/footer.php'); ?>

  <script>
  var app = new Vue({
    el: '#mySearch',

    data: {
      searchPage: 'simple',
      query: "",
      message: "Teste",
      authors: []
    },
    mounted() {
      this.searchCV();
    },
    methods: {
      searchCV() {
        axios.get(
            'tools/proxy_autocomplete_cv.php?query=' + this.query
          ).then((response) => {
            this.authors = response.data.hits.hits;
          })
          .catch((error) => {
            console.log(error);
            console.error(error);
            this.errored = true;
          })
          .finally(() => (this.loading = false));
      },
      changeSearchMode() {
        if (this.searchPage == 'simple') this.searchPage = 'advanced'
        else this.searchPage = 'simple'
      }
    }
  })
  </script>


</body>

</html>