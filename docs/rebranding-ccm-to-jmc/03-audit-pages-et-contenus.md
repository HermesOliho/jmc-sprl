# 03 — Audit des pages, fonctionnalités et contenus

**Objet :** inventorier ce que le site propose réellement, page par page, et classer les modifications nécessaires pour JMC.

**Règle :** aucune page n'est supposée exister parce qu'elle serait habituelle sur un site institutionnel. Seules les routes et composants vérifiés sont décrits comme existants.

---

## 1. Vue d'ensemble

### 1.1 Pages publiques réellement accessibles

| # | URL | Nom de route | Composant | Statut |
|---:|---|---|---|---|
| 1 | `/` | `home` | `Pages/Public/Home.vue` | ✅ Fonctionnelle |
| 2 | `/a-propos` | `about` | `Pages/Public/About.vue` | ✅ Fonctionnelle |
| 3 | `/services` | `services` | `Pages/Public/Services.vue` | ✅ Fonctionnelle |
| 4 | `/contact` | `contact` | `Pages/Public/Contact.vue` | ✅ Fonctionnelle (formulaire non fonctionnel) |

### 1.2 Routes existantes mais non abouties

| URL | Constat |
|---|---|
| `/services/{slug}` | Route déclarée, rend le même composant que `/services`, prop `slug` ignorée. **Pas de page de détail réelle.** |

### 1.3 Pages liées mais inexistantes

| URL | Référencée dans | Statut HTTP attendu |
|---|---|---|
| `/realisations` | Navigation, footer, `ProjectsCarousel` | 404 |
| `/carrieres` | Navigation | 404 |
| `/demande-devis` | Header (desktop + mobile), hero, `CtaSection` sur 4 pages | 404 |
| `/actualites` | `NewsSection` (liens article + « voir toutes ») | 404 |
| `/mentions-legales` | Aucun lien, mais attendue pour un site institutionnel | 404 |
| `/politique-de-confidentialite` | Aucun lien, alors que le formulaire recueille un consentement | 404 |
| `/galerie` | README uniquement | 404 |
| `/telechargements` | README uniquement | 404 |
| `/parc-equipements` | README uniquement | 404 |

### 1.4 Pages internes

| URL | Composant | Statut |
|---|---|---|
| `/login`, `/register`, `/forgot-password`, `/reset-password/{token}`, `/confirm-password`, `/verify-email` | `Pages/Auth/*` | ✅ Fonctionnelles, en anglais |
| `/dashboard` | `Pages/Dashboard.vue` | ✅ Accessible après auth, contenu Breeze |
| `/profile` | `Pages/Profile/Edit.vue` | ✅ Fonctionnel, en anglais |
| Erreurs 404/403/500 | `Pages/Errors/*` | ❌ Composants non branchés |

### 1.5 Chiffres

- **4** pages publiques réelles.
- **1** route de détail non implémentée.
- **15** routes d'authentification.
- **3** routes de profil + **1** dashboard.
- **3** composants d'erreur non branchés.
- **1** page orpheline (`Welcome.vue`).
- **9** URLs publiques manquantes ou non abouties (hors détail service).

---

## 2. Fiche détaillée — Accueil `/`

### 2.1 Identité de la page

| Champ | Valeur |
|---|---|
| URL | `/` |
| Route | `home` (closure, `routes/web.php:7`) |
| Composant | `resources/js/Pages/Public/Home.vue` |
| Layout | `PublicLayout` |
| Objectif actuel | Présenter l'entreprise, ses services, ses réalisations, ses chiffres, ses partenaires et ses actualités |
| Métadonnées | `SeoHead title="Accueil"`, description `COMPANY.description`, canonical `/` |
| JSON-LD | `Organization` injecté dans `onMounted` |

### 2.2 Structure réelle

