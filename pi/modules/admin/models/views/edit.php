<?php $this->layout('tpl/layout.php'); ?>

<?php $this->begin('content'); ?>
	<form method="post">
		<label for="content">Contenu</label>
		<textarea name="content" id="content"><?=$content?></textarea>

		<input type="submit" value="Modifier" />
	</form>
<?php $this->end(); ?>
