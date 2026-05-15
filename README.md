# 🏠 OpenDoor — Plateforme Immobilière

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)
![Leaflet](https://img.shields.io/badge/Leaflet.js-1.9-199900?style=for-the-badge&logo=leaflet&logoColor=white)
![PHPUnit](https://img.shields.io/badge/PHPUnit-12-3F51B5?style=for-the-badge&logo=php&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)

**Plateforme immobilière moderne développée avec Laravel 13**  
*Annonces · Géolocalisation · Médias polymorphes · Tableau de bord analytique*

---

[🚀 Installation rapide](#-installation-rapide) · [📖 Documentation](#-structure-du-projet) · [🧪 Tests](#-tests) · [🚢 Déploiement](#-déploiement)

</div>

---

## 📋 Table des matières

- [Présentation](#-présentation)
- [Fonctionnalités](#-fonctionnalités)
- [Stack technique](#-stack-technique)
- [Prérequis](#-prérequis)
- [Installation rapide](#-installation-rapide)
- [Configuration](#-configuration)
- [Structure du projet](#-structure-du-projet)
- [Base de données](#-base-de-données)
- [Routes principales](#-routes-principales)
- [Tests](#-tests)
- [Déploiement](#-déploiement)
- [Auteure](#-auteure)

---

## 🎯 Présentation

**OpenDoor** est une plateforme immobilière sur mesure développée dans le cadre d'un stage de 4 semaines chez [WebExperts](https://webexperts.ma) (Safi, Maroc). Elle permet la publication, la recherche et la gestion d'annonces immobilières avec une expérience utilisateur moderne et une architecture technique robuste.

### Points différenciants

| Fonctionnalité | Détail |
|---|---|
| 🗺️ **Géolocalisation temps réel** | Carte Leaflet + algorithme Haversine côté client, aucune requête serveur supplémentaire |
| 🎨 **Médias polymorphes** | Images, vidéos locales, liens YouTube/Vimeo et articles rattachés à une annonce via une seule relation |
| 🔐 **Sécurité granulaire** | Laravel Policies : chaque propriétaire ne peut modifier que ses propres annonces |
| 📊 **Analytics marché** | Statistiques de prix, vues, types de biens et quartiers populaires |
| 🛡️ **Administration complète** | Modération des annonces, gestion des utilisateurs, traitement des réclamations |
| 🧪 **107 tests automatisés** | Couverture unitaire et feature des modèles, contrôleurs, policies et intégrité BDD |

---

## ✨ Fonctionnalités

### Visiteur (non connecté)
- 🔍 Consulter et filtrer les annonces (ville, type de bien, prix, surface)
- 📍 Explorer les biens à proximité via géolocalisation GPS
- 📊 Consulter l'analyse du marché immobilier local
- 💬 Envoyer un message de contact au propriétaire
- ⭐ Laisser un témoignage et des commentaires

### Utilisateur authentifié
- ➕ Créer, modifier, archiver ses annonces avec upload de médias (jusqu'à 40 Mo)
- 📸 Joindre des images, vidéos locales, liens YouTube/Vimeo et articles
- 📩 Consulter les messages reçus sur ses annonces
- 💬 Modérer les commentaires de ses annonces
- 🚨 Soumettre des réclamations à l'administration
- 👤 Gérer son profil (nom, email, mot de passe)

### Administrateur
- ✅ Approuver ou rejeter les annonces soumises
- 👥 Gérer les comptes utilisateurs (activation/désactivation/suppression)
- 📋 Traiter les réclamations (statuts : ouvert / en_cours / resolu)
- 📈 Tableau de bord analytique avec statistiques et graphiques (24h / 7j / 30j)
- 🗣️ Modérer les témoignages clients

---

## 🛠️ Stack technique

| Catégorie | Technologie | Version | Usage |
|---|---|---|---|
| **Framework Back-end** | Laravel | 13.x | MVC, Eloquent ORM, Policies, Breeze Auth |
| **Langage** | PHP | 8.3+ | — |
| **Base de données** | MySQL | 8.0 | Production |
| **Base de données tests** | SQLite | — | In-memory (isolation tests) |
| **CSS** | Tailwind CSS | 3.x | Design system utility-first, mobile-first |
| **JavaScript** | Alpine.js | 3.x | Réactivité : filtres, modales, formulaires |
| **Cartographie** | Leaflet.js | 1.9 | Carte interactive + géolocalisation GPS |
| **Build** | Vite | 7.x | Compilation assets CSS/JS |
| **Tests** | PHPUnit | 12 | Tests unitaires et feature |
| **Auth** | Laravel Breeze | — | Authentification complète |
| **Déploiement** | Railway / VPS Nginx | — | Cloud + HTTPS Let's Encrypt |

---

## 📦 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **PHP** `>= 8.3` avec les extensions : `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd`
- **Composer** `>= 2.x`
- **Node.js** `>= 20.x` et **npm**
- **MySQL** `>= 8.0` (ou MariaDB `>= 10.4`)
- **Git**

---

## 🚀 Installation rapide

### 1. Cloner le projet

```bash
git clone https://github.com/votre-username/opendoor.git
cd opendoor
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances JavaScript

```bash
npm install
```

### 4. Configurer l'environnement

```bash
# Copier le fichier .env
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 5. Configurer la base de données

Éditez le fichier `.env` et renseignez vos paramètres MySQL :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=opendoor
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

### 6. Exécuter les migrations

```bash
php artisan migrate
```

### 7. Créer le lien symbolique pour les fichiers

```bash
php artisan storage:link
```

### 8. Compiler les assets frontend

```bash
# Développement (avec watcher)
npm run dev

# Production
npm run build
```

### 9. Lancer le serveur de développement

```bash
php artisan serve
```

L'application est accessible sur **http://localhost:8000** 🎉

---

## ⚙️ Configuration

### Variables d'environnement importantes (`.env`)

```env
# Application
APP_NAME="OpenDoor"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=opendoor
DB_USERNAME=root
DB_PASSWORD=

# Stockage des médias
FILESYSTEM_DISK=public

# Upload (à configurer aussi dans php.ini)
# upload_max_filesize = 40M
# post_max_size = 42M
```

### Créer un compte administrateur

```bash
# Via Tinker (console interactive Laravel)
php artisan tinker

# Dans la console :
\App\Models\User::create([
    'name'     => 'Administrateur',
    'email'    => 'admin@opendoor.ma',
    'password' => bcrypt('VotreMotDePasse123!'),
    'is_admin' => true,
    'is_active' => true,
]);
```

### Données de démonstration (optionnel)

```bash
php artisan db:seed
```

---

## 📁 Structure du projet

```
opendoor/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdmineController.php       # Dashboard admin, modération, stats
│   │   │   ├── CommentController.php      # Gestion des commentaires
│   │   │   ├── DashboardController.php    # Dashboard utilisateur
│   │   │   ├── HomeController.php         # Page d'accueil
│   │   │   ├── MessageController.php      # Messages de contact
│   │   │   ├── ProfileController.php      # Gestion du profil
│   │   │   ├── PropertyController.php     # CRUD annonces, géoloc, analytics
│   │   │   ├── ReclamationController.php  # Réclamations
│   │   │   ├── RessourceController.php    # Upload/suppression médias
│   │   │   └── TestimonialController.php  # Témoignages clients
│   │   └── Middleware/
│   │       └── AdminMiddleware.php        # Protection routes admin
│   ├── Models/
│   │   ├── Article.php                    # Article lié à une annonce
│   │   ├── Commentaire.php               # Commentaires sur annonces
│   │   ├── Image.php                      # Images uploadées
│   │   ├── Message.php                    # Messages de contact
│   │   ├── Property.php                   # Annonce immobilière
│   │   ├── Reclamation.php               # Réclamations
│   │   ├── Ressource.php                  # Pivot polymorphique médias
│   │   ├── Testimonial.php               # Témoignages
│   │   ├── User.php                       # Utilisateurs
│   │   └── Video.php                      # Vidéos locales / YouTube
│   └── Policies/
│       └── PropertyPolicy.php             # Contrôle d'accès annonces
├── database/
│   ├── migrations/                        # 18 migrations
│   └── seeders/                           # Données de démonstration
├── resources/
│   └── views/                             # Templates Blade
│       ├── properties/                    # Pages annonces publiques
│       ├── user/                          # Dashboard utilisateur
│       ├── admin/                         # Interface d'administration
│       └── components/                    # Composants réutilisables
├── routes/
│   └── web.php                            # Toutes les routes
├── storage/
│   └── app/public/                        # Médias uploadés
├── tests/
│   ├── Unit/                              # 32 tests unitaires
│   └── Feature/                           # 75 tests feature
├── public/                                # Point d'entrée web
├── .env.example                           # Template configuration
├── phpunit.xml                            # Configuration PHPUnit
└── DEPLOIEMENT.md                         # Guide déploiement détaillé
```

---

## 🗄️ Base de données

### Schéma simplifié

```
USERS (id, name, email, password, is_admin, is_active)
  │
  ├── PROPERTIES (id, title, description, price, type_transaction,
  │              type_bien, surface, rooms, city, address, phone,
  │              status, is_approved, views_count, latitude, longitude)
  │     │
  │     ├── RESSOURCES (id, property_id, resourceable_type, resourceable_id)
  │     │     ├── IMAGES    (id, path, caption)
  │     │     ├── VIDEOS    (id, path, url, provider)
  │     │     └── ARTICLES  (id, title, content, author_name)
  │     │
  │     ├── COMMENTAIRES (id, property_id, user_id, guest_name,
  │     │                content, is_approved)
  │     │
  │     └── MESSAGES (id, property_id, receiver_id, visitor_name,
  │                  visitor_email, content, is_read)
  │
  ├── RECLAMATIONS (id, user_id, subject, message, priority, status, is_read)
  │
  └── TESTIMONIALS (id, name, content, rating, is_approved)
```

### Valeurs des énumérations

| Champ | Valeurs |
|---|---|
| `properties.type_transaction` | `vente`, `location` |
| `properties.type_bien` | `appartement`, `maison`, `terrain`, `commercial` |
| `properties.status` | `publiee`, `brouillon`, `archivee` |
| `reclamations.priority` | `basse`, `normale`, `urgente` |
| `reclamations.status` | `ouvert`, `en_cours`, `resolu` |

---

## 🗺️ Routes principales

### Publiques

| Méthode | URI | Description |
|---|---|---|
| `GET` | `/` | Page d'accueil |
| `GET` | `/annonces` | Liste des annonces (avec filtres) |
| `GET` | `/annonces/{id}` | Détail d'une annonce |
| `GET` | `/annonces/autour-de-moi` | Carte de proximité GPS |
| `GET` | `/annonces/analyse-du-marche` | Statistiques du marché |
| `POST` | `/annonces/{id}/contact` | Envoyer un message |
| `POST` | `/annonces/{id}/comments` | Poster un commentaire |

### Authentifié (`auth` middleware)

| Méthode | URI | Description |
|---|---|---|
| `GET` | `/dashboard` | Tableau de bord |
| `GET` | `/dashboard/mes-annonces` | Mes annonces |
| `POST` | `/user/annonces` | Créer une annonce |
| `PUT` | `/user/annonces/{id}` | Modifier une annonce |
| `DELETE` | `/user/annonces/{id}` | Supprimer une annonce |
| `GET` | `/messages` | Mes messages reçus |
| `POST` | `/reclamations` | Soumettre une réclamation |
| `GET` | `/profile` | Modifier le profil |

### Administration (`admin` middleware)

| Méthode | URI | Description |
|---|---|---|
| `GET` | `/admin` | Dashboard administrateur |
| `GET` | `/admin/annonces` | Gestion de toutes les annonces |
| `PATCH` | `/admin/annonces/{id}/moderate` | Approuver / rejeter |
| `GET` | `/admin/users` | Gestion des utilisateurs |
| `PATCH` | `/admin/users/{id}/toggle` | Activer / désactiver un compte |
| `GET` | `/admin/reclamations` | Traiter les réclamations |
| `GET` | `/admin/stats/views` | API JSON statistiques (24h/7j/30j) |

---

## 🧪 Tests

Le projet inclut **107 tests** couvrant l'intégralité de l'application.

### Lancer tous les tests

```bash
php artisan test
```

### Lancer avec détail

```bash
php artisan test --verbose
```

### Lancer une suite spécifique

```bash
# Tests unitaires uniquement
php artisan test --testsuite=Unit

# Tests feature uniquement
php artisan test --testsuite=Feature

# Un fichier spécifique
php artisan test tests/Feature/PropertyTest.php

# Un test spécifique
php artisan test --filter test_owner_can_update_their_property
```

### Couverture des tests

| Fichier | Tests | Couverture |
|---|---|---|
| `Unit/PropertyModelTest.php` | 7 | Casts, relations, fillable du modèle Property |
| `Unit/UserModelTest.php` | 6 | Casts, hidden, relations du modèle User |
| `Unit/OtherModelsTest.php` | 10 | Modèles Commentaire, Message, Reclamation |
| `Unit/PropertyPolicyTest.php` | 9 | Règles d'autorisation (Policy) |
| `Feature/PropertyTest.php` | 16 | CRUD annonces, filtres, sécurité propriétaire |
| `Feature/CommentTest.php` | 8 | Store, approve, destroy, validation |
| `Feature/MessageTest.php` | 9 | Visiteur vs connecté, marquage lu |
| `Feature/ReclamationTest.php` | 7 | Store, destroy, validations enum |
| `Feature/AdminTest.php` | 12 | Dashboard, modération, CRUD users, API stats |
| `Feature/DatabaseIntegrityTest.php` | 13 | Schéma, cascades ON DELETE, contraintes |
| `Feature/PublicPagesTest.php` | 10 | Pages publiques, dashboard |
| **Total** | **107** | — |

> **Note :** Les tests utilisent une base de données SQLite en mémoire (configurée dans `phpunit.xml`), totalement isolée de la base de développement.

---


## 🔒 Sécurité

- **CSRF** : Protection automatique Laravel sur tous les formulaires POST/PUT/DELETE
- **Authentification** : Laravel Breeze avec hachage bcrypt des mots de passe
- **Autorisation** : `PropertyPolicy` via Gates — vérification côté serveur sur chaque action
- **Middleware admin** : Les routes `/admin/*` sont protégées par `AdminMiddleware` (renvoie HTTP 403 si connecté non-admin)
- **Validation** : Toutes les entrées utilisateur sont validées côté serveur (types, longueurs, enums)
- **Upload** : Types MIME vérifiés (`jpeg`, `png`, `jpg`, `webp`, `mp4`, `mov`) avec limite à 40 Mo

---

## 📄 Licence

Ce projet a été développé dans le cadre d'un stage professionnel chez **WebExperts** (Safi, Maroc).  
© 2026 EL GOURARI Meryem — Tous droits réservés.

---

## 👩‍💻 Auteure

**EL GOURARI Meryem**  
Stagiaire Développement Web & Digital  
WebExperts — Safi, Maroc  
Tuteur de stage : M. NAINIA Omar  
Mars 2026

---

<div align="center">

Fait avec  · Laravel 13 · Tailwind CSS · Alpine.js · Leaflet.js

</div>