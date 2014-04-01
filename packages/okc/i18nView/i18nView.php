<?php
namespace okc\i18nView;

use okc\i18n\i18n;

/**
 * Make templates translatable :
 * search for templates in a subdirectory with langcode if existing.
 */
class i18nView {

  /**
   * Listener
   *
   * Add suggestions template to load a different template according to
   * current language.
   * Search template if a fr_FR or en_EN subfolder in templates folder.
   */
  static function viewSetFile(&$file) {
    $languageCode = i18n::getLanguage();
    $file_parts = explode(DIRECTORY_SEPARATOR, $file);
    $file_name = array_pop($file_parts);
    $file_parts[] = $languageCode;
    $file_parts[] = $file_name;
    $file_suggestion = implode(DIRECTORY_SEPARATOR, $file_parts);
    if (is_readable($file_suggestion)) {
      $file = $file_suggestion;
    }
  }

}

