<?php
// require 'inc/functions.php';

class Production
{

  static function bullet($tipo)
  {
    $img = '';
    switch ($tipo) {
      case "Artigo publicado":
        $img = 'article-published';
        break;
      case "Capítulo de livro publicado":
        $img = 'chapter';
        break;
      case "Livro publicado ou organizado":
        $img = 'book';
        break;
      case "Patente":
        $img = 'patent';
        break;
      case "Software":
        $img = 'softwares';
        break;
      case "Textos em jornais de notícias/revistas":
        $img = 'papers';
        break;
      case "Trabalhos em eventos":
        $img = 'event';
        break;
      case "Tradução":
        $img = 'book';
        break;
      default:
        $img = 'default';
    }
    return "<img class='s-list-ico' title='{$tipo}' src='inc/images/icons/$img.svg'/>";
  }

  static function sLineItem($url, $type)
  {
    switch ($type) {
      case "doi":
        $path = "<a href='https://doi.org/$url' target='blank'></a>";
        $title = "doi";
        break;
      case "link":
        $path = "<a href='$url' target='blank'>Conteúdo completo</a>";
        $title = "conteúdo completo";
        break;
      case "issn":
        $path = "<a href='$url' target='blank'>$type</a>";
        $title = "issn";
        break;
      case "evento":
        $path = "<a href=''>Evento: $url</a>";
        $title = "Evento";
    }

    if (!empty($url)) {
      $output = <<<TEXT
			<div class="s-line-item">
				<img 
					class="s-line-icon" 
					src="inc/images/icons/$type.svg" 
					title= "$title" 
					alt="$title" />
					$path
			</div>
			TEXT;
    }

    return $output;
  }


  static function IntelectualProduction(
    $type,
    $name,
    $authors,
    $doi,
    $url,
    $issn,
    $refName,
    $refVol,
    $refFascicle,
    $refPage,
    $evento,
    $datePublished,
    $id
  ) {

    $bullet = Production::bullet($type);


    !empty($doi) ? $doiRendered = Production::sLineItem($doi, 'doi') : $doiRendered = '';
    !empty($url) ? $urlRendered = Production::sLineItem($url, 'link') : $urlRendered = '';
    !empty($evento) ? $eventoRendered = Production::sLineItem($evento, 'evento') : $eventoRendered = '';
    !empty($refName) ? $refName = $refName : '';
    !empty($refVol) ? $refVol = ", v. $refVol" : '';
    !empty($refFascicle) ? $refFascicle = ", n. $refFascicle" : '';
    !empty($refPage) ? $refPage = ", p. $refPage" : '';

    $authorsRendered = implode('; ', $authors);

    // (!empty($datePublished) && !empty($id)) ? $query = DadosInternos::queryProdmais($name, $datePublished, $id) : $query = '';

    echo ("
			<div class='s-list'>
				<div class='s-list-bullet'>
					$bullet
				</div>

				<div class='s-list-content'>
					<p class='ty-item'>$name<i> — $type </i ></p>
					<p class='ty-gray'><b class='ty-subItem'>Autores: </b> $authorsRendered </p>
					
					<div class='s-line'>
            $doiRendered
            $urlRendered	
            $eventoRendered					
					</div>
					
					<p class='ty-right ty-themeLight'>
						Fonte: $refName $refVol $refFascicle $refPage
					</p>
					
				</div>
			</div>
    ");
  }
}
