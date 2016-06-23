# Créer un thème

## Création du dossier et des fichiers obligatoires

- Se placer dans le dossier `content/themes/` ;
- Créer un dossier portant le nom du thème en minuscule : « `0-9`, `a-z`,
  `_` » ;
- Dans ce nouveau dossier, créer un fichier `${NomThème}Theme.php`.

Contenu du fichier `${NomThème}Theme.php` :

```php
<?php

namespace Theme\Classic;

use Pi\Core\App\Theme;

class ${NomThème}Theme extends Theme {
}
```

Il est aussi possible d'hériter un thème de la même manière :

```php
<?php

namespace Theme\Classic;

use Theme\Classic\ClassicTheme;

class ${NomThème}Theme extends ClassicTheme {
  public function initialize() {
    parent::initialize();
  }
}
```

Pour charger un fichier CSS ou JavaScript, il est préférable d'utiliser la
fonction `initialize` plutôt que de le mettre dans le code HTML :

```php
$this->registerCss('css/style.css');
```

Sinon, il est possible de dupliquer le thème `classic` et de l'étudier pour
voir comment il est construit.

## Variables disponibles dans les vues

- `url`
  - `site` : lien complet vers le site
	- `content` : lien complet vers le contenu
	- `models` : lien complet vers les modèles
	- `pages` : lien complet vers les pages
	- `themes` : lien complet vers les thèmes
  - `theme` : lien complet vers le thème courant
  - `current` : lien complet vers la page actuelle
- `dir`
  - `site` : chemin complet vers le site
	- `content` : chemin complet vers le contenu
	- `models` : chemin complet vers les modèles
	- `pages` : chemin complet vers les pages
	- `themes` : chemin complet vers les thèmes
  - `theme` : chemin complet vers le thème courant
- `settings`
  - `site`
    - `name` : nom du site
    - `theme` : slug du thème
- `pages` : liste des pages
- `users` : liste des utilisateurs

Exemple d'utilisation pour l'affichage `{{ settings.site.name }}`.
