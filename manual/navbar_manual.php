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

  <a href="<?php echo $url_base; ?>/index.php">
    <?php include 'assets/img/logos/prodmais_navbar.svg'; ?>
  </a>

  <a class="u-skip" href="#skipmenu">Pular menu principal</a>

  <nav class="" title="Menu do prodmais" aria-labelledby="Menu principal">
    <ul class="sitemenu">

      <li class="sitemenu-item" title="Home">
        <a class="sitemenu-link" href="<?php echo $url_base; ?>/index.php" title="Home">
          <svg class="sitemenu-ico" viewBox="0 0 30 30">
            <title>home</title>
            <g id="Camada_1" data-name="Camada 1">
              <polygon class="cls-1"
                points="15 2.33 0.1 15.74 4.57 15.74 4.57 27.67 11.24 27.67 11.24 19.76 18.76 19.76 18.76 27.67 25.43 27.67 25.43 15.74 29.9 15.74 15 2.33" />
            </g>
          </svg>
        </a>

      </li>

      <li class="sitemenu-item">
        <a class="sitemenu-link" href="<?php echo $url_base; ?>/result_autores.php" title="Pesquisadores">
          <svg class="sitemenu-ico" x="0px" y="0px" viewBox="0 0 24 24">
            <path
              d="M12.7,23.3c-0.4,0-0.9,0-1.3,0c-0.1,0-0.1,0-0.2,0c-1.6-0.1-3-0.5-4.4-1.3c-3.6-2-5.6-5.2-5.9-9.3c-0.1-1.8,0.2-3.5,1-5.1 c2-3.9,5.2-6.1,9.6-6.4c2-0.1,3.9,0.3,5.7,1.3c3.1,1.7,5,4.3,5.7,7.9c0.1,0.4,0.1,0.9,0.2,1.3c0,0.4,0,0.9,0,1.3c0,0.1,0,0.1,0,0.2 c-0.1,1.6-0.5,3-1.3,4.4c-1.7,3.1-4.4,5-7.9,5.7C13.5,23.2,13.1,23.2,12.7,23.3z M12,20.4c2,0,3.7-0.6,5.2-1.9 c0.4-0.4,0.7-0.8,0.6-1.4c-0.1-2-1.7-3.6-3.8-3.6c-1.4,0-2.8,0-4.1,0c-2,0-3.5,1.4-3.8,3.3c-0.1,0.6,0.1,1.2,0.6,1.6 C8.3,19.7,10,20.3,12,20.4z M8.4,8.1c0,2,1.7,3.7,3.7,3.7c2,0,3.7-1.7,3.7-3.7c0-2-1.7-3.7-3.7-3.6C10,4.4,8.3,6.1,8.4,8.1z" />
          </svg>
        </a>

      </li>

      <li class="sitemenu-item">
        <a class="sitemenu-link" href="<?php echo $url_base; ?>/manual/" title="Manual">
          <svg class="sitemenu-ico" x="0px" y="0px" viewBox="0 0 24 24">
            <g>
              <path
                d="M6.8,1.2c4.1,0,8.2,0,12.3,0c0,0.1,0,0.2,0,0.3c0,3.5,0,6.9,0,10.4c0,0.1,0,0.2,0,0.3c-3.4,0.1-5.5,1.7-6.4,4.9 c-1.9,0-3.9,0-5.8,0c0-0.1,0-0.2,0-0.3c0-1.8,0-3.5,0-5.3C6.8,8.1,6.8,4.7,6.8,1.2z M16.4,9.1c0-0.4,0-0.8,0-1.3 c-2.4,0-4.8,0-7.2,0c0,0.4,0,0.8,0,1.3C11.7,9.1,14.1,9.1,16.4,9.1z M15,5c-1.4,0-2.8,0-4.3,0c0,0.4,0,0.8,0,1.3c1.4,0,2.8,0,4.3,0 C15,5.9,15,5.5,15,5z" />
              <path
                d="M5.5,1.2c0,0.8,0,1.7,0,2.5c0,4.3,0,8.7,0,13c0,0.1,0,0.2,0,0.3c-0.1,0-0.2,0-0.2,0c-0.5,0-1,0-1.6,0c-0.8,0-1.4,0.4-2,0.9 c0-0.1,0-0.2,0-0.2c0-4.5,0-9.1,0-13.6c0-1.5,1-2.6,2.4-2.8h0.1C4.6,1.2,5.1,1.2,5.5,1.2z" />
              <path
                d="M1.6,20.4c0.1-0.3,0.2-0.6,0.3-0.9c0.5-0.8,1.2-1.3,2.1-1.3c2.8,0,5.6,0,8.4,0h0.1c0.1,0.6,0.2,1.2,0.3,1.8 c-2.6,0-5.2,0-7.8,0c0,0.4,0,0.9,0,1.3c0.1,0,0.2,0,0.3,0c2.7,0,5.3,0,8,0c0.2,0,0.2,0,0.3,0.2c0.4,0.6,0.9,1.1,1.5,1.6 c-0.1,0-0.1,0-0.2,0c-3.6,0-7.1,0-10.7,0c-1.2,0-2.2-0.8-2.4-2V21C1.6,20.8,1.6,20.6,1.6,20.4z" />
              <path
                d="M13.8,18.3c0-2.7,2.2-4.9,4.9-4.9s4.9,2.2,4.9,4.9s-2.2,4.9-4.9,4.9C16,23.2,13.8,21,13.8,18.3z M18.1,20.8 c0.4,0,0.8,0,1.3,0c0-1.1,0-2.2,0-3.3c-0.4,0-0.8,0-1.3,0C18.1,18.6,18.1,19.7,18.1,20.8z M18.7,15.4c-0.3,0-0.7,0.3-0.7,0.6 c0,0.4,0.3,0.7,0.6,0.7c0.3,0,0.7-0.3,0.7-0.6C19.3,15.7,19,15.4,18.7,15.4z" />
            </g>
          </svg>
        </a>

      </li>

      <li class="sitemenu-item">
        <a class="sitemenu-link" href="<?php echo $url_base; ?>/pre_dash.php" title="Dashboard">
          <svg class="sitemenu-ico" x="0px" y="0px" viewBox="0 0 24 24">
            <path
              d="M21,16V4H3v12H21 M21,2c1.1,0,2,0.9,2,2v12c0,1.1-0.9,2-2,2h-7v2h2v2H8v-2h2v-2H3c-1.1,0-2-0.9-2-2V4c0-1.1,0.9-2,2-2H21 M5,6h9v5H5V6 M15,6h4v2h-4V6 M19,9v5h-4V9H19 M5,12h4v2H5V12 M10,12h4v2h-4V12z" />
          </svg>
        </a>
      </li>

      <li class="sitemenu-item">
        <a class="sitemenu-link" href="<?php echo $url_base; ?>/sobre.php" title="Sobre o Prodmais">
          <svg class="sitemenu-ico" x="0px" y="0px" viewBox="0 0 24 24">
            <path
              d="M12,0C5.4,0,0,5.4,0,12s5.4,12,12,12s12-5.4,12-12S18.6,0,12,0z M14.5,17.7c-0.2,0.1-1.8,1.2-2.4,1.6 c-0.6,0.4-3,1.8-2.6-0.9c0.9-5.3,2.7-8.4,0.6-7.1C9.6,11.7,9.2,11.9,9,12c-0.2,0.1-0.2,0.1-0.3-0.2c-0.2-0.3-0.2-0.3,0-0.4 c0,0,3.2-2.6,4.4-2.7c1.2-0.1,0.9,1.3,0.8,1.9c-0.7,2.7-1.9,6.6-1.7,7.2c0.2,0.6,1.3-0.3,2-0.8c0,0,0.1-0.1,0.2,0 C14.6,17.4,14.8,17.5,14.5,17.7z M13.5,7C12.7,7,12,6.3,12,5.5S12.7,4,13.5,4S15,4.7,15,5.5S14.3,7,13.5,7z" />
          </svg>
        </a>
      </li>
    </ul>
  </nav>
  <div class="u-skip" id="skipmenu"></div>
</header>