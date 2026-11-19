# 02 — Inventaire exhaustif de l'identité CCM existante

**Objet :** recenser toutes les traces de l'ancienne identité, avec fichier, emplacement, nature, importance et action recommandée.

**Méthode :** recherche globale reproductible sur les fichiers suivis, lecture des assets et des configurations. Les artefacts générés (`public/build`, `bootstrap/ssr`) sont traités séparément.

---

## 1. Synthèse quantitative

| Catégorie | Volume vérifié | Détail |
|---|---:|---|
| Fichiers source suivis contenant `ccm` (insensible à la casse) | **63** | Hors dépendances et artefacts |
| Lignes contenant « CCM » ou « Congo Construction » | **49** | Contenu de marque, commentaires, docs, data |
| Occurrences de `var(--color-ccm-*)` | **278** | Dans **49 fichiers** |
| Définitions de tokens `--color-ccm-*` | **17 + 6 alias** | `resources/css/app.css` (26 lignes contenant `ccm` au total) |
| Assets de marque obsolètes | **8 fichiers** | 2 logos applicatifs + 6 favicons |
| Références de contacts anciens | **6** | Adresse, téléphone, e-mail, 4 réseaux |
| Images de contenu simulées | **45** | `placehold.co`, dont plusieurs portent « CCM » |
| Fichiers compilés contenant encore `ccm` | **25** | `public/build` (410 occurrences) et `bootstrap/ssr` (529) |
| Fichiers README/docs à réécrire | **2** | `README.md`, `docs/ARCHITECTURE.md` (vide) |

> **Attention :** 63 fichiers ne signifie pas 63 remplacements. Les tokens CSS sont des identifiants techniques à renommer, tandis que les chaînes de marque doivent être réécrites avec validation éditoriale.

---

## 2. Classification des références

| Type | Définition | Traitement |
|---|---|---|
| **A — Marque visible** | Nom, slogan, description, logo, signature, copyright | Réécriture validée par la direction |
| **B — Contenu institutionnel** | Histoire, mission, valeurs, équipe, certifications | Réécriture ou suppression après validation |
| **C — Donnée opérationnelle** | Adresse, téléphone, e-mail, réseaux, horaires | Remplacement par les données officielles uniquement |
| **D — Identifiant technique** | Tokens CSS, constantes, noms de variables | Renommage contrôlé, sans impact fonctionnel |
| **E — Métadonnée SEO** | Titles, descriptions, JSON-LD, OG, canonical | Réécriture + vérification |
| **F — Documentation** | README, commentaires, docs | Réécriture |
| **G — Artefact généré** | `public/build`, `bootstrap/ssr`, caches | Rebuild/purge, jamais éditer à la main |

---

## 3. Identité textuelle — inventaire détaillé

### 3.1 Nom, raison sociale, slogan, description

| Fichier | Ligne(s) | Contenu exact | Type | Importance | Action recommandée |
|---|---:|---|---|---|---|
| `resources/js/config/company.ts` | 4 | `name: 'CCM SARL'` | A | **Critique** | Remplacer par le nom d'affichage officiel |
| `resources/js/config/company.ts` | 5 | `legalName: 'Congo Construction & Métallique SARL'` | A | **Critique** | Remplacer par la raison sociale exacte |
| `resources/js/config/company.ts` | 6 | `slogan: 'Bâtir l'avenir avec excellence et intégrité'` | A | Haute | Remplacer si nouveau slogan validé, sinon conserver avec accord |
| `resources/js/config/company.ts` | 7 | Description « Entreprise congolaise de référence… » | A | Haute | Réécrire selon la présentation officielle JMC |
| `resources/js/constants/index.ts` | 1 | `APP_NAME = 'CCM SARL'` | A/D | **Critique** | Remplacer par le nom officiel |
| `resources/js/constants/index.ts` | 2 | `APP_DESCRIPTION = 'Congo Construction & Métallique SARL - …'` | A/E | **Critique** | Remplacer + aligner avec la meta description |
| `resources/js/app.ts` | 10 | Fallback `'CCM SARL'` | A/D | Haute | Fallback neutre ou nom JMC |
| `resources/js/ssr.ts` | 9 | Fallback `'CCM SARL'` | A/D | Haute | Idem, si SSR conservé |
| `README.md` | 1, 3, 9, 470 | Titre, description, copyright CCM | F | Moyenne | Réécrire entièrement |
| `docs/ARCHITECTURE.md` | — | Fichier vide (0 octet) | F | Basse | Remplacer par la documentation de migration ou supprimer |

### 3.2 Header et navigation

