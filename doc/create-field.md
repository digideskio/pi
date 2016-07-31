# Créer un champ

Créer un champ peut potentiellement s'avérer utile si les existants ne
suffisent pas.

Pour créer un champ, suivez d'abord la [procédure de création d'un
module](create-module.md) puis revenez ici pour la suite.

## Créer une classe

Pour créer un champ, il faut commencer par créer une classe, une bonne
pratique est de créer un dossier `field` dans le dossier du module puis
de créer un fichier `${NomChamp}Field.php` avec le contenu suivant :

```php
namespace Module\${NomModule}\Field;

use Pi\Core\Model\Field;
use Pi\Lib\Num;
use Pi\Lib\Html\Tag;

class ${NomChamp}Field extends Field {
  public function __construct(array $data = []) {
    parent::__construct($data);
  }

  public function validate(): bool {
    return false;
  }

  public function value(): array {
    return '';
  }

  public function html(): string {
    return '';
  }
}
```

## Enregistrer le champ

Dans la méthode `initialize` du module, ajouter le code suivant :

```
$this->registerField('${nom_champ}', Field\${NomChamp}Field::class);
```

`${nom_champ}` doit être le nom de votre champ en minuscule avec un tiret bas
avant les lettres majuscules elles aussi à écrire en minuscule.

Par exemple, pour un champ `TestField` (nom de la classe), c'est `test` qui
devrait être écrit. C'est ensuite ce second nom qui devra être utilisé dans la
création des modèles.

## Contenu des méthodes de la classe du champ

(PARTIE INCOMPLETE)
