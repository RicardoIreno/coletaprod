<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<head>
  <?php
  require 'inc/config.php';
  require 'inc/meta-header.php';
  require 'inc/functions.php';
  ?>
  <meta charset="utf-8" />
  <title><?php echo $branch; ?> - Resultado da busca</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta name="description" content="Prodmais Unifesp." />
  <meta name="keywords" content="Produção acadêmica, lattes, ORCID" />
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <link rel="stylesheet" href="sass/main.css" />
</head>

<body>
  <!-- NAV -->
  <?php require 'inc/navbar.php'; ?>
  <!-- /NAV -->

  <div class="result-container">

    <main class="result-main">
      <div class="c-searchterm">Termo pesquisado: </div>


      <div class="s-list">
        <div class="s-list-bullet">
          <?php
          $exemplo = 'Artigo publicado';

          switch ($exemplo) {
            case "Artigo publicado":
              echo '<img class="s-list-ico" 
                    src="inc/images/icons/article-published.svg" 
                    title="Artigo publicado"  />';
              break;

            case "Capítulo de livro publicado":
              echo '<img class="s-list-ico" 
                    src="inc/images/icons/chapter.svg"
                    title="Capítulo de livro publicado" />';
              break;

            case "Livro publicado ou organizado":
              echo '<img class="s-list-ico" 
                    src="inc/images/icons/book.svg"
                    title="Livro publicado ou organizado" />';
              break;

            case "Patente":
              echo '<img class="s-list-ico" 
                    src="inc/images/icons/patent.svg"
                    title="Patente" />';
              break;

            case "Software":
              echo '<img class="s-list-ico" 
                    src="inc/images/icons/softwares.svg"
                    title="Software" />';
              break;

            case "Textos em jornais de notícias/revistas":
              echo '<img class="s-list-ico" 
                    src="inc/images/icons/papers.svg"
                    title="Textos em jornais de notícias/revistas" />';
              break;

            case "Trabalhos em eventos":
              echo '<img class="s-list-ico" 
                    src="inc/images/icons/event.svg"
                    title="Trabalhos em eventos" />';
              break;

            case "Tradução":
              echo '<img class="s-list-ico" 
                    src="inc/images/icons/book.svg"
                    title="Tradução" />';
              break;

            default:
              echo '<img class="s-list-ico" 
                    src="inc/images/icons/default.svg"
                    title="Item" />';
          }
          ?>
        </div> <!-- end s-list-bullet -->
        <div class="s-list-content">

          <p class="ty-item">Título do item <i> — Artigo Publicado</i><span class="ty-gray"> 2022</span></p>
          <p class="ty-gray">
            <b class="ty-subItem">Autores: </b>
            MAADI, MOHAMMAD ALI, MINAS, ARAM, SEPEHRI VAFA, REZVAN, TABATABAEI'NAEINI, ABOUTORAB, Ricardo Pimenta Bertolla
          </p>


          <div class="s-line ty-gray">

            <div class="s-line-item">
              <img class="s-line-icon" src="inc/images/icons/link.svg" alt="representação de um link" />
              <a href="" target="blank">Conteúdo completo</a>
            </div>

            <div class="s-line-item">
              <img class="s-line-icon" src="inc/images/logos/doi.svg" alt="logo DOI" />
              <a href=""> DOI</a>
            </div>

            <div class="s-line-item">
              <a href=""> ISSN: </a>
            </div>
          </div> <!-- end s-line -->

          <p class="ty-right ty-themeLight">Fonte: Alguma fonte</p>

          <!-- <div class="s-line-item">
            <img class="s-line-icon" src="inc/images/icons/citation.svg" alt="representação de citação" />
            <span class="c-pi-citations">Web Of Science: </span>
            <span class="c-pi-citations">Scopus </span>
          </div> -->
        </div> <!-- end s-list-content -->
      </div> <!-- end s-list -->


      <div class="cc-navigator">
        <button class="cc-navigator-btn">«</button>
        <span> X página de Y </span>
        <button class="cc-navigator-btn">»</button>
      </div>
    </main>

    <nav class="cc-fbar">
      <div class="cc-fbar-header">
        <b class="ty">Refinar Resultados</b>
      </div>
      <div class="cc-fbloc-wrapper">
        <!-- <div class="gradient"></div> -->

        <details class="cc-fbloc">
          <summary class="cc-fbloc-header">
            <span class="cc-fbloc-name--header">Nome do bloco</span>
            <span class="cc-fbloc-number">420</span>
          </summary>
          <ul class="cc-fbloc-content" name="bloc1">
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">4200</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
          </ul>
        </details>

        <details class="cc-fbloc">
          <summary class="cc-fbloc-header">
            <span class="cc-fbloc-name--header">Nome do bloco</span>
            <span class="cc-fbloc-number">4200</span>
          </summary>
          <ul class="cc-fbloc-content" name="bloc1">
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">420</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">4200</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
            <li class="cc-fbloc-item">
              <span class="cc-fbloc-name">Um nome enorme só para meter o loko</span>
              <span class="cc-fbloc-number">42</span>
            </li>
          </ul>
        </details>

      </div> <!-- end cc-fbloc -->
    </nav> <!-- end cc-fbar -->
  </div> <!-- end result-container -->

  <?php include('inc/footer.php'); ?>
  <script>
    let fblocs = document.getElementsByClassName('cc-fbloc')

    for (let i = 0; i < fblocs.length; i++) {
      const newBtn = document.createElement('button')
      newBtn.classList.add('cc-fbloc-btn')
      newBtn.innerHTML = "<svg class='cc-fbloc-btn-ico' x='0px' y='0px' viewBox='0 0 80 48'> <path d='M72.3,35.5c-0.7,0-1.5-0.2-2.2-0.5L40.3,20.5l-30.6,14c-2.5,1.1-5.5,0-6.6-2.5c-1.1-2.5,0-5.5,2.5-6.6l32.7-15 c1.4-0.6,2.9-0.6,4.3,0.1l32,15.6c2.5,1.2,3.5,4.2,2.3,6.7C76,34.5,74.2,35.5,72.3,35.5z' /> </svg>"
      newBtn.addEventListener("click", function() {
        this.parentNode.removeAttribute("open")
      })
      fblocs[i].appendChild(newBtn)
    }
  </script>
</body>

</html>