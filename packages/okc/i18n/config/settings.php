<?php

return array(

  // default language used in the site.
  // We use string Ids so there is always a translation running background
  // from string Ids do default language.
  'defaultLanguage' => 'en_EN',

  // enabled i18 on site. (e.g : set lang prefix in url etc...)
  // By default, only defaultLanguage will be used everywhere with no
  // way to switch language.
  'enabled' => TRUE,

  // how current language page will be found.
  'languageNegociation' => 'urlPrefix',

  // define language settings.
  'languages' => array(
    'en_EN' => array(
      'name' => 'English',
      'urlPrefix' => 'en',
    ),
    'fr_FR' => array(
      'name' => 'French',
      'urlPrefix' => 'fr',
    ),
  )

);

