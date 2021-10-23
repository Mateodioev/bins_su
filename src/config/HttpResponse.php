<?php

namespace Scrapper\Config;

/**
 * Establecer las cabeceras del codigo http
 */
class HttpResponse {
  public static $message = array(
    'success' => false,
    'status'  => 'ok',
    'message' => ''
  );

  /**
   * Parsear el resultado
   *
   * @param integer $response_code
   * @param string $status
   * @param string $response
   * @param boolean $success
   * @return array
   */
  private static function statusParser(int $response_code = 200, string $status = 'ok', string $response = '', bool $success = true) {
    http_response_code($response_code);
    header('content-type: application/json');
    self::$message = ['success' => $success, 'status' => $status, 'message' => $response];
    return self::$message;
  }

  /**
   * Cabeceras para http status 200
   *
   * @param string $res
   * @return array
   */
  final public static function status200(string $res) {
    return self::statusParser(200, 'ok', $res);
  }

  /**
   * Cabeceras para http status 201
   *
   * @param string $res
   * @return array
   */
  final public static function status201(string $res) {
    return self::statusParser(201, 'ok', $res);
  }

  /**
   * Cabeceras para http status 400
   *
   * @param string $res
   * @return array
   */
  final public static function status400(string $res = 'Bad request') {
    return self::statusParser(400, 'error', $res, false);
  }

  /**
   * Cabeceras para http status 401
   *
   * @param string $res
   * @return array
   */
  final public static function status401(string $res = 'Acces denied') {
    return self::statusParser(401, 'error', $res, false);
  }

  /**
   * Cabeceras para http status 404
   *
   * @param string $res
   * @return array
   */
  final public static function status404(string $res = '404 Page not found') {
    return self::statusParser(404, 'error', $res, false);
  }

  /**
   * Cabeceras para http status 500
   *
   * @param string $res
   * @return array
   */
  final public static function status500(string $res = 'Internal server error') {
    return self::statusParser(500, 'error', $res, false);
  }

}