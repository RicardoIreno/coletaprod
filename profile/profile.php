<?php
// Set directory to ROOT
chdir('../');
// Include essencial files
require 'inc/config.php';
require 'inc/functions.php';

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
?>

<!DOCTYPE HTML>

<html lang="pt-br"><head>
  <title>Prodmais — Perfil do usuário - <?php echo $profile["nome_completo"] ?></title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta name="description" content="Prodmais Unifesp." />
  <meta name="keywords" content="Produção acadêmica, lattes, ORCID" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head><body><header class="siteHeader">

  <svg class="logo siteHeader-logo" alt="Logomarca Prodmais" viewBox="0 0 300 169"><path d="M150.7 101.4h-16.2c-0.7 0-1.3-0.6-1.3-1.3v-15c-8.6-0.6-15.5-7.5-16.1-16.1h-15c-9.6 0-17.4-7.8-17.4-17.4 0-9.2 7.2-16.8 16.2-17.4 0.6-18 15.5-32.4 33.6-32.4 6.2 0 12.2 1.7 17.4 4.9 4.4-3.2 9.5-4.9 15-4.9 10.5 0 19.9 6.5 23.7 16.2h0.5c14.1 0 25.5 11.5 25.5 25.5s-11.5 25.5-25.5 25.5h-23.5l-15.8 31.7C151.6 101.2 151.2 101.4 150.7 101.4zM135.8 98.9h14.1l15.8-31.7c0.2-0.4 0.7-0.7 1.1-0.7h24.3c12.7 0 23-10.3 23-23s-10.3-23-23-23h-1.4c-0.5 0-1-0.3-1.2-0.8 -3.2-9.2-12-15.3-21.7-15.3 -5.1 0-10 1.7-14.1 4.9 -0.4 0.3-1 0.4-1.5 0.1 -5-3.2-10.8-4.9-16.8-4.9 -17.2 0-31.1 14-31.1 31.1 0 0.7-0.6 1.3-1.3 1.3 -8.2 0-14.9 6.7-14.9 14.9 0 8.2 6.7 14.9 14.9 14.9h16.2c0.7 0 1.3 0.6 1.3 1.3 0 8.2 6.7 14.9 14.9 14.9 0.7 0 1.3 0.6 1.3 1.3V98.9z"/><path d="M150.7 84.6h-16.2c-9.3 0-16.8-7.5-16.8-16.8S125.3 51 134.5 51h16.2c0.3 0 0.6 0.3 0.6 0.6V84C151.3 84.3 151.1 84.6 150.7 84.6zM134.5 52.2c-8.6 0-15.6 7-15.6 15.6s7 15.6 15.6 15.6h15.6V52.2H134.5z"/><path d="M166.9 68.4h-64.7c-0.3 0-0.6-0.3-0.6-0.6V35.4c0-18.2 14.8-33 33-33s33 14.8 33 33v32.4C167.5 68.1 167.2 68.4 166.9 68.4zM102.8 67.2h63.5V35.4c0-17.5-14.2-31.7-31.7-31.7 -17.5 0-31.7 14.2-31.7 31.7V67.2z"/><path d="M150.7 100.8h-16.2c-0.3 0-0.6-0.3-0.6-0.6V67.8c0-0.3 0.3-0.6 0.6-0.6h32.4c0.2 0 0.4 0.1 0.5 0.3 0.1 0.2 0.1 0.4 0 0.6l-16.2 32.4C151.2 100.7 151 100.8 150.7 100.8zM135.2 99.5h15.2l15.6-31.1h-30.7V99.5z"/><path d="M118.3 68.4h-16.2c-9.3 0-16.8-7.5-16.8-16.8 0-9.3 7.5-16.8 16.8-16.8h16.2c0.3 0 0.6 0.3 0.6 0.6v32.4C119 68.1 118.7 68.4 118.3 68.4zM102.2 36.1c-8.6 0-15.6 7-15.6 15.6 0 8.6 7 15.6 15.6 15.6h15.6V36.1H102.2z"/><path d="M191.2 68.4h-24.3c-0.3 0-0.6-0.3-0.6-0.6V19.3c0-0.3 0.3-0.6 0.6-0.6h24.3c13.7 0 24.9 11.2 24.9 24.9S204.9 68.4 191.2 68.4zM167.5 67.2h23.6c13 0 23.6-10.6 23.6-23.6s-10.6-23.6-23.6-23.6h-23.6V67.2z"/><path d="M191.2 52.2h-48.5c-0.3 0-0.6-0.3-0.6-0.6V27.3c0-13.7 11.2-24.9 24.9-24.9 13.7 0 24.9 11.2 24.9 24.9v24.3C191.8 52 191.5 52.2 191.2 52.2zM143.3 51h47.3V27.3c0-13-10.6-23.6-23.6-23.6s-23.6 10.6-23.6 23.6V51z"/><path d="M158.4 167h-32c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v32C170.4 161.6 165 167 158.4 167zM126.4 118.4c-2.5 0-4.5 2-4.5 4.5v32c0 2.5 2 4.5 4.5 4.5h32c2.5 0 4.5-2 4.5-4.5v-32c0-2.5-2-4.5-4.5-4.5H126.4z"/><path d="M4.7 166.9c-2.1 0-3.8-1.7-3.8-3.8v-48.5c0-2.1 1.7-3.8 3.8-3.8s3.8 1.7 3.8 3.8v48.5C8.5 165.2 6.8 166.9 4.7 166.9z"/><path d="M232 133.2c-2.1 0-3.8-1.7-3.8-3.8V80.8c0-2.1 1.7-3.8 3.8-3.8 2.1 0 3.8 1.7 3.8 3.8v48.5C235.7 131.5 234 133.2 232 133.2z"/><path d="M272.5 133.2c-2.1 0-3.8-1.7-3.8-3.8V80.8c0-2.1 1.7-3.8 3.8-3.8s3.8 1.7 3.8 3.8v48.5C276.2 131.5 274.5 133.2 272.5 133.2z"/><path d="M296.7 108.9h-48.5c-2.1 0-3.8-1.7-3.8-3.8s1.7-3.8 3.8-3.8h48.5c2.1 0 3.8 1.7 3.8 3.8C300.5 107.2 298.8 108.9 296.7 108.9z"/><path d="M29 134.5H4.7c-2.1 0-3.8-1.7-3.8-3.8V90.1c0-6.4 5.2-11.7 11.7-11.7H29C44.5 78.4 57 91 57 106.5S44.5 134.5 29 134.5zM8.5 127H29c11.3 0 20.5-9.2 20.5-20.5S40.3 86 29 86H12.6c-2.3 0-4.1 1.8-4.1 4.1V127z"/><path d="M224.2 165.5h-16.6c-15.5 0-28.1-12.6-28.1-28.1 0-15.5 12.6-28.1 28.1-28.1H232c2.1 0 3.8 1.7 3.8 3.8V154C235.7 160.4 230.6 165.5 224.2 165.5zM207.7 117c-11.3 0-20.5 9.2-20.5 20.5 0 11.3 9.2 20.5 20.5 20.5h16.6c2.2 0 3.9-1.8 3.9-3.9v-37H207.7z"/><path d="M69.6 167c-2.1 0-3.8-1.7-3.8-3.8v-40.6c0-6.5 5.3-11.8 11.8-11.8H102c2.1 0 3.8 1.7 3.8 3.8s-1.7 3.8-3.8 3.8H77.6c-2.3 0-4.2 1.9-4.2 4.2v40.6C73.4 165.3 71.7 167 69.6 167z"/></svg> 
  <a class="u-skip" href="#skipmenu">Pular menu principal</a>

  <nav class="" title="Menu do prodmais" aria-labelledby="Menu principal">
    <ul class="mainMenu">
  
      <li class="mainMenu-item" title="Home">
        <a class="mainMenu-link" href="index.php" title="Home"><svg class="mainMenu-ico" x="0px" y="0px" viewBox="0 0 24 24"><path d="M10,20v-6h4v6h5v-8h3L12,3L2,12h3v8H10z"/></svg>
