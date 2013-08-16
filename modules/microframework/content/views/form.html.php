<?php use microframework\core\controller; ?>

<form action="<?php print controller::path('content/form') ?>" method="post">

<?php if ($errors) : ?>
Le fomulaire contient des erreurs.
<?php endif ?>

<!-- field id -->
<div class="field-wrapper">
  <div class="field">
  <?php $id = isset($object['id']) ? $object['id'] : '' ?>
  <input type="hidden" name="id" value="<?php print $id ?>"/>
  </div>
</div>

<!-- field title -->
<div class="field-wrapper">

  <?php if (isset($errors['title'])) : ?>
    <div class="error"> <?php print $errors['title'] ?> </div>
  <?php endif ?>

  <div class="label"> Title </div>
  <div class="field">
  <?php $title = isset($object['title']) ? $object['title'] : '' ?>
  <input type="textfield" name="title" value="<?php print $title ?>"/>
  </div>
</div>


<!-- field body -->
<div class="field-wrapper">

  <?php if (isset($errors['body'])) : ?>
    <div class="error"> <?php print $errors['body'] ?> </div>
  <?php endif ?>

  <div class="label"> Corps </div>
  <div class="field">
  <?php $body = isset($object['body']) ? $object['body'] : '' ?>
  <textarea name="body"><?php print $body ?></textarea>
  </div>
</div>

<!-- field state -->
<div class="field-wrapper">

  <?php if (isset($errors['state'])) : ?>
    <div class="error"> <?php print $errors['state'] ?> </div>
  <?php endif ?>

  <div class="label"> Publié : </div>
  <div class="field">
  <?php $state = isset($object['state']) ? $object['state'] : '' ?>
  Publié <input type="radio" name="state" value="0" <?php $state == 0 ? print "checked=checked" : '' ?>> 
  Dépublié <input type="radio" name="state" value="1" <?php $state == 1 ? print "checked=checked" : '' ?>> 
  </div>
</div>

<!-- field submit -->
<div class="field">
<input type="submit" name="form_content_submit" value="enregistrer"/>
</div>

</form>