| Fichier | Ligne(s) | Contenu / comportement | Type | Importance | Action |
|---|---:|---|---|---|---|
| `resources/js/Components/layout/Header.vue` | 54 | `aria-label="Accueil CCM SARL"` | A | Haute | « Accueil JMC Services… » |
| `resources/js/Components/layout/Header.vue` | 56 | `alt="CCM SARL"` sur le logo | A | **Critique** | Alt officiel + variante de logo |
| `resources/js/Components/layout/Header.vue` | 59-66 | Texte « CCM » + « Congo Construction & Métallique » | A | **Critique** | Remplacer par « JMC » + baseline officielle |
| `resources/js/Components/layout/Header.vue` | 60-66 | Wordmark codé en dur à côté du logo | A | Haute | Décider : conserver le wordmark ou l'intégrer au SVG |
| `resources/js/Components/layout/Header.vue` | 94, 156 | Bouton doré « Demander un devis » | A/D | Haute | Recolorer + corriger le lien mort `/demande-devis` |
| `resources/js/config/navigation.ts` | 4-9 | Navigation dont `/realisations` et `/carrieres` | A/D | Haute | Décision produit : router ou retirer |
| `resources/js/config/navigation.ts` | 13-24 | Liens footer, ancres `#metallique`, etc. | D | Haute | Corriger les ancres inexistantes |

### 3.3 Footer et copyright

| Fichier | Ligne(s) | Contenu | Type | Importance | Action |
|---|---:|---|---|---|---|
| `resources/js/Components/layout/Footer.vue` | 23 | `alt="CCM SARL"` | A | **Critique** | Nouveau logo + alt |
| `resources/js/Components/layout/Footer.vue` | 22-27 | `COMPANY.name`, `COMPANY.slogan` | A | **Critique** | Données JMC |
| `resources/js/Components/layout/Footer.vue` | 32 | `COMPANY.description` | A | Haute | Description JMC |
| `resources/js/Components/layout/Footer.vue` | 103 | `© {{ year }} {{ COMPANY.legalName }}` | A | **Critique** | Raison sociale exacte |
| `resources/js/Components/layout/Footer.vue` | 16 | Fond `--color-ccm-anthracite` | D | Moyenne | Remplacer par surface sombre de la charte |
| `resources/js/Components/layout/Footer.vue` | 74-99 | Icônes or | D | Moyenne | Recolorer en orange |
| `resources/js/Components/layout/Footer.vue` | 108-120 | Réseaux sociaux issus de `COMPANY.social` | C | Haute | Données officielles uniquement |

### 3.4 Pages publiques

| Fichier | Ligne(s) | Contenu | Type | Importance | Action |
|---|---:|---|---|---|---|
| `resources/js/Pages/Public/Home.vue` | 72 | Image de fond `placehold.co/.../CCM+SARL+Construction` | A | Haute | Remplacer par photo réelle |
| `resources/js/Pages/Public/Home.vue` | 81 | Image « Pourquoi CCM SARL » | A | Haute | Remplacer par photo réelle |
| `resources/js/Pages/Public/Home.vue` | 26-47 | JSON-LD `name: COMPANY.legalName` | E | **Critique** | Générer côté serveur avec le nom JMC |
| `resources/js/Pages/Public/About.vue` | 36 | `name: 'À propos de CCM SARL'` (JSON-LD) | A/E | **Critique** | Réécrire |
| `resources/js/Pages/Public/Contact.vue` | 24-25 | `name`, `description` JSON-LD « Contact – CCM SARL » | A/E | **Critique** | Réécrire |
| `resources/js/Pages/Public/Contact.vue` | 54 | Meta description « Contactez CCM SARL… » | A/E | **Critique** | Réécrire |
| `resources/js/Pages/Public/Services.vue` | 23 | Description JSON-LD « … de CCM SARL » | A/E | **Critique** | Réécrire |
| `resources/js/Pages/Public/*.vue` | — | Titres `SeoHead` « Accueil », « À propos », etc. | E | Moyenne | Suffixe via `APP_NAME` à revoir |

### 3.5 Sections et composants à texte de marque codé en dur

| Fichier | Ligne(s) | Contenu | Type | Importance | Action |
|---|---:|---|---|---|---|
| `resources/js/Components/sections/FeaturesSection.vue` | 20 | « Pourquoi choisir CCM SARL ? » | A | **Critique** | Passer le titre en prop ou utiliser `COMPANY.name` |
| `resources/js/Components/sections/FeaturesSection.vue` | 52-53 | Fallback image + alt « Pourquoi CCM » | A | Haute | Réécrire + asset réel |
| `resources/js/Components/sections/StatisticsSection.vue` | 50 | « CCM SARL en chiffres » | A | **Critique** | Utiliser `COMPANY.name` |
| `resources/js/Components/sections/TeamSection.vue` | 15 | « Ceux qui font CCM SARL » | A | **Critique** | Utiliser `COMPANY.name` |
| `resources/js/Components/sections/HeroBanner.vue` | 63, 101 | `alt="CCM SARL"` (logo mobile + desktop) | A | **Critique** | Nouveau logo + alt pertinent (ou `alt=""` si décoratif) |
| `resources/js/Components/ApplicationLogo.vue` | 6 | `alt="CCM SARL"` | A | **Critique** | Remplacer + variantes |
| `resources/js/Pages/Public/Contact.vue` | 115, 124, 133 | Icônes et cartes de contact | D | Moyenne | Recolorer |
| `resources/js/Components/sections/ServiceCard.vue` | 13-76 | Cartes de services, CTA devis | D | Haute | Adapter couleurs + lien devis |

