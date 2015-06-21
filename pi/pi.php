<?php

namespace Pi;

use Pi\Core\Form;
use Pi\Lib\Yaml;

?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>Pi</title>

		<link rel="stylesheet" href="web/css/style.css" />
	</head>

	<body>
		<div style="width: 1000px;">
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
	</body>
</html>
