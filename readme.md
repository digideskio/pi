Champs
------

### Les champs et leurs valeurs possibles

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

### Définition des valeurs

Partie incomplète.

- label (String)
  Le titre du champ

- default (String ou List)
  La valeur par défaut du champ

- required (Bool)
  Définit si le champ est obligatoire ou non

- message (String)
  Message d'aide

- placeholder (String)
  Petit message indicatif sur les champs textuels

- options (List)
  Les options possibles pour un champ

- min (Num)
  Le nombre ou la taille minimale d'un champ

- max (Num)
  Le nombre ou la taille maximale d'un champ

- step (Num)
  Le pas entre deux valeurs

- format (String)
  Le format que doit respecter le champ
  Valeurs possibles :
  - code
    - un langage de programmation
  - color
    - rgba
    - rgb
    - hex
    - hsl
  - file
    - format simple : json
    - liste de formats : [ "json", "png", "c" ]
  - password
    - expression régulière
  - textarea
    - expression régulière
    - text
    - markdown
    - json
    - ini
    - yaml
    - cson
    - xml
  - text
    - expression régulière
  - time
    - hh:mm
    - hh:mm:ss

Modèles
-------

### Un modèle est modifié
Un champ ajouté   = valeur vide ou par défaut dans les pages créées avec ce modèle
Un champ supprimé = champ supprimé sur les pages créées avec ce modèle
Un champ modifié  = un champ supprimé et un champ ajouté

Pour savoir si le champ a été ajouté, supprimé ou modifié, on se base sur le nom et le type du champ
