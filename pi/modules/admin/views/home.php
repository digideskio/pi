<h1>Administration</h1>

<h2>Modèles</h2>

<ul>
	<?php foreach ($models as $model): ?>
		<li>
			<a href="<?=$app->genLink('GET admin.models.use', $model->slug)?>"><?=$model->title?></a>
		</li>
	<?php endforeach; ?>
</ul>
