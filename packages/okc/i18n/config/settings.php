<?php

// default language used in the site.
// We use string Ids so there is always a translation running background
// from string Ids do default language.
$settings['defaultLanguage'] = 'en_EN';

// If FALSE, oly default language will be enabled on the site, with no
// way to display other translations.
$settings['enabled'] = TRUE;

  // declare enabled languages
$settings['languages']['en_EN'] = array('name' => 'English');
$settings['languages']['fr_FR'] = array('name' => 'French');

return $settings;

