# À faire pour la mise en production

Voici une liste non-exhaustive des choses à faire pour que Pi puisse être un
projet utilisable en production.

- Administration :
  - Gérer les pages ;
  - Gérer les utilisateurs (avec permissions) ;
  - Gérer les paramètres du site ;
  - Gérer les paramètres avancés du site ;

- Modules :
  - Un module doit pouvoir, ajouter et modifier des permissions utilisateur,
    surcharger un champ, ... ;
  - Un modèle doit pouvoir être enregistré depuis un fichier JSON ;

- Autre :
  - Ajouter la possibilité d'ajouter une table des matière n'importe où (dans
    les textarea du type « twig » ou « markdown ») ;
  - Ajouter la possibilité de faire un fil d'Ariane (possibilité d'ajouter une
    page parent) ;

- ...

# À faire en amont

Voici une liste non-exhaustive des choses à faire après la version 1.0.

- Administration :
  - Gérer les modules (activation, personnalisation, ...) ;
  - Gestion complète des modules (mise à jour, importation zip, etc.) ;
  - Donner la possibilité, via les modules, de créer des « filtres ».
    C'est-à-dire de créer des pages d'administration qui n'afficheront que
    les pages qui correspondent à ce filtre, un peu comme le fait
    PageCollection pour les pages ;
  - Que tout soit configurable via l'administration ;

- Thèmes :
  - Possibilité de configurer (via l'administration) le thème pour en modifier
    l'affichage. Les configurations seront stockées dans un fichier.

- Thèmes & modules :
  - Possibilité d'enregistrer des évènements pour exécuter du code ou un
    affichage à un endroit ou un moment précis ;
  - Possibilité de créer des filtres et fonctions pour les utiliser dans les
    vues ;

- Autre :
  - Ajouter des tests unitaires ;

- ...
