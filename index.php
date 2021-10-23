<?php

/**
 * @author @Mateodioev - 996202950
 * @link https://t.me/Mateodioev
 */


require __DIR__ . '/loader.php';

use Scrapper\Config\ErrorLog;
use Scrapper\Config\StringUtils;
use Scrapper\Config\HttpResponse;
use Scrapper\Config\ScrapperBin;

ErrorLog::ActivarErrorLog();

$bin = substr(StringUtils::GetQuery('bin', true), 0, 6);

if (empty($bin)) {
  echo json_encode(HttpResponse::status400('Please put one bin'));
  exit;

} elseif (strlen($bin) < 6) {
  echo json_encode(HttpResponse::status400('Invalid bin lenght'));
  exit;

} else {
  // Search bin
  $fim = ScrapperBin::Search($bin);
  $fim['result']['flag'] = getFlag($fim['result']['country']);

  echo json_encode($fim);
  exit;
}