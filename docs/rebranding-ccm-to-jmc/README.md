# Migration d'identité CCM S.A.R.L → JMC Services S.P.R.L

## Documentation d'audit et de planification

**Statut : audit terminé, aucune implémentation réalisée.**
Cette documentation a été produite sans modifier aucun fichier source, configuration, route, asset, dépendance ni base de données.

| Élément | Valeur |
|---|---|
| Dépôt | `jmc-sprl` |
| Branche auditée | `main` |
| Commit de référence | `dc384bf` (le dépôt contient 2 commits : `6af016b`, puis `dc384bf`) |
| Date de l'audit | 19 novembre 2026 |
| Framework | Laravel 13.43.0 / PHP 8.5.12 |
| Frontend | Inertia.js 3.7.0 (Laravel) / `@inertiajs/vue3` 3.11.0 / Vue 3.5.45 |
| Design system | Tailwind CSS 4.3.5 + daisyUI 5.8.1 |
| Base de données locale observée | MySQL 8.4.13, base `dev_jmc_sprl` (lecture seule) |

> **Point d'attention immédiat :** le nouveau logo JMC n'est présent nulle part dans le dépôt. Les deux fichiers `resources/images/logo.png` et `resources/images/logo-full.png`, ainsi que tous les favicons de `public/`, sont encore les anciens visuels CCM. Le rebranding visuel ne peut pas être finalisé sans les fichiers de marque officiels.

---

## 1. Chiffres clés de l'audit

| Indicateur | Valeur vérifiée | Commentaire |
|---|---:|---|
| Pages publiques réellement implémentées | **4** | Accueil, À propos, Services, Contact |
| Routes déclarées (hors vendor) | **24** | 5 routes publiques, 15 routes d'authentification, 3 de profil, 1 dashboard |
| Composants de page Vue | **19** | Inclut les pages d'auth, de profil, d'erreur et `Welcome.vue` |
| Fichiers source suivis contenant « CCM » ou `ccm-` | **63** | Hors `node_modules`, `vendor`, `public/build`, `bootstrap/ssr` |
| Occurrences textuelles « CCM » / « Congo Construction » | **49 lignes** | Dans les sources, hors artefacts générés |
| Utilisations de tokens CSS `var(--color-ccm-*)` | **278** | Dans **49 fichiers** |
| Définitions de tokens `--color-ccm-*` | **17 + 6 alias** | 17 tokens de couleur + 6 alias dans `resources/css/app.css` |
| Images placeholder externes `placehold.co` | **45** | Tout le contenu visuel « réel » est simulé |
| Anciens logos raster dans le dépôt | **2** | `logo.png` (732×732, 336 Ko), `logo-full.png` (1024×1024, 524 Ko) |
| Nouveaux logos JMC dans le dépôt | **0** | Aucun SVG, aucune déclinaison claire/sombre |
| Pages liées mais inexistantes | **8+** | Réalisations, carrières, actualités, devis, mentions légales, confidentialité, galerie, téléchargements |
| Formulaire de contact fonctionnel | **Non** | `console.log` uniquement, aucune route POST ni email |
| Sitemap | **Absent** | Package `spatie/laravel-sitemap` installé mais non utilisé |
| Thème sombre | **Non opérationnel** | daisyUI configuré en thème clair uniquement ; `useTheme` jamais appelé |
| Tests | **25 tests** | Essentiellement le squelette Breeze ; aucun test des pages publiques ni du branding |

---

## 2. Légende des niveaux de preuve

Tous les documents utilisent la même convention :

| Marque | Signification |
|---|---|
| ✅ **Vérifié** | Constaté directement dans le code, les fichiers ou les commandes exécutées |
| ◐ **Déduit** | Déduit de l'architecture ou du comportement attendu, sans exécution fonctionnelle complète |
| ⚠ **À valider** | Nécessite une confirmation humaine (direction JMC, juridique, technique) |
| ➜ **Recommandation** | Proposition de l'audit, à arbitrer avant implémentation |
| ⛔ **Bloquant** | La tâche ne peut pas être finalisée sans une ressource ou une décision externe |

---

## 3. Ordre de lecture recommandé

