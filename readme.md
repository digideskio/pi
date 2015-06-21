Champs
------

### Les champs et leurs valeurs possibles

    y = implémenté
    n = non implémenté

                 +-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
                 | label | default | required | message | placeholder | options | min | max | step | format |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | checkboxes |   y   |    y    |    n     |    n    |             |    y    |  n  |  n  |      |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | choice     |   y   |    y    |    y     |    n    |             |    y    |     |     |      |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | date       |   y   |    y    |    y     |    n    |      y      |    n    |  n  |  n  |  n   |   n    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | email      |   y   |    y    |    y     |    n    |      y      |    n    |  n  |  n  |      |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | file       |   y   |    n    |    y     |    n    |             |    n    |  n  |  n  |      |   n    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | number     |   y   |    y    |    y     |    n    |             |    n    |  n  |  n  |  y   |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | password   |   y   |    y    |    y     |    n    |      y      |    n    |  n  |  n  |      |   n    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | range      |   y   |    y    |          |    n    |             |    n    |  n  |  n  |  y   |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | tel        |   y   |    y    |    y     |    n    |      y      |    n    |     |     |      |   n    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | textarea   |   y   |    y    |    y     |    n    |      y      |    n    |  n  |  n  |      |   n    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | text       |   y   |    y    |    y     |    n    |      y      |    n    |  n  |  n  |      |   n    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | time       |   y   |    y    |    y     |    n    |      y      |    n    |  n  |  n  |  n   |   n    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | url        |   y   |    y    |    y     |    n    |      y      |    n    |  n  |  n  |      |   n    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | color      |   y   |    y    |          |    n    |             |    n    |     |     |      |   n    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | title      |   y   |    y    |    y     |    n    |      y      |    n    |     |     |      |   n    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | user       |   y   |    n    |    n     |    n    |      n      |    n    |  n  |  n  |      |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | tags       |   y   |    n    |    n     |    n    |      n      |    n    |  n  |  n  |      |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | slug       |   y   |    y    |    y     |    n    |      y      |    n    |  n  |  n  |      |   n    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+

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
  - color
    - rgba
    - rgb
    - hex
  - date
    - dd/mm/yyyy
    - mm/dd/yyyy
    - yyyy/mm/dd
  - password
    - expression régulière
  - slug
    - expression régulière
    - alpha
    - number
    - alphanum
  - tel
    - 0000000000
    - 00 00 00 00 00
    - 00.00.00.00.00
    - 00-00-00-00-00
    - à compléter
  - text
    - expression régulière
    - alpha
    - number
    - alphanum
  - textarea
    - expression régulière
    - alpha
    - number
    - alphanum
  - time
    - hh:mm:ss [AM|PM]
    - hh mm ss [AM|PM]
    - hh h mm m ss s [AM|PM]
  - title
    - expression régulière
    - alpha
    - number
    - alphanum
  - url
    - expression régulière