### 3.6 Contenu institutionnel dans `resources/js/config/`

| Fichier | Ligne(s) | Contenu | Type | Importance | Action |
|---|---:|---|---|---|---|
| `config/about.ts` | 4 | Titre « À propos de CCM SARL » | A | **Critique** | Réécrire |
| `config/about.ts` | 7 | Image placeholder « À propos de CCM SARL » | A | Haute | Asset réel |
| `config/about.ts` | 12-14 | Présentation « Congo Construction & Métallique SARL (CCM SARL)… fondée il y a plus de 15 ans » | B | **Critique** | **Ne pas réutiliser sans validation** |
| `config/about.ts` | 20-60 | Histoire 2009 → 2024, création CCM, certifications | B | **Critique** | Décision : conserver l'histoire de CCM ou repartir sur JMC |
| `config/about.ts` | 22, 31, 52, 57, 59 | Mentions CCM dans les jalons | B | **Critique** | Réécrire selon la décision |
| `config/about.ts` | 64-90 | Valeurs (qualité, innovation, sécurité…) | B | Moyenne | À valider, a priori réutilisables si toujours exactes |
| `config/about.ts` | 94-122 | Mission et vision | B | Haute | Validation direction |
| `config/about.ts` | 124-150 | « Pourquoi nous choisir » | B | Moyenne | À valider |
| `config/home.ts` | 6 | Sous-titre hero « … CCM SARL donne vie à vos projets… » | A | **Critique** | Réécrire |
| `config/home.ts` | 20 | Présentation « Congo Construction & Métallique SARL… » | B | **Critique** | Réécrire |
| `config/home.ts` | 21 | Image placeholder « CCM SARL » | A | Haute | Asset réel |
| `config/home.ts` | 10 | Chiffres hero : 20+, 15+, 100% | B | Haute | Incohérents avec `statistics.ts` (150, 15) et `company.ts` (12+) |
| `config/news.ts` | 6, 18, 27 | Actualités mentionnant CCM | B | Haute | **Contenu fictif** : remplacer ou retirer |
| `config/projects.ts` | 41, 44 | « Siège CCM SARL », image « Siège CCM » | B | Haute | Remplacer par un projet réel ou retirer |
| `config/team.ts` | 8 | « Fondateur de CCM SARL » | B | **Critique** | **Ne pas réutiliser** sans validation (personnes réelles ?) |
| `config/contact.ts` | 7 | Image placeholder « Contactez CCM SARL » | A | Haute | Asset réel |
| `config/contact.ts` | 13 | Urgence au `+243 81 234 5678` | C | **Critique** | Remplacer par le numéro officiel |
| `config/company.ts` | 30-58 | `SERVICES` et `STATS` exportés mais **non utilisés** | D/B | Basse | Supprimer ou aligner avec la taxonomie retenue |
| `config/projects.ts` | 1-46 | 6 projets, tous fictifs | B | **Critique** | Ne pas publier sans preuve |
| `config/news.ts` | 1-32 | 3 actualités fictives | B | **Critique** | Ne pas publier sans preuve |
| `config/team.ts` | 1-50 | 4 personnes nommées, avatars placeholder | B | **Critique** | **Risque juridique/réputationnel** : validation obligatoire |
| `config/certifications.ts` | 1-36 | ISO 9001, ISO 14001, OHSAS 18001, RSE | B | **Critique** | Vérifier les certificats réels avant publication |
| `config/partners.ts` | 1-12 | 6 partenaires génériques | B | Haute | Remplacer par des partenaires autorisés |
| `config/statistics.ts` | 4-7 | 150+, 80+, 200+, 15+ | B | Haute | Chiffres officiels uniquement |

### 3.7 Coordonnées et présence numérique

