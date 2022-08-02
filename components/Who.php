<?php

class Who
{
  static function ppg(
    $picture,
    $name,
    $title,
    $link
  ){
    $title ? $titleRender = "<b class='c-who-title'>$title</b>" : '';
    echo ("
      
    <a href='$link' class='c-who' target='blank'/>
      <img class='c-who-photo' src=$picture />
      <div class='c-who-text'>
        <b class='c-who-name'>$name</b>
        <p>$titleRender</p>
      </div>
    </a>
    ");
  }

  static function mini(
    $picture,
    $name,
    $title,
    $link
  ){
    $title ? $titleRender = "<b class='c-who-title'>$title</b>" : '';
    echo ("
      
    <a href='$link' class='c-whomini' target='blank'/>
      <img class='c-whomini-photo' src=$picture />
      <div class='c-whomini-text'>
        <b class='c-whomini-name'>$name</b>
        $titleRender
      </div>
    </a>
    ");
  }
}
?>