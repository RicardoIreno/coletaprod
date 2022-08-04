<?php 
  class Tag {
    static function cloud($arr) {
      $buf = '';

      foreach ($arr as $t)
      {
        $buf = "$buf <li><a class='tag' data-weight={$t['amount']}> {$t['category']}</a> </li>";
      }
      unset($t);

      echo("
        <ul class='tag-cloud' role='navigation' aria-label='Tags mais usadas'>
          $buf
        </ul>
      ");

    }
  }
?>