| Fichier | Ligne(s) | Donnée | Type | Importance | Action |
|---|---:|---|---|---|---|
| `config/company.ts` | 8-14 | Adresse : « Avenue de la Libération, n° 15 », Kinshasa, RDC | C | **Critique** | **À confirmer**, probablement fictive |
| `config/company.ts` | 15 | `+243 81 234 5678` | C | **Critique** | Numéro officiel |
| `config/company.ts` | 16 | `info@ccmsarl.cd` | C | **Critique** | Nouvelle adresse officielle |
| `config/company.ts` | 17 | Horaires | C | Haute | À confirmer |
| `config/company.ts` | 18-21 | GPS Kinshasa (-4.44193, 15.26629) | C | Haute | Coordonnées exactes |
| `config/company.ts` | 23 | Facebook `facebook.com/ccmsarl` | C | **Critique** | Nouveau compte ou conservation validée |
| `config/company.ts` | 24 | LinkedIn `linkedin.com/company/ccmsarl` | C | **Critique** | Idem |
| `config/company.ts` | 25 | WhatsApp `wa.me/243812345678` | C | **Critique** | Numéro officiel |
| `config/company.ts` | 26 | YouTube `youtube.com/@ccmsarl` | C | Haute | Idem |
| `config/home.ts` | 113 | `tel:+243812345678` | C | **Critique** | Idem |
| `config/contact.ts` | 13 | Numéro d'urgence en texte | C | **Critique** | Idem |

> **Ne jamais remplacer ces valeurs par des données inventées.** Voir doc 06.

### 3.8 README et documentation

| Fichier | Ligne(s) | Problème | Type | Action |
|---|---:|---|---|---|
| `README.md` | 1-470 | Nom CCM, copyright, promesses de fonctionnalités inexistantes (espace client, administration, blog, devis, recrutement, galerie, téléchargements) | F | Réécrire après arbitrage du périmètre réel |
| `docs/ARCHITECTURE.md` | — | Fichier vide | F | Supprimer ou remplacer par un renvoi vers ce dossier |
| Commentaires de code | — | Aucun commentaire CCM trouvé hors README/docs | F | RAS |

**Point de vigilance :** le README décrit un produit bien plus riche que le code. Il ne doit pas servir de base pour déduire des fonctionnalités. Il constitue une **fausse documentation** à corriger.

---

## 4. Identité visuelle

### 4.1 Logos applicatifs

| Fichier | Usage | Description visuelle vérifiée | Problème |
|---|---|---|---|
| `resources/images/logo.png` | Header, Footer, ApplicationLogo (auth) | Grue bleue, casque jaune, route grise, sans texte | Ancien logo, 336 Ko pour 40 px |
| `resources/images/logo-full.png` | Hero (mobile + desktop) | Même visuel + « CCM SARL » bleu + « Congo Construction & Métallique » + « Architecture, Bâtiment, Rénovation, Travaux publics » | Ancien logo complet, 524 Ko pour 176 px |
| `public/favicon.ico` | Favicon | Symbole CCM (casque/grue) | Ancien |
| `public/favicon-16x16.png` | Favicon | Symbole CCM | Ancien |
| `public/favicon-32x32.png` | Favicon | Symbole CCM | Ancien |
| `public/apple-touch-icon.png` | iOS | Symbole CCM | Ancien |
| `public/android-chrome-192x192.png` | Android | Symbole CCM | Ancien |
| `public/android-chrome-512x512.png` | Android | Symbole CCM | Ancien |

✅ **Aucun fichier SVG de logo n'existe dans le dépôt.**
✅ **Aucun logo JMC n'existe dans le dépôt.**
⚠ Les couleurs du logo CCM (bleu vif, jaune vif, gris) **ne correspondent pas** aux tokens du site (marine `#1a3a5c`, or `#d4a843`). Il faut donc éviter de déduire la palette JMC à partir des tokens existants.

### 4.2 Emplacements du logo dans le code

| Fichier | Ligne | Contexte |
|---|---:|---|
| `resources/js/Components/layout/Header.vue` | 11, 56 | Logo du header |
| `resources/js/Components/layout/Footer.vue` | 8, 21-24 | Logo du footer |
| `resources/js/Components/sections/HeroBanner.vue` | 9, 63, 101 | Logo du hero (deux tailles) |
| `resources/js/Components/ApplicationLogo.vue` | 2, 6 | Logo des pages auth |
| `resources/views/app.blade.php` | 9-13 | Favicons + manifest |
| `public/site.webmanifest` | 1 | Icônes PWA + couleurs |
| `resources/js/Pages/Public/*.vue` | JSON-LD | Pas de champ `logo` actuellement ; à ajouter |

### 4.3 Images de contenu

✅ 45 URLs `placehold.co` :

- 6 services homepage (`HOME_SERVICES`)
- 12 services complets (`ALL_SERVICES`)
- 6 réalisations (`HOME_PROJECTS`)
- 3 actualités (`HOME_NEWS`)
- 4 membres d'équipe (`TEAM_MEMBERS`)
- 4 certifications
- 6 partenaires
- 3 images éditoriales (à-propos, mission, vision)
- 2 images « pourquoi nous choisir »
- 2 heros de page
- 1 image de contact

➜ Aucune de ces images n'est un asset de marque à conserver. Elles doivent être remplacées par des photographies réelles, avec droits d'utilisation vérifiés.

### 4.4 Favicon et manifest

✅ `public/site.webmanifest` :

```json
{"name":"","short_name":"","icons":[...],"theme_color":"#ffffff","background_color":"#ffffff","display":"standalone"}
```

