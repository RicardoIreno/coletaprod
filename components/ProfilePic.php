<?php

class ProfilePic
{
  static function ppg(
    $picture,
    $name,
    $link
  ){
    echo ("
      
    <a href='$link' target='blank'/>
      <div class='cc-profilex'>
      <img class='cc-profilex-photo' src=$picture />
      <b class='cc-profilex-name'>$name</b>
      </div>
    </a>
    ");
  }
}
?>