</a>
  
      </li>
  
      <li class="mainMenu-item">
        <a class="mainMenu-link" href="" title="Pesquisadores"><svg class="mainMenu-ico" x="0px" y="0px" viewBox="0 0 24 24"><path d="M12.7,23.3c-0.4,0-0.9,0-1.3,0c-0.1,0-0.1,0-0.2,0c-1.6-0.1-3-0.5-4.4-1.3c-3.6-2-5.6-5.2-5.9-9.3c-0.1-1.8,0.2-3.5,1-5.1
	c2-3.9,5.2-6.1,9.6-6.4c2-0.1,3.9,0.3,5.7,1.3c3.1,1.7,5,4.3,5.7,7.9c0.1,0.4,0.1,0.9,0.2,1.3c0,0.4,0,0.9,0,1.3c0,0.1,0,0.1,0,0.2
	c-0.1,1.6-0.5,3-1.3,4.4c-1.7,3.1-4.4,5-7.9,5.7C13.5,23.2,13.1,23.2,12.7,23.3z M12,20.4c2,0,3.7-0.6,5.2-1.9
	c0.4-0.4,0.7-0.8,0.6-1.4c-0.1-2-1.7-3.6-3.8-3.6c-1.4,0-2.8,0-4.1,0c-2,0-3.5,1.4-3.8,3.3c-0.1,0.6,0.1,1.2,0.6,1.6
	C8.3,19.7,10,20.3,12,20.4z M8.4,8.1c0,2,1.7,3.7,3.7,3.7c2,0,3.7-1.7,3.7-3.7c0-2-1.7-3.7-3.7-3.6C10,4.4,8.3,6.1,8.4,8.1z"/></svg>

