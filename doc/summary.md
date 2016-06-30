# Pouvoirs des entités

## Pouvoir des utilisateurs

Les utilisateurs peuvent :

- Gérer les pages (création, modification, suppression) ;
- Gérer les utilisateurs (création, modification, suppression) ;
- Gérer les thèmes (création, modification, suppression, choix) ;
- Gérer les modules (création, modification, suppression, activation) ;
- Modifier les paramètres du site via une interface graphique ;
- Modifier les paramètres du site via un fichier.

## Pouvoir des modules

Les modules peuvent :

- Enregistrer des modèles ;
- Surcharger des modèles ;
- Surcharger la vue des modèles ;
- Enregistrer un champ ;
- Surcharger un champ ;
- Enregistrer un fichier CSS ;
- Enregistrer un fichier JS ;
- Désenregistrer un fichier CSS ;
- Désenregistrer un fichier JS.

## Pouvoir des thèmes

Les thèmes peuvent :

- Surcharger la vue des modèles ;
- Enregistrer un fichier CSS ;
- Enregistrer un fichier JS ;
- Désenregistrer un fichier CSS ;
- Désenregistrer un fichier JS.

# Notes

## Surcharge des modèles et des champs

Chaque modèle ou champ peut être enregistré une seule fois (il ne peut pas y
avoir plusieurs modèles ou champs avec le même nom). La surcharge de chaque
modèle ou champ n'est elle aussi autorisée qu'une fois.

Il est aussi possible de surcharger une deuxième fois la vue. Cela est
notamment utilisé par les thèmes afin d'adapter la vue d'un modèle à celui-ci.

## Héritage des thèmes

Si vous créez un thème B qui hérite du thème A, quand les fichiers HTML, CSS et
JS seront chargés, ils seront d'abord recherchés dans le dossier du thème B
puis ensuite du thème A.

Cela permet de profiter des mises à jour d'un thème sans écraser les données
que l'on a enregistré soi-même.
