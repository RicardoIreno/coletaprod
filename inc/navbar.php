<?php 
  if (file_exists('../inc/config.php')) {
      require '../inc/config.php';
  } elseif (file_exists('../../inc/config.php')) {
      require '../../inc/config.php';
  } elseif (file_exists('inc/config.php')) {
      require 'inc/config.php';
  } else {
      die('No config file found');
  }
?>

<header class="siteheader">

  <a href="index.php">
    <?php include $logo_navbar; ?>
  </a>

  <a class="u-skip" href="#skipmenu">Pular menu principal</a>

  <nav class="" title="Menu do prodmais" aria-labelledby="Menu principal">
    <ul class="sitemenu">

      <li class="sitemenu-item" title="Home">
        <a class="sitemenu-link" href="index.php" title="Home">
          <i class="i i-home sitemenu-icons"></i>
        </a>
      </li>

      <li class=" sitemenu-item">
        <a class="sitemenu-link" href="result_autores.php" title="Pesquisadores">
          <i class="i i-aboutme sitemenu-icons"></i>
        </a>
      </li>

      <li class=" sitemenu-item">
        <a class="sitemenu-link" href="ppg.php" title="Programas de pós graduação">
          <i class="i i-ppg-ico sitemenu-icons"></i>
        </a>
      </li>

      <li class="sitemenu-item">
        <a class="sitemenu-link" href="manual" title="Manual">
          <i class="i i-manual sitemenu-icons"></i>
        </a>
      </li>

      <li class="sitemenu-item">
        <a class="sitemenu-link" href="pre_dash.php" title="Dashboard">
          <i class="i i-dashboard sitemenu-icons"></i>
        </a>
      </li>

      <li class="sitemenu-item">
        <a class="sitemenu-link" href="sobre.php" title="Sobre o Prodmais">
          <i class="i i-about sitemenu-icons"></i>
        </a>
      </li>
    </ul>
  </nav>
  <div class="u-skip" id="skipmenu"></div>
</header>