</a>
  
      </li>    
      
      <li class="mainMenu-item">
        <a class="mainMenu-link" href="" title="Manual"><svg class="mainMenu-ico" x="0px" y="0px" viewBox="0 0 24 24"><g><path d="M6.8,1.2c4.1,0,8.2,0,12.3,0c0,0.1,0,0.2,0,0.3c0,3.5,0,6.9,0,10.4c0,0.1,0,0.2,0,0.3c-3.4,0.1-5.5,1.7-6.4,4.9
		c-1.9,0-3.9,0-5.8,0c0-0.1,0-0.2,0-0.3c0-1.8,0-3.5,0-5.3C6.8,8.1,6.8,4.7,6.8,1.2z M16.4,9.1c0-0.4,0-0.8,0-1.3
		c-2.4,0-4.8,0-7.2,0c0,0.4,0,0.8,0,1.3C11.7,9.1,14.1,9.1,16.4,9.1z M15,5c-1.4,0-2.8,0-4.3,0c0,0.4,0,0.8,0,1.3c1.4,0,2.8,0,4.3,0
		C15,5.9,15,5.5,15,5z"/><path d="M5.5,1.2c0,0.8,0,1.7,0,2.5c0,4.3,0,8.7,0,13c0,0.1,0,0.2,0,0.3c-0.1,0-0.2,0-0.2,0c-0.5,0-1,0-1.6,0c-0.8,0-1.4,0.4-2,0.9
		c0-0.1,0-0.2,0-0.2c0-4.5,0-9.1,0-13.6c0-1.5,1-2.6,2.4-2.8h0.1C4.6,1.2,5.1,1.2,5.5,1.2z"/><path d="M1.6,20.4c0.1-0.3,0.2-0.6,0.3-0.9c0.5-0.8,1.2-1.3,2.1-1.3c2.8,0,5.6,0,8.4,0h0.1c0.1,0.6,0.2,1.2,0.3,1.8
		c-2.6,0-5.2,0-7.8,0c0,0.4,0,0.9,0,1.3c0.1,0,0.2,0,0.3,0c2.7,0,5.3,0,8,0c0.2,0,0.2,0,0.3,0.2c0.4,0.6,0.9,1.1,1.5,1.6
		c-0.1,0-0.1,0-0.2,0c-3.6,0-7.1,0-10.7,0c-1.2,0-2.2-0.8-2.4-2V21C1.6,20.8,1.6,20.6,1.6,20.4z"/><path d="M13.8,18.3c0-2.7,2.2-4.9,4.9-4.9s4.9,2.2,4.9,4.9s-2.2,4.9-4.9,4.9C16,23.2,13.8,21,13.8,18.3z M18.1,20.8
		c0.4,0,0.8,0,1.3,0c0-1.1,0-2.2,0-3.3c-0.4,0-0.8,0-1.3,0C18.1,18.6,18.1,19.7,18.1,20.8z M18.7,15.4c-0.3,0-0.7,0.3-0.7,0.6
		c0,0.4,0.3,0.7,0.6,0.7c0.3,0,0.7-0.3,0.7-0.6C19.3,15.7,19,15.4,18.7,15.4z"/></g></svg>
</a>
  
      </li>    
      
      <li class="mainMenu-item">
        <a class="mainMenu-link" href="" title="Dashboard"><svg class="mainMenu-ico" x="0px" y="0px" viewBox="0 0 24 24"><path d="M21,16V4H3v12H21 M21,2c1.1,0,2,0.9,2,2v12c0,1.1-0.9,2-2,2h-7v2h2v2H8v-2h2v-2H3c-1.1,0-2-0.9-2-2V4c0-1.1,0.9-2,2-2H21
	 M5,6h9v5H5V6 M15,6h4v2h-4V6 M19,9v5h-4V9H19 M5,12h4v2H5V12 M10,12h4v2h-4V12z"/></svg>
</a>
      </li>
  
      <li class="mainMenu-item">
        <a class="mainMenu-link" href="" title="Sobre o Prodmais"><svg class="mainMenu-ico" x="0px" y="0px" viewBox="0 0 24 24"><path d="M12,0C5.4,0,0,5.4,0,12s5.4,12,12,12s12-5.4,12-12S18.6,0,12,0z M14.5,17.7c-0.2,0.1-1.8,1.2-2.4,1.6
	c-0.6,0.4-3,1.8-2.6-0.9c0.9-5.3,2.7-8.4,0.6-7.1C9.6,11.7,9.2,11.9,9,12c-0.2,0.1-0.2,0.1-0.3-0.2c-0.2-0.3-0.2-0.3,0-0.4
	c0,0,3.2-2.6,4.4-2.7c1.2-0.1,0.9,1.3,0.8,1.9c-0.7,2.7-1.9,6.6-1.7,7.2c0.2,0.6,1.3-0.3,2-0.8c0,0,0.1-0.1,0.2,0
	C14.6,17.4,14.8,17.5,14.5,17.7z M13.5,7C12.7,7,12,6.3,12,5.5S12.7,4,13.5,4S15,4.7,15,5.5S14.3,7,13.5,7z"/></svg>
</a>
      </li>
    </ul>
  </nav>
  <div class="u-skip" id="skipmenu"></div>  
</header>

