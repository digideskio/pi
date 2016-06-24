# Pi

Pi est un CMS qui se veut modulaire. Voici comment il fonctionne :

- Vous créez des modèles (par exemple un modèle « article ») ;
- Vous créez des pages avec vos modèle (donc un article, par exemple) ;
- Vous visualisez vos pages.

Il s'agit d'un CMS plutôt orienté pour les développeurs car le format des
modèles est JSON (ou PHP, au choix) et la vue associée utilise [Twig][] (et
donc HTML).

Un modèle, c'est une liste de champs. Par exemple pour le modèle « Article » il
faut définir un champ titre et un champ contenu (l'exemple est simplifié ici
pour ne pas surcharger). Ensuite à la création de la page il faut sélectionner
le modèle, remplir les champs puis enregistrer.

Les thèmes aussi sont plutôt orienté développeurs (ou au moins intégrateur) car
ils utilisent aussi [Twig][].

Le CMS étant modulaire, des modules de base ainsi qu'un thème seront fournis
pour pouvoir créer un site. La communauté pourra aussi contribuer à la création
de modules et les partager.

Configurations minimales :

- PHP 7 ;
- Apache ;
- URL rewriting.

[Twig]: http://twig.sensiolabs.org/
