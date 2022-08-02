<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<?php
class PPG {
  static function externos($type, $link) {
    $ico = '';
    $text = '';

    switch ($type) {
      case 'sucupira':
        $ico = 'sucupira.png';
        $text = 'Repositório cucupura';
        break;
      case 'dataverse':
        $ico = 'dataverse.png';
        $text = 'Repositório Dataverse';
        break;
      case 'DSpace':
        $ico = 'DSpace.svg';
        $text = 'Repositório DSpace';
        break;
    }

    echo 
    "<a class='p-ppg-externos' href='$link' target='blank'>
      <img class='p-ppg-plataforms' src='inc/images/logos/$ico' title='$text'/>
      <p class='t t-light'><b>$text</b></p>
    </a>";
  }
}
?>

<head>
  <?php
  require 'inc/config.php';
  require 'inc/meta-header.php';
  require 'inc/functions.php';
  require 'components/GraphBar.php';
  require 'components/Production.php';
  require 'components/Who.php';
  require 'components/PPGBadges.php';
  require '_fakedata.php';
  ?>
  <meta charset="utf-8" />
  <title><?php echo $branch; ?> - p-ppg</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta name="description" content="Prodmais Unifesp." />
  <meta name="keywords" content="Produção acadêmica, lattes, ORCID" />
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <link rel="stylesheet" href="sass/main.css" />
</head>

