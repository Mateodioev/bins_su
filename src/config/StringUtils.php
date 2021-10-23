<?php

namespace Scrapper\Config;

class StringUtils {

  final public static function RemoveStrings(string $string) {
    return preg_replace('/[^0-9]/', '', $string);
  }

  final public static function GetQuery(string $key = 'bin', bool $is_int = false) {

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $index = $_GET;
    } else {
      $index = $_POST;
    }

    $string = (isset($index[$key])) ? $index[$key] : '';

    return ($is_int) ? self::RemoveStrings($string) : $string;
  }
}