**Problèmes :**
- `name` et `short_name` vides.
- `theme_color` et `background_color` blancs, sans lien avec la marque.
- Icônes anciennes CCM.
- Aucune icône `maskable`.
- Aucun lien `theme-color` dans le `<head>`.

### 4.5 Couleurs et typographie

| Élément | Valeur actuelle | Problème |
|---|---|---|
| Bleu primaire | `#1a3a5c` | Ne correspond pas au bleu du logo |
| Or secondaire | `#d4a843` | Ne correspond pas au jaune du logo |
| Anthracite footer | `#2c2c2c` | Hors palette |
| Police | Figtree 400/500/600 | Graisse 700 utilisée mais non chargée |
| Favicon theme | `#ffffff` | Sans identité |

---

## 5. Identité technique — tokens et identifiants

### 5.1 Définitions dans `resources/css/app.css`

| Ligne | Token | Valeur |
|---:|---|---|
| 12 | `--color-ccm-blue` | `#1a3a5c` |
| 13 | `--color-ccm-blue-light` | `#2a5a8c` |
| 14 | `--color-ccm-blue-dark` | `#0f2440` |
| 15 | `--color-ccm-yellow` | `#d4a843` |
| 16 | `--color-ccm-yellow-light` | `#e0c06a` |
| 17 | `--color-ccm-yellow-dark` | `#b8922e` |
| 18-27 | `--color-ccm-gray-50` → `gray-900` | Palette grise |
| 28 | `--color-ccm-anthracite` | `#2c2c2c` |
| 30-35 | `--color-primary`, `primary-light`, `primary-dark`, `secondary`, `secondary-light`, `secondary-dark` | Alias vers les tokens CCM |

### 5.2 Répartition des 278 usages de tokens

| Fichier | Occurrences | Action |
|---|---:|---|
| `resources/css/app.css` | 10 usages + 17 définitions + 6 alias | Remplacer le bloc `@theme` et les variables de base |
| `Pages/Public/Contact.vue` | 19 | Migrer vers tokens sémantiques |
| `Components/layout/Header.vue` | 15 | Priorité haute (visible partout) |
| `Components/layout/Footer.vue` | 12 | Priorité haute |
| `Components/sections/ServiceCard.vue` | 10 | Migrer |
| `Components/sections/MissionSection.vue` | 10 | Migrer |
| `Components/sections/FeaturesSection.vue` | 7 | Migrer + titre |
| `Pages/Public/Services.vue` | 6 | Migrer |
| `Components/ui/inputs/TextInput.vue` | 6 | Migrer |
| `Components/ui/inputs/TextArea.vue` | 6 | Migrer |
| `Components/sections/TeamSection.vue` | 6 | Migrer + titre |
| `Components/sections/ProjectsCarousel.vue` | 6 | Migrer |
| `Components/sections/ProcessSection.vue` | 6 | Migrer |
| `Components/sections/NewsSection.vue` | 6 | Migrer |
| `Components/sections/GoogleMapPlaceholder.vue` | 6 | Migrer |
| `Components/sections/FAQAccordion.vue` | 6 | Migrer |
| `Components/sections/ContactCard.vue` | 6 | Migrer |
| `Components/sections/CompanyHistory.vue` | 6 | Migrer |
| `Components/sections/ValuesGrid.vue` | 5 | Migrer |
| `Components/sections/HeroBanner.vue` | 5 | Migrer + logo |
| `Components/ui/cards/StatCard.vue` | 5 | Migrer |
| `Components/ui/cards/FeatureCard.vue` | 5 | Migrer |
| `Layouts/ErrorLayout.vue` | 4 | Migrer |
| `Components/ui/navigation/Breadcrumb.vue` | 4 | Migrer |
| `Components/ui/feedback/EmptyState.vue` | 4 | Migrer |
| `Components/sections/IconBox.vue` | 4 | Migrer |
| `Components/sections/ContactForm.vue` | 4 | Migrer + formulaire |
| `Components/ui/overlays/Modal.vue` | 3 | Migrer |
| `Components/ui/badges/Badge.vue` | 3 | Migrer |
| `Components/sections/CertificationGrid.vue` | 3 | Migrer |
| `Components/ui/buttons/*` (4 fichiers) | 2 chacun | Migrer |
| `Components/ui/typography/*` (3 fichiers) | 1-2 | Migrer |
| `Components/ui/navigation/Divider.vue` | 1 | Migrer |
| `Components/ui/feedback/Skeleton.vue` | 1 | Migrer |
| `Components/ui/feedback/LoadingSpinner.vue` | 1 | Migrer |
| `Components/ui/cards/Card.vue` | 1 | Migrer |
| `Components/ui/badges/Tag.vue` | 1 | Migrer |
| `Components/sections/Section.vue` | 2 | Migrer |
| `Components/sections/HeroSection.vue` | 2 | Migrer |
| `Components/sections/CtaSection.vue` | 2 | Migrer |
| `Components/sections/AboutPreviewSection.vue` | 2 | Migrer |
| `Components/sections/ServicesPreviewSection.vue` | 1 | Migrer |
| `Components/sections/StatisticsSection.vue` | 1 | Migrer |
| `Components/common/PageHeader.vue` | 1 | Migrer |
| `Components/ApplicationLogo.vue` | 0 (alt seulement) | Remplacer le composant |

