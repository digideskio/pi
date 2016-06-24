# Créer un module

## Pourquoi créer un module ?

Un module permet :

- D'ajouter des champs (cf. create-field.md) ;
- D'ajouter des modèles (cf. create-model.md) ;
- De surcharger un modèle existant ;
- De surcharger un champ existant ;
- De surcharger la vue d'un modèle.

## Modèle de base

Voici le modèle de base pour créer un module vierge.

Dans ces exemples, remplacez `${NomModule}` par le nom de votre module, en
*CamelCase*.

- Se placer dans le dossier `content/modules/` ;
- Créer un dossier portant le nom du module en minuscule (seuls les caractères
  `0-9`, `a-z` et `_` sont autorisés) ;
- Créer le fichier `${NomModule}Module.php` dans ce nouveau dossier.

Contenu du fichier `${NomModule}Module.php` :

```php
<?php

namespace Module\${NomModule};

use Pi\Core\App\Module;

class ${NomModule}Module extends Module {
  public function initialize() {
    // Ici, les actions effectuées par votre module
  }
}
```

Par exemple pour un module nommé « Contact Form », le nom du dossier serait
`contactform` et `${NomModule}` serait `ContactForm`.
