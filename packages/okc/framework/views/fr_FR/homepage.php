<?php
use okc\server\server;
$this->setParentView('okc/framework/views/layout.php');
?>

<p>Ceci est la page d'accueil par défaut, définie dans le package <em>packages/okc/framework</em>. <br/>
Pour créer une nouvelle page ou modifier la page d'accueil, copier le fichier <em>config/example.routes.php</em> en <em>config/routes.php</em>, puis éditez le</p>

<p>
Voir aussi <a target="_blank" href="https://github.com/nyl-auster/okc-framework/blob/master/README.md"> la documentation en ligne  </a> sur la manière de créer de nouvelle ressources; ou regarder le code du package packages/okc/example.<br/>
</p>
<p>
La page "hello world" de test sera visible une fois le fichier routes.php existant.
<a href="<?php echo server::getUrlFromRoute('hello-world')?>"> <?php echo server::getUrlFromRoute('hello-world')?></a>
</p>