1. `SeoHead`
2. `nav` fil d'Ariane `sr-only`
3. `HeroBanner` : titre, sous-titre, badge, 3 stats, 2 CTA, logo full, image de fond placeholder
4. `AboutPreviewSection` : présentation + 3 valeurs + CTA `/a-propos`
5. `ServicesPreviewSection` : 6 services + CTA `/services`
6. `FeaturesSection` : 6 atouts + image « Pourquoi CCM SARL »
7. `ProjectsCarousel` : 6 projets + CTA `/realisations`
8. `StatisticsSection` : 4 compteurs animés
9. `ProcessSection` : 5 étapes
10. `PartnersCarousel` : 6 partenaires
11. `CtaSection` : devis + téléphone
12. `NewsSection` : 3 actualités + CTA `/actualites`

### 2.3 Contenus et données

| Section | Source | Nature |
|---|---|---|
| Hero | `config/home.ts` `HOME_HERO` | Texte CCM + stats 20+/15+/100% |
| À propos | `config/home.ts` `ABOUT_PREVIEW` | Texte CCM, image placeholder |
| Services | `config/services.ts` `HOME_SERVICES` | 6 services |
| Atouts | `config/home.ts` `FEATURES` | 6 atouts |
| Projets | `config/projects.ts` `HOME_PROJECTS` | 6 projets fictifs |
| Chiffres | `config/statistics.ts` `HOME_STATISTICS` | 150/80/200/15 |
| Process | `config/home.ts` `PROCESS` | 5 étapes |
| Partenaires | `config/partners.ts` | 6 logos génériques |
| CTA | `config/home.ts` `CTA_SECTION` | Devis + téléphone |
| Actualités | `config/news.ts` `HOME_NEWS` | 3 actualités fictives |

### 2.4 Interactions

- Animation d'entrée du hero (`motion-v`, `onMounted`).
- Header fixe avec masquage au scroll.
- Compteurs animés au scroll (`IntersectionObserver`).
- Carrousel de projets avec boutons gauche/droite.
- Carrousel infini de partenaires (CSS), pause au survol.
- Liens CTA.

### 2.5 Problèmes vérifiés

| Problème | Preuve | Gravité |
|---|---|---|
| CTA « Demander un devis » → 404 | `HOME_HERO.secondaryCta`, `CTA_SECTION.primaryButton` → `/demande-devis` | **Haute** |
| « Voir toutes nos réalisations » → 404 | `ProjectsCarousel` → `/realisations` | **Haute** |
| « Voir toutes les actualités » → 404 | `NewsSection` → `/actualites` | **Haute** |
| Liens « Lire l'article » → `/actualites#id` | 404 + ancre inexistante | Haute |
| Liens « Voir le projet » → `/realisations#id` | 404 + ancre inexistante | Haute |
| Liens services → `/services#titre-avec-accents` | Aucun `id` correspondant | Haute |
| Incohérence 20+ vs 150+ projets | `home.ts:10` vs `statistics.ts:4` | Haute |
| Incohérence 12+ vs 15+ années | `company.ts:55` vs `statistics.ts:7` | Haute |
| Image de fond placeholder | `Home.vue:72` | Haute |
| Image « Pourquoi CCM » placeholder | `Home.vue:81` | Haute |
| JSON-LD ajouté à chaque navigation sans nettoyage | `Home.vue:46-52` | Moyenne |
| `url: '/'` relative dans le JSON-LD | `Home.vue:36` | Moyenne |
| Stats hero non issues de la même source que les compteurs | Deux configs distinctes | Moyenne |
| Aucun `og:image` | `SeoHead` sans prop `ogImage` | Moyenne |

### 2.6 Classement des modifications

| Catégorie | Applicable ? | Détail |
|---|---|---|
| 1. Aucune modification | Non | Tout est impacté |
| 2. Mise à jour éditoriale | **Oui** | Hero, présentation, chiffres, actualités, projets |
| 3. Mise à jour visuelle | **Oui** | Hero, cartes, couleurs, logo, images |
| 4. Mise à jour fonctionnelle | **Oui** | CTA, liens, ancres, JSON-LD |
| 5. Refonte partielle recommandée | **Oui** | Hero + section chiffres + preuve sociale |
| 6. Nouvelle page | Non (sauf pages manquantes, décision produit) | — |

