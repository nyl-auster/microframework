<?php
use okc\server\server;
use okc\i18n\i18n;
?>

<html>
  <head>
    <title> OKC FRAMEWORK </title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link href="<?php echo server::$basePath ?>app/packages/okc/demo/assets/style.css" rel="stylesheet"/>
  </head>
<body>
  <header>
    <div id="marque">

      <div id="marque-1">
        <div class="letter" id="letter-O">O</div>
        <div class="letter" id="letter-K">K</div>
        <div class="letter" id="letter-C">C</div>
      </div>

      <div id="marque-2">
        FRAMEWORK
      </div>

    </div>
  </header>

<!--
<navigation id="lang">
  <ul>
  <li><?php // echo server::link(server::getRouteFromUrl(), i18n::t('french'), array('language' => 'fr_FR')) ?> </li>
  <li><?php // echo server::link(server::getRouteFromUrl(), i18n::t('english'), array('language' => 'en_EN')) ?> </li>
  </ul>
</navigation>
-->

<div id="wrapper">

  <?php echo $childView ?>

</div>

</body>
</html>

