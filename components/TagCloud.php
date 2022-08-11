<?php 
  class Tag {
    static function cloud($arr, $hasLink = '' ) {
      $buf = '';

      // if (array_key_exists('first', $search_array))
  
      if ($hasLink) {
        foreach ($arr as $t)
        {
          $buf = "$buf <li><a class='tag' data-weight={$t['amount']} href={$t['link']}> {$t['category']}</a> </li>";
        }
        unset($t);
      } else {
        foreach ($arr as $t)
        {
          $buf = "$buf <li><a class='tag' data-weight={$t['amount']}> {$t['category']}</a> </li>";
        }
        unset($t);
      }


      echo("
        <ul class='tag-cloud' role='navigation' aria-label='Tags mais usadas'>
          $buf
        </ul>
      ");

    }
  }
?>