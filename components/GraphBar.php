<?php
class GraphBar {
    static function levels(){
    $output = '';
    for ($i = 0; $i <= 40; $i+=10) {
      $output =  "$output <div class='cc-gppg-level'>$i</div>";
    }
    return $output;
  }

  static function lines() {
    $output = '';
    for ($i = 1; $i <= 7; $i++) {
      $output =  "$output <div class='cc-gppg-grid-line'></div>";
    }
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
      $infoC = $i['infoB'];
      $infoD = $i['infoB'];

      $output = "$output
      <div class='cc-gppg-slice'>
        <div class='cc-gppg-bar' data-type='article' data-weight='$infoA'></div>
        <div class='cc-gppg-bar' data-type='magazine' data-weight='$infoB'></div>
        <div class='cc-gppg-bar' data-type='event' data-weight='$infoC'></div>
        <div class='cc-gppg-bar' data-type='other' data-weight='$infoD'></div>
        <span class='cc-gppg-year'>$year</span> 
      </div>";
    }

    unset($year);
    unset($infoA);
    unset($infoB);
    return $output;
  }

  static function graph(
    $arr
  ) {
    $linesRendered = GraphBar::lines();
    $levelsRendered = GraphBar::levels();
    $slicesRendered = GraphBar::slices($arr); 

    $infoALegend = 'Artigos publicados';
    $infoBLegend = 'Textos em jornais e revistas';
    $infoCLegend = 'Participação em eventos';
    $infoDLegend = 'Outras produções';
    
    echo ("
      <div class='cc-gppg'>
      
      <div class='cc-gppg-plot'>
        <div class='cc-gppg-labels'>
          <div class='cc-gppg-label-a'>$infoALegend</div>
          <div class='cc-gppg-label-b'>$infoBLegend</div>
          <div class='cc-gppg-label-c'>$infoCLegend</div>
          <div class='cc-gppg-label-d'>$infoDLegend</div>
        </div>
      
          <div class='cc-gppg-slice-zero'>
            <div class='cc-gppg-level'></div>
              $levelsRendered
            </div>
          
          $slicesRendered
          
          <div class='cc-gppg-grid'>
          $linesRendered
          <div class='cc-gppg-linezero'></div>
          </div>

        </div>
      </div>
    ");
  }
}
?>