| Ordre | Document | À lire si vous êtes… |
|---:|---|---|
| 1 | [`01-audit-technique.md`](./01-audit-technique.md) | Développeur qui reprend le projet |
| 2 | [`02-inventaire-identite-existante.md`](./02-inventaire-identite-existante.md) | Développeur, chef de projet, responsable de marque |
| 3 | [`03-audit-pages-et-contenus.md`](./03-audit-pages-et-contenus.md) | Équipe éditoriale et produit |
| 4 | [`04-nouvelle-identite-visuelle.md`](./04-nouvelle-identite-visuelle.md) | Designer, intégrateur, développeur frontend |
| 5 | [`05-audit-seo-et-integrations.md`](./05-audit-seo-et-integrations.md) | Responsable SEO, marketing, développeur |
| 6 | [`06-informations-a-valider.md`](./06-informations-a-valider.md) | Direction JMC, chef de projet |
| 7 | [`07-plan-complet-de-migration.md`](./07-plan-complet-de-migration.md) | Chef de projet et agent d'implémentation |
| 8 | [`08-checklist-validation.md`](./08-checklist-validation.md) | QA, développeur, responsable de mise en production |
| 9 | [`09-rapport-implementation.md`](./09-rapport-implementation.md) | Suivi de l'implémentation et points restants |

**Parcours minimal avant de coder :** `06` (décisions) → `04` (système visuel) → `07` (plan) → `08` (critères de recette).

---

## 4. Synthèse exécutive

Le site est un **squelette Laravel/Breeze/Inertia correctement structuré**, avec une couche de présentation publique déjà travaillée (layouts, sections réutilisables, animations, thème clair). Il n'est cependant **pas prêt à être rebrandé par un simple remplacement de texte** :

1. **L'identité CCM est partout** : 63 fichiers source, 278 usages de tokens CSS nommés `ccm`, 49 lignes de contenu de marque, 4 fichiers de logo/favicon, README, constantes, métadonnées et données JSON-LD.
2. **Le nouveau logo et les nouveaux contenus n'existent pas dans le dépôt.** Sans eux, la migration visuelle et éditoriale est bloquée.
3. **Le site contient des liens cassés et des promesses non tenues** : `/realisations`, `/carrieres`, `/demande-devis`, `/actualites` sont dans la navigation ou les CTA mais ne sont pas routés. Les ancres de services du footer ne correspondent à aucun `id`.
4. **Le formulaire de contact ne fonctionne pas.** Il valide côté client puis écrit dans `console.log`. Aucune route POST, aucun contrôleur, aucun mailable, aucune protection anti-spam.
5. **Le contenu est majoritairement fictif ou non validé** : 45 images `placehold.co`, chiffres incohérents (20+ vs 150+, 12+ vs 15+), équipe nommée, certifications ISO/OHSAS, adresse, téléphone et e-mail probablement provisoires.
6. **Le SEO est fragile** : métadonnées générées côté client, canonicals relatifs, JSON-LD injecté sans nettoyage, aucun sitemap, `robots.txt` minimal, pages d'erreur non branchées.
7. **Le thème sombre est annoncé par le code mais inopérant** : daisyUI ne charge que `light`, `useTheme` n'est utilisé nulle part, et les couleurs sont majoritairement codées en dur.
8. **La dette technique est modérée** : dépendances installées mais inutilisées, composants Breeze dupliqués avec le kit UI, pages d'auth en anglais, documentation d'architecture vide.

La migration est donc **faisable par adaptation ciblée**, sans réécriture complète. La difficulté principale n'est pas le code : c'est **la collecte des actifs de marque, la validation des contenus et l'arbitrage sur les pages manquantes**.

---

## 5. Décisions bloquantes à obtenir avant l'implémentation

Liste complète dans [`06-informations-a-valider.md`](./06-informations-a-valider.md). Les cinq plus urgentes :

