<?php

namespace API;

class API
{
  protected $config;

  function __construct()
  {
    include '../webmech.config.php';

    $this->config = $config;

    $keyFromHeader = (isset($_SERVER['HTTP_X_WEBMECHANIX_APIKEY']))
                      ? $_SERVER['HTTP_X_WEBMECHANIX_APIKEY'] : '';

    if ($keyFromHeader == '' || !in_array($keyFromHeader, $config->apiKeys)) {
      $this->throw_error('API KEY IS MISSING OR WRONG');
    }
  }

  public function throw_error($message)
  {
    die(json_encode(array('error' => $message)));
  }
}