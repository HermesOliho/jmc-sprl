# 01 — Audit technique du projet

**Objet :** décrire l'architecture réellement présente, les technologies installées, les composants, les dépendances et la dette technique, afin qu'un développeur puisse implémenter la migration sans redécouvrir le projet.

**Périmètre :** dépôt local `jmc-sprl`, branche `main`, commit de référence `dc384bf`.
**Méthode :** lecture statique intégrale ; aucune modification, aucun build, aucun test exécuté.

---

## 1. Synthèse technique

| Constat | Niveau | Impact migration |
|---|---|---|
| Application Laravel 13 + Inertia 3 + Vue 3 + Tailwind 4 + daisyUI 5, sans API ni logique métier | ✅ Vérifié | Le rebranding est essentiellement frontend + contenu |
| Quatre pages publiques seulement, rendues par des closures de route | ✅ Vérifié | Peu de contrôleurs à modifier, mais peu de flexibilité serveur |
| Identité centralisée en partie dans `resources/js/config/` | ✅ Vérifié | Point d'entrée idéal pour la réécriture éditoriale |
| 278 usages de tokens CSS `--color-ccm-*` dans 49 fichiers | ✅ Vérifié | Chantier visuel mécanique mais large |
| Aucun logo JMC, aucun SVG, favicons CCM | ✅ Vérifié | Blocage visuel |
| Thème sombre non fonctionnel | ✅ Vérifié | Nécessite une refonte de la couche tokens |
| Formulaire de contact sans backend | ✅ Vérifié | Fonctionnalité à créer ou à retirer |
| SEO majoritairement côté client, sans sitemap | ✅ Vérifié | Risque de régression au changement de nom |
| Dépendances nombreuses mais peu utilisées | ✅ Vérifié | Nettoyage possible, hors chemin critique |
| Tests limités au squelette Breeze | ✅ Vérifié | Aucun filet de sécurité sur le branding |

**Conclusion :** l'architecture est saine et adaptée à un site institutionnel. La migration ne doit pas être une réécriture ; elle doit être une **adaptation structurée** avec trois chantiers de fond : tokens de design, contenus, SEO.

---

## 2. Environnement et versions vérifiés

### 2.1 Runtime

| Composant | Version constatée | Source |
|---|---|---|
| PHP | 8.5.12 (NTS) | `php -v` |
| Laravel Framework | 13.43.0 | `php artisan --version`, `composer.lock` |
| Composer | installé, dépendances à jour localement | `composer show --direct` |
| Node.js | 26.13.0 | `node -v` |
| npm | 11.20.0 | `npm -v` |
| MySQL | 8.4.13 | `php artisan db:show` |
| Base locale | `dev_jmc_sprl` | `.env`, `db:show` |
| Extensions PHP utiles | `pdo_mysql`, `mbstring`, `gd`, `intl`, `zip` | `php -m` |

### 2.2 Dépendances backend directes

| Package | Version installée | Utilisé réellement ? |
|---|---|---|
| `laravel/framework` | 13.43.0 | ✅ Oui |
| `inertiajs/inertia-laravel` | 3.7.0 | ✅ Oui (`Inertia::render`, middleware) |
| `tightenco/ziggy` | 2.7.0 | ✅ Oui (`@routes`, `ZiggyVue`) |
| `laravel/sanctum` | 4.5.0 | ❌ Aucune route API, aucun token |
| `laravel/tinker` | 3.2.0 | Outil de développement |
| `ralphjsmit/laravel-seo` | 1.8.3 | ❌ Config publiée, aucune utilisation dans le code |
| `spatie/laravel-activitylog` | 5.1.5 | ❌ Table migrée, aucun trait/utilisateur |
| `spatie/laravel-backup` | 10.5.0 | ❌ Config présente, aucune planification |
| `spatie/laravel-medialibrary` | 11.23.13 | ❌ Table `media` migrée, aucun modèle `HasMedia` |
| `spatie/laravel-pdf` | 2.14.0 | ❌ Aucune utilisation |
| `spatie/laravel-permission` | 8.5.0 | ❌ Tables migrées, aucun rôle/permission |
| `spatie/laravel-sitemap` | 8.2.0 | ❌ Aucun sitemap généré |
| Dev : Breeze, Pest, Pint, Larastan, Debugbar, IDE Helper, Boost | versions récentes | Outillage |

### 2.3 Dépendances frontend directes