<main class="profile-container">
      <div class="profile-wrapper"><div class="core"> 

  <div class="core-one">

    <div class="co-photo-wrapper">
      <!-- <img class="co-bestBagde" src="assets/img/badges/bolsista-cnpq-1a.svg"/>  -->
      <div class="co-photo-container">
        <img class="co-photo" src="http://servicosweb.cnpq.br/wspessoa/servletrecuperafoto?tipo=1&amp;bcv=true&amp;id=<?php echo $lattesID10; ?>" />
      </div>
    </div>
    
    <?php if($profile["nacionalidade"]=="B") : ?>
      <img 
        class="country-flag" 
        src="assets/img/country_flags/br.svg" 
        alt="nacionalidade brasileira"
        title="nacionalidade brasileira" 
      />
    <?php endif; ?>
    <!--
    
    <div class="co-badgeIcons">
      
      
        <img 
          class="co-badgeIcons-icon" 
          
            src="assets/img/badges/bolsista-cnpq-1a.svg" 
            alt="Bolsista CNPQ nível 1A"
            title="Bolsista CNPQ nível 1A"
            
        />
      
      
        <img 
          class="co-badgeIcons-icon" 
          
            src="assets/img/badges/member.svg"
            alt="Membro de conselho ou comissão"  
            title="Membro de conselho ou comissão"  
            
        />
      
      
        <img 
          class="co-badgeIcons-icon" 
          
            src="assets/img/badges/leader.svg" 
            alt="Exercedor de cargo de chefia"
            title="Exercedor de cargo de chefia"
            
        />
      
    </div> 
    -->
  </div>

  <div class="core-two">
    <h1 class="ty-name"><?php echo $profile["nome_completo"] ?></h1>
    <!-- <div class="u-spacer-2  "></div> -->
    <h2 class="ty ty-prof">Universidade Federal de São Paulo</h2>
    <p class="ty ty-prof"><?php echo $profile["unidade"][0] ?></p>
    <p class="ty ty-prof"><?php echo $profile["departamento"][0] ?></p>
    <?php if(isset($profile["ppg_nome"])): ?>
      <?php foreach ($profile["ppg_nome"] as $key => $ppg_nome): ?>
        <p class="ty ty-prof">Programa de Pós-Graduação: <?php echo $ppg_nome ?></p>
      <?php endforeach; ?>
    <?php endif; ?>
    <!-- <p class="ty ty-email">bertola@unifesp.br</p> -->
    <div class="u-spacer-1"></div>



    <div class="u-spacer-1"></div>
    
    <h3 class="ty-subtitle">Nomes em citações bibliográficas</h3>

    <p class="ty-prof"><?php echo $profile["nome_em_citacoes_bibliograficas"] ?></p>
  

    <h3 class="ty-subtitle">Perfis na web</h3>
    <div class="co-socialIcons">

      
        <img 
          href="www.google.com.br" 
          class="co-socialIcons-icon" 
          src="assets/img/academic_plataforms/logo_academia_edu.svg"  
          alt="Academia . Edu" 
          title="Academia . Edu" 
        />
      
        <img 
          href="www.google.com.br" 
          class="co-socialIcons-icon" 
          src="assets/img/academic_plataforms/logo_altmetric.svg"  
          alt="Altmetric" 
          title="Altmetric" 
        />
      
        <img 
          href="www.google.com.br" 
          class="co-socialIcons-icon" 
          src="assets/img/academic_plataforms/logo_google_scholar.svg"  
          alt="Google Scholar" 
          title="Google Scholar" 
        />
      
        <img 
          href="www.google.com.br" 
          class="co-socialIcons-icon" 
          src="assets/img/academic_plataforms/logo_innovation_catalyst_global.svg"  
          alt="Innovation Catalyst Global" 
          title="Innovation Catalyst Global" 
        />
      
        <img 
          href="www.google.com.br" 
          class="co-socialIcons-icon" 
          src="assets/img/academic_plataforms/logo_lattes.svg"  
          alt="Lattes" 
          title="Lattes" 
        />
      
        <img 
          href="www.google.com.br" 
          class="co-socialIcons-icon" 
          src="assets/img/academic_plataforms/logo_mendeley.svg"  
          alt="Mendely" 
          title="Mendely" 
        />
      
        <img 
          href="www.google.com.br" 
          class="co-socialIcons-icon" 
          src="assets/img/academic_plataforms/logo_publons.svg"  
          alt="Publons" 
          title="Publons" 
        />
      
        <img 
          href="www.google.com.br" 
          class="co-socialIcons-icon" 
          src="assets/img/academic_plataforms/logo_research_id.svg"  
          alt="Research ID" 
          title="Research ID" 
        />
      
        <img 
          href="www.google.com.br" 
          class="co-socialIcons-icon" 
          src="assets/img/academic_plataforms/logo_researchgate.svg"  
          alt="research Gate" 
          title="research Gate" 
        />
      
        <img 
          href="www.google.com" 
          class="co-socialIcons-icon" 
          src="assets/img/academic_plataforms/logo_zotero.svg"  
          alt="Zotero" 
          title="Zotero" 
        />
      

      <span class="u-vseparator">|</span>
      
      
        <img 
          href="www.google.com" 
          class="co-socialIcons-icon" 
          src="assets/img/social/Twitter.svg"  
          alt="Twitter" 
          title="Twitter" 
        />
      
        <img 
          href="www.google.com" 
          class="co-socialIcons-icon" 
          src="assets/img/social/facebook.svg"  
          alt="Twitter" 
          title="Twitter" 
        />
      
    </div>

  </div>  

  <div class="core-three">

    <div class="co-numbers">
      <span class="co-numbers-number">
        <img class="co-numbers-icon"src="assets/img/icons/article-published.svg" alt="Artigos publicados" />
        45
      </span>

      <span class="co-numbers-number">
        <img class="co-numbers-icon"src="assets/img/icons/article-aproved.svg" alt="Artigos aprovados"/>
        35
      </span>

      <span class="co-numbers-number">
        <img class="co-numbers-icon"src="assets/img/icons/orientation.svg" alt="Orientações"/>
        12
      </span>

      <span class="co-numbers-number">
        <img class="co-numbers-icon"src="assets/img/icons/research.svg" alt="Pesquisas"/>
        15
      </span>

      <span class="co-numbers-number">
        <img class="co-numbers-icon"src="assets/img/icons/event.svg" alt="Eventos participados"/>
        41
      </span>

    </div>

    <div class="graph">
      <a class="u-skip" href=”#skipgraph”>Pular gráfico</a>


      <div class="graph-line"> 
        <span class="graph-label">Artigos publicados</span>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="2"></div>
        
      </div>
      
      <div class="graph-line"> 
        <span class="graph-label">Livros e capítulos</span>
        
          <div class="graph-unit" data-weight="2"></div>
        
          <div class="graph-unit" data-weight="1"></div>
        
          <div class="graph-unit" data-weight="1"></div>
        
          <div class="graph-unit" data-weight="2"></div>
        
          <div class="graph-unit" data-weight="2"></div>
        
          <div class="graph-unit" data-weight="0"></div>
        
          <div class="graph-unit" data-weight="0"></div>
        
      </div>  
      
      <div class="graph-line graph-division"> 
        <span class="graph-label">Orientações de mestrado</span>
        
          <div class="graph-unit" data-weight="1"></div>
        
          <div class="graph-unit" data-weight="1"></div>
        
          <div class="graph-unit" data-weight="2"></div>
        
          <div class="graph-unit" data-weight="2"></div>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
      </div>
      
      <div class="graph-line"> 
        <span class="graph-label">Orientações de doutorado</span>
        
          <div class="graph-unit" data-weight="2"></div>
        
          <div class="graph-unit" data-weight="2"></div>
        
          <div class="graph-unit" data-weight="1"></div>
        
          <div class="graph-unit" data-weight="1"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="5"></div>
        
          <div class="graph-unit" data-weight="6"></div>
        
      </div>
      
      <div class="graph-line"> 
        <span class="graph-label">Outras orientações</span>
        
          <div class="graph-unit" data-weight="2"></div>
        
          <div class="graph-unit" data-weight="2"></div>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="2"></div>
        
      </div>

      <div class="graph-line"> 
        <span class="graph-label">Ensino</span>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="2"></div>
        
      </div>

      <div class="graph-line graph-division"> 
        <span class="graph-label">Sofwtwares e patentes</span>
        
          <div class="graph-unit" data-weight="1"></div>
        
          <div class="graph-unit" data-weight="1"></div>
        
          <div class="graph-unit" data-weight="0"></div>
        
          <div class="graph-unit" data-weight="0"></div>
        
          <div class="graph-unit" data-weight="0"></div>
        
          <div class="graph-unit" data-weight="0"></div>
        
          <div class="graph-unit" data-weight="0"></div>
        
      </div>
      
      <div class="graph-line"> 
        <span class="graph-label">Trabalhos em eventos</span>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="2"></div>
        
          <div class="graph-unit" data-weight="2"></div>
        
          <div class="graph-unit" data-weight="1"></div>
        
          <div class="graph-unit" data-weight="1"></div>
        
      </div>
        
      <div class="graph-line"> 
        <span class="graph-label">Participações em eventos</span>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="2"></div>
        
          <div class="graph-unit" data-weight="3"></div>
        
          <div class="graph-unit" data-weight="4"></div>
        
      </div>

      <div class="graph-line"> 
        <div class="graph-icon"></div>
          <div class="graph-label">2021 ————— 2015</div>
      </div>  


      
    </div> <!-- // graph -->

    <div class="graph-info">
      <span class="graph-info-label">+</span>
      <div class="graph-unit" data-weight="4"></div>
      <div class="graph-unit" data-weight="3"></div>
      <div class="graph-unit" data-weight="2"></div>
      <div class="graph-unit" data-weight="1"></div>
      <div class="graph-unit" data-weight="0"></div>
      <span class="graph-info-label">-</span>
    </div>
  </div>

  
