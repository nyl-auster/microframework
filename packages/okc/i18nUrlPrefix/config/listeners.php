<?php

$listeners['serverGetUrlFromRoute'] = array(
  'okc\i18nUrlPrefix\i18nUrlPrefix' => array('order' => 0),
);
$listeners['serverGetRouteFromUrl'] = array(
  'okc\i18nUrlPrefix\i18nUrlPrefix' => array('order' => 0),
);
$listeners['viewSetFile'] = array(
  'okc\i18nUrlPrefix\i18nUrlPrefix' => array('order' => 0),
);

return $listeners;

