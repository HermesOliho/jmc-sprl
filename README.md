# 🏗️ CCM SARL – Portail Web Institutionnel

> Plateforme web officielle de **CONGO CONSTRUCTION & MÉTALLIQUE SARL (CCM SARL)** développée avec **Laravel 13**, **Vue 3**, **TypeScript**, **Inertia.js** et **Tailwind CSS**.

---

## 📖 À propos

Le portail web de **CCM SARL** est une plateforme institutionnelle moderne destinée à renforcer la présence numérique de l'entreprise.

Elle permet notamment de :

- Présenter l'entreprise
- Présenter les services
- Valoriser les réalisations
- Recevoir les demandes de devis
- Gérer les candidatures
- Publier les actualités
- Fournir un espace client sécurisé
- Mettre en avant les partenaires et investisseurs

Le projet est conçu pour être **évolutif**, **sécurisé**, **performant** et conforme aux bonnes pratiques Laravel.

---

# ✨ Fonctionnalités

## 🌐 Site public

- Accueil
- À propos
- Services
- Réalisations
- Parc d'équipements
- Actualités
- Carrières
- Demande de devis
- Contact
- Galerie
- Téléchargements

---

## 👤 Espace client

- Tableau de bord
- Suivi des projets
- Téléchargement des documents
- Rapports
- Factures
- Historique
- Profil

---

## ⚙️ Administration

- Gestion des utilisateurs
- Gestion des rôles
- Gestion des permissions
- Gestion des services
- Gestion des réalisations
- Gestion des actualités
- Gestion des candidatures
- Gestion des devis
- Gestion documentaire
- Paramètres du site
- Tableau de bord statistique

---

# 🛠️ Stack technique

## Backend

- Laravel 13
- PHP 8.x
- MySQL 8
- Redis
- Laravel Queue
- Laravel Scheduler
- Laravel Notifications

---

## Frontend

- Vue 3
- TypeScript
- Inertia.js
- Tailwind CSS
- DaisyUI
- Motion for Vue
- ApexCharts

---

## Packages principaux

- spatie/laravel-permission
- spatie/laravel-medialibrary
- spatie/laravel-activitylog
- spatie/laravel-backup
- spatie/laravel-sitemap
- spatie/laravel-pdf
- ralphjsmit/laravel-seo

---

## Outils de développement

- Vite
- Composer
- npm
- Laravel Pint
- ESLint
- Prettier
- PHPStan
- Pest

---

# 🏛️ Architecture

```
Internet
    │
Laravel 13
    │
───────────────
│             │
Blade      Inertia
│             │
│         Vue 3
│             │
───────────────
    │
 Services
    │
 MySQL
```

---

# 📁 Structure du projet

```
app/
bootstrap/
config/
database/
public/
resources/
│
├── css/
├── js/
│   ├── Components/
│   ├── Composables/
│   ├── Layouts/
│   ├── Pages/
│   ├── Stores/
│   ├── Types/
│   ├── Utils/
│   └── App.ts
│
├── views/
│
routes/
storage/
tests/
```

---

# 🔐 Authentification

Le projet utilise l'authentification native de Laravel.

Fonctionnalités :

- Connexion
- Déconnexion
- Réinitialisation du mot de passe
- Vérification d'email
- Sessions sécurisées

---

# 🛡️ Gestion des rôles

Les autorisations sont gérées grâce à **Spatie Laravel Permission**.

## Rôles

- Super Administrateur
- Administrateur
- Responsable Technique
- Responsable Commercial
- Responsable RH
- Rédacteur
- Client
- Partenaire
- Investisseur

Les permissions sont attribuées de manière granulaire.

---

# 📂 Gestion des fichiers

Le système permet le téléversement de :

- Images
- PDF
- Plans DWG
- DOCX
- XLSX
- ZIP
- MP4

Fonctionnalités :

- Drag & Drop
- Barre de progression
- Prévisualisation
- Validation
- Téléversement multiple

---

# 📊 Tableau de bord

Les statistiques sont générées avec **ApexCharts**.

Exemples :

- Évolution des devis
- Répartition des projets
- Candidatures
- Visites
- Nouveaux clients

---

# 🎨 Interface utilisateur

Le design repose sur :

- Tailwind CSS
- DaisyUI
- Motion for Vue

Objectifs :

- Responsive
- Moderne
- Rapide
- Accessible

---

# 🚀 Installation

## Cloner le dépôt

```bash
git clone <repository-url>
```

---

## Installer les dépendances PHP

```bash
composer install
```

---

## Installer les dépendances JavaScript

```bash
npm install
```

---

## Copier le fichier d'environnement

```bash
cp .env.example .env
```

---

## Générer la clé

```bash
php artisan key:generate
```

---

## Configurer la base de données

Modifier le fichier `.env`.

---

## Exécuter les migrations

```bash
php artisan migrate
```

---

## (Optionnel) Seeder

```bash
php artisan db:seed
```

---

## Créer le lien de stockage

```bash
php artisan storage:link
```

---

## Lancer le serveur

Backend :

```bash
php artisan serve
```

Frontend :

```bash
npm run dev
```

---

# 🧪 Tests

Exécuter tous les tests :

```bash
php artisan test
```

ou

```bash
./vendor/bin/pest
```

---

# 🎯 Qualité de code

Formatage PHP :

```bash
./vendor/bin/pint
```

Analyse statique :

```bash
./vendor/bin/phpstan analyse
```

Formatage JavaScript :

```bash
npm run lint
```

---

# 📦 Déploiement

Build frontend :

```bash
npm run build
```

Optimisations Laravel :

```bash
php artisan optimize
```

Mise en cache :

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

# 🔒 Sécurité

Le projet applique les bonnes pratiques Laravel :

- Protection CSRF
- Validation serveur
- Protection XSS
- Prévention des injections SQL
- Rate Limiting
- HTTPS
- Journalisation des activités
- Sauvegardes automatiques

---

# 📈 Roadmap

Version 1

- ✅ Site institutionnel
- ✅ Blog
- ✅ Réalisations
- ✅ Demande de devis
- ✅ Recrutement
- ✅ Administration
- ✅ Espace client

Version 2

- Portail partenaires
- Paiement en ligne
- Signature électronique
- Tableau de bord BI
- API publique

Version 3

- Application Flutter
- Notifications Push
- Chat temps réel
- Assistant IA

---

# 👨‍💻 Développement

Projet développé avec ❤️ par :

**Hermès Matabishi**

Full Stack Web & Mobile Developer

---

# 📄 Licence

Projet propriétaire.

Tous droits réservés à **CONGO CONSTRUCTION & MÉTALLIQUE SARL (CCM SARL)**.

Toute reproduction ou distribution sans autorisation est interdite.

---