> Les totaux ci-dessus incluent parfois des occurrences dans les commentaires ou les classes. Le comptage exact par fichier est reproductible avec la commande du § 8.

### 5.3 Autres identifiants

| Emplacement | Constat | Action |
|---|---|---|
| `package.json` → `"name": "jmc-sprl"` | Déjà JMC | ✅ Conserver |
| `composer.json` → `"name": "laravel/laravel"` | Nom générique | Optionnel : renommer le projet |
| `.env` → `APP_NAME="JMC S.P.R.L."` | Déjà JMC, non versionné | Aligner sur le nom officiel |
| `.env.example` → `APP_NAME=Laravel` | Générique | Mettre à jour |
| `README.md` | CCM partout | Réécrire |
| `docs/ARCHITECTURE.md` | Vide | Remplacer/supprimer |
| `public/build` | 410 occurrences `ccm` | Rebuild |
| `bootstrap/ssr` | 529 occurrences `ccm` | Rebuild ou supprimer |
| `public/hot` | Serveur Vite local | Ne pas versionner (déjà ignoré) |
| Caches `storage/framework/views` | Aucun `ccm` trouvé | Purger par précaution au déploiement |

### 5.4 Noms de fichiers et répertoires

✅ Aucun fichier ni répertoire ne contient `ccm` dans son nom.
✅ Le dépôt s'appelle déjà `jmc-sprl`.
➜ Aucun renommage de dossier n'est nécessaire. C'est un point positif pour la migration.

---

## 6. Inventaire des 63 fichiers suivis contenant CCM

Légende : **T** = occurrences textuelles (lignes), **K** = usages de tokens `var(--color-ccm-*)`.

