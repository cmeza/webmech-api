<?php

namespace WebMechanix\API;

use WebMechanix\BaseAbstract;

abstract class ApiAbstract extends BaseAbstract
{
  function __construct()
  {
    parent::__construct();

    $this->verifyApiKey();
  }

  public function throwError($message)
  {
    die(json_encode(array('error' => $message)));
  }

  private function verifyApiKey()
  {
    $keyFromHeader = (isset($_SERVER['HTTP_X_WEBMECHANIX_APIKEY']))
        ? $_SERVER['HTTP_X_WEBMECHANIX_APIKEY'] : '';

    if ($keyFromHeader == '' || !in_array($keyFromHeader, $this->config->apiKeys)) {
      $this->throwError('API KEY IS MISSING OR WRONG');
    }
  }
}
