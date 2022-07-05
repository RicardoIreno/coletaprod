<?php
// require 'inc/functions.php';

class SList
{

  static function bullet($tipo)
  {
    $img = '';
    switch ($tipo) {
      case "atuacoes":
        $img = 'professional';
        break;
      case "orientation":
        $img = 'orientation';
        break;
      case "managing":
        $img = 'managing';
        break;
      case "research":
        $img = 'research';
        break;
      case "formation":
        $img = 'academic';
        break;
      default:
        $img = 'default';
    }
    return "<img class='s-list-ico' title='{$tipo}' src='inc/images/icons/$img.svg'/>";
  }


  static function date($yearStart, $yearEnd)
  {
    $output = '';
    if (!empty($yearStart)) {
      !empty($yearEnd) ? $output = "$yearStart a $yearEnd" : $output = "Desde $yearStart";
      return  $output;
    } else {
      !empty($yearEnd) ? $output = "$yearEnd"  : $output = "";
      return  $output;
    }
  }


  static function genericItem(
    $type,
    $itemName,
    $itemNameLink,
    $itemInfoA,
    $itemInfoB,
    $itemInfoC,
    $itemInfoD,
    $itemInfoE,
    $authors,
    $yearStart,
    $yearEnd
  ) {

    $bullet = SList::bullet($type);
    $date = SList::date($yearStart, $yearEnd);

    if (!empty($itemNameLink)) {
      $header = "<p class='ty ty-item'><a class='ty-itemLink' href='$itemNameLink'> $itemName </a></p>";
    } else {
      $header = "<p class='ty ty-item'> $itemName </a></p>";
    }

    !empty($itemInfoB) && !empty($itemInfoC) ? $sepataror = ', ' : $sepataror = '';
    !empty($authors) ? $aut = "<b class='ty-subItem'>Autores: </b> $authors </p>" : $aut = '';

    echo ("
    <li class='s-nobullet'>
			<div class='s-list'>
				<div class='s-list-bullet'>
					$bullet
				</div>

				<div class='s-list-content'>
					<p class='ty ty-item'>$header</p>
					<p class='ty'>$itemInfoA</p>

					<p class='ty ty-gray'>$itemInfoB $sepataror $itemInfoC</p>
					<p class='ty ty-gray'>$itemInfoC</p>
					<p class='ty ty-gray'>$itemInfoD</p>
					<p class='ty ty-gray'>$itemInfoE</p>
					<p class='ty ty-gray'>$aut</p>		
					<p class='ty ty-gray'>$date</p>			
				</div>
			</div>
    </li>
    ");
  }
}