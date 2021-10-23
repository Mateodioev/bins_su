<?php

namespace Scrapper\Config;

use Scrapper\Config\CurlX;

/**
 * Scrapea bin de bins.su
 * @link http://bins.su
 */
class ScrapperBin {

  private static $proxy_file = __DIR__ . '/../../src/files/webshare.txt'; // Put your proxys here

  private static $link = 'http://bins.su/';
  private static $Headers = ['Host: bins.su', 'Origin: http://bins.su', 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9', 'Referer: http://bins.su/'];
  private static $proxyU = '';
  private static array $proxy = [
    'METHOD' => 'CUSTOM',
    'SERVER' => 'p.webshare.io:80',
  ];


  /**
   * Obtener proxys de un archivo .txt
   */
  private static function GetProxys($use = false) {
    $proxy_user = CurlX::GetRandVal(self::$proxy_file);

    if (!$use) {
      return null;
    }
    if (empty($proxy_user)) {
      return null;

    } else {
      self::$proxyU = $proxy_user;
      self::$proxy['AUTH'] = $proxy_user;
      return self::$proxy;

    }

  }


  private static function ExistError($result) {
    
    if (isset($result->headers->response['X-Webshare-Error'])) {
      //Webshare proxy error
      error_log('Proxy['.self::$proxyU.'] error: ' . $result->headers->response['X-Webshare-Reason']);
      return ['sucess' => false, 'msg' => 'Webshare error'];

    } elseif ($result->success) {
      return ['sucess' => true];

    } else {
      // CURL error
      error_log('cURL error: ' . $result->body);
      return ['sucess' => false, 'msg' => 'cURL error, try again'];

    }
    
  }

  /**
   * Buscar un bin en bins.su
   * @link http://bins.su/
   */
  final public static function Search($bin, $use_proxy = false) 
  {

    try {
      $result = Curlx::Post(self::$link, 'action=searchbins&bins='.urlencode($bin), self::$Headers, null, self::GetProxys($use_proxy));

    } catch (\Exception $e) {
      error_log('Curl: ' . $e);
      return ['sucess' => false, 'bin' => $bin, 'status' => 'error', 'msg' => $e];

    }

    $eval = self::ExistError($result);

    if ($eval['sucess']) {
      # Sucess
      $body = CurlX::ParseString($result->body, '<div id="result">', '</div>');

      if ($body == 'No bins found!') {
        return ['sucess' => false, 'bin' => $bin, 'status' => 'ok', 'msg' => 'Invalid bin'];

      } else {
        $span = 'Total found 1 bins<table><tr><td>BIN</td><td>Country</td><td>Vendor</td><td>Type</td><td>Level</td><td>Bank</td></tr><tr>';
        $body = str_replace([$span, '</tr></table>', '</td>'], '', $body);
        $fim  = explode('<td>', $body);

        return [
          'sucess' => true,
          'status' => 'ok',
          'result' => [
            'bin' => (int) $fim[1],
            'country' => $fim[2],
            'vendor' => $fim[3],
            'type' => $fim[4],
            'level' => $fim[5],
            'bank' => $fim[6],
          ]
        ];

      }
    } else {
      return ['sucess' => false, 'bin' => $bin, 'status' => 'error', 'msg' => $eval['msg'] ];
    }

  }
}