<body class="c-wrapper-body">
  <?php if(file_exists('inc/google_analytics.php')){include 'inc/google_analytics.php';}?>

  <?php require 'inc/navbar.php'; ?>
  <main class="c-wrapper-container">
    <div class="c-wrapper-paper">

      <div class="c-wrapper-inner">

        <section class="p-ppg-header">

          <div class="p-ppg-header-a">
            <i class="i i-ppg-ico p-ppg-logo"></i>

            <div class="p-ppg-about">
              <h1 class="t t-h1">PPG Letras</h1>
              <h2 class="t t-h2">Programa de Pós Graduação em Letras</h2>
              <p class="t t-b ty-light-a">
                <span>Campus Guarulhos</span>
                <span>Escola de Filosofia, Letras e ciências Humanas</span>
              </p>
              <p class="t t-b t-gray">Estrada do Caminho Velho nª 123 - Bairro, Cidade - SP</p>

              <p class="t t-gray"><span class="t-b">Secretariado:</span> Maria Oliveira | Olívia Maria</p>
              <p class="t-b"></p>


              <a href="" target="blank">
                <div class="u-icon-text t-gray">
                  <i class="i i-mail p-ppg-i"></i> email@email.com
                </div>
              </a>

              <div class="u-icon-text t-gray">
                <i class="i i-phone p-ppg-i"></i> (11) 5555-5555
              </div>

              <a href="" target="blank">
                <div class="u-icon-text t-gray">
                  <i class="i i-web p-ppg-i"></i> www.http://ppg.unifesp.br/alimentosnutricaoesaude
                </div>
              </a>

              <?php
              Who::mini(
                $picture = "inc/images/tmp/profile.jpg",
                $name = 'Sócrates',
                $title = 'Coordenador',
                $link = 'https://unifesp.br/prodmais/index.php'
              )
              ?>

            </div>

          </div>

          <div class="p-ppg-header-b">
            <div class="u-line-to-col gridside-a">
              <?php echo PPGBadges::students(
                $rate = 20,
                $title = 'Estudantes Em Curso',
                $ico = 'book'
              ); ?>

              <?php echo PPGBadges::students(
                $rate = 100,
                $title = 'Estudantes Formados',
                $ico = 'formado'
              ); ?>
            </div>

            <div class="u-line-to-col">
              <?php echo PPGBadges::capes(
                $rate = 4,
                $title = 'Mestrado acadêmico'
                ); ?>

              <?php echo PPGBadges::capes(
                $rate = 6,
                $title = 'Doutorado acadêmico'
                ); ?>

              <?php echo PPGBadges::capes(
                $rate = 6,
                $title = 'Outro '
                ); ?>
            </div>
          </div>
        </section>


        <section class="u-col-to-line">
          <?php echo PPG::externos(
            $type = 'sucupira',
            $link = 'https://repositorio.unifesp.br/handle/11600/6108'
            ); ?>
          <?php echo PPG::externos(
            $type = 'dataverse',
            $link = 'https://repositoriodedados.unifesp.br/dataverse/eflch'
            ); ?>

          <?php echo PPG::externos(
            $type = 'DSpace',
            $link = 'https://sucupira.capes.gov.br/sucupira/public/consultas/coleta/programa/viewPrograma.xhtml;jsessionid=OLRUfmVYapfO6QJKy+Wf0KS1.sucupira-218?popup=true&cd_programa=33009015089P5'
            ); ?>

        </section>

        <hr class="c-line u-my-2" />


        <section class="l-ppg">
          <h3 class="t t-title">Tags</h3>

          <div>
            <ul class="tag-cloud" role="navigation" aria-label="Tags mais usadas">
              <?php foreach ($tagsFake as $tag) {
                echo "<li> <a class='tag' data-weight={$tag['amount']}> {$tag['tag']}</a> </li>";
                }
                unset($tagt);
                unset($category);
                unset($amount);
              ?>
            </ul>
          </div> <!-- end -->
        </section>

        <hr class="c-line u-my-2" />

        <section class="l-ppg">
          <?php
            $legends = array(
              "Artigos publicados",
              "Textos em jornais e revistas",
              "Participação em eventos",
              "Outras produções"
            );

            GraphBar::graph(
              $title = 'Produção nos últimos anos',
              $arrData = $infosToGraph,
              $arrLegends = $legends
            );
          ?>
        </section>


        <section class="l-ppg">
          <?php
            $legends2 = array(
              "Artigos publicados",
              "Textos em jornais e revistas",
              "Participação em eventos",
              "Outras produções"
            );

            GraphBar::graph3(
              $title = 'Orientações concluídas',
              $arrData = $infosToGraph,
              $arrLegends = $legends
            );
          ?>
        </section>

        <hr class="c-line u-my-2" />

        <section class="l-ppg">
          <h3 class='t t-title'>Nossos pesquisadores</h3>

          <ul class="p-ppg-orientadores">

            <li>
              <?php
                Who::ppg(
                  $picture = "inc/images/tmp/profile.jpg",
                  $name = 'Sebastião',
                  $title = 'Professor',
                  $link = 'https://unifesp.br/prodmais/index.php'
                )
              ?>
            </li>
            <li>
              <?php
                Who::ppg(
                  $picture = "inc/images/tmp/profile.jpg",
                  $name = 'Sócrates',
                  $title = 'Professor',
                  $link = 'https://unifesp.br/prodmais/index.php'
                )
              ?>
            </li>
            <li>
              <?php
                  Who::ppg(
                    $picture = "inc/images/tmp/profile.jpg",
                    $name = 'Sêneca',
                    $title = 'Professor',
                    $link = 'https://unifesp.br/prodmais/index.php'
                  )
                ?>
            </li>
            <li>
              <?php
                  Who::ppg(
                    $picture = "inc/images/tmp/profile.jpg",
                    $name = 'Salomão',
                    $title = 'Professor',
                    $link = 'https://unifesp.br/prodmais/index.php'
                  )
                ?>
            </li>
          </ul>

        </section>

        <hr class="c-line u-my-2" />

        <section>
          <div class="u-center">
            <p class="t t-gray u-mt-1"><b>Código CAPES</b></p>
            <p class="t t-gray u-mb-1">33009015088p9</p>
          </div>

          <table>
            <thead>
              <tr class="thead">
                <th>Avaliação</th>
                <th>MA</th>
                <th>DO</th>
                <th>MP</th>
                <th>Portaria/Parecer</th>
                <th>Data D.O.U.</th>
                <th>Seção D.O.U.</th>
                <th>Página D.O.U.</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>Quadrienal 2013/2014/2015/2016</th>
                <th>4</th>
                <th>3</th>
                <th>5</th>
                <th>Portaria MEC 609, de 14/03/2019</th>
                <th>18/03/2019</th>
                <th>1</th>
                <th>78</th>
              </tr>
            </tbody>
          </table>


        </section>

      </div> <!-- c-wrapper-inner -->
    </div> <!-- c-wrapper-paper -->
  </main> <!-- c-wrapper-container -->


  </div> <!-- end result-container -->

  <?php include('inc/footer.php'); ?>
  <script>

  </script>
</body>


</html>