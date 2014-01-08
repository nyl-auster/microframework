<?php
namespace okc\container\container;

class container {

  protected $config;

  function __construct($config) {
    $this->config = $config;
  }

  function getService($className) {

  }

}