| Package | Version installée | Utilisé réellement ? |
|---|---|---|
| `vue` | 3.5.45 | ✅ Oui |
| `@inertiajs/vue3` | 3.11.0 | ✅ Oui |
| `pinia` | 3.0.4 | ✅ Oui (store de navigation mobile uniquement) |
| `daisyui` | 5.8.1 | ✅ Oui (plugin CSS, classe `btn`, `loading`) |
| `tailwindcss` | 4.3.5 | ✅ Oui |
| `@tailwindcss/vite` | 4.3.5 | ✅ Oui |
| `@tailwindcss/forms` | 0.5.11 | ✅ Oui |
| `motion-v` | 2.13.0 | ✅ Oui (animations d'entrée, compteurs) |
| `@lucide/vue` | 1.76.0 | ✅ Oui (registre d'icônes) |
| `axios` | 1.21.1 | ◐ Importé dans `bootstrap.ts`, mais Inertia 3 gère ses requêtes ; usage direct non constaté |
| `@vueuse/core` | 14.4.0 | ❌ Aucun import |
| `vee-validate` | 4.15.1 | ❌ Aucun import |
| `@vee-validate/zod` | 4.15.1 | ❌ Aucun import (et vulnérabilité npm signalée) |
| `apexcharts` | 5.16.0 | ❌ Aucun composant de graphique |
| `vue3-apexcharts` | 1.11.3 | ❌ Aucun import |
| `typescript` | 5.9.3 | ✅ Oui (`vue-tsc`) |
| `vite` | 8.3.8 | ✅ Oui |
| `vue-tsc` | 2.2.12 | ✅ Oui (script `build`) |

### 2.4 Écart de configuration notable

✅ **Vérifié :**
- `.env` contient déjà `APP_NAME="JMC S.P.R.L."`, `APP_LOCALE=fr`, `APP_URL=http://localhost:8000`, `DB_CONNECTION=mysql`.
- `.env.example` contient encore `APP_NAME=Laravel`, `APP_LOCALE=en`, `DB_CONNECTION=sqlite`, `MAIL_MAILER=log`.
- `.env` n'est pas versionné (`.gitignore`), donc **la configuration de production ne peut pas être déduite du dépôt**.
- Le premier commit s'intitule « Initialisation du projet à partir du repo de CCM sarl » : l'historique Git du site CCM d'origine n'est pas présent, ce qui empêche de retrouver d'anciennes URLs ou redirections par l'historique.

➜ **Recommandation :** considérer `.env` comme un état local, pas comme une source de vérité de marque. La migration doit mettre à jour `.env.example` et documenter les variables de production nécessaires, sans supposer que `JMC S.P.R.L.` est le nom officiel retenu.

---

## 3. Structure du dépôt

```text
jmc-sprl/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/ (9 contrôleurs Breeze)
│   │   │   ├── Controller.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/HandleInertiaRequests.php
│   │   └── Requests/
│   │       ├── Auth/LoginRequest.php
│   │       └── ProfileUpdateRequest.php
│   ├── Models/User.php
│   └── Providers/AppServiceProvider.php
├── bootstrap/app.php
├── config/ (11 fichiers + seo.php)
├── database/
│   ├── factories/UserFactory.php
│   ├── migrations/ (6 migrations)
│   └── seeders/DatabaseSeeder.php
├── public/ (favicons, robots.txt, manifest, build, hot)
├── resources/
│   ├── css/app.css
│   ├── images/ (logo.png, logo-full.png)
│   ├── js/
│   │   ├── Components/ (UI kit, sections, layout, Breeze legacy)
│   │   ├── Layouts/ (Public, Guest, Authenticated, Error)
│   │   ├── Pages/ (19 composants)
│   │   ├── config/ (14 fichiers de contenu)
│   │   ├── composables/, stores/, utils/, constants/, types/
│   │   ├── app.ts, ssr.ts, bootstrap.ts
│   └── views/app.blade.php
├── routes/web.php, auth.php, console.php
├── tests/ (Feature Auth + Profile, Unit exemple)
├── docs/ARCHITECTURE.md (fichier vide, 0 octet)
├── vite.config.js
├── composer.json / composer.lock
├── package.json / package-lock.json
└── README.md
```

### 3.1 Absences structurelles vérifiées

✅ Aucun des éléments suivants n'existe :

- `app/Http/Controllers/PublicController.php` ou équivalent ;
- `app/Models/` autre que `User` ;
- `app/Mail/`, `app/Notifications/`, `app/Jobs/`, `app/Events/`, `app/Listeners/`, `app/Policies/`, `app/Services/`, `app/Actions/` ;
- routes API (`routes/api.php` absent) ;
- `config/inertia.php` ;
- `tailwind.config.js` (normal en Tailwind v4) ;
- `public/storage` (lien symbolique absent) ;
- tout fichier `.svg` de marque ;
- sitemap généré (`public/sitemap.xml` absent).

➜ **Conséquence :** il n'y a **aucune logique métier serveur** à préserver. Les seuls points serveur à faire évoluer sont les routes publiques, le partage de props Inertia, les métadonnées et l'éventuel formulaire de contact.

---

## 4. Architecture Laravel

### 4.1 Routage

✅ `routes/web.php` (39 lignes) :

| Méthode | URI | Nom | Action | Middleware |
|---|---|---|---|---|
| GET | `/` | `home` | `Inertia::render('Public/Home')` | web |
| GET | `/a-propos` | `about` | `Public/About` | web |
| GET | `/services` | `services` | `Public/Services` | web |
| GET | `/services/{slug}` | `services.show` | `Public/Services` avec prop `slug` | web |
| GET | `/contact` | `contact` | `Public/Contact` | web |
| GET | `/dashboard` | `dashboard` | `Dashboard` | `auth`, `verified` |
| GET/PATCH/DELETE | `/profile` | `profile.*` | `ProfileController` | `auth` |

✅ `routes/auth.php` ajoute 15 routes Breeze : register, login, logout, forgot/reset password, verify email, confirm password, update password.

✅ `routes/console.php` ne contient qu'une commande d'exemple `inspire`. Aucune planification.

**Constats :**

1. ◐ Les routes publiques sont des closures. C'est acceptable pour un site statique, mais cela empêche de passer des props SEO ou des données serveur par page sans modifier `routes/web.php`.
2. ✅ `services/{slug}` rend **le même composant** `Public/Services` et la prop `slug` **n'est jamais lue** dans la page. Il n'existe donc pas de page de détail de service.
3. ✅ Aucune route pour `/realisations`, `/carrieres`, `/demande-devis`, `/actualites`, `/mentions-legales`, `/politique-de-confidentialite`.
4. ✅ Aucune route de formulaire de contact (POST).
5. ✅ Les pages d'erreur (`Errors/NotFound`, `Errors/Forbidden`, `Errors/ServerError`) ne sont reliées à aucun mécanisme d'exception : `bootstrap/app.php` ne contient aucun `respond()` ni `Inertia::handleExceptionsUsing()`. Elles sont donc **inaccessibles** en l'état.
6. ✅ `Welcome.vue` (page de démarrage Laravel) n'est routée nulle part.

### 4.2 Contrôleurs

| Contrôleur | Rôle | Verdict |
|---|---|---|
| `ProfileController` | Édition, mise à jour, suppression du compte | Standard Breeze, à conserver sauf décision sur l'espace client |
| 9 contrôleurs `Auth/*` | Authentification Breeze complète | Standard, pages en anglais, branding ancien via `GuestLayout` |

➜ Aucun contrôleur public dédié. Si le formulaire de contact est implémenté, créer un contrôleur ciblé (ex. `ContactController`) plutôt que d'alourdir `routes/web.php`.

### 4.3 Modèles et base de données

✅ Un seul modèle : `App\Models\User`, avec attributs PHP 8 `#[Fillable]` et `#[Hidden]`, `HasFactory`, `Notifiable`.

✅ Migrations présentes et exécutées localement :

| Migration | Table |
|---|---|
| `0001_01_01_000000_create_users_table` | `users`, `password_reset_tokens`, `sessions` |
| `0001_01_01_000001_create_cache_table` | `cache`, `cache_locks` |
| `0001_01_01_000002_create_jobs_table` | `jobs`, `job_batches`, `failed_jobs` |
| `2026_06_29_181915_create_permission_tables` | permissions Spatie |
| `2026_06_29_182135_create_media_table` | `media` |
| `2026_06_29_182320_create_activity_log_table` | `activity_log` |

✅ Aucune table de contenu (pages, services, actualités, projets, équipe). **Tout le contenu public est statique en TypeScript.**

⚠ La base locale contient aussi d'autres bases (`dev_gestion_commerciale`, `dev_it_consulting_blog`) sans rapport avec ce projet. Ne pas y toucher.

### 4.4 Middleware

✅ `bootstrap/app.php` :

```php
$middleware->web(append: [
    HandleInertiaRequests::class,
    AddLinkHeadersForPreloadedAssets::class,
]);
```

✅ `HandleInertiaRequests` partage uniquement :

```php
'auth' => ['user' => $request->user()],
'ziggy' => fn () => [...(new Ziggy)->toArray(), 'location' => $request->url()],
```

**Constats :**

- Aucun partage de `flash` (succès/erreur), de `company`, de `locale` ou de métadonnées.
- Le formulaire de contact, s'il est implémenté, devra soit utiliser les erreurs de session Inertia, soit ajouter un partage `flash`.
- `HandleInertiaRequests` est le point naturel pour exposer des données institutionnelles serveur si l'option « source de vérité PHP » est retenue (voir § 9).

### 4.5 Providers et configuration

✅ `AppServiceProvider` : uniquement `Vite::prefetch(concurrency: 3)`.

✅ Fichiers de config : `app`, `auth`, `backup`, `cache`, `database`, `filesystems`, `logging`, `mail`, `permission`, `queue`, `seo`, `services`, `session`.

**Constats :**

- `config/seo.php` est le fichier par défaut du package `ralphjsmit/laravel-seo` : `site_name`, `sitemap`, `favicon`, `description.fallback`, `image.fallback` sont tous `null`. Le package n'est branché nulle part.
- `config/backup.php` est présent mais aucune planification ni notification configurée pour ce projet.
- `config/filesystems.php` : disque par défaut `local` (`storage/app/private`), disque `public` défini mais **aucun lien `public/storage`**.
- `config/mail.php` : `MAIL_MAILER=log` en local. Aucun mailable.
- `config/session.php` : cookie `http_only` par défaut, `same_site=lax`, `secure` piloté par `SESSION_SECURE_COOKIE` (non défini). À durcir en production.
- `config/app.php` : locale pilotée par `APP_LOCALE` (fr en local), timezone `UTC`.

### 4.6 Stockage et fichiers

✅ Aucun upload, aucun média associé à un modèle, aucun téléchargement public.

✅ Les seuls assets applicatifs sont :

- `resources/images/logo.png` (336 Ko, 732×732, PNG RGBA)
- `resources/images/logo-full.png` (524 Ko, 1024×1024, PNG RGBA)
- `public/favicon.ico`, `favicon-16x16.png`, `favicon-32x32.png`, `apple-touch-icon.png`, `android-chrome-192x192.png`, `android-chrome-512x512.png`
- `public/site.webmanifest`
- `public/robots.txt`

✅ Le logo est importé directement dans les composants via des chemins relatifs (`../../../images/logo.png`), traité par Vite. Il n'existe **aucun composant de logo central** ni variante claire/sombre.

### 4.7 Build et rendu

✅ `vite.config.js` :

- plugin `@tailwindcss/vite` ;
- plugin `laravel` avec entrée `resources/js/app.ts` et SSR `resources/js/ssr.ts` ;
- plugin `vue`.

✅ `package.json` : `build` exécute `vue-tsc && vite build && vite build --ssr`.

✅ `bootstrap/ssr/` et `public/build/` existent localement (générés, non versionnés). `public/hot` existe : un serveur Vite tournait au moment de l'audit.

**Constats :**

- ◐ Le build SSR est produit mais **aucun serveur SSR Inertia n'est configuré ni démarré** dans le dépôt. Le rendu réel est client (`@inertia`), avec `@inertiaHead` côté Blade.
- ✅ `resources/views/app.blade.php` contient `@vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])`, `@routes`, `@inertiaHead`.
- ✅ Le titre initial Blade est `config('app.name')` (donc JMC en local), mais les métadonnées par page sont injectées par `SeoHead.vue` côté client.
- ⚠ Ne pas supposer que la production sert le SSR : à vérifier dans l'infrastructure de déploiement.

---

## 5. Architecture Inertia.js / Vue.js

### 5.1 Entrées applicatives

| Fichier | Rôle |
|---|---|
| `resources/js/app.ts` | Création de l'app Inertia, Pinia, Ziggy, résolution des pages, barre de progression `#d4a843` |
| `resources/js/ssr.ts` | Entrée SSR, même résolution de pages, Pinia, Ziggy |
| `resources/js/bootstrap.ts` | Import Axios et configuration `X-Requested-With` |
| `resources/views/app.blade.php` | Template racine, favicons, police Bunny, `@inertia` |

✅ `app.ts` et `ssr.ts` contiennent tous deux un fallback `'CCM SARL'` pour `VITE_APP_NAME`.

### 5.2 Résolution des pages

✅ Les pages sont dans `resources/js/Pages` et résolues par `import.meta.glob('./Pages/**/*.vue')`. Il n'y a pas de layout automatique : chaque page importe explicitement son layout (`PublicLayout`, `GuestLayout`, `AuthenticatedLayout`).

### 5.3 Pages (19 composants)

| Groupe | Fichiers | Statut |
|---|---|---|
| Public | `Public/Home.vue`, `About.vue`, `Services.vue`, `Contact.vue` | ✅ Routées |
| Auth | `Auth/Login.vue`, `Register.vue`, `ForgotPassword.vue`, `ResetPassword.vue`, `ConfirmPassword.vue`, `VerifyEmail.vue` | ✅ Routées, en anglais |
| Profil | `Profile/Edit.vue`, `Partials/UpdateProfileInformationForm.vue`, `UpdatePasswordForm.vue`, `DeleteUserForm.vue` | ✅ Routées, en anglais |
| Dashboard | `Dashboard.vue` | ✅ Routée, en anglais |
| Erreurs | `Errors/NotFound.vue`, `Forbidden.vue`, `ServerError.vue` | ❌ Non branchées |
| Orpheline | `Welcome.vue` | ❌ Non routée, contenu Laravel |

### 5.4 Layouts

| Layout | Contenu | Utilisation |
|---|---|---|
| `PublicLayout.vue` | `Header`, `main` avec `pt-20`, `Footer` | 4 pages publiques |
| `GuestLayout.vue` | Logo `ApplicationLogo` + carte centrée, classes `dark:` | 6 pages auth |
| `AuthenticatedLayout.vue` | Navigation Breeze, dropdown, menu responsive, classes `dark:` | Dashboard, profil |
| `ErrorLayout.vue` | Code HTTP, titre, description, bouton retour | Pages d'erreur (non branchées) |

**Constats :**

- `GuestLayout` et `AuthenticatedLayout` utilisent encore le logo CCM et des composants Breeze gris/indigo, hors charte.
- Le header public est `fixed` avec `h-20` et le `main` compense par `pt-20`. Toute modification de hauteur doit être répercutée aux deux endroits (ou remplacée par une variable CSS).
- Le header se cache au scroll vers le bas (`-translate-y-full`), ce qui peut poser un problème d'accessibilité au clavier (voir § 8).

### 5.5 Composants

**Trois familles coexistent :**

1. **Kit UI maison** (`resources/js/Components/ui/`) : `Container`, `buttons/*`, `cards/*`, `badges/*`, `inputs/*`, `typography/*`, `navigation/*`, `feedback/*`, `overlays/*`.
2. **Sections métier** (`resources/js/Components/sections/`) : 18 composants (Hero, About, Services, Projects, Statistics, Process, Partners, News, History, Values, Mission, Team, Certifications, ServiceCard, ContactCard, ContactForm, GoogleMapPlaceholder, FAQ, CTA, Section, IconBox…).
3. **Composants Breeze legacy** (`Components/*.vue`) : `ApplicationLogo`, `Checkbox`, `DangerButton`, `Dropdown`, `DropdownLink`, `InputError`, `InputLabel`, `Modal`, `NavLink`, `PrimaryButton`, `ResponsiveNavLink`, `SecondaryButton`, `TextInput`.

**Constats :**

- ✅ Doublons : `PrimaryButton`, `SecondaryButton`, `TextInput`, `Modal` existent en version Breeze **et** en version UI kit.
- ✅ Les pages publiques utilisent le kit UI ; les pages auth utilisent Breeze. Les deux systèmes auront besoin d'être alignés visuellement.
- ✅ `Section.vue` importe `computed` après l'avoir utilisé dans le script (hoisting ES module, donc fonctionnel, mais fragile et non conventionnel).
- ✅ `PageHeader.vue` n'accepte pas d'image ; `ABOUT_HERO.image`, `SERVICES_HERO.image`, `CONTACT_HERO.image` sont donc **définies mais jamais affichées**.
- ✅ `FeaturesSection.vue` contient le titre codé en dur « Pourquoi choisir CCM SARL ? » et un fallback d'image contenant `CCM`.
- ✅ `StatisticsSection.vue` contient « CCM SARL en chiffres » codé en dur.
- ✅ `TeamSection.vue` contient « Ceux qui font CCM SARL » codé en dur.
- ✅ `Footer.vue` contient le copyright `COMPANY.legalName`, le logo et les coordonnées.

### 5.6 Gestion d'état

| Élément | Usage réel |
|---|---|
| `stores/appStore.ts` | Ouverture/fermeture du menu mobile, `isLoading` non utilisé ailleurs |
| `stores/navigationStore.ts` | Défini mais **jamais importé** |
| `stores/index.ts` | Réexport |
| `composables/useTheme.ts` | **Jamais appelé** ; écrit `data-theme="light|dark"` |
| `composables/useScroll.ts` | Utilisé par `Header.vue` |
| `composables/useMeta.ts` | Défini mais **jamais utilisé** |
| Autres composables (`useBreakpoint`, `useWindowSize`) | Non utilisés dans les pages publiques |

➜ L'état global est minimal. La migration ne nécessite pas d'ajouter Pinia ; le thème peut rester un composable simple.

### 5.7 Formulaires

| Formulaire | Techno | Validation | Soumission |
|---|---|---|---|
| Contact (`ContactForm.vue`) | `reactive` manuel | Client uniquement | `console.log`, **aucun POST** |
| Auth (login, register, reset…) | `useForm` Inertia | Serveur (Breeze) | Routes Breeze |
| Profil | `useForm` Inertia | Serveur (`ProfileUpdateRequest`) | Routes profil |

**Constats :**

- ✅ Le formulaire de contact n'a **ni action, ni méthode, ni route, ni CSRF**, puisqu'il ne fait aucun appel réseau.
- ✅ Les erreurs du formulaire de contact sont locales, avec `role="alert"`, `aria-invalid` et `aria-describedby` pour les champs texte. Le `select` « Sujet » a un label non lié (`<label>` sans `for`, pas d'`id` sur le `select`).
- ✅ Aucun message de succès, aucun état de chargement, aucune protection anti-spam.
- ⚠ La mention « J'accepte que mes données soient traitées… » implique une politique de confidentialité **qui n'existe pas**.

### 5.8 Gestion des erreurs

✅ Aucune gestion Inertia des exceptions. Les composants d'erreur existent mais ne sont pas utilisés.
✅ Les erreurs de validation Inertia sont affichées via `InputError` dans les pages Breeze, et via `error` props dans le kit UI.
✅ Aucun partage de `flash` ni de message global.

### 5.9 Interactions côté client vérifiées

- Header fixe, masquage au scroll, menu mobile (`appStore`).
- Carrousel horizontal de réalisations avec boutons de défilement.
- Carrousel infini de partenaires en CSS (`@keyframes`), pause au survol.
- Compteurs animés (`StatisticsSection`) via `IntersectionObserver` + `motion-v`.
- Animations d'entrée `FadeIn`, `SlideLeft`, `SlideRight`, `SlideUp`, `ScaleIn`, `Stagger`.
- Accordéon FAQ avec `aria-expanded`/`aria-controls`.
- Hero animé à l'`onMounted`.
- Aucun formulaire fonctionnel, aucune requête API, aucun websocket, aucun polling.

---

## 6. Design system existant

### 6.1 Tailwind CSS

✅ Tailwind CSS **4.3.5**, configuration CSS-first dans `resources/css/app.css`. Aucun `tailwind.config.js`.

✅ Contenu du fichier (65 lignes) :

```css
@import "tailwindcss";

@plugin "daisyui" {
    themes: light --default;
}

@plugin "@tailwindcss/forms";

@theme {
    --font-sans: 'Figtree', ui-sans-serif, system-ui, sans-serif;

    --color-ccm-blue: #1a3a5c;
    --color-ccm-blue-light: #2a5a8c;
    --color-ccm-blue-dark: #0f2440;
    --color-ccm-yellow: #d4a843;
    --color-ccm-yellow-light: #e0c06a;
    --color-ccm-yellow-dark: #b8922e;
    --color-ccm-gray-50 ... --color-ccm-gray-900;
    --color-ccm-anthracite: #2c2c2c;

    --color-primary: var(--color-ccm-blue);
    --color-primary-light: var(--color-ccm-blue-light);
    --color-primary-dark: var(--color-ccm-blue-dark);
    --color-secondary: var(--color-ccm-yellow);
    --color-secondary-light: var(--color-ccm-yellow-light);
    --color-secondary-dark: var(--color-ccm-yellow-dark);

    --container-max: 1280px;
    --container-narrow: 960px;
    --container-wide: 1440px;

    --breakpoint-xs: 375px;
    ...
}

@layer base {
    body { @apply bg-[var(--color-ccm-gray-50)] text-[var(--color-ccm-gray-900)] antialiased; }
    ::selection { @apply bg-[var(--color-ccm-blue)] text-white; }
    :focus-visible { @apply outline-2 outline-offset-2 outline-[var(--color-ccm-blue)]; }
}
```

### 6.2 daisyUI

✅ daisyUI **5.8.1**, plugin Tailwind v4.
✅ Un seul thème chargé : `light --default`.
❌ Aucun thème sombre, aucun thème personnalisé JMC.
✅ La classe `btn` est utilisée dans `PrimaryButton.vue` ; `loading loading-spinner` est utilisée pour l'état de chargement.
⚠ Le fichier `@theme` redéfinit `--color-primary`, `--color-secondary`, etc., qui sont aussi des variables sémantiques daisyUI. Cela crée une **collision de tokens** : les composants utilisent les tokens `ccm`, mais daisyUI peut interpréter `--color-primary` différemment. La migration devra clarifier qui possède ces variables.

### 6.3 Couleurs existantes

| Token | Valeur | Usage |
|---|---|---|
| `--color-ccm-blue` | `#1a3a5c` | Primaire (fonds, textes, boutons, focus) |
| `--color-ccm-blue-light` | `#2a5a8c` | Hover |
| `--color-ccm-blue-dark` | `#0f2440` | Dégradés, texte sur jaune |
| `--color-ccm-yellow` | `#d4a843` | Accent, CTA, icônes |
| `--color-ccm-yellow-light` | `#e0c06a` | Hover |
| `--color-ccm-yellow-dark` | `#b8922e` | Défini, très peu utilisé |
| `--color-ccm-gray-50` | `#f8f9fa` | Fond de section |
| `--color-ccm-gray-100` | `#f1f3f5` | Fonds secondaires |
| `--color-ccm-gray-200` | `#e9ecef` | Bordures |
| `--color-ccm-gray-300` | `#dee2e6` | Bordures de champs |
| `--color-ccm-gray-400` | `#ced4da` | Placeholder, icônes faibles |
| `--color-ccm-gray-500` | `#adb5bd` | Texte discret |
| `--color-ccm-gray-600` | `#6c757d` | Texte courant secondaire |
| `--color-ccm-gray-700` | `#495057` | Labels |
| `--color-ccm-gray-800` | `#343a40` | Défini, peu utilisé |
| `--color-ccm-gray-900` | `#212529` | Texte principal |
| `--color-ccm-anthracite` | `#2c2c2c` | Footer |

**Incohérence visuelle majeure :** l'ancien logo utilise un **bleu vif** (proche `#0B63CE`) et un **jaune vif** (proche `#FFC400`), alors que la charte CSS utilise un **bleu marine `#1a3a5c`** et un **or `#d4a843`**. Le site ne correspond déjà pas exactement à son propre logo.

### 6.4 Typographie

✅ `Figtree` chargée depuis `fonts.bunny.net` avec les graisses **400, 500, 600** uniquement.
❌ Les composants utilisent `font-bold` (700) et parfois `font-semibold` (600). La graisse 700 n'est pas chargée : le navigateur la synthétise.
❌ Aucune font-display locale, aucune stratégie de fallback au-delà de `ui-sans-serif`.
⚠ Aucune charte typographique officielle JMC n'est disponible dans le dépôt.

### 6.5 Espacements, conteneurs, breakpoints

| Élément | Valeur |
|---|---|
| Conteneur par défaut | `1280px` |
| Conteneur étroit | `960px` |
| Conteneur large | `1440px` |
| Padding horizontal | `1rem` / `1.5rem` / `2rem` |
| Breakpoints | 375, 640, 768, 1024, 1280, 1536 |
| Rythme vertical des sections | `py-16` (mobile) / `py-24` (desktop) |
| Rayon des cartes | `rounded-xl` (0,75 rem) |
| Rayon des boutons | `rounded-lg` (0,5 rem) |

➜ Ces valeurs sont cohérentes et peuvent être conservées. La nouvelle identité doit les réutiliser plutôt que créer une seconde échelle.

### 6.6 Responsive

✅ Grilles responsive dans les sections (`sm:grid-cols-2`, `lg:grid-cols-3/4/5`).
✅ Header avec menu mobile.
✅ Carrousel horizontal.
⚠ Quelques hauteurs minimales de hero très grandes (`min-h-[85vh]`, `min-h-[80vh]`) peuvent être problématiques sur petits écrans avec la barre d'adresse mobile.
⚠ Les images ont des attributs `width`/`height` parfois incohérents avec le ratio réel (ex. `ServiceCard` : `width="800" height="600"` dans un conteneur `aspect-[16/9]`).

### 6.7 Thème clair / sombre

✅ Thème clair uniquement. Les classes `dark:` n'existent que dans les composants Breeze et `Welcome.vue`.
❌ `useTheme.ts` n'est appelé nulle part, aucun bouton de bascule, aucune persistance, aucune gestion de `prefers-color-scheme`.
❌ `body` force `bg-[var(--color-ccm-gray-50)]` et `text-[var(--color-ccm-gray-900)]` : même si `data-theme="dark"` était posé, le fond et le texte resteraient clairs.
➜ **Le thème sombre est à construire, pas à « réparer ».**

---

## 7. Build, assets et performance

### 7.1 Pipeline

- Vite 8 + Laravel Vite Plugin 3.
- Tailwind v4 via plugin Vite.
- `vue-tsc` avant build (vérification TypeScript).
- Build SSR séparé.
- Prefetch Vite activé (`concurrency: 3`).

### 7.2 Assets de marque

| Fichier | Format | Dimensions | Poids | Problème |
|---|---|---|---:|---|
| `resources/images/logo.png` | PNG RGBA | 732×732 | 336 Ko | Ancien logo, utilisé en header/footer/auth à 40 px |
| `resources/images/logo-full.png` | PNG RGBA | 1024×1024 | 524 Ko | Ancien logo complet, utilisé en hero à 176 px |
| `public/favicon.ico` | ICO | 16/32 | 15 Ko | Ancien logo |
| `public/favicon-16x16.png` | PNG | 16×16 | 619 o | Ancien logo |
| `public/favicon-32x32.png` | PNG | 32×32 | 1,6 Ko | Ancien logo |
| `public/apple-touch-icon.png` | PNG | 180×180 | 26 Ko | Ancien logo |
| `public/android-chrome-192x192.png` | PNG | 192×192 | 29 Ko | Ancien logo |
| `public/android-chrome-512x512.png` | PNG | 512×512 | 180 Ko | Ancien logo |

➜ Les deux PNG applicatifs sont **surdimensionnés** pour leur usage et **obsolètes**. La nouvelle identité doit fournir des SVG + PNG optimisés.

### 7.3 Images de contenu

✅ **45 références `https://placehold.co/...`** dans les fichiers de configuration. Aucune photographie réelle n'est versionnée.
✅ 19 balises `<img>` dans les composants ; elles utilisent `loading="lazy"` (sauf le logo du header et le logo du hero, qui sont above-the-fold et doivent rester prioritaires).
⚠ Dépendance à un service tiers pour tout le visuel : indisponibilité, lenteur, esthétique générique, aucun contrôle de droits.
➜ **Bloquant éditorial** : sans photographies réelles, le site JMC ressemblera à une maquette, pas à un site institutionnel.

### 7.4 Polices

✅ Bunny Fonts, Figtree 400/500/600, `display=swap`.
⚠ Dépendance réseau externe ; pas de préchargement des fichiers de police ; graisse 700 manquante.
➜ Recommandation : conserver Figtree (ou la police officielle JMC) et **auto-héberger** les fichiers WOFF2 avec `font-display: swap`, ou au minimum compléter les graisses et vérifier la disponibilité.

### 7.5 JavaScript

- `motion-v` pour les animations (9 occurrences d'`animate`).
- `IntersectionObserver` pour les compteurs.
- Pas de gros framework de graphiques réellement utilisé (ApexCharts installé mais aucun composant).
- Bundle build local : 39 entrées dans `manifest.json`, ~1,7 Mo dans `public/build` (artefact local, non versionné).

### 7.6 Points de performance à traiter

| Point | Preuve | Recommandation |
|---|---|---|
| Logo PNG lourd | 336 Ko / 524 Ko | SVG + PNG optimisés, dimensions adaptées |
| Images distantes `placehold.co` | 45 références | Remplacer par des assets locaux optimisés (WebP/AVIF + fallback) |
| Police externe | `fonts.bunny.net` | Auto-héberger ou préconnecter correctement |
| Animations above-the-fold | Hero `onMounted`, `motion-v` | Éviter d'animer le LCP ; respecter `prefers-reduced-motion` |
| Carrousel infini | `PartnersCarousel` | Pause au survol existe, mais pas de pause clavier / reduced motion |
| Absence de SSR réel | `ssr.ts` + build mais pas de serveur | Décider : SSR ou métadonnées serveur ; sinon le SEO dépend du rendu JS |

---

## 8. Qualité, tests et sécurité

### 8.1 Tests

✅ 25 tests, regroupés ainsi :

- `tests/Feature/ExampleTest.php` : `GET /` répond 200.
- `tests/Feature/Auth/*` : 6 fichiers Breeze (login, register, reset, verify, confirm, password update).
- `tests/Feature/ProfileTest.php` : 5 tests profil.
- `tests/Unit/ExampleTest.php` : test trivial.

**Constats :**

- ❌ Aucun test des pages `/a-propos`, `/services`, `/contact`.
- ❌ Aucun test de contenu (absence de « CCM », présence du nom JMC, métadonnées, liens).
- ❌ Aucun test du formulaire de contact.
- ❌ Aucun test des redirections ou du sitemap.
- ✅ `phpunit.xml` utilise SQLite `:memory:` et `RefreshDatabase`, donc les tests sont isolés.
- ⚠ Le test `GET /` dépend du rendu Inertia et ne vérifie que le statut HTTP.

### 8.2 Analyse de dépendances

✅ `composer audit` : **aucune vulnérabilité connue** au moment de l'audit.
⚠ `npm audit --omit=dev` : **2 vulnérabilités high** via `zod < 4.6.6`, tirées par `@vee-validate/zod`, **package non utilisé** dans le code.

➜ Recommandation : retirer les dépendances inutilisées (`@vee-validate/zod`, `vee-validate`, `apexcharts`, `vue3-apexcharts`, `@vueuse/core`, éventuellement `axios`) après validation des besoins futurs. Cela supprime la vulnérabilité sans mise à niveau générale. **Ne pas modifier les dépendances dans la mission d'audit.**

### 8.3 Sécurité applicative

| Point | Constat | Niveau |
|---|---|---|
| CSRF | Inertia/Breeze gèrent le CSRF sur les POST existants | ✅ |
| Validation serveur | Uniquement auth et profil ; pas de formulaire public | ✅/❌ |
| Inscription publique | `/register` est ouvert à tous | ⚠ Décision requise |
| Rate limiting login | 5 tentatives via `LoginRequest` | ✅ |
| Debug | `APP_DEBUG=true` en local | ⚠ Vérifier la production |
| Cookies | `SESSION_SECURE_COOKIE` non défini | ⚠ À durcir en HTTPS |
| Secrets | `.env` non versionné | ✅ |
| Debugbar | Présent en dev uniquement | ✅ |
| Exposition de données | Aucune donnée sensible côté public | ✅ |
| Formulaire de contact | Aucune donnée transmise, donc pas de risque… mais aucune fonction | ⚠ |

### 8.4 Accessibilité — constats vérifiés

| Point | Constat | Impact |
|---|---|---|
| Langue | `<html lang="fr">` via `APP_LOCALE=fr` | ✅ |
| Skip link | Absent | ⚠ Clavier |
| Contraste texte secondaire | `#6c757d` sur `#f8f9fa` = **4,45:1** | ❌ Juste sous AA (4,5:1) |
| Contraste bouton or | `#1a3a5c` sur `#d4a843` = **5,26:1** | ✅ |
| Contraste blanc sur or | `#ffffff` sur `#d4a843` = **2,21:1** | ❌ Ne pas utiliser |
| Footer copyright | `white/40` sur `#2c2c2c` ≈ **3,54:1** | ❌ Échoue AA |
| Focus visible | Outline navy global ; sur fond navy, peu visible | ⚠ |
| Menu mobile | `aria-expanded` présent, pas d'`aria-controls` | ⚠ |
| Logo hero | `alt="CCM SARL"` en double (mobile + desktop) | ⚠ Bruit lecteur d'écran |
| Images décoratives | Aucun `alt=""` explicite | ⚠ |
| Formulaire contact | Label « Sujet » non lié au `select` | ⚠ |
| Animations | Pas de `prefers-reduced-motion` | ⚠ |
| Header masqué au scroll | Le focus clavier peut sortir de l'écran | ⚠ |
| Titres | Majorité h1 → h2 correcte ; `Contact` utilise h3 sous h1 | ⚠ |

---

## 9. Dette technique et décisions d'architecture

### 9.1 Dette priorisée

| ID | Dette | Preuve | Sévérité | Recommandation |
|---|---|---|---|---|
| T01 | Identité CCM codée en dur partout | 63 fichiers, 278 tokens | **Critique** | Centraliser puis migrer |
| T02 | Aucun asset JMC | `resources/images/*`, `public/*` | **Critique** | Obtenir les fichiers officiels |
| T03 | Formulaire de contact factice | `ContactForm.vue:34-38` | **Haute** | Implémenter ou retirer |
| T04 | Liens morts dans la navigation | `/realisations`, `/carrieres`, `/demande-devis` | **Haute** | Router, rediriger ou retirer |
| T05 | SEO client-only + pas de sitemap | `SeoHead.vue`, `public/robots.txt` | **Haute** | SSR ou métadonnées serveur + sitemap |
| T06 | Thème sombre inopérant | `app.css`, `useTheme.ts` | **Moyenne** | Refonte tokens + thèmes daisyUI |
| T07 | Contenu fictif/incohérent | 45 placeholders, chiffres divergents | **Haute** | Collecte éditoriale |
| T08 | Pages d'erreur non branchées | `bootstrap/app.php`, `Errors/*` | **Moyenne** | Configurer les exceptions Inertia |
| T09 | Pages auth en anglais | `Pages/Auth/*`, `Profile/*` | **Moyenne** | Traduire si l'espace est conservé |
| T10 | Composants Breeze/UI dupliqués | `Components/*` vs `Components/ui/*` | **Moyenne** | Unifier ou assumer la séparation |
| T11 | Dépendances inutilisées | `package.json` | **Basse** | Nettoyage après validation |
| T12 | Documentation vide | `docs/ARCHITECTURE.md` (0 o) | **Basse** | Remplacer par cette documentation |
| T13 | Build SSR sans serveur | `ssr.ts`, `bootstrap/ssr` | **Moyenne** | Décider SSR ou supprimer |
| T14 | `Welcome.vue` orpheline | `Pages/Welcome.vue` | **Basse** | Supprimer ou ignorer |
| T15 | Pas de tests publics | `tests/` | **Haute** | Ajouter des tests de contenu et de routes |

### 9.2 Options d'architecture pour la source de vérité de l'identité

**Option A — Conserver les configs TypeScript (`resources/js/config/*.ts`) comme source unique.**

- Avantages : changement minimal, déjà en place, typé, adapté au rendu Vue.
- Inconvénients : les métadonnées SEO et le JSON-LD restent côté client ; duplication si un jour le serveur a besoin du nom/contact.

**Option B — Déplacer l'identité institutionnelle dans `config/company.php` et la partager via Inertia.**

- Avantages : source unique serveur + client, métadonnées fiables, JSON-LD serveur, cohérence email/SEO.
- Inconvénients : refactor des imports dans 7 fichiers, typage à maintenir, plus de travail initial.

**Option C — Hybride : garder les configs TS pour l'UI, ajouter un fichier PHP pour les métadonnées serveur.**

- Avantages : peu de refactor, SEO serveur possible.
- Inconvénients : **deux sources** pour le nom et les coordonnées → risque de divergence. À éviter sauf si le fichier PHP est généré depuis la source TS (peu pratique).

➜ **Recommandation : Option B** si le SEO est prioritaire (ce qui est le cas pour un site institutionnel) **ou Option A + SSR activé**. Dans les deux cas, une seule source doit alimenter le nom, le slogan, la description, les coordonnées et les réseaux sociaux. Le plan (doc 07, tâche E01) prévoit un arbitrage explicite avant implémentation.

### 9.3 Convention de nommage à retenir

- Un fichier `resources/js/config/brand.ts` (ou `config/company.php`) contient : nom d'affichage, nom légal, nom court, slogan, description, coordonnées, réseaux, URL canonique.
- Les composants ne doivent plus contenir de nom de marque en dur.
- Les tokens CSS ne doivent plus contenir `ccm`.
- Les libellés « CCM » ne doivent subsister que dans un éventuel contenu historique **validé** ou dans les redirections SEO.

---

## 10. Risques techniques de la migration

| Risque | Probabilité | Impact | Mitigation |
|---|---|---|---|
| Logo JMC absent ou incomplet | Élevée | Blocage visuel | Tâche A02 bloquante, ne pas dessiner |
| Remplacement global cassant du contenu historique | Moyenne | Perte de sens/juridique | Inventaire + revue éditoriale |
| Régression SEO au changement de métadonnées | Moyenne | Perte de trafic | Audit URLs/GSC avant, redirections, sitemap |
| Thème sombre contrasté incorrect | Moyenne | Accessibilité | Table de contrastes + tests |
| Formulaire de contact non conforme (RGPD/confidentialité) | Moyenne | Juridique | Politique de confidentialité + consentement |
| Cache/artefacts conservant CCM | Moyenne | Image incohérente | Rebuild, `config:clear`, `view:clear`, purge CDN |
| Mélange avec les modifications skills en cours | Faible | Commit pollution | Branche dédiée, baseline propre |
| Pages manquantes laissées en 404 | Élevée | UX/SEO | Décision produit avant D |

---

## 11. Annexes

### 11.1 Fichiers de configuration à connaître

| Fichier | Rôle pour la migration |
|---|---|
| `resources/css/app.css` | Tokens, thèmes daisyUI, base |
| `resources/js/config/company.ts` | Nom, coordonnées, réseaux, services, stats |
| `resources/js/config/navigation.ts` | Navigation, liens footer, ancres |
| `resources/js/config/home.ts` | Hero, à-propos, features, process, CTA |
| `resources/js/config/about.ts` | Présentation, histoire, valeurs, mission/vision |
| `resources/js/config/services.ts` | 12 services + hero + process + FAQ |
| `resources/js/config/contact.ts` | Hero, infos, sujets |
| `resources/js/config/faq.ts` | FAQ contact |
| `resources/js/config/team.ts` | Équipe |
| `resources/js/config/certifications.ts` | Certifications |
| `resources/js/config/projects.ts` | Réalisations |
| `resources/js/config/news.ts` | Actualités |
| `resources/js/config/partners.ts` | Partenaires |
| `resources/js/config/statistics.ts` | Chiffres clés |
| `resources/js/config/theme.ts` | Constantes de thème (non utilisé par les composants) |
| `resources/js/constants/index.ts` | `APP_NAME`, `APP_DESCRIPTION`, routes |
| `resources/js/Components/common/SeoHead.vue` | Métadonnées par page |
| `resources/views/app.blade.php` | Favicons, police, titre initial |
| `public/robots.txt`, `public/site.webmanifest` | SEO/identité navigateur |
| `routes/web.php` | Routes publiques |
| `bootstrap/app.php` | Middleware, gestion des exceptions |

### 11.2 Commandes de vérification utilisées (lecture seule)

```bash
# Versions
php -v && php artisan --version
composer show --direct
npm ls --depth=0

# Inventaire CCM
grep -rIn --exclude-dir={node_modules,vendor,.git,build,bootstrap} -i "ccm" .
grep -rIo --exclude-dir={node_modules,vendor} "var(--color-ccm-[a-z0-9-]*" resources/js resources/css | wc -l

# Routes
php artisan route:list --except-vendor

# Base
php artisan migrate:status
php artisan db:show --counts

# Assets
file resources/images/* public/*.png public/favicon.ico
du -h resources/images/* public/*.png

# Dépendances
composer audit
npm audit --omit=dev
```

### 11.3 Critères d'acceptation de l'audit technique

- [x] Toutes les routes publiques et internes sont listées.
- [x] Les versions réelles sont documentées.
- [x] Les pages, layouts et composants sont cartographiés.
- [x] Les tokens et incohérences visuelles sont identifiés.
- [x] Les dépendances inutilisées sont signalées.
- [x] Les tests existants et leurs lacunes sont décrits.
- [x] Les risques techniques sont explicites.
- [x] Aucun fichier source n'a été modifié.
