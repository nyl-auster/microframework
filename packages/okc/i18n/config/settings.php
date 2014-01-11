<?php

return array(

  // default language used in the site.
  // We use string Ids so there is always a translation running background
  // from string Ids do default language.
  'i18n.defaultLanguage' => 'en-EN',

  // declare enabled languages
  'i18n.languages' => array(
    'en-EN' => array('name' => 'English'),
    'fr-FR' => array('name' => 'French'),
  ),

  // If FALSE, oly default language will be enabled on the site, with no
  // way to display other translations.
  'i18n.enabled' => FALSE,

);


