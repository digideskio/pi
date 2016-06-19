# À faire

Voici une liste non-exhaustive des choses à faire pour que Pi puisse être un
projet utilisable en production.

- Administration :
	- Gérer les pages ;
	- Gérer les modules (activation, personnalisation, ...) ;
	- Gérer les utilisateurs (avec permissions) ;
	- Gérer les paramètres du site ;
	- Gérer les paramètres avancés du site ;
	- Donner la possibilité, via les modules, de créer des « filtres ».
	  C'est-à-dire de créer des pages d'administration qui n'afficheront que
	  les pages qui correspondent à ce filtre, un peu comme le fait
	  PageCollection pour les pages ;

- Thème :
	- Ajouter la possibilité de partager des données communes entre les thèmes ;
	- Ajouter la possibilité de faire un thème hérité. Une vue inexistante dans
	  le thème sera recherchée dans le thème parent en remontant jusqu'au premier
	  thème et utilisera la vue du thème « classic » dans le cas où la vue
	  n'existe dans aucun des thèmes ;
	- Ajouter la possibilité de désenregistrer un CSS ou JS ;
	- Un thème doit pouvoir surcharger la vue d'un modèle ;

- Module :
	- Un module doit pouvoir créer un modèle, surcharger un modèle, ajouter et
    modifier des permissions utilisateur, ajouter un champ, surcharger un
    champ, ... ;

- Autre :
	- Ajouter la possibilité d'ajouter une table des matière n'importe où (dans
	  les textarea du type « twig » ou « markdown ») ;
	- Ajouter la possibilité de faire un fil d'Ariane (possibilité d'ajouter une
	  page parent) ;

- ...
