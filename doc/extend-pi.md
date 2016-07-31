# Pi

Pi est un CMS qui se veut extensible. Pour cela, vous avez la possibilité de
créer des champs, des modèles et des thèmes.

Vous avez aussi la possibilité de surcharger un champ ou un modèle existant.

Les thèmes fonctionnent pas héritage.

## Modules

Il est possible de modifier l'affichage d'un modèle de trois façons
différentes :

- En modifiant le fichier `content/models/[nom modèle]/view.html` (très mauvaise
  pratique) ;
- En créant un fichier dans le thème courant avec le chemin suivant :
  `content/themes/[nom thème]/tpl/models/[nom modèle].html` ;
- En créant un module avec un fichier dont le chemin est le
  suivant : `content/modules/[nom module]/[nom modèle].html` (le fichier peut
  bien sûr être placé dans des sous-dossiers).
