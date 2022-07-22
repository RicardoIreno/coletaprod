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

        <section class="l-ppg-header">

          <div class=".l-ppg-header-s1">
            <h1 class="ty ty-ppg-sigla">PPG Letras</h1>
            <h2 class="ty ty-ppg-name">Programa de Pós Graduação em Letras</h2>
            <p class="ty ty-ppg-location">
              <span>Campus Guarulhos</span>
              <span>Escola de Filosofia, Letras e ciências Humanas</span>
            </p>

            <p class="ty ">Estrada do Caminho Velho nª 123 - Bairro, Cidade - SP</p>
            <p class="ty ">email@email.com</p>
          </div>

          <div class="l-ppg-header-s2">
            <div class="u-grid">
              <div class="u-col-1-of-2">
                <div class="s-line">
                  <!-- <img class="s-line-icon" src="inc/images/icons/profile.svg" title="titulo" alt="titulo" /> -->
                  <div class="imgTest"></div>
                  30 alunos em curso
                </div>

                <div class="s-line">
                  <img class="s-line-icon" src="inc/images/icons/profile.svg" title="titulo" alt="titulo" />
                  130 alunos formados
                </div>
              </div>
              <div class="u-col-1-of-2">
                <div class="s-line">
                  <img class="s-line-icon" src="inc/images/icons/profile.svg" title="titulo" alt="titulo" />
                  Mestrado acadêmico
                </div>

                <div class="s-line">
                  <img class="s-line-icon" src="inc/images/icons/profile.svg" title="titulo" alt="titulo" />
                  Doutorado acadêmico
                </div>
              </div>

            </div>

            <svg class="svgTest" xmlns="http://www.w3.org/2000/svg" viewport="0 0 5 5">
              <path
                d="M 2.4623527,5.2328075 C 2.2017053,5.2062168 1.9534795,5.1528786 1.7618475,5.0822831 1.607875,5.0255614 1.3490949,4.8948515 1.2209574,4.8090803 0.60097875,4.3940876 0.18871322,3.7480896 0.08099449,3.0228064 -0.02179499,2.3307314 0.15513629,1.6386784 0.58043826,1.0693073 0.67598463,0.94139394 0.95162862,0.66574816 1.0795458,0.57020146 1.2827586,0.4184084 1.5308336,0.2830541 1.7618475,0.19792464 2.0621609,0.08725953 2.4186796,0.03141604 2.7415399,0.04447051 3.3182802,0.06779051 3.8395867,0.26290837 4.2873429,0.6230382 4.4098262,0.7215506 4.6247939,0.94365854 4.7196212,1.0696707 5.2059938,1.71599 5.365545,2.5323386 5.1586323,3.3158847 5.0775142,3.6230708 4.9209204,3.9422233 4.7192559,4.21138 4.6286272,4.3323418 4.412807,4.5554304 4.2897553,4.6553457 3.9319784,4.9458546 3.4906766,5.1401953 3.0308756,5.2097337 2.9044663,5.228851 2.5604391,5.2428137 2.4623527,5.2328075 Z M 2.951677,4.9593906 C 3.2062237,4.926342 3.4422133,4.8542599 3.6806211,4.7367341 3.9348083,4.6114309 4.1246369,4.4739059 4.3238136,4.2707623 L 4.4289459,4.1635418 4.4056334,4.1250837 C 4.3133056,3.9726251 4.1141926,3.7479462 3.9649928,3.6278696 3.5481866,3.2924075 3.0132289,3.1236895 2.5005458,3.1660009 2.085775,3.2002319 1.7350034,3.3314435 1.4014262,3.5771485 1.2295516,3.7037473 0.99372448,3.958684 0.89387521,4.1258332 l -0.0234282,0.039206 0.13604759,0.1341419 c 0.2030795,0.200238 0.3829277,0.327572 0.6335079,0.448535 0.2178325,0.1051575 0.4622076,0.1792079 0.6954251,0.2107312 0.1469847,0.019868 0.4666962,0.020356 0.6162266,9.394e-4 z M 0.95913846,3.6263695 C 1.2381054,3.3358568 1.5617082,3.1335802 1.9445895,3.0103903 c 0.055845,-0.017965 0.1015191,-0.034644 0.1015191,-0.037064 0,-0.00241 -0.029691,-0.029601 -0.065989,-0.060403 C 1.8017397,2.7615332 1.6805785,2.5566654 1.6326256,2.3253496 1.603862,2.1866957 1.6114008,1.9728767 1.6495011,1.8429833 1.7047087,1.6549935 1.7946416,1.5060834 1.9327708,1.3739185 2.0292742,1.2815796 2.101276,1.2318604 2.2167308,1.1778319 2.4840704,1.0527313 2.8152816,1.0520578 3.0799305,1.1760747 c 0.1219497,0.057146 0.1895212,0.1034258 0.2853749,0.1954472 0.1406229,0.1350023 0.2300338,0.2826586 0.285485,0.4714592 0.038157,0.1298934 0.04564,0.3437124 0.016875,0.4823663 -0.047495,0.2289625 -0.1700478,0.436979 -0.3450016,0.5854577 -0.034911,0.029638 -0.06234,0.057271 -0.060914,0.061403 0.00116,0.00414 0.061975,0.027195 0.1345628,0.051247 0.2479358,0.082155 0.5181285,0.2314304 0.7325744,0.4047348 0.1499421,0.1211757 0.3542105,0.3433922 0.4509167,0.4905336 l 0.016006,0.024327 0.052714,-0.087241 C 4.7217611,3.7345628 4.8145065,3.5381503 4.8583305,3.4115008 4.9451317,3.1606477 4.9851689,2.9192216 4.9851689,2.6466398 4.9851689,2.2519567 4.9080927,1.9241369 4.7349425,1.5823726 4.3990515,0.91939617 3.7679038,0.45693183 3.0256507,0.32990818 2.8927579,0.30716592 2.549879,0.29880991 2.4044021,0.31476829 1.8759278,0.37274015 1.4068135,0.59231301 1.027748,0.95912164 0.82191959,1.1582954 0.67718505,1.3566195 0.55312439,1.6094803 0.44734256,1.8250864 0.38910195,2.0018991 0.34411815,2.2439946 0.31442663,2.40388 0.30706174,2.7545408 0.32967833,2.932122 0.37056216,3.2530967 0.48340151,3.5770524 0.65080484,3.8541935 l 0.0517281,0.085625 0.077198,-0.1035067 C 0.82218054,3.7793828 0.90291596,3.684908 0.95912687,3.6263675 Z M 2.849595,2.8729504 C 3.1378521,2.7996692 3.3639658,2.5533146 3.4175439,2.2541486 3.4354052,2.1544063 3.4351732,2.0930069 3.4163841,1.9864037 3.3743404,1.7453418 3.2162794,1.5320389 3.0015552,1.426606 2.8687437,1.3613935 2.8014913,1.3459711 2.6499485,1.3459711 c -0.1515427,0 -0.2187892,0.015423 -0.3516008,0.080635 -0.1935284,0.095023 -0.3489275,0.287297 -0.4040134,0.49987 -0.078213,0.3018389 0.043494,0.6427223 0.2924904,0.8193003 0.2030795,0.1440077 0.4271519,0.1870177 0.66255,0.1271739 z" />
            </svg>
          </div>

        </section>
        <hr class=" c-line" />

        <section class="l-ppg">
          gráfico
        </section>

        <hr class=" c-line" />

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

        <hr class=" c-line" />

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