| Fichier | T | K | Nature | Action |
|---|---:|---:|---|---|
| `README.md` | 4 | 0 | Documentation | Réécrire |
| `resources/css/app.css` | 0 | 10 usages + 17 déf. + 6 alias | Design tokens | Remplacer le bloc |
| `resources/js/app.ts` | 1 | 0 | Fallback nom | Remplacer |
| `resources/js/ssr.ts` | 1 | 0 | Fallback nom | Remplacer |
| `resources/js/constants/index.ts` | 2 | 0 | Nom/description | Remplacer |
| `resources/js/Components/ApplicationLogo.vue` | 1 | 0 | Logo/alt | Remplacer le composant |
| `resources/js/Components/common/PageHeader.vue` | 0 | 1 | Couleur | Migrer |
| `resources/js/Components/layout/Header.vue` | 4 | 22 | Logo, nom, couleurs, CTA | Priorité 1 |
| `resources/js/Components/layout/Footer.vue` | 1 | 13 | Logo, coordonnées, copyright | Priorité 1 |
| `resources/js/Components/sections/AboutPreviewSection.vue` | 0 | 2 | Couleurs | Migrer |
| `resources/js/Components/sections/CertificationGrid.vue` | 0 | 3 | Couleurs | Migrer |
| `resources/js/Components/sections/CompanyHistory.vue` | 0 | 6 | Couleurs | Migrer |
| `resources/js/Components/sections/ContactCard.vue` | 0 | 6 | Couleurs | Migrer |
| `resources/js/Components/sections/ContactForm.vue` | 0 | 9 | Couleurs + formulaire | Migrer + implémenter |
| `resources/js/Components/sections/CtaSection.vue` | 0 | 5 | Couleurs | Migrer |
| `resources/js/Components/sections/FAQAccordion.vue` | 0 | 6 | Couleurs | Migrer |
| `resources/js/Components/sections/FeaturesSection.vue` | 3 | 4 | Titre codé en dur | Migrer + prop |
| `resources/js/Components/sections/GoogleMapPlaceholder.vue` | 0 | 6 | Couleurs | Migrer |
| `resources/js/Components/sections/HeroBanner.vue` | 2 | 7 | Logo + alt | Migrer + logo |
| `resources/js/Components/sections/HeroSection.vue` | 0 | 6 | Couleurs | Migrer ou supprimer si inutilisé |
| `resources/js/Components/sections/IconBox.vue` | 0 | 4 | Couleurs | Migrer |
| `resources/js/Components/sections/MissionSection.vue` | 0 | 12 | Couleurs | Migrer |
| `resources/js/Components/sections/NewsSection.vue` | 0 | 9 | Couleurs + liens | Migrer + décision |
| `resources/js/Components/sections/ProcessSection.vue` | 0 | 6 | Couleurs | Migrer |
| `resources/js/Components/sections/ProjectsCarousel.vue` | 0 | 13 | Couleurs + liens | Migrer + décision |
| `resources/js/Components/sections/Section.vue` | 0 | 2 | Couleurs | Migrer |
| `resources/js/Components/sections/ServiceCard.vue` | 0 | 13 | Couleurs + CTA | Migrer |
| `resources/js/Components/sections/ServicesPreviewSection.vue` | 0 | 2 | Couleurs + ancres | Migrer |
| `resources/js/Components/sections/StatisticsSection.vue` | 1 | 0 | Titre codé en dur | Remplacer par `COMPANY.name` |
| `resources/js/Components/sections/TeamSection.vue` | 1 | 7 | Titre codé en dur | Remplacer + données |
| `resources/js/Components/sections/ValuesGrid.vue` | 0 | 6 | Couleurs | Migrer |
| `resources/js/Components/ui/badges/Badge.vue` | 0 | 5 | Couleurs | Migrer |
| `resources/js/Components/ui/badges/Tag.vue` | 0 | 2 | Couleurs | Migrer |
| `resources/js/Components/ui/buttons/GhostButton.vue` | 0 | 4 | Couleurs | Migrer |
| `resources/js/Components/ui/buttons/OutlineButton.vue` | 0 | 4 | Couleurs | Migrer |
| `resources/js/Components/ui/buttons/PrimaryButton.vue` | 0 | 3 | Couleurs | Migrer |
| `resources/js/Components/ui/buttons/SecondaryButton.vue` | 0 | 4 | Couleurs | Migrer |
| `resources/js/Components/ui/cards/Card.vue` | 0 | 1 | Couleurs | Migrer |
| `resources/js/Components/ui/cards/FeatureCard.vue` | 0 | 6 | Couleurs | Migrer |
| `resources/js/Components/ui/cards/StatCard.vue` | 0 | 5 | Couleurs | Migrer |
| `resources/js/Components/ui/feedback/EmptyState.vue` | 0 | 4 | Couleurs | Migrer |
| `resources/js/Components/ui/feedback/LoadingSpinner.vue` | 0 | 2 | Couleurs | Migrer |
| `resources/js/Components/ui/feedback/Skeleton.vue` | 0 | 1 | Couleurs | Migrer |
| `resources/js/Components/ui/inputs/TextArea.vue` | 0 | 7 | Couleurs | Migrer |
| `resources/js/Components/ui/inputs/TextInput.vue` | 0 | 7 | Couleurs | Migrer |
| `resources/js/Components/ui/navigation/Breadcrumb.vue` | 0 | 6 | Couleurs | Migrer |
| `resources/js/Components/ui/navigation/Divider.vue` | 0 | 1 | Couleurs | Migrer |
| `resources/js/Components/ui/overlays/Modal.vue` | 0 | 5 | Couleurs | Migrer |
| `resources/js/Components/ui/typography/Heading.vue` | 0 | 1 | Couleurs | Migrer |
| `resources/js/Components/ui/typography/SectionTitle.vue` | 0 | 2 | Couleurs | Migrer |
| `resources/js/Components/ui/typography/Text.vue` | 0 | 1 | Couleurs | Migrer |
| `resources/js/config/about.ts` | 9 | 0 | Contenu CCM | Réécrire/valider |
| `resources/js/config/company.ts` | 2 | 0 | Nom/coordonnées | Réécrire |
| `resources/js/config/contact.ts` | 1 | 0 | Image/urgence | Réécrire |
| `resources/js/config/home.ts` | 3 | 0 | Hero/présentation | Réécrire |
| `resources/js/config/news.ts` | 3 | 0 | Actualités | Remplacer/retirer |
| `resources/js/config/projects.ts` | 2 | 0 | Réalisations | Remplacer/retirer |
| `resources/js/config/team.ts` | 1 | 0 | Équipe | Valider |
| `resources/js/Layouts/ErrorLayout.vue` | 0 | 4 | Couleurs | Migrer |
| `resources/js/Pages/Public/About.vue` | 1 | 1 | JSON-LD + couleur | Réécrire |
| `resources/js/Pages/Public/Contact.vue` | 3 | 17 | JSON-LD/meta/couleurs | Réécrire |
| `resources/js/Pages/Public/Home.vue` | 2 | 0 | Images placeholder | Remplacer |
| `resources/js/Pages/Public/Services.vue` | 1 | 5 | JSON-LD/couleurs | Réécrire |

**Total : 63 fichiers.**

---

## 7. Références résiduelles hors sources

### 7.1 Artefacts de build

| Emplacement | Occurrences `ccm` | Traitement |
|---|---:|---|
| `public/build/` | 410 | Supprimer/rebuild ; ne jamais éditer |
| `bootstrap/ssr/` | 529 | Rebuild ou supprimer si SSR abandonné |
| `public/hot` | 0 | Fichier de dev, ignoré par Git |

