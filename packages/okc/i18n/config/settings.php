<?php

// define language settings.
$_settings['i18n']['languages']['fr_FR']['urlPrefix'] = 'fr';
$_settings['i18n']['languages']['en_EN']['urlPrefix'] = 'en';

// if TRUE, language will be passed in url to determine in which
// language we shloud display the content.
$_settings['i18n']['enabled'] = TRUE;

$_settings['i18n']['languageNegociation'] = 'urlPrefix';

$_settings['i18n']['languageNegociators']['urlPrefix'] = array(
  'name' => 'Url Prefix',
  'description' => 'Determine language by adding a prefix to all routes.',
  'negociationCallback' => 'okc\i18n\i18n',
);

