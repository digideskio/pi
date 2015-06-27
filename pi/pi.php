<?php

namespace Pi;

use Pi\Core\Form;
use Pi\Lib\Yaml;

$models = glob('content/models/*.yaml');

/*
foreach ($models as $model) {
?>

<label>Contenu</label>
<textarea><?=file_get_contents($model)?></textarea>

<?php
}
*/

?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>Pi</title>

		<link rel="stylesheet" href="web/css/style.min.css" />
	</head>

	<body>
		<div class="row global">
			<div class="col-xs-3 sidebar-left">
				<ul>
					<?php foreach ($models as $model): ?>
						<li><a href="#"><?=$model?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="col-xs-9 content">
				<?php

				$model = Yaml::read('content/models/blog.yaml');

				$form = new Form($model);

				echo $form->html();

				if (!empty($_POST)) {
					$valid = !in_array(false, $form->validate());

					echo '<pre>';
					var_dump($form->validate());
					var_dump($form->save());
					echo '</pre>';

					//if ($valid)
					//	Yaml::write(time() . '.yaml', $form->save());
				}

				?>
			</div>
		</div>
	</body>
</html>