---

## 3. Fiche détaillée — À propos `/a-propos`

### 3.1 Identité

| Champ | Valeur |
|---|---|
| URL | `/a-propos` |
| Route | `about` |
| Composant | `Public/About.vue` |
| Objectif actuel | Raconter l'histoire, la mission, la vision, les valeurs, l'équipe et les certifications |
| Métadonnées | `title="À propos"`, description `COMPANY.description`, canonical `/a-propos` |
| JSON-LD | `AboutPage` + `Organization` |

### 3.2 Structure réelle

1. `PageHeader` : titre `ABOUT_HERO.title`, sous-titre, fil d'Ariane
2. Section présentation : image placeholder + paragraphes `ABOUT_PRESENTATION`
3. `CompanyHistory` : 6 jalons 2009 → 2024
4. `ValuesGrid` : 6 valeurs
5. `MissionSection` : mission
6. `MissionSection reversed` : vision
7. `TeamSection` : 4 membres
8. `CertificationGrid` : 4 certifications
9. `FeaturesSection` : « Pourquoi nous choisir » + image placeholder
10. `CtaSection`

### 3.3 Contenus à risque

| Contenu | Source | Risque |
|---|---|---|
| « Fondée il y a plus de 15 ans » | `ABOUT_PRESENTATION` | Contredit les jalons (2009 → 17 ans en 2026) et les stats (12+/15+) |
| « CCM SARL s'est imposée… » | `ABOUT_PRESENTATION` | Ancienne identité, à réécrire |
| Historique 2009-2024 | `ABOUT_HISTORY` | **Ne peut pas être transposé tel quel à JMC sans décision** |
| « Création de CCM SARL » | jalon 2009 | Question : JMC est-elle une continuité ou une nouvelle entité ? |
| « Certifications ISO 9001, ISO 14001, OHSAS 18001, RSE » | `CERTIFICATIONS` | **Non vérifié** : ne pas publier sans certificats |
| Équipe : Jean-Pierre Kabongo, Marie-Claire Ntumba, Paul Mputu, Esther Lukusa | `TEAM_MEMBERS` | **Non vérifié** : noms et photos possiblement fictifs |
| « Fondateur de CCM SARL » | `team.ts:8` | Identité + fait non vérifié |
| Mission/vision | `ABOUT_MISSION`, `ABOUT_VISION` | À valider par la direction |
| « Pourquoi nous choisir » | `ABOUT_WHY_US` | À valider |
| Image `ABOUT_HERO.image` | `config/about.ts:7` | **Définie mais jamais affichée** (PageHeader n'a pas d'image) |

### 3.4 Problèmes vérifiés

- Titre de section « Pourquoi choisir CCM SARL ? » codé en dur dans `FeaturesSection.vue:20`, utilisé aussi sur Home.
- JSON-LD `name: 'À propos de CCM SARL'` en dur (`About.vue:36`).
- Aucun `og:image`.
- Le fil d'Ariane est correct.
- La page est très longue (9 sections) ; la charge visuelle devra être réévaluée après suppression éventuelle de l'historique/équipe/certifications.

### 3.5 Classement

| Catégorie | Applicable ? | Détail |
|---|---|---|
| 1. Aucune modification | Non | — |
| 2. Mise à jour éditoriale | **Oui, majeure** | Présentation, histoire, mission, équipe, certifications |
| 3. Mise à jour visuelle | **Oui** | Images, couleurs, logo |
| 4. Mise à jour fonctionnelle | Oui | JSON-LD, liens |
| 5. Refonte partielle recommandée | **Oui** | Section histoire et preuve sociale à reconditionner |
| 6. Nouvelle page | Non | — |

---

## 4. Fiche détaillée — Services `/services`

### 4.1 Identité

| Champ | Valeur |
|---|---|
| URL | `/services` et `/services/{slug}` |
| Route | `services`, `services.show` |
| Composant | `Public/Services.vue` |
| Objectif actuel | Présenter 12 services, la méthode, la FAQ et un CTA |
| Métadonnées | `title="Services"`, description dynamique avec `COMPANY.name`, canonical `/services` |
| JSON-LD | `CollectionPage` + `ItemList` de 12 services |

