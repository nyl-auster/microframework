<?php
namespace okc\container;

class container {

  protected $config;

  function __construct($config) {
    $this->config = $config;
  }

  /**
   * Get a service. 
   * @param string $name
   *   the service name
   * @param string $context
   *   different set of params may be set.
   *   if $context is an array; this will be used directly as arguments
   *   to the class constructor.
   */
  function get($name, $context = 'default') {
    $arguments = array();
    if (is_array($context)) {
      $arguments = $context;
      $class = new \ReflectionClass($this->config[$name]['default']['class']);
      $object = $class->newInstanceArgs($arguments);
      return $object;
    }
    else {
      $datas = $this->config[$name][$context];
      if (!empty($datas['arguments'])) {
        $arguments = $this->parseServiceArguments($datas['arguments']);
      }
      $class = new \ReflectionClass($datas['class']);
      $object = $class->newInstanceArgs($arguments);
      return $object;
    }
  }

  /**
   * @param array $arguments
   *   associative array containing :
   *   -context
   *     - class : class with its namespace
   *     - arguments : array containing
   *       - Argument name => type of argument
   *
   * Example :
   *
   * array(
   *   'default' => array(
   *     'class' => 'okc\okc\server',
   *     'arguments' => array(
   *       'routes' => 'array',
   *       'config' => 'service',
   *     ),
   *   ),
   * );
   *
   */
  function parseServiceArguments($arguments) {
    $args = array();
    foreach ($arguments as $value => $description) {
      if ($description['type'] == 'service') {
        $args[] = $this->get($value);
      }
      else {
        $args[] = $value;
      }
    }
    return $args;
  }

}

