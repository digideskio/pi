<?php $this->layout('tpl/layout.php'); ?>

<?php $this->begin('content'); ?>
	<form method="post">
		<label for="content">Contenu</label>
		<textarea name="content" id="content">title: heyyy
	fields: []</textarea>

		<input type="submit" value="Créer" />
	</form>
<?php $this->end(); ?>
