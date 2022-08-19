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
    <i class="i i-logo-header siteheader-logo"></i>
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
        <a class="sitemenu-link" href="ppgs.php" title="Programas de pós graduação">
          <i class="i i-ppg-logo sitemenu-icons"></i>
        </a>
      </li>
      <li class=" sitemenu-item">
        <a class="sitemenu-link" href="projetos.php" title="Projetos de pesquisa">
          <i class="i i-project sitemenu-icons"></i>
        </a>
      </li>

      <li class="sitemenu-item">
        <a class="sitemenu-link" href="predash.php" title="Dashboard">
          <i class="i i-dashboard sitemenu-icons"></i>
        </a>
      </li>

      <li class="sitemenu-item">
        <a class="sitemenu-link" href="manual" title="Manual">
          <i class="i i-manual sitemenu-icons"></i>
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