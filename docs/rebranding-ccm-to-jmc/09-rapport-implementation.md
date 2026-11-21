# 09 — Rapport d'implémentation

**Date :** 21 novembre 2026
**Périmètre :** migration visuelle, éditoriale, fonctionnelle et SEO de l'ancien site vers JMC Services S.P.R.L.

---

## 1. Ce qui a été réalisé

### Identité et design system

- Palette JMC échantillonnée sur le logo officiel : bleu `#101A79`, orange `#FE5900`, blanc.
- Deux thèmes daisyUI : `jmc-light` et `jmc-dark`.
- Tokens sémantiques : surfaces, contenu, bordures, action, lien, accent, footer.
- Suppression de tous les tokens `--color-ccm-*`.
- Contrastes vérifiés (texte normal ≥ 4,5:1, grands textes et composants ≥ 3:1).

### Logo et assets

- Logo SVG utilisé sur fond clair via Vite.
- Variante sombre utilisée sur fond sombre, avec une version WebP 512 px optimisée pour le header.
- Composant `BrandLogo.vue` centralisé (variantes auto/clair/sombre, contextes header/footer/hero/auth).
- Nouveaux favicons et `site.webmanifest` conservés.
- Image Open Graph `public/og/jmc-default.jpg` créée.
- Anciens logos raster supprimés du dossier `resources/images/`.

### Thèmes

- Thème clair et thème sombre fonctionnels.
- Détection de la préférence système.
- Bascule manuelle dans le header public, les layouts auth et l'administration.
- Persistance dans `localStorage`.
- Script anti-flash dans `app.blade.php`.
- Respect de `prefers-reduced-motion` pour les transitions CSS et le carrousel de partenaires.

### Contenus

- Nom officiel : **JMC Services S.P.R.L**.
- Slogan officiel : « Building Progress, Moving Possibilities, Delivering Excellence ».
- Présentation centrée sur Durba, Haut-Uélé, République Démocratique du Congo.
- Suppression de l'historique CCM, de l'équipe fictive, des certifications non vérifiées, des projets et actualités fictifs.
- Coordonnées officielles centralisées dans `config/site.php` : téléphones, WhatsApp, e-mail, site web, adresse.
- Navigation réduite aux pages réellement disponibles.
- Pages légales créées avec les éléments restant à valider clairement signalés.

### Pages

- Accueil : hero, présentation, services, approche, processus, CTA, partenaires dynamiques.
- À propos : présentation, valeurs, engagement, approche, raisons de nous choisir.
- Services : 12 services existants, ancres stables, approche, processus, FAQ.
- Contact : coordonnées officielles, formulaire fonctionnel, FAQ.
- Mentions légales et politique de confidentialité.
- Pages d'erreur 403/404/500/503 branchées sur Inertia.
- Redirections 301 pour les anciennes entrées de navigation.

### Formulaire de contact

- Route `POST /contact` avec limitation de débit.
- `ContactRequest` : validation serveur, sujet autorisé, consentement, honeypot.
- `ContactController` + `ContactMessage` + vue e-mail.
- Destination configurable via `CONTACT_TO_ADDRESS`, par défaut `contact@jmcservices.com`.
- États de succès, d'erreur et de chargement côté Vue.
- Préremplissage du sujet et du service depuis l'URL.
- Tests Pest dédiés.

### SEO

- Métadonnées initiales rendues côté serveur dans `app.blade.php`.
- `SeoHead.vue` met à jour les métadonnées lors des navigations Inertia, sans doublon.
- Canonicals absolus.
- Open Graph et Twitter Cards avec image.
- JSON-LD `Organization`, `WebSite`, `WebPage`/`AboutPage`/`CollectionPage`/`ContactPage`.
- `logo`, `slogan`, `email`, `address`, `telephone`, `contactPoint` renseignés.
- Sitemap XML dynamique et `robots.txt` mis à jour.
- Pages internes en `noindex, nofollow`.
- `lang="fr"`.

### Sécurité et qualité

- Inscription publique désactivée par défaut (`AUTH_REGISTRATION_ENABLED=false`).
- Honeypot et limitation de débit sur le formulaire.
- CSRF via Inertia.
- Suppression des `console.log` de démonstration.
- Tests : 57 tests, 289 assertions.
- Build frontend et vérification TypeScript passés.

---

## 2. Configuration de production nécessaire

```dotenv
APP_NAME="JMC Services S.P.R.L"
APP_URL=https://www.jmcservices.com
APP_LOCALE=fr

AUTH_REGISTRATION_ENABLED=false
CONTACT_TO_ADDRESS=contact@jmcservices.com
MAIL_FROM_ADDRESS=contact@jmcservices.com
MAIL_FROM_NAME="${APP_NAME}"
```

Configurer le transport SMTP réel et les enregistrements SPF/DKIM/DMARC.

Exécuter :

```bash
php artisan migrate --force
php artisan storage:link
npm run build
php artisan optimize
```

---

## 3. Points restant à valider par la direction

- Identification légale complète (registre du commerce, identifiant national, responsable de publication, hébergeur).
- Politique de confidentialité : base légale, durée de conservation, coordonnées du responsable.
- Validation finale des services et des descriptions.
- Validation des partenaires et autorisation d’utiliser leurs logos.
- Validation des photographies et autorisations de publication.
- Horaires et coordonnées GPS, non fournis.
- Réseaux sociaux officiels, non fournis.

---

## 4. Éléments volontairement non publiés

- Historique CCM.
- Équipe nominative.
- Certifications ISO/OHSAS/RSE.
- Projets et actualités fictifs.
- Chiffres non vérifiés (nombre de projets, effectifs, années).
- Anciens comptes sociaux.
- Anciennes coordonnées CCM.

---

## 5. Vérifications effectuées

- `php artisan test --compact` : 57 tests réussis.
- `npm run build` : build client + SSR réussi.
- `npx vue-tsc --noEmit` : aucune erreur.
- Crawl HTTP des pages publiques : 200, redirections 301, 404 corrects.
- Formulaire de contact testé dans le navigateur : message de succès affiché.
- Thèmes clair et sombre vérifiés sur desktop et mobile.
- Aucun token `ccm` ni `placehold.co` dans les sources/build.
- Anciens liens morts supprimés ou redirigés.
