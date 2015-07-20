<?php $this->layout('tpl/layout.php'); ?>

<?php $this->begin('content'); ?>
	<h1>Administration</h1>

	<ul>
		<li><a href="<?=$app->genLink('GET admin.models.home')?>">Gérer les modèles</a></li>
		<li><a href="#">Créer une page</a></li>
	</ul>
<?php $this->end(); ?>
