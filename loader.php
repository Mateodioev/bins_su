<?php


foreach (glob('src/config/*.php') as $value) {
  require $value;
}

require './functions.php';