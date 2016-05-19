<?php

namespace WebMechanix;

class BaseAbstract
{
  protected $config;

  function __construct()
  {
    include '../webmech.config.php';

    $this->config = $config; // from webmech.config.php
  }
}
