<?php
class GraphBar {
    static function levels(){
    $output = '';
    for ($i = 0; $i <= 24; $i+=1) {
      $output =  "$output <div class='cc-gppg-level'>$i</div>";
    }
    return $output;
  }

  static function lines() {
    $output = '';
    for ($i = 1; $i <= 25; $i++) {
      $output =  "$output <hr class='cc-gppg-grid-line' />";
    }
    return $output;
  }

  static function legends($arr) {
    $output = '';
    $aux = 1;
    foreach ($arr as $i) {
      $output = ''. $output .'<div class="cc-gppg-legend" data-number="'. $aux++ .'">'.$i.'</div>';
    }
    unset($aux);
    return $output;
  }

  static function slices(
    $arr
  ) {
    $year = 0;
    $infoA = '';
    $infoB = '';
    $infoC = '';
    $infoD = '';
    $output = '';

    foreach ($arr as $i)    
    {
      $year = $i['year'];
      $infoA = $i['infoA'];
      $infoB = $i['infoB'];
      $infoC = $i['infoC'];
      $infoD = $i['infoD'];

      $output = "$output
      <div class='cc-gppg-slice'>
        <div class='cc-gppg-bar' data-type='1' data-weight='$infoA'>$infoA</div>
        <div class='cc-gppg-bar' data-type='2' data-weight='$infoB'>$infoB</div>
        <div class='cc-gppg-bar' data-type='3' data-weight='$infoC'>$infoC</div>
        <div class='cc-gppg-bar' data-type='4' data-weight='$infoD'>$infoD</div>
        <span class='cc-gppg-year'>$year</span> 
      </div>";
    }

    unset($year);
    unset($infoA);
    unset($infoB);
    return $output;
  }

  static function graph(
    $title,
    $arrData,
    $arrLegends
  ) {
    $linesRendered = GraphBar::lines();
    $levelsRendered = GraphBar::levels();
    $slicesRendered = GraphBar::slices($arrData); 
    $legendsRendered = GraphBar::legends($arrLegends);

    echo ("
      <div class='cc-gppg'>
        <div class='cc-gppg-title'>$title</div>
        <div class='cc-gppg-legends'>
          $legendsRendered
        </div>

        <div class='cc-gppg-plot'>
        
          <div class='cc-gppg-slice-zero'>
            <div class='cc-gppg-level'></div>
            $levelsRendered
          </div>
          
          $slicesRendered
          
          <div class='cc-gppg-grid'>
            $linesRendered
          </div>

        </div>
      </div>
    ");
  }
}
?>