### 4.2 Structure réelle

1. `PageHeader`
2. `Section id="liste"` : grille de 12 `ServiceCard`
3. Section « Pourquoi choisir nos services ? » : 6 atouts codés en dur dans le template
4. `ProcessSection` : 5 étapes
5. `FAQAccordion` : 5 questions
6. `CtaSection`

### 4.3 Taxonomie incohérente

| Source | Nombre | Services |
|---|---:|---|
| `config/company.ts` `SERVICES` | 4 | Construction métallique, génie civil, infrastructures, menuiserie |
| `config/services.ts` `HOME_SERVICES` | 6 | Construction générale, métallique, électricité, travaux publics, rénovation, consultance |
| `config/services.ts` `ALL_SERVICES` | 12 | Les 6 + production de matériaux, travaux miniers, adduction d'eau, soudure, peinture, commerce de pièces, agro-pastoral |
| `config/navigation.ts` `FOOTER_SERVICES` | 4 | Métallique, génie civil, infrastructures, menuiserie |

➜ **Aucune de ces listes n'est validée par la direction.** La migration doit retenir **une seule taxonomie officielle** et l'utiliser partout (navigation, footer, cartes, JSON-LD, ancres).

### 4.4 Problèmes vérifiés

| Problème | Preuve | Gravité |
|---|---|---|
| Pas de page de détail | `services.show` rend `Services.vue`, `slug` ignoré | **Haute** |
| Liens « En savoir plus » vers `/services/{slug}` | `ServiceCard.vue:68` | Duplique la liste, pas de contenu dédié |
| CTA « Demander un devis » vers `/contact?subject={slug}` | `ServiceCard.vue:75` | Le paramètre `subject` n'est jamais lu par le formulaire |
| Ancres footer inexistantes | `#metallique`, `#genie-civil`, etc. | Haute |
| Ancres homepage calculées avec accents | `/services#construction-générale` | Ne correspond à aucun `id` |
| Images placeholder | 12 `placehold.co` | Haute |
| 6 atouts codés en dur dans le template | `Services.vue:76-101` | Maintenance difficile |
| JSON-LD contient « CCM SARL » | `Services.vue:23` | Critique |
| Description de service non validée | `ALL_SERVICES` | Haute |
| Allégations commerciales non vérifiées | « garantie décennale incluse », « normes OMS », « soudeurs certifiés » | **Critique** |

### 4.5 Classement

| Catégorie | Applicable ? | Détail |
|---|---|---|
| 1. Aucune modification | Non | — |
| 2. Mise à jour éditoriale | **Oui, majeure** | Taxonomie + descriptions + allégations |
| 3. Mise à jour visuelle | **Oui** | Couleurs, images, cartes |
| 4. Mise à jour fonctionnelle | **Oui** | Détail de service, ancres, query `subject` |
| 5. Refonte partielle recommandée | **Oui** | Page liste + détail |
| 6. Nouvelle page | **Oui, conditionnelle** | Pages de détail si contenu validé |

---

## 5. Fiche détaillée — Contact `/contact`

### 5.1 Identité

| Champ | Valeur |
|---|---|
| URL | `/contact` |
| Route | `contact` |
| Composant | `Public/Contact.vue` |
| Objectif actuel | Afficher les coordonnées, un formulaire, une carte, des informations et une FAQ |
| Métadonnées | `title="Contact"`, description CCM, canonical `/contact` |
| JSON-LD | `ContactPage` + `Organization` |

### 5.2 Structure réelle

1. `PageHeader`
2. Coordonnées (`ContactCard`) + réseaux sociaux
3. Formulaire (`ContactForm`)
4. Section « Nous trouver » avec `GoogleMapPlaceholder`
5. 3 cartes d'information : délai de réponse, disponibilité, urgence
6. FAQ (4 questions)
7. `CtaSection`

