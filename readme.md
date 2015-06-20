Champs
------

### Les champs et leurs valeurs possibles

    .
                 +-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
                 | label | default | required | message | placeholder | options | min | max | step | format |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | checkboxes |   x   |    x    |    x     |    x    |             |    x    |  x  |  x  |      |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | choice     |   x   |    x    |    x     |    x    |             |    x    |     |     |      |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | date       |   x   |    x    |    x     |    x    |      x      |    x    |  x  |  x  |  x   |   x    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | email      |   x   |    x    |    x     |    x    |      x      |    x    |  x  |  x  |      |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | number     |   x   |    x    |    x     |    x    |      x      |    x    |  x  |  x  |  x   |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | password   |   x   |    x    |    x     |    x    |      x      |    x    |  x  |  x  |      |   x    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | range      |   x   |    x    |    x     |    x    |             |    x    |  x  |  x  |  x   |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | tel        |   x   |    x    |    x     |    x    |      x      |    x    |     |     |      |   x    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | textarea   |   x   |    x    |    x     |    x    |      x      |    x    |  x  |  x  |      |   x    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | text       |   x   |    x    |    x     |    x    |      x      |    x    |  x  |  x  |      |   x    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | time       |   x   |    x    |    x     |    x    |      x      |    x    |  x  |  x  |  x   |   x    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | url        |   x   |    x    |    x     |    x    |      x      |    x    |  x  |  x  |      |   x    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | color      |   x   |    x    |    x     |    x    |      x      |    x    |     |     |      |   x    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | title      |   x   |    x    |    x     |    x    |      x      |    x    |     |     |      |   x    |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | user       |   x   |    x    |    x     |    x    |      x      |    x    |  x  |  x  |      |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | tags       |   x   |    x    |    x     |    x    |      x      |    x    |  x  |  x  |      |        |
    +------------+-------+---------+----------+---------+-------------+---------+-----+-----+------+--------+
    | slug       |   x   |    x    |    x     |    x    |      x      |    x    |  x  |  x  |      |   x    |
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
  Valeur possibles :
  - date
    - dd/mm/yyyy
    - mm/dd/yyyy
    - yyyy/mm/dd
  - password
  - tel
    - 0000000000
    - 00 00 00 00 00
    - 00.00.00.00.00
    - 00-00-00-00-00
    - à compléter
  - textarea
    - expression régulière
    - alpha
    - number
    - alphanum
  - text
    - expression régulière
    - alpha
    - number
    - alphanum
  - time
    - hh:mm:ss [AM|PM]
    - hh mm ss [AM|PM]
    - hh h mm m ss s [AM|PM]
  - url
    - expression régulière
  - color
    - rgba
    - rgb
    - hex
  - title
    - expression régulière
    - alpha
    - number
    - alphanum
  - slug
    - expression régulière
    - alpha
    - number
    - alphanum
