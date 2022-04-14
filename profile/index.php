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

<html lang="pt-br">
  <head>
    <title>Prodmais — Perfil do usuário - <?php echo $profile["nome_completo"] ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="description" content="Prodmais Unifesp." />
    <meta name="keywords" content="Produção acadêmica, lattes, ORCID" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  </head>
  <body>

  <!-- NAV -->
  <?php require 'inc/navbar.php'; ?>
  <!-- /NAV -->

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
                <?php if(!empty($livreDocencia["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"])): ?>
                  <p class="ty">Grande área: <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"] ?></p>
                <?php endif; ?>
                <?php if(!empty($livreDocencia["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"])): ?>
                  <p class="ty">Área do conhecimento: <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"] ?></p>
                <?php endif; ?>
                <?php if(!empty($livreDocencia["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"])): ?>
                  <p class="ty">Sub área: <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"] ?></p>
                <?php endif; ?>
                <?php if(!empty($livreDocencia["area_do_conhecimento"][0]["nomeDaEspecialidade"])): ?>
                  <p class="ty">Especialidade: <?php echo $livreDocencia["area_do_conhecimento"][0]["nomeDaEspecialidade"] ?></p>
                <?php endif; ?>
                
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
                <?php if(!empty($doutorado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"])): ?>
                  <p class="ty">Grande área: <?php echo $doutorado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"] ?></p>
                <?php endif; ?>
                <?php if(!empty($doutorado["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"])): ?>
                  <p class="ty">Área do conhecimento: <?php echo $doutorado["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"] ?></p>
                <?php endif; ?>
                <?php if(!empty($doutorado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"])): ?>
                  <p class="ty">Sub área: <?php echo $doutorado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"] ?></p>
                <?php endif; ?>
                <?php if(!empty($doutorado["area_do_conhecimento"][0]["nomeDaEspecialidade"])): ?>
                  <p class="ty">Especialidade: <?php echo $doutorado["area_do_conhecimento"][0]["nomeDaEspecialidade"] ?></p>
                <?php endif; ?>
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
                  <?php if(!empty($mestrado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"])): ?>
                    <p class="ty">Grande área: <?php echo $mestrado["area_do_conhecimento"][0]["nomeGrandeAreaDoConhecimento"] ?></p>
                  <?php endif; ?>
                  <?php if(!empty($mestrado["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"])): ?>
                    <p class="ty">Área do conhecimento: <?php echo $mestrado["area_do_conhecimento"][0]["nomeDaAreaDoConhecimento"] ?></p>
                  <?php endif; ?>
                  <?php if(!empty($mestrado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"])): ?>
                    <p class="ty">Sub área: <?php echo $mestrado["area_do_conhecimento"][0]["nomeDaSubAreaDoConhecimento"] ?></p>
                  <?php endif; ?>
                  <?php if(!empty($mestrado["area_do_conhecimento"][0]["nomeDaEspecialidade"])): ?>
                    <p class="ty">Especialidade: <?php echo $mestrado["area_do_conhecimento"][0]["nomeDaEspecialidade"] ?></p>
                  <?php endif; ?>
                  
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
    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
    <?php echo "<pre>".print_r($cursor,true)."</pre>"; ?>
    <?php echo "<pre>".print_r($cursor_works,true)."</pre>"; ?>     
	</body>
		

</html>