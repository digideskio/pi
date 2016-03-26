# Pi

Pi est un CMS qui se veut modulaire.

## Modèles

### Créer ou modifier un modèle

#### Création d'un modèle

- Se placer dans le dossier `/content/models/` ;
- Créer un dossier portant le nom du modèle en minuscule : « 0-9, a-z, _ » ;
- Créer deux fichiers dans ce nouveau dossier :
  - `view.html` ;
  - `model.yaml`.

Le modèle (model.yaml) contient deux valeurs :
- `title` : le titre du modèle ;
- `fields` : la liste des champs.

#### Modification d'un modèle

- Un champ ajouté : valeur vide ou par défaut dans les pages créées avec ce
  modèle ;
- Un champ supprimé : champ supprimé sur les pages créées avec ce modèle ;
- Un champ modifié : un champ supprimé et un champ ajouté.

Pour savoir si le champ a été ajouté, supprimé ou modifié, on se base sur le nom
et le type du champ

## La vue

Variables disponibles dans toutes les vues :

- `url`
  - `site` : lien complet vers le site
  - `theme` : lien complet vers le thème courant
  - `current` : lien complet vers la page actuelle
- `config`
  - `site`
    - `name` : nom du site
    - `theme` : slug du thème
- `dir`
  - `site` : chemin complet vers le site
	- `theme` : chemin complet vers le thème courant

Variables disponibles en supplément dans les pages :

- `meta`
  - `model` : slug du modèle
  - `created_at` : date de création de la page
  - `updated_at` : date de dernière modification de la page
- `page` : tous les champs liés à la page

## Pages spéciales

Il existe deux pages spéciales qui doivent obligatoirement exister :

- `home` : la page d'accueil ;
- `error` : la page d'erreur (404 par exemple).

## Champs

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
  - `code`
    - un langage de programmation
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
    - `regex`
    - `markdown`
    - `json`
    - `ini`
    - `yaml`
    - `cson`
    - `xml`
  - `text`
    - `text`
    - `regex`
    - `icon`
    - `twitter`
    - `github`
  - `time`
    - `hh:mm`
    - `hh:mm:ss`