➜ Après migration, exécuter `npm run build` et vérifier qu'aucun `ccm` ne subsiste dans les nouveaux bundles. Si un CDN sert d'anciens assets, purge nécessaire.

### 7.2 Caches

✅ Aucun `ccm` trouvé dans `storage/framework` au moment de l'audit.
➜ Purger `config:clear`, `view:clear`, `route:clear`, `cache:clear` après déploiement, par précaution.

### 7.3 Base de données

✅ Aucune table de contenu, aucun enregistrement de marque.
✅ Les seules données sont des utilisateurs et des tables techniques vides.
➜ Aucune migration de données CCM→JMC n'est nécessaire **pour le site public**. ⚠ Si la production contient des utilisateurs ou des médias, faire un inventaire séparé avant déploiement.

### 7.4 Configuration serveur / domaine

⚠ Non vérifiable depuis le dépôt :
- nom de domaine de production ;
- anciennes URLs indexées ;
- redirections existantes ;
- certificats, SMTP, DNS ;
- comptes Google Search Console / Analytics / Business Profile.

➜ À collecter avant la phase E (voir doc 05 et 06).

---

## 8. Commandes de recherche reproductibles

```bash
# Toutes les occurrences textuelles, hors artefacts
grep -rIn --exclude-dir={node_modules,vendor,.git,build,bootstrap} \
  -E "CCM|Congo Construction" .

# Tous les fichiers concernés
git ls-files | xargs grep -Il -i "ccm"

# Tous les tokens CSS
grep -rIo --exclude-dir={node_modules,vendor} \
  "var(--color-ccm-[a-z0-9-]*" resources/js resources/css | wc -l

# Répartition par fichier
for f in $(git ls-files | xargs grep -Il -i "ccm"); do
  printf "%-80s %s\n" "$f" "$(grep -c -i ccm "$f")"
done | sort

# Contacts et réseaux
grep -rn --exclude-dir={node_modules,vendor,.git,build,bootstrap} \
  -E "ccmsarl|243 81|243812345|Avenue de la Libération|facebook.com|linkedin.com|youtube.com" .

# Artefacts
grep -rIl -i "ccm" public/build bootstrap/ssr
```

---

## 9. Pièges à éviter lors du remplacement

| Piège | Exemple | Conséquence | Bonne pratique |
|---|---|---|---|
| Remplacement global « CCM » → « JMC » | Histoire, actualités, équipe | Contenu faux, incohérences | Réécriture par bloc, validation |
| Remplacement global « SARL » → « S.P.R.L » | Raison sociale | Erreur juridique | Utiliser le nom exact validé |
| Renommer les tokens sans tester | `--color-ccm-blue` → `--color-primary` | Collision avec daisyUI | Cartographier les rôles |
| Supprimer l'ancien nom partout | SEO, histoire, entité légale | Perte de continuité | Conserver si justifié et validé (`alternateName`, page histoire) |
| Oublier les artefacts | `public/build`, `bootstrap/ssr` | Ancien nom visible/caché | Rebuild + purge |
| Oublier les métadonnées | JSON-LD, OG, title | SEO incohérent | Checklist doc 08 |
| Remplacer les coordonnées par des valeurs plausibles | Téléphone, e-mail | Perte de contact | Attendre les données officielles |
| Publier l'équipe/les certifications sans preuve | Risque juridique | Litige, réputation | Validation écrite |

### 9.1 Exceptions pouvant légitimement conserver « CCM »

Sous réserve de validation :

- une page « Notre histoire » qui explique la transition CCM → JMC ;
- la mention « anciennement CCM S.A.R.L » dans un communiqué ;
- le champ `alternateName` du JSON-LD si la même entité juridique continue ;
- les redirections d'anciennes URLs ;
- les documents légaux historiques ;
- d'éventuels backlinks/partenaires qui citent l'ancien nom (hors site).

➜ **Aucune de ces exceptions ne doit être ajoutée par défaut.** Elles nécessitent une décision explicite (doc 06).

---

## 10. Critères d'acceptation de l'inventaire

- [x] Les 63 fichiers source sont listés avec leur nature et leur action.
- [x] Les occurrences textuelles critiques sont localisées par fichier et ligne.
- [x] Les 8 assets de marque obsolètes sont identifiés.
- [x] Les 45 placeholders sont catégorisés.
- [x] Les coordonnées et réseaux anciens sont isolés.
- [x] Les artefacts générés et caches sont distingués des sources.
- [x] Les exceptions légitimes potentielles sont signalées.
- [x] Les commandes de vérification sont fournies.

**Critère de sortie de la migration :** zéro occurrence non justifiée de `CCM` / `ccm` / `Congo Construction` dans les sources, les assets publics, les métadonnées et les bundles générés.
