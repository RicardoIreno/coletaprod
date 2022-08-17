<?php
// require 'inc/functions.php';

class SList
{

  static function bullet($tipo)
  {
    $img = '';
    switch ($tipo) {
      case "professional":
        $img = 'working';
        break;
      case "orientation":
        $img = 'orientation';
        break;
      case "managing":
        $img = 'managment';
        break;
      case "research":
        $img = 'research';
        break;
      case "formation":
        $img = 'academic';
        break;
      case "ppg":
        $img = 'ppg-logo';
        break;
      default:
        $img = 'defaultProduction';
    }
    return "<i class='i i-$img s-list-ico' title='$tipo'></i>";
  }


  static function date($start, $end)
  {
    $buf = '';
    if (!empty($start)) {
      !empty($end) ? $buf = "$start a $end" : $buf = "Desde $start";
      return  $buf;
    } else {
      !empty($end) ? $buf = "Concluído em $end"  : $buf = "";
      return  $buf;
    }
  }


  static function genericItem(
    $type,
    $itemName,
    $itemNameLink = '',
    $itemInfoA = '',
    $itemInfoB = '',
    $itemInfoC = '',
    $itemInfoD = '',
    $itemInfoE = '',
    $authors = '',
    $yearStart = '',
    $yearEnd = ''
  ) {

    $bullet = SList::bullet($type);
    $date = SList::date($yearStart, $yearEnd);

    if (!empty($itemNameLink)) {
      $header = "<p class='t t-b'><a class='t-a' href='$itemNameLink'> $itemName </a></p>";
    } else {
      $header = "<p class='t t-b'> $itemName </a></p>";
    }

    !empty($itemInfoB) && !empty($itemInfoC) ? $sepataror = ', ' : $sepataror = '';
    !empty($authors) ? $aut = "<b class='t-subItem'>Autores: </b> $authors </p>" : $aut = '';

    echo ("
    <li class='s-nobullet'>
			<div class='s-list'>
				<div class='s-list-bullet'>
					$bullet
				</div>

				<div class='s-list-content'>
					<p class='t t-b'>$header</p>
					<p class='ty'>$itemInfoA</p>

					<p class='t t-gray'>$itemInfoB</p>
					<p class='t t-gray'>$itemInfoC</p>
					<p class='t t-gray'>$itemInfoD</p>
					<p class='t t-gray'>$itemInfoE</p>
					<p class='t t-gray'>$aut</p>		
					<p class='t t-gray'>$date</p>			
				</div>
			</div>
    </li>
    ");
  }
}