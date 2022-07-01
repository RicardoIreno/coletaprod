<?php

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
    $output = '';
    $path = '';

    switch ($type) {
      case "doi":
        $path = "<a href='https://doi.org/$url' target='blank'></a>";
        break;
      case "link":
        $path = "<a href='$url' target='blank'>Conteúdo completo</a>";
        break;
      case "issn":
        $path = "<a href='$url' target='blank'>ISSN: $url</a>";
        break;
    }

    if (!empty($url)) {
      $output = <<<TEXT
			<div class="s-line-item">
				<img 
					class="s-line-icon" 
					src="inc/images/icons/$type.svg" 
					title= "conteúdo completo" 
					alt="simbolo de um link" />
					$path
			</div>
			TEXT;
    }

    return $output;
  }


  static function IntelectualProduction(
    $type,
    $sourceName,
    $sourceType,
    $authors,
    $doi,
    $url,
    $issn,
    $refName,
    $refVol,
    $refFascicle
  ) {

    $bullet = Production::bullet($type);

    !empty($doi) ? $doiRendered = Production::sLineItem($url, 'doi') : '';
    !empty($url) ? $urlRendered = Production::sLineItem($url, 'link') : '';
    !empty($refVol) ? $refVol = ", v. $refVol" : '';
    !empty($refFascicle) ? $refFascicle = ", n. $refFascicle" : '';

    echo ("
			<div class='s-list'>
				<div class='s-list-bullet'>
					$bullet
				</div>

				<div class='s-list-content'>
					<p class='ty-item'$sourceName '<i> — ' . $sourceType . '</i ></p>
					<p class='ty-gray'><b class='ty-subItem'>Autores: </b>' . implode('; ', $authors) . '</p>
					
					<div class='s-line'>
						$urlRendered						
					</div>
					
					<p class='ty-right ty-themeLight'>
						Fonte: $refFascicle $refVol $refFascicle
					</p>
					
				</div>
			</div>
    ");
  }
}
