<?php
use okc\server\server;
$this->setParentView('packages/okc/framework/views/layout.php');
?>

<table>
<tr>
<th> String Id </th>
<th> Language </th>
<th> Translation </th>
</tr>
<?php foreach ($translations as $stringId => $languages) : ?>
<?php foreach ($languages as $lang => $translation) : ?>
<tr>
  <td><?php echo $stringId ?></td>
  <td><?php echo $lang ?></td>
  <td><?php echo $translation ?></td>
</tr>
<?php endforeach ?>
<?php endforeach ?>
</table>

