<?php

namespace Scrapper\Config;

date_default_timezone_set('America/Lima');

class ErrorLog {
  
  public static function ActivarErrorLog()
  {
    error_reporting(E_ALL);
    ini_set('ignore_repeated_errors', TRUE);
    ini_set('display_errors', false);
    ini_set('log_errors', true);
    ini_set('error_log', dirname(__DIR__) . '/Logs/php-error.log');
  }
}