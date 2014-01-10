<?php
namespace okc\i18n;

/**
 * Translates strings Id to a localized string.
 * e.g :
 * "hello.world" will be translated to "Hello world !" in English.
 *
 * @code
 * // instanciate settings and translations first
 * i18n::setSettings($settings);
 * i18n::setTranslations($translations);
 * // now t() method is available calling :
 * i18n::t('myStringId')
 */
class i18n {

  static protected $translations;
  static protected $settings;
  const defaultLanguage = 'en_En';

  public function __construct($settings, $translations) {
    self::$settings = $settings;
    self::$translations = $translations;
  }

  /**
   * Translate a string Id to a localized string
   *
   * @param string $stringId
   *   "hello.world"
   * @param string $languageCode
   *   fr_FR, en_EN etc... If not provided, this function try to determine
   *   current active language with getLanguage() method.
   */
  public function t($stringId, $languageCode = NULL) {
    $languageCode = $languageCode ? $languageCode : self::getLanguage();
    if (isset(self::$translations[$languageCode][$stringId])) {
       return self::$translations[$languageCode][$stringId];
    }
    return $stringId;
  }

  /**
   * Get default language. Extends class and overrides this method to do something usefull with
   * this function.
   *
   * return string
   *   e.g fr_FR, en_EN etc...
   */
   public function getLanguage() {
     return (!empty(self::$settings['defaultLanguage'])) ? self::$settings['defaultLanguage'] : self::defaultLanguage;
   }

}

