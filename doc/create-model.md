# Créer un modèle

## Créer le dossier du modèle et les fichiers obligatoires

Pour créer un modèle, suivez d'abord la [procédure de création d'un
module](create-module.md) puis revenez ici pour la suite.

Dans le dossier du module, créez les fichiers suivants :
  - `view.html` ;
  - `model.json`.

Dans la fonction `initialize` du module, inscrivez ceci :

```php
public function initialize() {
$this->registerModelFromJson(
  'nom_du_modele',
  __DIR__ . '/model.json',
  __DIR__ . '/view.html');
}
```

(PARTIE INCOMPLETE)

Le modèle (`model.json`) contient deux valeurs :
- `title` : le titre du modèle ;
- `fields` : la liste des champs.

## Variables disponibles dans la vue

La vue (fichier `view.html` du modèle) dispose de toutes les variables auquel
peut accéder le thème (cf. `create-theme.md`) mais aussi à quelques variables
supplémentaires spécifiques aux pages :

- `meta`
  - `model` : slug du modèle
  - `created_at` : date de création de la page
  - `updated_at` : date de dernière modification de la page
- `page` : tous les champs liés à la page

## Types de champs

### Les champs et leurs valeurs possibles

```
y = implémenté
n = non implémenté

             +-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
             | label | default | message | width | required | min | max | placeholder | options | format | step |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| checkboxes |   y   |    y    |    y    |   y   |    n     |  n  |  n  |             |    y    |        |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| choice     |   y   |    y    |    y    |   y   |    y     |     |     |             |    y    |        |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| code       |   y   |    y    |    y    |   y   |    y     |  n  |  n  |      y      |         |   n    |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| color      |   y   |    y    |    y    |   y   |          |     |     |             |         |   n    |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| date       |   y   |    y    |    y    |   y   |    y     |  n  |  n  |      y      |         |        |  n   |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| email      |   y   |    y    |    y    |   y   |    y     |  n  |  n  |      y      |         |        |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| file       |   y   |    n    |    y    |   y   |    y     |  n  |  n  |             |         |   n    |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| number     |   y   |    y    |    y    |   y   |    y     |  y  |  y  |             |         |        |  y   |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| password   |   y   |    y    |    y    |   y   |    y     |  y  |  y  |      y      |         |   n    |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| radio      |   y   |    y    |    y    |   y   |    n     |     |     |             |    y    |        |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
             | label | default | message | width | required | min | max | placeholder | options | format | step |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| range      |   y   |    y    |    y    |   y   |          |  y  |  y  |             |    n    |        |  y   |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| slug       |   y   |    y    |    y    |   y   |    y     |  y  |  y  |      y      |         |        |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| tags       |   y   |    n    |    y    |   y   |    n     |  n  |  n  |      n      |    n    |        |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| tel        |   y   |    y    |    y    |   y   |    y     |  y  |  y  |      y      |         |        |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| textarea   |   y   |    y    |    y    |   y   |    y     |  n  |  n  |      y      |         |   n    |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| text       |   y   |    y    |    y    |   y   |    y     |  y  |  y  |      y      |         |   n    |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| time       |   y   |    y    |    y    |   y   |    y     |  n  |  n  |      y      |         |   y    |  n   |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| title      |   y   |    y    |    y    |   y   |    y     |  y  |  y  |      y      |         |        |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| url        |   y   |    y    |    y    |   y   |    y     |  n  |  n  |      y      |         |        |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| user       |   y   |    n    |    y    |   y   |    n     |  n  |  n  |      n      |    n    |        |      |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
             | label | default | message | width | required | min | max | placeholder | options | format | step |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
| version    |   y   |    y    |    y    |   y   |    y     |  n  |  n  |      y      |    n    |   n    |  n   |
+------------+-------+---------+---------+-------+----------+-----+-----+-------------+---------+--------+------+
```

Note : ici sont décrits les champs fournit avec le CMS. Il est possible (via la
création d'un module) d'en ajouter.

### Définition des valeurs

Partie incomplète.

- `label` (`String`)
  Le titre du champ

- `default` (`String` ou `List`)
  La valeur par défaut du champ

- `required` (`Bool`)
  Définit si le champ est obligatoire ou non

- `message` (`String`)
  Message d'aide

- `placeholder` (`String`)
  Petit message indicatif sur les champs textuels

- `options` (`List`)
  Les options possibles pour un champ

- `min` (`Num`)
  Le nombre ou la taille minimale d'un champ

- `max` (`Num`)
  Le nombre ou la taille maximale d'un champ

- `step` (`Num`)
  Le pas entre deux valeurs

- `format` (`String`)
  Le format que doit respecter le champ
  Valeurs possibles :
  - `color`
    - `rgba`
    - `rgb`
    - `hex`
    - `hsl`
  - `file`
    - format simple : `json`
    - liste de formats : `[ "json", "png", "c" ]`
  - `password`
    - expression régulière
  - `textarea`
    - `text`
		- `wysiwyg`
		- un langage parmi `markdown`, `twig`, `html`
		- tous les langages : `javascript`, `java`, `go`, `css`, `c`, `cpp`, ...
  - `text`
    - `text`
    - `regex`
    - `icon`
    - `twitter`
    - `github`
  - `time`
    - `hh:mm`
    - `hh:mm:ss`
