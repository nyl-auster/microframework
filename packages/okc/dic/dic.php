<?php
namespace okc\dic;

/**
 * Depency injection by constructor.
 *
 * Example $config :
 * @code
 * return array(
 *   'okc.resource' => array(
 *     'default' => array(
 *       'class' => 'okc\resource\resource',
 *         'arguments' => array(
 *           'okc.i18n' => array(
 *             'packages' => array('type' => 'string'),
 *             'type' => 'service',
 *           ),
 *        ),
 *      ),
 *    ),
 * );
 *
 * okc.resource is an arbitrary string name for the service.
 * default is the default context. 
 * arguments are the arguments passed to the constructor of the class
 * type is the php type, except for "service" type.
 * @endcode
 */
class dic {

  protected $config;
  protected $services;
  protected $parameters;
  protected $instances;

  function __construct($config) {
    $this->config = $config;
    $this->services = $config['services'];
    $this->parameters = $config['parameters'];
  }

  /**
   * Get a service. 
   * @param string $name
   *   the service name (alias for a class name)
   * @param string $context
   *   different set of params may be set.
   *   if $context is an array; this will be used directly as arguments
   *   to the class constructor.
   */
  function get($name, $context = 'default') {

    // if this service asked to be a singleton and
    // is present in our cache, return same instance
    if ($this->services[$name][$context]['singleton']) {
      if (isset($this->instances[$name][$context])) {
        return $this->instances[$name][$context];
      }
    }

    $arguments = array();
    if (is_array($context)) {
      $arguments = $context;
      $class = new \ReflectionClass($this->service[$name]['default']['class']);
      $object = $class->newInstanceArgs($arguments);
      return $object;
    }
    else {
      $datas = $this->service[$name][$context];
      if (!empty($datas['arguments'])) {
        $arguments = $this->parseServiceArguments($datas['arguments']);
      }
      $class = new \ReflectionClass($datas['class']);
      $object = $class->newInstanceArgs($arguments);

      if ($this->service[$name][$context]['singleton']) {
        $this->instances[$name][$context] = $object;
      }

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

