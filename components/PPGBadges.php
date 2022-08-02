<?php
class PPGBadges {
  static function capes(
    $rate,
    $title
  ) {
    echo 
    "<div class='p-ppg-badge'>
      <img class='p-ppg-imgcapes' src='inc/images/badges/capes$rate.svg' />
      <p class='t t-b'>$title</p>
    </div>";
  }

  static function students(
    $rate,
    $title,
    $ico
  ) {
    echo 
    "<div class='p-ppg-badge'>
      <i class='i i-$ico p-ppg-badge-i' title='title' alt='imagem $title'></i>
      <p class='p-ppg-ratenumber'>$rate</p>
      <p class='t t-light'><b> $title</b></p>
    </div>";
  }
}
?>