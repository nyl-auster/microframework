<?php use microframework\core\controller; ?>

<form action="<?php print controller::path('content/form/save') ?>" method="post">

<!-- field title -->
<div class="field-wrapper">

  <?php if (isset($_POST['_errors']['title'])) : ?>
    <div class="error"> <?php print $_POST['_errors']['title'] ?> </div>
  <?php endif ?>

  <div class="label"> Title </div>
  <div class="field">
  <input type="textfield" name="title"/>
  </div>
</div>


<!-- field body -->
<div class="field-wrapper">

  <?php if (isset($_POST['_errors']['body'])) : ?>
    <div class="error"> <?php print $_POST['_errors']['body'] ?> </div>
  <?php endif ?>

  <div class="label"> Corps </div>
  <div class="field">
  <textarea name="body"></textarea>
  </div>
</div>

<!-- field submit -->
<div class="field">
<input type="submit" name="submit" value="enregistrer"/>
</div>

</form>

