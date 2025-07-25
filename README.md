# Mini-Framework PHP MVC Challenge2

Un mini-framework PHP léger implémentant le pattern MVC avec support multi-base de données, système de routage, middlewares et gestion de sessions.

## 🚀 Installation

```bash
composer require zaff/challenge2
```

## 📋 Prérequis

- PHP 8.0+
- Composer
- Base de données (MySQL, PostgreSQL ou SQLite)

## 🏗️ Structure du Projet

```
miniFrameworkChallenge2/
├── config/
│   ├── core/                    # Classes du framework
│   │   ├── AbstractController.php
│   │   ├── AbstractEntity.php
│   │   ├── AbstractRepository.php
│   │   ├── App.php              # Container d'injection de dépendances
│   │   ├── Database.php         # Connexion base de données
│   │   ├── DatabaseFactory.php  # Factory pour la DB
│   │   ├── Router.php           # Système de routage
│   │   ├── Session.php          # Gestion des sessions
│   │   ├── Validator.php        # Validation des données
│   │   └── middleware.php       # Middlewares d'authentification
│   ├── bootstrap.php            # Initialisation
│   ├── env.php                  # Configuration environnement
│   └── helpers.php              # Fonctions utilitaires
├── controller/                  # Contrôleurs de l'application
├── src/
│   ├── entities/               # Entités métier
│   ├── repository/             # Couche d'accès aux données
│   └── service/                # Services métier
├── template/                   # Vues et templates
│   └── layout/                 # Layouts de base
├── route/
│   └── route.web.php           # Définition des routes
├── public/
│   └── index.php               # Point d'entrée
├── .env                        # Variables d'environnement
└── composer.json
```

## ⚙️ Configuration

### 1. Variables d'environnement

Créez un fichier `.env` à la racine du projet :

```env
APP_URL=http://localhost:8000

# Choix du driver : pgsql, mysql ou sqlite
DB_DRIVER=mysql

# Pour PostgreSQL/MySQL
DB_HOST=localhost
DB_PORT=3306
DB_NAME=votre_base
DB_USER=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe

# Pour SQLite (optionnel)
# DB_PATH=/chemin/vers/ta_base.sqlite
```

### 2. Autoloading PSR-4

Le framework utilise l'autoloading PSR-4 configuré dans `composer.json` :

```json
{
    "autoload": {
        "psr-4": {
            "Vendor\\Challenge2\\": "src/",
            "App\\Entity\\": "src/entities/",
            "App\\Config\\Core\\": "config/core/",
            "App\\Repository\\": "src/repository/",
            "App\\Service\\": "src/service/",
            "App\\Controller\\": "controller/"
        }
    }
}
```

## 🛣️ Système de Routage

### Définition des routes

Dans `route/route.web.php` :

```php
use App\Config\Core\Router;
use App\Controller\CommandeController;
use App\Controller\SecurityController;

// Routes publiques
Router::get('/', SecurityController::class, 'index');
Router::post('/login', SecurityController::class, 'authenticate');

// Routes protégées par middleware
Router::get('/list', CommandeController::class, 'index', ['auth']);
Router::get('/form', CommandeController::class, 'create', ['auth', 'isVendeur']);

// Résolution des routes
Router::resolve();
```

### Méthodes disponibles

- `Router::get($uri, $controller, $action, $middlewares = [])`
- `Router::post($uri, $controller, $action, $middlewares = [])`

## 🎮 Contrôleurs

### Contrôleur abstrait

Tous les contrôleurs héritent de `AbstractController` :

```php
use App\Config\Core\AbstractController;

class MonController extends AbstractController
{
    public function index()
    {
        // Logique pour lister
        $this->renderHtml('ma_vue.php', ['data' => $data]);
    }

    public function create()
    {
        // Logique pour créer
    }

    public function store()
    {
        // Logique pour sauvegarder
    }

    public function show()
    {
        // Logique pour afficher un élément
    }

    public function edit()
    {
        // Logique pour éditer
    }

    public function destroy()
    {
        // Logique pour supprimer
    }
}
```

### Méthodes obligatoires

Chaque contrôleur doit implémenter ces méthodes :

- `index()` - Lister les éléments
- `create()` - Afficher le formulaire de création
- `store()` - Traiter la création
- `show()` - Afficher un élément
- `edit()` - Afficher le formulaire d'édition
- `destroy()` - Supprimer un élément

### Rendu des vues

```php
protected function renderHtml(string $view, array $params = [])
{
    // $view : chemin vers la vue (ex: 'commande/list.php')
    // $params : données à passer à la vue
}
```

## 🗄️ Base de Données

### Support multi-base

Le framework supporte trois types de bases de données :

- **MySQL** : `DB_DRIVER=mysql`
- **PostgreSQL** : `DB_DRIVER=pgsql`
- **SQLite** : `DB_DRIVER=sqlite`

