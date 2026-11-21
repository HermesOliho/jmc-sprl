# Architecture

Ce projet est documenté dans [`docs/rebranding-ccm-to-jmc/`](./rebranding-ccm-to-jmc/README.md).

Points d'entrée utiles :

- `config/site.php` — identité institutionnelle, coordonnées et métadonnées des pages.
- `resources/css/app.css` — thèmes daisyUI `jmc-light` / `jmc-dark` et tokens de design.
- `resources/js/Components/common/BrandLogo.vue` — sélection du logo clair/sombre.
- `resources/views/app.blade.php` — métadonnées initiales et anti-flash du thème.
- `resources/js/Components/common/SeoHead.vue` — mise à jour des métadonnées lors des navigations Inertia.
- `routes/web.php` — pages publiques, formulaire de contact, sitemap et administration.
- `app/Http/Controllers/ContactController.php` — traitement du formulaire.