1. **Nom exact à afficher** : « JMC Services S.P.R.L », « JMC Services S.P.R.L. », « JMC S.P.R.L. » ? Le dépôt et `.env` utilisent déjà `JMC S.P.R.L.` alors que la mission parle de `JMC Services S.P.R.L`.
2. **Logo officiel** : SVG, déclinaison fond clair, déclinaison fond sombre, symbole seul, zone de protection, couleurs officielles.
3. **Contenus institutionnels** : présentation, activités réelles, historique à conserver ou non, coordonnées, équipe, certifications.
4. **Périmètre fonctionnel** : que fait-on des pages Réalisations, Carrières, Actualités et Demande de devis ? Les crée-t-on, les retire-t-on de la navigation, ou les redirige-t-on ?
5. **Formulaire de contact** : adresse de destination, SMTP de production, mention de confidentialité, stratégie anti-spam.

---

## 6. Ce qui est inclus et exclu de cette mission

### Inclus

- Audit statique complet de l'architecture, des pages, des contenus, des assets et des intégrations.
- Inventaire des références CCM avec chemins et lignes.
- Proposition de système visuel JMC (couleurs, thèmes, typographie, logo, composants).
- Audit SEO et stratégie de transition.
- Plan de migration par phases, avec tâches, dépendances, priorités, complexité et critères d'acceptation.
- Checklist de validation et liste des informations à obtenir.

### Exclu (à réaliser dans une mission ultérieure)

- Modification de tout fichier source ou configuration.
- Remplacement de CCM par JMC.
- Suppression d'assets, de routes, de dépendances ou de tables.
- Création du logo ou des photographies.
- Rédaction de contenus institutionnels non fournis.
- Migration de base de données, déploiement, achat de domaine.
- Audit de sécurité exhaustif ou test de pénétration.

---

## 7. Méthode et limites

### Méthode

- Lecture intégrale des fichiers applicatifs (`app/`, `routes/`, `config/`, `resources/`, `public/`, `tests/`, `database/`).
- Recherches globales reproductibles (`grep -rin`, inventaire par fichier, comptage des tokens).
- Vérification des versions installées (`composer show --direct`, `npm ls --depth=0`, `php artisan --version`).
- Lecture des métadonnées d'images (`file`, dimensions, poids).
- Lecture du schéma de base et de l'état des migrations, en lecture seule.
- Vérification des contrastes par calcul WCAG (ratios luminance).
- Aucune exécution de build, aucun test, aucune requête HTTP vers le site, aucune modification d'environnement.

### Limites

- Le rendu réel du site n'a pas été parcouru navigateur en main ; les constats d'interface sont issus du code.
- Le site de production, son domaine, son historique d'URLs, ses backlinks et ses données Search Console ne sont pas accessibles depuis le dépôt.
- Le contenu institutionnel réel de JMC n'est pas connu ; il n'a pas été inventé.
- Les couleurs exactes du nouveau logo n'ont pas pu être échantillonnées : la palette proposée est **provisoire** et devra être recalibrée sur le SVG officiel.
- L'état de la base `dev_jmc_sprl` observé localement ne préjuge pas de la base de production.

---

## 8. Documents générés

| Fichier | Rôle |
|---|---|
| `README.md` | Ce document : synthèse, chiffres clés, ordre de lecture |
| `01-audit-technique.md` | Architecture Laravel, Inertia/Vue, design system, dépendances, dette technique |
| `02-inventaire-identite-existante.md` | Inventaire exhaustif des références CCM et des assets de marque |
| `03-audit-pages-et-contenus.md` | Pages, routes, composants, liens, formulaires, contenu à valider |
| `04-nouvelle-identite-visuelle.md` | Palette, thèmes clair/sombre, logo, typographie, composants, direction artistique |
| `05-audit-seo-et-integrations.md` | SEO technique, métadonnées, URLs, transition, intégrations externes |
| `06-informations-a-valider.md` | Questions à la direction, hypothèses, décisions, matrice de blocage |
| `07-plan-complet-de-migration.md` | Plan d'exécution A→G, tâches, dépendances, priorités, critères |
| `08-checklist-validation.md` | Checklist de recette et de mise en production |

---

## 9. Règle d'or pour l'agent d'implémentation

> Ne jamais remplacer « CCM » de façon aveugle. Chaque occurrence doit être classée : **contenu de marque à réécrire**, **identifiant technique à renommer**, **donnée historique à conserver**, **asset à remplacer**, ou **référence à supprimer**. Le détail est dans [`02-inventaire-identite-existante.md`](./02-inventaire-identite-existante.md).