</div>

<span class="u-skip" id="skipgraph”" class="ty ty-lastUpdate">Atualizado em 20.02.2022</span><div id="tabs" class="profile-tabs">

          <div class="tab-bar">
            <button id="tab-btn-1" class="tab-btn" v-on:click="changeTab('1')">Sobre Mim</button>
            <button id="tab-btn-2" class="tab-btn" v-on:click="changeTab('2')">Produção Intelectual</button>
            <!-- <button id="tab-btn-3" class="tab-btn" v-on:click="changeTab('3')">Pesquisa</button> -->
            <!-- <button id="tab-btn-4" class="tab-btn" v-on:click="changeTab('4')">Orientações</button> -->
          </div>


          <div class="tab-container">
            <div id="tab-one" class="tab-content" v-if="tabOpened == '1'">
<div class="profile-ext-desc"> 

  <div class="p-description">
    <h3 class="ty-subtitle">Resumo</h3>
    <p class="ty">
      <p><?php echo $profile["resumo_cv"]["texto_resumo_cv_rh"] ?></p>
  </div>
  <div class="u-spacer-2"></div>

  <div class="p-tags">
    <h3 class="ty-subtitle">Tags mais usadas</h3>

    <ul class="tag-cloud" role="navigation" aria-label="Webdev tag cloud">
      
        <li><a class="tag" data-weight="3" href="">População</a></li>
      
        <li><a class="tag" data-weight="4" href="">Crise</a></li>
      
        <li><a class="tag" data-weight="7" href="">Comércio</a></li>
      
        <li><a class="tag" data-weight="2" href="">Legislação</a></li>
      
        <li><a class="tag" data-weight="3" href="">Trabalho</a></li>
      
        <li><a class="tag" data-weight="4" href="">Governança</a></li>
      
        <li><a class="tag" data-weight="5" href="">Empregabilidade</a></li>
      
        <li><a class="tag" data-weight="1" href="">Sociedade</a></li>
      
        <li><a class="tag" data-weight="8" href="">Justiça</a></li>
      
        <li><a class="tag" data-weight="9" href="">Direitos</a></li>
      
        <li><a class="tag" data-weight="4" href="">Direitos humanos</a></li>
      
        <li><a class="tag" data-weight="6" href="">Política</a></li>
      
        <li><a class="tag" data-weight="8" href="">Informação</a></li>
      
        <li><a class="tag" data-weight="5" href="">Redes sociais</a></li>
      
        <li><a class="tag" data-weight="7" href="">Mundo digital</a></li>
      
        <li><a class="tag" data-weight="4" href="">Saúde</a></li>
      
        <li><a class="tag" data-weight="8" href="">Ecologia</a></li>
      
        <li><a class="tag" data-weight="2" href="">Dinheiro</a></li>
      
        <li><a class="tag" data-weight="1" href="">Polítias Públicas</a></li>
      
        <li><a class="tag" data-weight="5" href="">Polícia</a></li>
      
        <li><a class="tag" data-weight="6" href="">Empreendedorismo</a></li>
      
        <li><a class="tag" data-weight="8" href="">Inclusão</a></li>
      
        <li><a class="tag" data-weight="7" href="">Classes sociais</a></li>
      
        <li><a class="tag" data-weight="4" href="">Antropologia</a></li>
      
        <li><a class="tag" data-weight="6" href="">Recessão</a></li>
      
        <li><a class="tag" data-weight="1" href="">Pirataria</a></li>
      
        <li><a class="tag" data-weight="3" href="">Etnografia</a></li>
      
    </ul>
  </div>
  <div class="u-spacer-2"></div>


  
  <?php if(isset($profile["idiomas"])): ?>
  <div class="p-language">
    <h3 class="ty-subtitle">Idiomas</h3>
    <?php foreach ($profile["idiomas"] as $key => $idioma): ?>
      <p>
        <span><?php echo $idioma["descricaoDoIdioma"] ?>:</span>
        Compreende <?php echo $idioma["proficienciaDeCompreensao"] ?>, 
        Fala <?php echo $idioma["proficienciaDeFala"] ?>, 
        Lê <?php echo $idioma["proficienciaDeLeitura"] ?>, 
        Escreve <?php echo $idioma["proficienciaDeEscrita"] ?>
      </p>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
  <div class="u-spacer-2"></div>

  <div class="edu">
    <h3 class="ty-subtitle">Formação</h3>
    
    <!-- Livre Docência -->
    <?php if(isset($profile["formacao_academica_titulacao_livreDocencia"])): ?>

      <?php foreach ($profile["formacao_academica_titulacao_livreDocencia"] as $key => $livreDocencia): ?>

        <div class="formation-container">
          <div class="u-grid">
            <div class="u-grid-left">
              <img class="pi-icon" src="assets/img/icons/academic.svg" />
            </div>
            
            <div class="u-grid-right">
              <div class="formation">
                <p class="ty-item">Livre Docência 
                  <span class="ty formation-date"><?php echo $livreDocencia["anoDeObtencaoDoTitulo"] ?></span>
                </p>
                <p class="ty"><?php echo $livreDocencia["nomeInstituicao"] ?></p>
                <div class="u-spacer-1"></div>
                <p class="ty">Título do trabalho: <?php echo $livreDocencia["tituloDoTrabalho"] ?></p>
                <p class="ty">Grande área: <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"] ?></p>
                <p class="ty">Sub área: <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"] ?></p>
                <p class="ty">Especialidade: <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeDaEspecialidade"] ?></p>
              </div>
            </div>
          </div>
        </div>

      <?php endforeach; ?>

    <?php endif; ?>

    <!-- Doutorado -->
    <?php if(isset($profile["formacao_academica_titulacao_doutorado"])): ?>

      <?php foreach ($profile["formacao_academica_titulacao_doutorado"] as $key => $doutorado): ?>

        <div class="formation-container">
          <div class="u-grid">
            <div class="u-grid-left">
              <img class="pi-icon" src="assets/img/icons/academic.svg" />
            </div>
            
            <div class="u-grid-right">
              <div class="formation">
                <p class="ty-item">Doutorado em <?php echo $doutorado["nomeCurso"] ?>
                  <span class="ty formation-date"><?php echo $doutorado["anoDeInicio"] ?> - <?php echo $doutorado["anoDeConclusao"] ?></span>
                </p>
                <p class="ty"><?php echo $doutorado["nomeInstituicao"] ?></p>
                <div class="u-spacer-1"></div>
                <p class="ty">Título do trabalho: <?php echo $doutorado["tituloDaDissertacaoTese"] ?></p>
                <p class="ty">Orientador: <?php echo $doutorado["nomeDoOrientador"] ?></p>
                <p class="ty">Grande área: <?php echo $doutorado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"] ?></p>
                <p class="ty">Sub área: <?php echo $doutorado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"] ?></p>
                <p class="ty">Especialidade: <?php echo $doutorado["area_do_conhecimento"][0]["nomeDaEspecialidade"] ?></p>
              </div>
            </div>
          </div>
        </div>

      <?php endforeach; ?>

      <?php endif; ?>

      <!-- Mestrado -->
      <?php if(isset($profile["formacao_academica_titulacao_mestrado"])): ?>

        <?php foreach ($profile["formacao_academica_titulacao_mestrado"] as $key => $mestrado): ?>

          <div class="formation-container">
            <div class="u-grid">
              <div class="u-grid-left">
                <img class="pi-icon" src="assets/img/icons/academic.svg" />
              </div>
              
              <div class="u-grid-right">
                <div class="formation">
                  <p class="ty-item">Mestrado em <?php echo $mestrado["nomeCurso"] ?>
                    <span class="ty formation-date"><?php echo $mestrado["anoDeInicio"] ?> - <?php echo $mestrado["anoDeConclusao"] ?></span>
                  </p>
                  <p class="ty"><?php echo $mestrado["nomeInstituicao"] ?></p>
                  <div class="u-spacer-1"></div>
                  <p class="ty">Título do trabalho: <?php echo $mestrado["tituloDaDissertacaoTese"] ?></p>
                  <p class="ty">Orientador: <?php echo $mestrado["nomeDoOrientador"] ?></p>
                  <p class="ty">Grande área: <?php echo $mestrado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"] ?></p>
                  <p class="ty">Sub área: <?php echo $mestrado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"] ?></p>
                  <p class="ty">Especialidade: <?php echo $mestrado["area_do_conhecimento"][0]["nomeDaEspecialidade"] ?></p>
                </div>
              </div>
            </div>
          </div>

        <?php endforeach; ?>

      <?php endif; ?>

      <!-- Graduação -->
      <?php if(isset($profile["formacao_academica_titulacao_graduacao"])): ?>

        <?php foreach ($profile["formacao_academica_titulacao_graduacao"] as $key => $graduacao): ?>

          <div class="formation-container">
            <div class="u-grid">
              <div class="u-grid-left">
                <img class="pi-icon" src="assets/img/icons/academic.svg" />
              </div>
              
              <div class="u-grid-right">
                <div class="formation">
                  <p class="ty-item">Graduação em <?php echo $graduacao["nomeCurso"] ?>
                    <span class="ty formation-date"><?php echo $graduacao["anoDeInicio"] ?> - <?php echo $graduacao["anoDeConclusao"] ?></span>
                  </p>
                  <p class="ty"><?php echo $graduacao["nomeInstituicao"] ?></p>
                  <div class="u-spacer-1"></div>
                  <?php if(!empty($graduacao["tituloDoTrabalhoDeConclusaoDeCurso"])): ?>
                    <p class="ty">Título do trabalho: <?php echo $graduacao["tituloDoTrabalhoDeConclusaoDeCurso"] ?></p>
                  <?php endif; ?>
                  <?php if(!empty($graduacao["nomeDoOrientador"])): ?>
                    <p class="ty">Orientador: <?php echo $graduacao["nomeDoOrientador"] ?></p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

        <?php endforeach; ?>

      <?php endif; ?>

  </div>


