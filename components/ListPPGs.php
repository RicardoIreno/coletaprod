<?php

class ListPPGs {
  static function listAll($data) {
    $arr = json_decode($data);
    $campus = $arr -> campus;
   
    foreach( $campus as $c ) {
      echo '<h2 class="t t-h2 u-my-2">' . $c -> nome .'<h2>';

      foreach( $c -> unidades as $unidade)
      {
        $programas = str_replace(array('{', '}'), array('[',']'), $unidade -> programas);

        echo '
        <details class="p-ppgs-item">
          <summary class="p-ppgs-item-header">'
             . $unidade -> nome .
          '</summary>
          ';
          
          foreach($programas as $p) 
            SList::genericItem(
              $type = 'ppg',
              $itemName = $p,
              $itemNameLink = '',
              $itemInfoA = '',
              $itemInfoB = 'CAPES 1234566890',
              $itemInfoC = '',
              $itemInfoD = '',
              $itemInfoE = '',
              $authors = '',
              $yearStart = '',
              $yearEnd = ''
            );
          
          echo  '</details>';
        
      }
    }

  }
}
?>