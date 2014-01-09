<?php

$services = array(
  'okc.dic' => array(
    'default' => array(
      'class' => 'okc\ioc\dic',
      'arguments' => array(
        'settings' => array(
          'type' => 'array',
        ),
      ),
    ),
  ),
  'okc.ioc' => array(
    'default' => array(
      'class' => 'okc\ioc\ioc',
      'arguments' => array(
        'okc.packages' => 'service'
      ),
    ),
  ),
  'okc.resource' => array(
    'default' => array(
      'class' => 'okc\resource\resource',
      'arguments' => array(
        'okc.i18n' => array(
          'type' => 'service',
          'alias' => 't',
        ),
        'okc.settings' => array(
          'type' => 'service',
        ),
      ),
    ),
    'okc.view' => array(
      'default' => array(
        'class' => 'okc\view\view',
        'arguments' => array(
          'okc.i18n' => array(
            'type' => 'service',
            'alias' => 't',
          ),
          'okc.settings' => array(
            'type' => 'service',
          ),
        ),
      ),
      'okc.server' => array(
        'default' => array(
          'class' => 'okc\server\server',
          'arguments' => array(
            'routes' => array(
              'type' => 'array',
              'callback' => 'okc.ioc::getRoutes',
            ),
          ) 
        ),
      ),
      'okc.i18n' => array(
        'default' => array(
          'singleton' => TRUE,
          'class' => 'okc\i18n\i18n',
          'arguments' => array(
            'okc.settings' => array('type' => 'service'),
            'okc.translations' => array(
              'type' => 'array',
              'callback' => 'okc.ioc::getTranslations'
            ),
          ),
        ),
      ),
      'okc.packages' => array(
        'default' => array(
          'singleton' => TRUE,
          'class' => 'okc\packages\packages',
          'arguments' => array(
            'packages' => array('type' => 'string'),
            'config' => array('type' => 'string'),
          ),
        ),
      ),
      'okc.settings' => array(
        'default' =>  array(
          'singleton' => TRUE,
          'class' => 'okc\configManager\settings',
          'arguments' => array(
            'okc.packages' => array(
              'type' => 'service',
            ),
          ),
        ),
      ),
    ),
  );

