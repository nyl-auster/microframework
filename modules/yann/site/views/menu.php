<?php
use microframework\core\server;
?>
<ul>
<li><a href="<?php print server::getUrlFromRoute('') ?>"> Accueil </a></li>
<li><a href="<?php print server::getUrlFromRoute('test') ?>"> test page </a></li>
<li><a href="<?php print server::getUrlFromRoute('cv') ?>"> CV </a></li>
</ul>