### 5.3 Formulaire — comportement exact

| Élément | Constat |
|---|---|
| Champs | Nom, entreprise, email, téléphone, sujet, message, consentement |
| Validation | Client uniquement (`validate()` dans `ContactForm.vue`) |
| Soumission | `console.log('Form submitted (placeholder):', { ...form })` |
| Route POST | **Aucune** |
| Contrôleur | **Aucun** |
| Mailable | **Aucun** |
| CSRF | Sans objet, aucun appel réseau |
| Anti-spam | **Aucun** (honeypot, captcha, rate limit) |
| Message de succès | **Aucun** |
| État de chargement | **Aucun** |
| Accessibilité | `aria-invalid`/`aria-describedby` sur les champs texte ; label « Sujet » non lié ; consentement encapsulé dans un label |
| Données personnelles | Consentement demandé sans politique de confidentialité |

➜ **Décision produit requise :** implémenter un vrai formulaire ou le retirer au profit de `mailto:`/téléphone. Voir doc 06 et doc 07 (D05).

### 5.4 Coordonnées affichées

Toutes issues de `config/company.ts` :

- Adresse : Avenue de la Libération, n° 15, Kinshasa, RDC
- Téléphone : +243 81 234 5678
- Email : info@ccmsarl.cd
- Horaires : Lun–Ven 07:30–16:30, Sam 08:00–12:00
- GPS : -4.44193, 15.26629
- Réseaux : Facebook, LinkedIn, WhatsApp, YouTube (`ccmsarl`)

⚠ **Ces données sont probablement provisoires/fictives.** Elles ne doivent pas être publiées telles quelles pour JMC.

### 5.5 Carte

✅ `GoogleMapPlaceholder.vue` affiche un encart « Carte interactive » avec l'adresse et la mention « (Intégration Google Maps à venir) ».
❌ Aucune carte réelle, aucune API Google Maps, aucun consentement cookies.
➜ Décider : intégrer une carte (avec consentement) ou afficher un lien « Ouvrir dans Maps » plus léger.

### 5.6 Problèmes vérifiés

- Description et JSON-LD CCM.
- Formulaire factice.
- Coordonnées et réseaux non valides.
- `?subject=` ignoré : un utilisateur venant d'une carte service ne voit pas le sujet présélectionné.
- Aucun `og:image`.
- Trois cartes d'information avec un ton commercial (« urgence 7j/7 ») non validé.

### 5.7 Classement

| Catégorie | Applicable ? | Détail |
|---|---|---|
| 1. Aucune modification | Non | — |
| 2. Mise à jour éditoriale | **Oui** | Coordonnées, FAQ, messages |
| 3. Mise à jour visuelle | **Oui** | Couleurs, carte, formulaire |
| 4. Mise à jour fonctionnelle | **Oui, critique** | Formulaire, query subject, carte |
| 5. Refonte partielle recommandée | **Oui** | Bloc contact + formulaire |
| 6. Nouvelle page | Non | — |

---

## 6. Pages d'authentification et espace interne

### 6.1 Pages

| URL | Page | Langue | Logo | Statut |
|---|---|---|---|---|
| `/login` | `Auth/Login.vue` | Anglais | Ancien CCM | ✅ Fonctionne |
| `/register` | `Auth/Register.vue` | Anglais | Ancien CCM | ✅ Fonctionne, **inscription ouverte** |
| `/forgot-password` | `Auth/ForgotPassword.vue` | Anglais | Ancien CCM | ✅ |
| `/reset-password/{token}` | `Auth/ResetPassword.vue` | Anglais | Ancien CCM | ✅ |
| `/confirm-password` | `Auth/ConfirmPassword.vue` | Anglais | Ancien CCM | ✅ |
| `/verify-email` | `Auth/VerifyEmail.vue` | Anglais | Ancien CCM | ✅ |
| `/dashboard` | `Dashboard.vue` | Anglais | Ancien CCM | ✅ après auth |
| `/profile` | `Profile/Edit.vue` | Anglais | Ancien CCM | ✅ après auth |

