# JMC Services S.P.R.L — Site institutionnel

Site web institutionnel de **JMC Services S.P.R.L**, construit avec Laravel, Inertia.js, Vue 3, TypeScript, Tailwind CSS et daisyUI.

## Stack

- PHP 8.5 / Laravel 13
- Inertia.js 3 / Vue 3 / TypeScript
- Tailwind CSS 4 / daisyUI 5
- Vite 8
- Pest / Pint

## Pages publiques

- `/` — accueil
- `/a-propos` — présentation, valeurs et approche
- `/services` — services et FAQ
- `/album` — albums photo et visionneuse
- `/contact` — coordonnées et formulaire
- `/mentions-legales` — structure à compléter par la direction
- `/politique-de-confidentialite` — structure à compléter par la direction

Les anciennes entrées `/demande-devis`, `/realisations`, `/carrieres` et `/actualites` sont redirigées vers les pages correspondantes.

## Fonctionnalités

- Thème clair et thème sombre avec détection de la préférence système, bascule manuelle et persistance locale.
- Formulaire de contact avec validation serveur, limitation de débit et envoi par e-mail.
- Métadonnées SEO rendues côté serveur (title, description, canonical, Open Graph, Twitter Cards, JSON-LD).
- Sitemap XML et `robots.txt`.
- Espace d'administration pour les utilisateurs, les partenaires, les membres de l'équipe et les services.
- Album photo public avec pagination, visionneuse plein écran et carrousel des dernières photos sur l'accueil.
- Gestion complète des albums en administration : upload multiple, légendes, couverture, ordre et publication.
- Carrousel de partenaires et catalogue de services alimentés par la base de données.

## Configuration

Copier `.env.example` vers `.env`, puis renseigner au minimum :

```dotenv
APP_NAME="JMC Services S.P.R.L"
APP_URL=https://www.jmcservices.com
APP_LOCALE=fr

CONTACT_TO_ADDRESS=contact@jmcservices.com
MAIL_FROM_ADDRESS=contact@jmcservices.com
MAIL_FROM_NAME="${APP_NAME}"
```

Configurer également le transport SMTP de production (hôte, port, identifiants) et les enregistrements SPF/DKIM/DMARC du domaine.

La source de vérité des informations institutionnelles se trouve dans `config/site.php` : nom, slogan, description, coordonnées, téléphones, WhatsApp, e-mail, site web, réseaux sociaux et métadonnées des pages.

### Inscription publique

L'inscription publique est désactivée par défaut :

```dotenv
AUTH_REGISTRATION_ENABLED=false
```

Le compte administrateur est créé par le seeder. En production, définir `ADMIN_EMAIL` et un `ADMIN_PASSWORD` robuste avant `php artisan db:seed`. Ne réactiver l'inscription que si un parcours client réel est prévu.

## Développement

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
```

ou :

```bash
composer run dev
```

## Tests et qualité

```bash
php artisan test --compact
npm run build
vendor/bin/pint --dirty --format agent
```

## Structure utile

- `config/site.php` — identité et métadonnées institutionnelles
- `resources/js/config/` — contenus des pages et navigation
- `resources/js/Components/common/SeoHead.vue` — métadonnées côté client après navigation Inertia
- `resources/css/app.css` — thèmes daisyUI et tokens de design
- `resources/views/app.blade.php` — métadonnées initiales rendues côté serveur
- `public/` — logos, favicons, manifest et image Open Graph
- `docs/rebranding-ccm-to-jmc/` — audit et plan de migration (documentation interne)

## Licence

Projet propriétaire. Tous droits réservés à JMC Services S.P.R.L.
