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
      <div class='c-profilex'>
      <img class='c-profilex-photo' src=$picture />
      <b class='c-profilex-name'>$name</b>
      </div>
    </a>
    ");
  }
}
?>