### 6.2 Constats

- ✅ `GuestLayout.vue` utilise `ApplicationLogo` (ancien logo CCM) et des classes `gray`/`indigo`.
- ✅ Tous les libellés sont en anglais alors que `APP_LOCALE=fr`.
- ✅ L'inscription est publique. N'importe qui peut créer un compte et accéder au dashboard.
- ⚠ Le README promet un « espace client » (suivi de projets, factures, rapports) qui n'existe pas.
- ⚠ Aucune politique de rôles n'est appliquée, alors que `spatie/laravel-permission` est installé.
- ⚠ Le dashboard n'a aucun contenu métier.

### 6.3 Classement

| Catégorie | Applicable ? | Détail |
|---|---|---|
| 1. Aucune modification | Non si l'espace est conservé | — |
| 2. Mise à jour éditoriale | **Oui** | Traduction FR, messages |
| 3. Mise à jour visuelle | **Oui** | Logo, couleurs, layout |
| 4. Mise à jour fonctionnelle | **Oui** | Décision : fermer l'inscription, limiter l'accès, ou conserver |
| 5. Refonte partielle recommandée | **Oui** | Layout auth + dashboard si conservé |
| 6. Nouvelle page | Non | — |

---

## 7. Pages d'erreur

| Composant | Statut | Problème |
|---|---|---|
| `Errors/NotFound.vue` | Non branché | Un 404 réel affiche la page Laravel par défaut (ou le debug en local) |
| `Errors/Forbidden.vue` | Non branché | Idem |
| `Errors/ServerError.vue` | Non branché | Idem |

