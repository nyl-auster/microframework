<?php
/**
 * @file
 * okc framework settings
 * copy to app/config and edit to override
 */

return array(

  'server.rewriteEngine' => FALSE,

  // default translation language
  'i18n.language.default' => 'en-EN',

  // declare enabled languages on site.
  'i18n.languages.enabled' => array(
    'en-EN' => array('name' => 'English'),
    'fr-FR' => array('name' => 'French'),
  ),

);


