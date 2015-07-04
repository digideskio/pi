<h1>Administration</h1>

<h2>Modèles</h2>

<ul>
	<li><a href="<?=$app->genLink('GET admin.models.create')?>">Créer un modèle</a></li>
	<li><a href="<?=$app->genLink('GET admin.models.import')?>">Importer</a></li>
</ul>

<ul>
	<?php foreach ($models as $model): ?>
		<li>
			<strong><?=$model->title?></strong>
			<ul>
				<li>
					<a href="<?=$app->genLink('GET admin.models.use', $model->slug)?>">Utiliser</a>
				</li>

				<li>
					<a href="<?=$app->genLink('GET admin.models.edit', $model->slug)?>">Modifier</a>
				</li>

				<li>
					<form method="post" action="<?=$app->genLink('POST admin.models.remove', $model->slug)?>">
						<input type="submit" value="Supprimer" class="btn-link" />
					</form>
				</li>
			</ul>
		</li>
	<?php endforeach; ?>
</ul>