➜ **Action :** configurer la gestion des exceptions Inertia dans `bootstrap/app.php` (ou l'équivalent Inertia 3) pour rendre ces composants. Sinon, les supprimer pour ne pas laisser de code mort.

**Classement :** 3 (visuel) + 4 (fonctionnel).

---

## 8. Page orpheline `Welcome.vue`

✅ Page de démarrage Laravel, non routée, avec logos Laravel, texte anglais et liens externes.
➜ **Recommandation :** supprimer le composant (ou le conserver hors périmètre si un usage de démonstration est prévu). Ne pas le rebrander.

---

## 9. Inventaire des liens et des ancres

### 9.1 Liens cassés (routes inexistantes)

| Lien | Occurrences | Fichiers |
|---|---:|---|
| `/demande-devis` | 6 | `Header.vue` (2), `config/home.ts` (2), `HeroBanner` via `HOME_HERO`, `CtaSection` sur 4 pages |
| `/realisations` | 4 | `config/navigation.ts` (2), `ProjectsCarousel.vue` (2) |
| `/carrieres` | 1 | `config/navigation.ts` |
| `/actualites` | 2 | `NewsSection.vue` (2) |
| `/realisations#id` | 6 | `ProjectsCarousel.vue` |
| `/actualites#id` | 3 | `NewsSection.vue` |
| `/services#slug` | 6 | `ServicesPreviewSection.vue` (calcul dynamique) |
| `/services#metallique` etc. | 4 | `config/navigation.ts` footer |
| `/contact?subject=slug` | 12 | `ServiceCard.vue` (paramètre ignoré) |

### 9.2 Ancres existantes

| Ancre | Fichier |
|---|---|
| `#realisations` | `ProjectsCarousel.vue` (section homepage) |
| `#actualites` | `NewsSection.vue` |
| `#services` | `ServicesPreviewSection.vue` |
| `#liste` | `Services.vue` |
| `#faq-answer-{index}` | `FAQAccordion.vue` (généré) |

➜ Aucune ancre `#metallique`, `#genie-civil`, `#infrastructures`, `#menuiserie`, ni `#construction-générale`.

### 9.3 Recommandation de traitement

| Cas | Option recommandée |
|---|---|
| Page non prévue (Réalisations, Carrières, Actualités) | **Retirer des navigations et CTA** tant que le contenu n'existe pas, plutôt que créer des pages vides |
| Demande de devis | Soit créer une vraie page/formulaire, soit rediriger vers `/contact` avec un sujet prérempli |
| Détail service | Implémenter une page par slug **ou** supprimer le lien « En savoir plus » et garder la liste |
| Ancres footer | Ajouter des `id` stables sur les cartes de service **ou** retirer les ancres |
| `?subject=` | Lire le paramètre dans `ContactForm` et présélectionner le sujet |

---

## 10. Incohérences éditoriales et allégations non vérifiées

| # | Incohérence / allégation | Sources | Risque | Décision |
|---:|---|---|---|---|
| 1 | 20+ projets vs 150+ projets | `home.ts:10`, `statistics.ts:4`, `company.ts:54`, `about.ts:59` | Crédibilité | Chiffre officiel unique |
| 2 | 12+ vs 15+ années d'expérience | `company.ts:55`, `statistics.ts:7`, `home.ts:10`, `about.ts:6` | Crédibilité | Date de création officielle |
| 3 | « Depuis plus de 15 ans » vs création 2009 | `about.ts:14`, `about.ts:22` | Crédibilité | Calcul cohérent |
| 4 | 200 collaborateurs vs 200+ employés | `company.ts:56`, `statistics.ts:6` | Crédibilité | Chiffre officiel |
| 5 | « 80+ clients satisfaits » | `company.ts:57`, `statistics.ts:5` | Crédibilité | Preuve |
| 6 | « 100% professionnalisme » | `home.ts:10` | Marketing | À reformuler ou retirer |
| 7 | Certifications ISO/OHSAS/RSE | `certifications.ts` | **Juridique** | Certificats à fournir |
| 8 | « Garantie décennale incluse » | `services.ts` (construction générale) | **Juridique** | Vérifier |
| 9 | « Assurance RC pro » | `services.ts` (FAQ) | **Juridique** | Vérifier |
| 10 | « Matériaux aux normes OMS » | `services.ts` (adduction d'eau) | **Juridique** | Vérifier |
| 11 | « Intervenons dans toutes les provinces » | `services.ts` (FAQ) | Commercial | Vérifier |
| 12 | « Réponse sous 48h » | `contact.ts`, FAQ | Commercial | Valider |
| 13 | « Urgence 7j/7 » | `contact.ts:13` | Commercial | Valider |
| 14 | « Soudeurs certifiés » | `services.ts` (soudure) | Commercial | Vérifier |
| 15 | Équipe nommée + rôles | `team.ts` | **Réputationnel/juridique** | Validation écrite |
| 16 | Partenaires génériques | `partners.ts` | Crédibilité | Logos autorisés |
| 17 | Projets et actualités fictifs | `projects.ts`, `news.ts` | **Crédibilité** | Contenus réels ou retrait |
| 18 | « Siège CCM SARL » parmi les réalisations | `projects.ts:41` | Identité | Retirer/remplacer |
| 19 | FAQ avec faute « Puis-vous visiter » | `faq.ts:16` | Qualité | Corriger |
| 20 | FAQ avec faute « Puis-je suivre » | `services.ts` FAQ | Qualité | Corriger |

➜ **Règle :** aucune de ces allégations ne doit être reprise dans la version JMC sans validation explicite. Voir doc 06.

---

## 11. Fonctionnalités réellement présentes

| Fonctionnalité | Présente ? | Détail |
|---|---|---|
| Navigation publique | ✅ | Header + footer |
| Menu mobile | ✅ | Pinia `appStore` |
| Pages statiques | ✅ | 4 pages |
| Carrousel de réalisations | ✅ | Défilement horizontal |
| Carrousel de partenaires | ✅ | Animation CSS |
| Compteurs animés | ✅ | `IntersectionObserver` |
| Accordéon FAQ | ✅ | Accessible (partiellement) |
| Formulaire de contact | ❌ | Factice |
| Demande de devis | ❌ | Lien mort |
| Actualités | ❌ | Section homepage + données fictives, pas de page |
| Réalisations | ❌ | Carrousel homepage + données fictives, pas de page |
| Carrières | ❌ | Lien mort |
| Galerie | ❌ | README uniquement |
| Téléchargements | ❌ | README uniquement |
| Espace client | ❌ | Dashboard Breeze vide |
| Administration | ❌ | Aucune interface |
| Blog | ❌ | Aucun modèle ni route |
| Newsletter | ❌ | Aucun |
| Recherche | ❌ | Aucun |
| Multilingue | ❌ | Locale FR uniquement, aucun switch |
| Thème sombre | ❌ | Non opérationnel |
| Analytics | ❌ | Aucun outil |
| Carte | ❌ | Placeholder |
| Réseaux sociaux | ✅ | Liens (données à remplacer) |

---

## 12. Classement global des pages

| Page | Cat. 1 | Cat. 2 | Cat. 3 | Cat. 4 | Cat. 5 | Cat. 6 |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| Accueil | — | ✅ | ✅ | ✅ | ✅ | — |
| À propos | — | ✅ | ✅ | ✅ | ✅ | — |
| Services | — | ✅ | ✅ | ✅ | ✅ | ✅ (détail) |
| Contact | — | ✅ | ✅ | ✅ | ✅ | — |
| Auth | — | ✅ | ✅ | ✅ | ✅ | — |
| Dashboard/Profil | — | ✅ | ✅ | ✅ | ✅ | — |
| Erreurs | — | — | ✅ | ✅ | — | — |
| Welcome | — | — | — | — | — | — (supprimer) |
| Réalisations | — | — | — | — | — | ✅ ou retrait |
| Carrières | — | — | — | — | — | ✅ ou retrait |
| Actualités | — | — | — | — | — | ✅ ou retrait |
| Devis | — | — | — | — | — | ✅ ou redirection |
| Mentions légales | — | — | — | — | — | ✅ (recommandé) |
| Confidentialité | — | — | — | — | — | ✅ (requis si formulaire) |

**Légende :** 1 aucune modification · 2 éditorial · 3 visuel · 4 fonctionnel · 5 refonte partielle · 6 nouvelle page.

---

## 13. Décisions produit à prendre

1. **Histoire** : conserver l'histoire CCM (continuité) ou présenter JMC comme une nouvelle entité ?
2. **Services** : quelle taxonomie officielle ? 4, 6, 12, autre ?
3. **Réalisations** : page dédiée ou simple section homepage ? Contenus réels disponibles ?
4. **Actualités** : page dédiée, blog, ou suppression de la section ?
5. **Carrières** : page, formulaire, ou suppression du lien ?
6. **Devis** : page dédiée, formulaire de contact avec sujet, ou suppression ?
7. **Espace client** : conserver l'auth/dashboard, le fermer, ou le réserver à l'administration ?
8. **Équipe** : publier des noms/photos ou rester générique ?
9. **Certifications** : publier uniquement les certificats valides.
10. **Partenaires** : publier uniquement les logos autorisés.
11. **Carte** : Google Maps intégré, lien externe, ou aucune carte ?
12. **Pages légales** : qui rédige et valide ?

Toutes ces décisions sont reprises dans [`06-informations-a-valider.md`](./06-informations-a-valider.md).

---

## 14. Critères d'acceptation de l'audit pages/contenus

- [x] Chaque page publique est décrite avec son URL, son objectif, ses composants et ses dépendances.
- [x] Chaque page est classée selon les six catégories demandées.
- [x] Les liens morts et les ancres invalides sont listés avec leur nombre d'occurrences.
- [x] Le formulaire de contact est décrit sans ambiguïté comme non fonctionnel.
- [x] Les contenus non vérifiés et les allégations à risque sont isolés.
- [x] Les pages manquantes sont signalées sans être créées.
- [x] Aucun contenu institutionnel n'a été inventé.
- [x] Les décisions produit sont explicites.

**Critère de sortie :** aucune page publique ne renvoie 404 depuis un lien interne, chaque page a un objectif validé, et chaque contenu affiché est soit vérifié, soit explicitement marqué comme hypothèse.
