<?php
use microframework\core\server;
?>
<div>
<h2> Menu </h2>
<ul>
<li><a href="<?php print server::getUrlFromRoute('') ?>"> Accueil </a></li>
<li><a href="<?php print server::getUrlFromRoute('test') ?>"> test page </a></li>
<li><a href="<?php print server::getUrlFromRoute('another-test') ?>"> Another page </a></li>
</ul>
</div>