</div></div>
            <div id="tab-two" class="tab-content" v-if="tabOpened == '2'"><div class="profile-pi"> 

  <h2 class="ty-title">Produção Intelecual</h2>

  

    <hr class="u-line"></hr>
    <h3 class="ty-subtitle pi-year">2022</h3>
    <hr class="u-line"></hr>


    

      

        <!-- pi: produção intelectual -->
        <div class="pi">
        
          <div class="u-grid">

            <div class="u-grid-left">
          
              
                <img class="pi-icon" src="assets/img/icons/article-published.svg" />

              

            </div>            

            <div class="u-grid-right">

              <div class="pi-separator">
                <span class="pi-type">Artigo publicado</span> 
                <hr class="pi-separator-ln"></hr>
              </div>
              <h4 class="ty-item">Impact of adrenalectomy and dexamethasone treatment on testicular morphology and sperm parameters in rats: insights into the adrenal control of male reproduction</h4>
              
              <span class="u-sr-only">Autores</span>
              <p class="pi-authors"> Paula Toni Del Giudice; Ricardo Pimenta Bertolla; Barbara Ferreira da Silva; Edson Guimarães Lo Turco; Renato Fraietta; Deborah Montagnini Spaine; Luiz Fernando Arruda Santos; Eduardo Jorge Pilau; Fabio Cesar Gozzo; Agnaldo Pereira Cedenho</p>
              

              
              <div class="pi-moreinfo">
                
                <div class="pi-moreinfo-item"> 
                  <img class="pi-moreinfo-icon"
                    src="assets/img/icons/citation.svg" 
                    alt="representação de citação" 
                  />
                    
                  
                  <span class="pi-citations">Web Of Science: 12</span>
                  
                  
                  
                  <span class="pi-citations">Scopus 8</span>
                  
                </div>
                
                      
                
                <div class="pi-moreinfo-item"> 
                  <img 
                    class="pi-moreinfo-icon"
                    src="assets/img/icons/link.svg" 
                    alt="representação de um link"
                  />
                  
                  <a href="https://www.google.com.br" target="blank">Acessar o conteúdo</a>
                </div>
                
                  
                
                <div class="pi-moreinfo-item">

                  <img 
                  class="pi-moreinfo-icon"
                  src="assets/img/logos/doi.svg" 
                  alt="logo DOI"
                  />
                  
                  <a href="https://www.google.com.br"> Acessar o DOI</a>
                </div>
                
              
                
                <div class="pi-moreinfo-item">
                  <a href="0264410X"> ISSN: 0264410X</a>
                </div>
                
              </div>
              <p class="ty-right ty-themeLight">Fonte: Alguma fonte</p>
                  
            </div>


          </div>
            
        </div>
      

    

      

        <!-- pi: produção intelectual -->
        <div class="pi">
        
          <div class="u-grid">

            <div class="u-grid-left">
          
              
                <img class="pi-icon" src="assets/img/icons/article-aproved.svg" />

              

            </div>            

            <div class="u-grid-right">

              <div class="pi-separator">
                <span class="pi-type">Artigo aprovado</span> 
                <hr class="pi-separator-ln"></hr>
              </div>
              <h4 class="ty-item">Impact of adrenalectomy and dexamethasone treatment on testicular morphology and sperm parameters in rats: insights into the adrenal control of male reproduction</h4>
              
              <span class="u-sr-only">Autores</span>
              <p class="pi-authors"> Paula Toni Del Giudice; Ricardo Pimenta Bertolla; Barbara Ferreira da Silva; Edson Guimarães Lo Turco; Renato Fraietta; Deborah Montagnini Spaine; Luiz Fernando Arruda Santos; Eduardo Jorge Pilau; Fabio Cesar Gozzo; Agnaldo Pereira Cedenho</p>
              

              
              <div class="pi-moreinfo">
                
                <div class="pi-moreinfo-item"> 
                  <img class="pi-moreinfo-icon"
                    src="assets/img/icons/citation.svg" 
                    alt="representação de citação" 
                  />
                    
                  
                  <span class="pi-citations">Web Of Science: 10</span>
                  
                  
                  
                  <span class="pi-citations">Scopus 3</span>
                  
                </div>
                
                      
                
                  
                
              
                
                <div class="pi-moreinfo-item">
                  <a href="0264410X"> ISSN: 0264410X</a>
                </div>
                
              </div>
              <p class="ty-right ty-themeLight">Fonte: Alguma fonte</p>
                  
            </div>


          </div>
            
        </div>
      

    

      

    

      

    

  

    <hr class="u-line"></hr>
    <h3 class="ty-subtitle pi-year">2021</h3>
    <hr class="u-line"></hr>


    

      

    

      

    

      

        <!-- pi: produção intelectual -->
        <div class="pi">
        
          <div class="u-grid">

            <div class="u-grid-left">
          
              
                <img class="pi-icon" src="assets/img/icons/article-preprint.svg" />

              

            </div>            

            <div class="u-grid-right">

              <div class="pi-separator">
                <span class="pi-type">Artigo em pré-print</span> 
                <hr class="pi-separator-ln"></hr>
              </div>
              <h4 class="ty-item">Movimentos sociais contemporâneos: Um balanço da produções de teses e dissertações em Antropologia nos últimos dez anos (2008-2018)</h4>
              
              <span class="u-sr-only">Autores</span>
              <p class="pi-authors"> Pinheiro Machado, R., Alegria, P. & Bulgarelli, L.</p>
              

              
              <div class="pi-moreinfo">
                
                <div class="pi-moreinfo-item"> 
                  <img class="pi-moreinfo-icon"
                    src="assets/img/icons/citation.svg" 
                    alt="representação de citação" 
                  />
                    
                  
                  <span class="pi-citations">Web Of Science: 10</span>
                  
                  
                  
                  <span class="pi-citations">Scopus 3</span>
                  
                </div>
                
                      
                
                  
                
              
                
              </div>
              <p class="ty-right ty-themeLight">Fonte: Alguma fonte</p>
                  
            </div>


          </div>
            
        </div>
      

    

      

    

  

    <hr class="u-line"></hr>
    <h3 class="ty-subtitle pi-year">2020</h3>
    <hr class="u-line"></hr>


    

      

    

      

    

      

    

      

        <!-- pi: produção intelectual -->
        <div class="pi">
        
          <div class="u-grid">

            <div class="u-grid-left">
          
              
                <img class="pi-icon" src="assets/img/icons/article-published.svg" />

              

            </div>            

            <div class="u-grid-right">

              <div class="pi-separator">
                <span class="pi-type">Artigo publicado</span> 
                <hr class="pi-separator-ln"></hr>
              </div>
              <h4 class="ty-item">Impact of adrenalectomy and dexamethasone treatment on testicular morphology and sperm parameters in rats: insights into the adrenal control of male reproduction</h4>
              
              <span class="u-sr-only">Autores</span>
              <p class="pi-authors"> Paula Toni Del Giudice; Ricardo Pimenta Bertolla; Barbara Ferreira da Silva; Edson Guimarães Lo Turco; Renato Fraietta; Deborah Montagnini Spaine; Luiz Fernando Arruda Santos; Eduardo Jorge Pilau; Fabio Cesar Gozzo; Agnaldo Pereira Cedenho</p>
              

              
              <div class="pi-moreinfo">
                
                <div class="pi-moreinfo-item"> 
                  <img class="pi-moreinfo-icon"
                    src="assets/img/icons/citation.svg" 
                    alt="representação de citação" 
                  />
                    
                  
                  <span class="pi-citations">Web Of Science: 10</span>
                  
                  
                  
                  <span class="pi-citations">Scopus 3</span>
                  
                </div>
                
                      
                
                  
                
              
                
                <div class="pi-moreinfo-item">
                  <a href="0264410X"> ISSN: 0264410X</a>
                </div>
                
              </div>
              <p class="ty-right ty-themeLight">Fonte: Alguma fonte</p>
                  
            </div>


          </div>
            
        </div>
      

    

  

</div></div>
            <div id="tab-three" class="tab-content" v-if="tabOpened == '3'">

            </div>
            <div id="tab-four" class="tab-content" v-if="tabOpened == '4'">

            </div>
    
    
          </div>
        </div>
      </div>
    </main>

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
            var tabs = document.getElementsByClassName("tab-btn")

            for (i = 0; i < tabs.length; i++ )
              tabs[i].className = tabs[i].className.replace("tab-active", "")

            tabs[Number(tab)-1].className += "tab-active"
          }
        }
      })
    </script>
    <?php echo "<pre>".print_r($profile,true)."</pre>"; ?>      
	</body>
		

</html>