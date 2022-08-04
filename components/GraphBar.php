<?php
class GraphBar {
    static function levels($lines){
    $output = '';
    for ($i = $lines; $i >= 0 ; $i-=1) {
      $output =  "$output <div class='c-gppg-level'>$i</div>";
    }
    return $output;
  }

  static function lines($lines) {
    $output = '';
    for ($i = 1; $i <= $lines ; $i++) {
      $output =  "$output <hr class='c-gppg-grid-line' />";
    }
    return $output;
  }

  static function legends($arr) {
    $output = '';
    $aux = 1;
    foreach ($arr as $i) {
      $output = ''. $output .'<div class="c-gppg-legend" data-number="'. $aux++ .'">'.$i.'</div>';
    }
    unset($aux);
    return $output;
  }

  static function yearRender($i) {
    if ($i == strftime("%Y") ) { return $i; } 
    elseif ($i % 4 == 0 && $i < (strftime("%Y") -3) ) { return $i; }
    else { return '';}

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
      $year = GraphBar::yearRender($i['year']);
      $infoA = $i['infoA'];
      $infoB = $i['infoB'];
      $infoC = $i['infoC'];
      $infoD = $i['infoD'];

      $output = "$output
      <div class='c-gppg-slice'>
        <div class='c-gppg-bar' data-type='1' data-weight='$infoA'></div>
        <div class='c-gppg-bar' data-type='2' data-weight='$infoB'></div>
        <div class='c-gppg-bar' data-type='3' data-weight='$infoC'></div>
        <div class='c-gppg-bar' data-type='4' data-weight='$infoD'></div>
        <span class='c-gppg-year'>$year</span> 
      </div>";
    }

    unset($year);
    unset($infoA);
    unset($infoB);
    return $output;
  }


  static function triSlices(
    $arr
  ) {
    $year = 0;
    $infoA = '';
    $infoB = '';
    $infoC = '';
    $output = '';

    foreach ($arr as $i)    
    {
      $year = GraphBar::yearRender($i['year']);
      $infoA = $i['infoA'];
      $infoB = $i['infoB'];
      $infoC = $i['infoC'];

      $output = "$output
      <div class='c-gppg-slice'>
        <div class='c-gppg-slice-tri'>
          <div class='c-gppg-slice'>
            <div class='c-gppg-bar' data-type='1' data-weight='$infoA'></div>
          </div>
          <div class='c-gppg-slice'>
            <div class='c-gppg-bar' data-type='2' data-weight='$infoB'></div>
          </div>
          <div class='c-gppg-slice'>
            <div class='c-gppg-bar' data-type='3' data-weight='$infoC'></div>
          </div>
        </div>
        <span class='c-gppg-year'>$year</span> 
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
    $arrLegends,
    $lines
  ) {
    $linesRendered = GraphBar::lines($lines);
    $levelsRendered = GraphBar::levels($lines);
    $slicesRendered = GraphBar::slices($arrData); 
    $legendsRendered = GraphBar::legends($arrLegends);

    echo ("
      <div class='c-gppg'>
      <div class='c-gppg-infos'>
        <div class='c-gppg-title t-title'>$title</div>
        <div class='c-gppg-legends'>
          $legendsRendered
        </div>
      </div>
      
      <div class='c-gppg-plot'>

        
        <div class='c-gppg-slice-zero'>
          <div class='c-gppg-level'></div>
          $levelsRendered
        </div>
        
        $slicesRendered
        
        <div class='c-gppg-grid'>
          $linesRendered
        </div>

        </div>
      </div>
    ");
  }


  static function graph3(
    $title,
    $arrData,
    $arrLegends,
    $lines
  ) {
    $linesRendered = GraphBar::lines($lines);
    $levelsRendered = GraphBar::levels($lines);
    $slicesRendered = GraphBar::triSlices($arrData); 
    $legendsRendered = GraphBar::legends($arrLegends);

    echo ("
      <div class='c-gppg'>
      <div class='c-gppg-infos'>
        <div class='c-gppg-title t-title'>$title</div>
        <div class='c-gppg-legends'>
          $legendsRendered
        </div>
      </div>
      
      <div class='c-gppg-plot'>

        
        <div class='c-gppg-slice-zero'>
          <div class='c-gppg-level'></div>
          $levelsRendered
        </div>
        
        $slicesRendered
        
        <div class='c-gppg-grid'>
          $linesRendered
        </div>

        </div>
      </div>
    ");
  }
}
?>