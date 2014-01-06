<?php

// default language used in the site.
// We use string Ids so there is always a translation running background
// from string Ids do default language.
$_settings['defaultLanguage'] = 'en_EN';

// define language settings.
$_settings['i18n']['languages']['fr_FR']['urlPrefix'] = 'fr';
$_settings['i18n']['languages']['en_EN']['urlPrefix'] = 'en';

// if TRUE, language will be passed in url to determine in which
// language we shloud display the content.
$_settings['i18n']['enabled'] = TRUE;

$_settings['i18n']['languageNegociation'] = 'urlPrefix';

