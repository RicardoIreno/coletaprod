<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<head>
  <?php
  require 'inc/config.php';
  require 'inc/meta-header.php';
  require 'inc/functions.php';
  require 'components/Production.php';
  require 'components/ProfilePic.php';
  require '_fakedata.php';
  ?>
  <meta charset="utf-8" />
  <title><?php echo $branch; ?> - PPG</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta name="description" content="Prodmais Unifesp." />
  <meta name="keywords" content="Produção acadêmica, lattes, ORCID" />
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <link rel="stylesheet" href="sass/main.css" />
</head>

<body class="cc-wrapper-body">
  <?php if(file_exists('inc/google_analytics.php')){include 'inc/google_analytics.php';}?>

  <?php require 'inc/navbar.php'; ?>
  <main class="cc-wrapper-container">
    <div class="cc-wrapper-paper">

      <div class="cc-wrapper-inner">

        <section class="ppg-header">

          <div class=".ppg-header-side1">
            <h1 class="ty ty-h1">PPG Letras</h1>
            <h2 class="ty ty-h2">Programa de Pós Graduação em Letras</h2>
            <p class="ty ty-b ty-light">
              <span>Campus Guarulhos</span>
              <span>Escola de Filosofia, Letras e ciências Humanas</span>
            </p>

            <p class="ty ty-b ty-gray">Estrada do Caminho Velho nª 123 - Bairro, Cidade - SP</p>
            <p class="ty ty-gray">email@email.com</p>
          </div>

          <div class="ppg-header-side2">

            <div class="u-icon-text ppg-header-infos">
              <i class="i i-star4 ppg-header-i"></i> Mestrado acadêmico
            </div>

            <div class="u-icon-text ppg-header-infos">
              <i class="i i-star5 ppg-header-i"></i> Doutorado acadêmico
            </div>

            <div class="u-icon-text ppg-header-infos">
              <i class="i i-book-school ppg-header-i"></i> 30 alunos em curso
            </div>

            <div class="u-icon-text ppg-header-infos">
              <i class="i i-shool-hat ppg-header-i"></i> 130 alunos formados
            </div>

          </div>

        </section>
        <hr class="c-line u-my-2" />

        <section class="l-ppg">
          <h3>Coordenação</h3>

          <?php
            ProfilePic::ppg(
              $picture = "inc/images/tmp/profile.jpg",
              $name = 'Sócrates',
              $link = 'https://unifesp.br/prodmais/index.php'
            )
          ?>

        </section>

        <hr class="c-line  u-my-2" />

        <section class="l-ppg">
          gráfico
        </section>

        <hr class="c-line u-my-2" />


        <section class="l-ppg">
          <h3>Tags</h3>

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
          <h3 class='ty'>Nossos orientadores</h3>

          <ul class="ppg-orientadores">
            <li>
              <?php
                ProfilePic::ppg(
                  $picture = "inc/images/tmp/profile.jpg",
                  $name = 'Sebastião',
                  $link = 'https://unifesp.br/prodmais/index.php'
                )
              ?>
            </li>
            <li>
              <?php
                ProfilePic::ppg(
                  $picture = "inc/images/tmp/profile.jpg",
                  $name = 'Sócrates',
                  $link = 'https://unifesp.br/prodmais/index.php'
                )
              ?>
            </li>
            <li>
              <?php
                  ProfilePic::ppg(
                    $picture = "inc/images/tmp/profile.jpg",
                    $name = 'Sêneca',
                    $link = 'https://unifesp.br/prodmais/index.php'
                  )
                ?>
            </li>
            <li>
              <?php
                  ProfilePic::ppg(
                    $picture = "inc/images/tmp/profile.jpg",
                    $name = 'Salomão',
                    $link = 'https://unifesp.br/prodmais/index.php'
                  )
                ?>
            </li>
          </ul>

        </section>



      </div> <!-- cc-wrapper-inner -->
    </div> <!-- cc-wrapper-paper -->
  </main> <!-- cc-wrapper-container -->


  </div> <!-- end result-container -->

  <?php include('inc/footer.php'); ?>
  <script>

  </script>
</body>

</html>