### Connexion

```php
use App\Config\Core\Database;

$pdo = Database::getConnection();
```

### Container d'injection de dépendances

```php
use App\Config\Core\App;

// Récupérer une dépendance
$pdo = App::get('pdo');
```

## 📊 Modèles et Repositories

### Entité abstraite

```php
use App\Config\Core\AbstractEntity;

class MonEntity extends AbstractEntity
{
    public static function toObject(array $tableau): static
    {
        // Convertir un tableau en objet
    }

    public function toArray(Object $object): array
    {
        // Convertir un objet en tableau
    }
}
```

### Repository abstrait

```php
abstract class AbstractRepository
{
    abstract public function selectAll();
    abstract public function insert();
    abstract public function update();
    abstract public function delete();
    abstract public function selectById();
    abstract public function selectBy(Array $filtre);
}
```

## 🔐 Authentification et Middlewares

### Middlewares disponibles

- `auth` - Vérifier si l'utilisateur est connecté
- `isVendeur` - Vérifier si l'utilisateur est un vendeur
- `isClient` - Vérifier si l'utilisateur est un client

### Utilisation

```php
// Route protégée par authentification
Router::get('/dashboard', Controller::class, 'index', ['auth']);

// Route pour vendeurs uniquement
Router::get('/admin', Controller::class, 'admin', ['auth', 'isVendeur']);
```

### Création de middlewares personnalisés

Dans `config/core/middleware.php` :

```php
$middlewares['monMiddleware'] = 'maFonction';

function maFonction()
{
    // Logique du middleware
    if (!$condition) {
        header('Location: /erreur');
        exit;
    }
}
```

## 🔧 Session

### Utilisation

```php
use App\Config\Core\Session;

$session = Session::getInstance();

// Définir une valeur
$session->set('user_id', 123);

// Récupérer une valeur
$userId = $session->get('user_id');

// Vérifier l'existence
if ($session->isset('user_id')) {
    // ...
}

// Supprimer une clé
$session->unset('user_id');

// Détruire la session
$session->destroy();
```

## ✅ Validation

### Utilisation du validateur

```php
use App\Config\Core\Validator;

$validator = new Validator();

// Validation email
$validator->isEmail('email', $email, 'Email invalide');

// Validation champ vide
$validator->isEmpty('nom', $nom, 'Le nom est requis');

// Vérifier les erreurs
if ($validator->isValid()) {
    // Aucune erreur
} else {
    $errors = $validator->getErrors();
}
```

## 🎨 Vues et Layouts

### Structure des templates

```
template/
├── layout/
│   └── base.layout.php     # Layout de base
├── commande/
│   ├── list.php           # Vue liste
│   ├── form.php           # Vue formulaire
│   └── 404.php            # Page d'erreur
```

### Layout de base

Le contenu de la vue est injecté dans la variable `$contentForLayout` :

```php
<!DOCTYPE html>
<html>
<head>
    <title>Mon App</title>
</head>
<body>
    <?= $contentForLayout ?>
</body>
</html>
```

## 🛠️ Utilitaires

### Fonction de debug

```php
// Dans config/helpers.php
dd($variable); // Affiche et arrête l'exécution
```

## 🚀 Démarrage Rapide

1. **Installation**
   ```bash
   composer require zaff/challenge2
   ```

2. **Configuration**
   ```bash
   cp .env.example .env
   # Éditer le fichier .env avec vos paramètres
   ```

3. **Créer un contrôleur**
   ```php
   // controller/MonController.php
   class MonController extends AbstractController
   {
       public function index()
       {
           $this->renderHtml('ma_vue.php', ['titre' => 'Bonjour']);
       }
       
       // Implémenter les autres méthodes...
   }
   ```

4. **Définir les routes**
   ```php
   // route/route.web.php
   Router::get('/ma-route', MonController::class, 'index');
   ```

5. **Lancer le serveur**
   ```bash
   php -S localhost:8000 -t public/
   ```

## 📝 Notes Importantes

- Le framework utilise le pattern Singleton pour la session et la base de données
- Les middlewares sont exécutés dans l'ordre de déclaration
- Toutes les vues doivent être placées dans le dossier `template/`
- Le container `App` centralise toutes les dépendances du projet
- Le système de routage supporte uniquement GET et POST

## 🤝 Contribution

Pour contribuer au projet :

1. Fork le repository
2. Créer une branche feature
3. Committer vos changements
4. Pousser vers la branche
5. Créer une Pull Request

## 👥 Auteur

**Moustapha Seck** - Développeur principal

---

*Ce mini-framework est conçu pour l'apprentissage et les projets de petite à moyenne envergure. Il implémente les patterns MVC classiques avec une approche moderne.*