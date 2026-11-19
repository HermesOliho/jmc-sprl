# 07 — Plan complet de migration CCM → JMC

**Objet :** fournir un plan d'exécution ordonné, dépendancié et vérifiable pour une mission d'implémentation ultérieure.

**Principe :** adaptation ciblée de l'existant, pas de réécriture. Chaque tâche indique les fichiers concernés, les dépendances, la priorité, la complexité, les critères d'acceptation et les ressources nécessaires.

---

## 1. Règles d'exécution

1. **Une seule source de vérité** pour le nom, les coordonnées, la description et les réseaux.
2. **Aucune invention** de contenu institutionnel, de chiffre, de certification ou de coordonnée.
3. **Aucun remplacement global aveugle** de « CCM ».
4. **Aucune suppression d'asset** avant validation et période de grâce.
5. **Un commit par lot cohérent**, avec message explicite (`rebrand: …`).
6. **Tests et build** avant chaque fin de phase.
7. **Aucune dépendance ajoutée** sans justification et validation.
8. **Le code existant est préservé** sauf dette explicitement traitée.

### Convention de priorité

| Priorité | Signification |
|---|---|
| **Critique** | Bloque la mise en production ou casse une fonction |
| **Haute** | Nécessaire à la qualité perçue ou au SEO |
| **Moyenne** | Améliore la cohérence, peut suivre |
| **Basse** | Confort, documentation, nettoyage |

### Convention de complexité

| Complexité | Signification |
|---|---|
| **Faible** | < 1 h, localisé, sans risque |
| **Moyenne** | 1–4 h, plusieurs fichiers, revue visuelle |
| **Élevée** | > 4 h, transversal, décision ou risque |

### Dépendances

- `—` : aucune dépendance.
- `A02` : dépend de la tâche A02.
- `[C]` : conditionnel, dépend d'une décision du doc 06.

---

## 2. Vue d'ensemble des phases

| Phase | Objectif | Durée indicative | Condition de sortie |
|---|---|---|---|
| **A — Préparation** | Sécuriser, collecter, arbitrer | 2–4 jours | Assets + décisions P0 + baseline |
| **B — Fondation visuelle** | Thèmes, logo, composants, layouts | 4–7 jours | Site visuellement JMC en clair/sombre |
| **C — Migration éditoriale** | Contenus, coordonnées, textes | 4–8 jours | Aucun contenu CCM non justifié |
| **D — Adaptation des pages** | Pages, liens, formulaire, erreurs | 4–7 jours | Parcours public complet sans 404 |
| **E — SEO et intégrations** | Métadonnées, sitemap, redirections, e-mail | 3–5 jours | SEO serveur + intégrations validées |
| **F — Qualité** | Tests, a11y, perf, sécurité | 3–5 jours | Checklist doc 08 verte |
| **G — Production** | Déploiement, vérifications, rollback | 1–2 jours | Site stable, SEO surveillé |

> Les durées sont indicatives et supposent les décisions P0 obtenues. Elles ne constituent pas un engagement.

### Chemin critique

```text
A02 (logo) ─┐
A03 (contenus) ─┼─→ B01–B06 ─→ C01–C04 ─→ D01–D07 ─→ E01–E08 ─→ F ─→ G
A04 (décisions) ─┘
A05 (SEO prod) ──────────────────────────────→ E05–E07
```

**Bloquants absolus :** A02, A03, A04, A05.
**Parallélisables :** B (une fois logo), C (une fois contenus), E (une fois pages), F partiellement.

---

## 3. Phase A — Préparation

**Objectif :** ne rien casser, ne rien inventer, disposer de tous les matériaux.

| ID | Tâche | Fichiers / composants | Objectif | Dépend de | Prio | Complexité | Critères d'acceptation | Ressources |
|---|---|---|---|---|---|---|---|---|
| **A01** | Créer une baseline | Git, `docs/` | Pouvoir revenir à l'état CCM | — | **Critique** | Faible | Tag `pre-rebrand` créé ; branche `rebrand/jmc` créée ; arbre de travail propre (hors docs de migration) | Accès Git |
| **A02** | Collecter les assets de marque | `resources/images/brand/`, `public/` | Disposer du logo et des variantes | — | **Critique** | Faible | SVG clair + sombre + mark reçus ; règles d'usage ; autorisation écrite | Direction/Marque |
| **A03** | Collecter les contenus institutionnels | `resources/js/config/*` | Remplacer les contenus fictifs | — | **Critique** | Moyenne | Présentation, services, chiffres, coordonnées, équipe/certifications (ou décision de retrait) reçus | Direction |
| **A04** | Remplir le journal de décisions | `docs/.../06` | Figer le périmètre | — | **Critique** | Faible | Toutes les questions P0 ont une réponse | Direction/IT |
| **A05** | Inventorier la production | Hors code | Connaître URLs, backlinks, GSC | — | **Critique** | Moyenne | Export GSC, crawl, sitemap actuel, analytics, liste des URLs | SEO/IT |
| **A06** | Vérifier le comportement réel | Site local/prod | Confirmer 404, formulaire, thème | — | Haute | Faible | Rapport de vérification (captures, statuts) | Accès site |
| **A07** | Choisir la source de vérité | `config/company.php` ou `config/company.ts` | Éviter la duplication | A04 | **Critique** | Moyenne | Décision documentée (Option A/B/C du doc 01) | Tech/SEO |
| **A08** | Isoler les modifications en cours | Git | Éviter de mélanger skills/docs et migration | A01 | Haute | Faible | Branche dédiée, aucun fichier non lié dans les commits | Git |
| **A09** | Définir la stratégie d'images | `resources/images/`, `public/` | Formats, tailles, nommage | A02, A03 | Moyenne | Faible | Convention documentée (WebP/AVIF, 1200/800/400, alt) | Design/Tech |
| **A10** | Préparer le plan de tests | `tests/` | Savoir quoi vérifier | A04 | Haute | Faible | Liste des pages/parcours/SEO/thèmes à tester | QA |
| **A11** | Sauvegarder la base et les médias | Hors code | Pouvoir restaurer | A01 | **Critique** | Faible | Dump DB + archive médias + procédure de restauration | IT |
| **A12** | Vérifier les accès externes | DNS, SMTP, GSC, réseaux | Ne pas être bloqué en E/G | A05 | Haute | Faible | Liste des accès et propriétaires | IT/Communication |

### Critères de sortie Phase A

- [ ] Tous les P0 du doc 06 sont répondus.
- [ ] Le logo SVG et ses variantes sont dans le dépôt (ou un dossier de travail).
- [ ] Les contenus sont validés ou explicitement marqués « à retirer ».
- [ ] La baseline est sauvegardée (code + DB + médias).
- [ ] Le périmètre des pages est arbitré.
- [ ] La stratégie de source de vérité est choisie.

---

## 4. Phase B — Fondation visuelle

**Objectif :** poser les thèmes, les tokens, le logo et les composants communs. Aucune page métier n'est réécrite ici.

| ID | Tâche | Fichiers / composants | Objectif | Dépend de | Prio | Complexité | Critères d'acceptation | Ressources |
|---|---|---|---|---|---|---|---|---|
| **B01** | Configurer les thèmes daisyUI | `resources/css/app.css` | Deux thèmes JMC | A02, A04 | **Critique** | Moyenne | `jmc-light` et `jmc-dark` définis ; `themes: false` ; build OK | Palette validée |
| **B02** | Définir les tokens sémantiques | `resources/css/app.css` | Couleurs de rôle, base, focus | B01 | **Critique** | Moyenne | `body` en `bg-base-200 text-base-content` ; focus visible ; sélection | Palette |
| **B03** | Créer `BrandLogo.vue` | `Components/common/BrandLogo.vue` | Centraliser le logo | A02 | **Critique** | Moyenne | Variantes clair/sombre, tailles, alt, fallback | Logo SVG |
| **B04** | Migrer le header | `Components/layout/Header.vue` | Logo, nom, CTA, couleurs | B03 | **Critique** | Moyenne | Header clair/sombre ; lien `/` ; CTA correct ; responsive | Logo |
| **B05** | Migrer le footer | `Components/layout/Footer.vue` | Logo sombre, copyright, coordonnées | B03, C01 | **Critique** | Moyenne | Footer lisible ; copyright JMC ; réseaux officiels | Contenus |
| **B06** | Remplacer favicon/manifest/OG | `public/*`, `app.blade.php` | Identité navigateur | A02 | **Critique** | Faible | Favicons JMC ; manifest rempli ; `theme-color` | Assets |
| **B07** | Migrer les boutons | `Components/ui/buttons/*` | Couleurs, focus, états | B01 | Haute | Moyenne | Primaire/secondaire/outline/ghost conformes ; focus AA | Palette |
| **B08** | Migrer les champs | `Components/ui/inputs/*` | Couleurs, erreurs, focus | B01 | Haute | Moyenne | Inputs lisibles clair/sombre ; erreurs contrastées | — |
| **B09** | Migrer les cartes/badges | `Components/ui/cards/*`, `badges/*` | Surfaces, bordures, ombres | B01 | Haute | Moyenne | Cartes sans fond blanc forcé ; badges sémantiques | — |
| **B10** | Migrer les sections communes | `Components/sections/Section.vue`, `CtaSection`, `PageHeader` | Fonds, hero, CTA | B01 | Haute | Moyenne | Fonds `base-*` ; CTA orange ; header de page navy | — |
| **B11** | Migrer la typographie | `Components/ui/typography/*`, `app.css` | Couleurs, graisses | B01 | Haute | Faible | Titres `base-content` ; 700 chargée | Police |
| **B12** | Adapter les layouts auth/erreur | `GuestLayout`, `AuthenticatedLayout`, `ErrorLayout` | Logo et couleurs | B03 | Haute | Moyenne | Pages auth/erreur cohérentes | Logo |
| **B13** | Implémenter le thème sombre | `useTheme.ts`, `Header`, `app.blade.php` | Bascule + persistance | B01, B02 | Haute | Moyenne | Bascule accessible ; persistance ; pas de flash ; système respecté | Décision Q58 |
| **B14** | Corriger la police | `app.blade.php`, `app.css`, `public/fonts` | 700 + auto-hébergement | A04 | Moyenne | Moyenne | 400/500/600/700 disponibles ; `font-display: swap` | Fichiers WOFF2 |
| **B15** | QA visuelle clair/sombre | 4 pages + auth + erreurs | Détecter les régressions | B01–B14 | Haute | Moyenne | Captures desktop/mobile des deux thèmes | Navigateur |
| **B16** | Nettoyer les anciens tokens | `resources/css/app.css` | Supprimer `ccm` | B01–B15 | Haute | Moyenne | Aucun `--color-ccm-*` défini | — |

> **Important :** B16 ne doit être fait qu'après migration des usages, sinon le site casse. L'ordre réel est : définir les nouveaux tokens → migrer les usages → supprimer les anciens.

### Critères de sortie Phase B

- [ ] Le site s'affiche correctement en `jmc-light` et `jmc-dark`.
- [ ] Le logo JMC est utilisé partout (header, footer, hero, auth).
- [ ] Les favicons/manifest sont JMC.
- [ ] Les boutons, champs, cartes et titres sont cohérents.
- [ ] La bascule de thème fonctionne et persiste.
- [ ] Aucun token `ccm` ne subsiste dans le CSS.
- [ ] Aucun composant commun ne dépend d'un fond blanc.

---

## 5. Phase C — Migration éditoriale

**Objectif :** remplacer les contenus, sans toucher à la structure des pages.

| ID | Tâche | Fichiers / composants | Objectif | Dépend de | Prio | Complexité | Critères d'acceptation | Ressources |
|---|---|---|---|---|---|---|---|---|
| **C01** | Centraliser l'identité | `config/company.ts`, `constants/index.ts` | Nom, raison sociale, slogan, description, contacts | A03, A07 | **Critique** | Moyenne | Une seule source ; aucun doublon dans les pages | Contenus validés |
| **C02** | Réécrire l'accueil | `config/home.ts`, `Pages/Public/Home.vue` | Hero, présentation, CTA | C01 | **Critique** | Moyenne | Textes JMC ; chiffres cohérents ; CTA valides | Contenus |
| **C03** | Réécrire À propos | `config/about.ts`, `Pages/Public/About.vue` | Présentation, histoire, mission, valeurs | C01, Q25 | **Critique** | Élevée | Histoire conservée/retirée selon décision ; aucun fait non validé | Direction |
| **C04** | Réécrire les services | `config/services.ts` | Taxonomie unique, descriptions, livrables | Q19, Q20 | **Critique** | Élevée | Une seule liste ; allégations validées | Direction |
| **C05** | Réécrire le contact | `config/contact.ts`, `config/faq.ts` | Coordonnées, FAQ, messages | C01 | **Critique** | Moyenne | Coordonnées officielles ; pas de promesse non tenue | Direction |
| **C06** | Mettre à jour la navigation | `config/navigation.ts` | Liens valides, footer | Q55 | Haute | Faible | Aucun lien mort ; libellés JMC | Décisions |
| **C07** | Traiter équipe/certifications | `config/team.ts`, `config/certifications.ts`, pages | Publier ou masquer | Q16, Q27 | **Critique** | Moyenne | Sections masquées si non validées | Direction |
| **C08** | Traiter projets/news/partenaires | `config/projects.ts`, `news.ts`, `partners.ts` | Réels ou retirés | Q18, Q30, Q17 | Haute | Moyenne | Aucun contenu fictif publié | Direction |
| **C09** | Réécrire les métadonnées éditoriales | `SeoHead` props, pages | Titles/descriptions JMC | C01 | Haute | Moyenne | 4 pages avec title/description uniques | SEO |
| **C10** | Nettoyer les textes codés en dur | `FeaturesSection`, `StatisticsSection`, `TeamSection` | Supprimer CCM | C01 | **Critique** | Faible | Aucun « CCM » dans ces composants | — |
| **C11** | Traduire les pages auth/profil | `Pages/Auth/*`, `Profile/*`, `Dashboard.vue` | Français | Q56 | Moyenne | Moyenne | Libellés FR ; titles FR | Traduction |
| **C12** | Intégrer les pages légales | Nouvelles pages/routes | Mentions + confidentialité | Q61–Q64 | Haute | Moyenne | Contenus validés ; liens footer/formulaire | Juridique |
| **C13** | Revue éditoriale | Tous les textes | Cohérence, ton, fautes | C01–C12 | Haute | Moyenne | Relecture validée ; aucune contradiction | Direction |

### Critères de sortie Phase C

- [ ] Plus aucun contenu CCM non justifié.
- [ ] Les chiffres sont cohérents partout.
- [ ] Les coordonnées sont officielles.
- [ ] Les allégations sont validées ou supprimées.
- [ ] L'équipe/certifications/projets sont publiés uniquement si autorisés.
- [ ] Les métadonnées éditoriales sont JMC.
- [ ] Les pages légales existent si le formulaire est conservé.

---

## 6. Phase D — Adaptation des pages et fonctionnalités

**Objectif :** rendre le parcours public complet, sans lien mort, avec un formulaire fonctionnel.

| ID | Tâche | Fichiers / composants | Objectif | Dépend de | Prio | Complexité | Critères d'acceptation | Ressources |
|---|---|---|---|---|---|---|---|---|
| **D01** | Adapter l'accueil | `Home.vue`, sections | Hero, preuves, CTA | B, C02 | **Critique** | Moyenne | Aucun 404 ; images réelles ; responsive | Assets |
| **D02** | Adapter À propos | `About.vue` | Sections validées | B, C03 | Haute | Moyenne | Sections conditionnelles ; JSON-LD | Contenus |
| **D03** | Adapter Services | `Services.vue`, `ServiceCard.vue` | Liste, liens, ancres | B, C04 | **Critique** | Moyenne | Ancres valides ; CTA corrects | Contenus |
| **D04** | Implémenter le détail service `[C]` | Nouvelle page `Public/ServiceDetail.vue`, route | Contenu par slug | D03, Q21 | Haute | Élevée | Une page par slug ; 404 si slug inconnu ; SEO | Contenus |
| **D05** | Implémenter le formulaire `[C]` | `ContactForm.vue`, `ContactController`, `ContactRequest`, Mailable, route | Recevoir les messages | Q51, Q52 | **Critique** | Élevée | POST validé ; rate limit ; e-mail reçu ; succès/erreur | SMTP |
| **D06** | Finaliser Contact | `Contact.vue`, `ContactCard`, `GoogleMapPlaceholder` | Coordonnées, carte, sujet | C05, D05 | Haute | Moyenne | `?subject=` préremplit ; carte/lien Maps | Décisions |
| **D07** | Corriger liens et ancres | `navigation.ts`, sections, pages | Zéro 404 | C06 | **Critique** | Moyenne | Crawl interne sans 404 ; ancres existantes | — |
| **D08** | Traiter les pages manquantes | Routes/pages ou retrait | Réalisations, carrières, actualités, devis | Q55 | **Critique** | Moyenne | Décision appliquée ; aucun lien mort | Direction |
| **D09** | Brancher les pages d'erreur | `bootstrap/app.php`, `Errors/*` | 404/403/500 brandées | B12 | Moyenne | Moyenne | Statuts corrects ; navigation | — |
| **D10** | Adapter/fermer l'espace client `[C]` | Routes auth, `Dashboard`, `Profile` | Sécurité/produit | Q56 | Haute | Moyenne | Inscription fermée ou accès restreint | Décision |
| **D11** | Finaliser footer | `Footer.vue` | Coordonnées, liens, copyright | B05, C01 | Haute | Faible | Aucun lien mort ; mentions légales | Contenus |
| **D12** | QA responsive | Toutes les pages | Mobile/tablette/desktop | D01–D11 | Haute | Moyenne | 375/768/1024/1440 sans débordement | Navigateur |

### Critères de sortie Phase D

- [ ] Toutes les pages publiques sont accessibles et brandées.
- [ ] Aucun lien interne ne renvoie 404.
- [ ] Le formulaire de contact fonctionne de bout en bout (si retenu).
- [ ] Les pages d'erreur sont branchées.
- [ ] L'espace client est fermé ou réellement fonctionnel.
- [ ] Le rendu responsive est validé.

---

## 7. Phase E — SEO et intégrations

**Objectif :** préserver et améliorer la visibilité, mettre à jour les intégrations.

| ID | Tâche | Fichiers / composants | Objectif | Dépend de | Prio | Complexité | Critères d'acceptation | Ressources |
|---|---|---|---|---|---|---|---|---|
| **E01** | Choisir la stratégie métadonnées | `app.blade.php`, `SeoHead`, routes | SEO serveur fiable | A07, D | **Critique** | Élevée | Décision SSR vs props serveur vs package ; documentée | IT |
| **E02** | Centraliser les métadonnées | Nouveau `config/seo` ou props | Titles/descriptions/canonicals | E01, C09 | **Critique** | Moyenne | Source unique ; canonicals absolus | SEO |
| **E03** | Ajouter OG/Twitter | `SeoHead`, `app.blade.php` | Aperçus sociaux | B06, C09 | Haute | Faible | `og:image`, `og:site_name`, `og:locale`, Twitter image | Asset OG |
| **E04** | Refaire le JSON-LD | Layout/pages | Données structurées propres | E01, C01 | Haute | Moyenne | `Organization` + `WebSite` + `BreadcrumbList` ; `logo` absolu ; pas de doublon | SEO |
| **E05** | Créer le sitemap | Commande/route, `public/` | Indexation | D07 | Haute | Moyenne | Sitemap XML valide ; URLs publiques uniquement | Routes |
| **E06** | Mettre à jour robots.txt | `public/robots.txt` | Crawl propre | E05 | Haute | Faible | Sitemap référencé ; pages internes bloquées | — |
| **E07** | Redirections | `routes/web.php` ou serveur | Préserver le SEO | A05, D08 | **Critique** | Élevée | Table de redirection 301 testée ; aucune chaîne | SEO/IT |
| **E08** | Configurer e-mail/SMTP | `config/mail.php`, `.env`, DNS | Formulaire + notifications | D05, Q70 | **Critique** | Moyenne | Envoi testé ; SPF/DKIM/DMARC ; `from` officiel | IT |
| **E09** | Mettre à jour les réseaux | `company.ts` | Liens officiels | Q37 | Haute | Faible | Liens valides ; icônes cohérentes | Communication |
| **E10** | Analytics + consentement `[C]` | Layout, config | Mesure | Q65, Q74 | Basse | Moyenne | Outil choisi ; consentement si requis | Marketing |
| **E11** | Soumettre sitemap/GSC | Hors code | Indexation | G03 | Haute | Faible | Sitemap soumis ; propriétés vérifiées | SEO |
| **E12** | Crawl final | Site | Zéro 404/500 | D07, E05 | **Critique** | Faible | Rapport de crawl propre | SEO |

### Critères de sortie Phase E

- [ ] Titles/descriptions/canonicals absolus et uniques.
- [ ] OG/Twitter complets.
- [ ] JSON-LD serveur, sans doublon, avec logo.
- [ ] Sitemap + robots corrects.
- [ ] Redirections testées.
- [ ] E-mails fonctionnels et délivrables.
- [ ] Réseaux officiels.
- [ ] Aucune métadonnée CCM.

---

## 8. Phase F — Qualité et validation

**Objectif :** prouver que la migration est complète et sans régression.

| ID | Tâche | Fichiers / outil | Objectif | Dépend de | Prio | Complexité | Critères d'acceptation | Ressources |
|---|---|---|---|---|---|---|---|---|
| **F01** | Scan résiduel CCM | `grep`, bundles | Zéro trace | B–E | **Critique** | Faible | Aucun `ccm` non justifié dans sources/bundles | — |
| **F02** | Tests des pages publiques | `tests/Feature/PublicPagesTest.php` | Non-régression | D | **Critique** | Moyenne | 4 pages 200 ; titres JMC ; absence CCM | Pest |
| **F03** | Tests du formulaire | `tests/Feature/ContactTest.php` | Validation/envoi | D05 | **Critique** | Moyenne | Cas valide/invalide/rate limit | Pest |
| **F04** | Tests auth/profil | `tests/Feature/Auth/*` | Non-régression | D10 | Haute | Faible | Suite Breeze verte | Pest |
| **F05** | Tests responsive | Navigateur | 375→1440 | D12 | Haute | Moyenne | Aucun débordement ; menu OK | Navigateur |
| **F06** | Tests thèmes | Navigateur | Clair/sombre | B15 | Haute | Moyenne | Contrastes ; logo ; focus | — |
| **F07** | Audit accessibilité | Lighthouse/axe | AA | B–D | Haute | Moyenne | Pas d'erreur critique ; contrastes OK | Outil |
| **F08** | Audit performance | Lighthouse | Pas de régression | B–D | Haute | Moyenne | LCP/CLS corrects ; images optimisées | Outil |
| **F09** | Revue sécurité | Config/routes | Pas de faille introduite | D05, D10 | Haute | Moyenne | Debug off ; CSRF ; rate limit ; cookies | — |
| **F10** | Revue légale/contenu | Pages | Conformité | C12 | **Critique** | Moyenne | Mentions/confidentialité validées | Juridique |
| **F11** | Tests navigateurs | Chrome/Firefox/Safari | Compatibilité | D12 | Moyenne | Moyenne | Rendu et formulaires OK | Navigateurs |
| **F12** | Pint + build + tests | `vendor/bin/pint`, `npm run build`, `php artisan test` | Qualité | Toutes | **Critique** | Faible | Tout passe ; aucun warning bloquant | CI locale |

### Critères de sortie Phase F

- [ ] Tous les tests passent.
- [ ] `npm run build` passe.
- [ ] `php artisan test` passe.
- [ ] `vendor/bin/pint --dirty --format agent` passe.
- [ ] Aucun CCM résiduel.
- [ ] A11y et performance validées.
- [ ] Formulaire et auth testés.
- [ ] Contenus légaux validés.

---

## 9. Phase G — Mise en production

**Objectif :** déployer sans perte de données ni de SEO, avec retour arrière possible.

| ID | Tâche | Fichiers / infra | Objectif | Dépend de | Prio | Complexité | Critères d'acceptation | Ressources |
|---|---|---|---|---|---|---|---|---|
| **G01** | Sauvegarde pré-déploiement | DB, médias, code | Retour arrière | F | **Critique** | Faible | Sauvegarde vérifiée et restaurable | IT |
| **G02** | Préparer la release | Build, caches | Artefacts propres | G01 | **Critique** | Moyenne | `npm run build` ; pas de `hot` ; caches purgés | CI |
| **G03** | Déployer | Infra | Mise en ligne | G02 | **Critique** | Moyenne | Site accessible ; assets chargés | IT |
| **G04** | Smoke tests | Site | Vérifier l'essentiel | G03 | **Critique** | Faible | 4 pages 200 ; formulaire ; thème ; liens | QA |
| **G05** | SEO post-déploiement | GSC/Bing | Indexation | G03 | Haute | Faible | Sitemap soumis ; canonicals ; OG | SEO |
| **G06** | Vérifier redirections/monitoring | Serveur | Pas de 404 de masse | G03, E07 | **Critique** | Moyenne | Aucune 404 interne ; logs propres | IT |
| **G07** | Plan de rollback | Infra | Réagir vite | G01 | **Critique** | Faible | Procédure écrite et testée | IT |
| **G08** | Surveillance 30 jours | GSC/analytics/logs | Détecter les régressions | G03 | Haute | Moyenne | Rapport hebdomadaire | SEO/IT |
| **G09** | Nettoyage final `[C]` | Assets/dépendances | Retirer l'ancien | G08 | Basse | Moyenne | Anciens logos supprimés après grâce ; deps inutiles retirées | Validation |
| **G10** | Mettre à jour la documentation | `README`, `docs/` | Transmission | G03 | Moyenne | Faible | Documentation à jour | Tech |

### Plan de rollback

1. Conserver l'artefact de la release précédente et la sauvegarde DB.
2. En cas d'échec critique (site indisponible, formulaire cassé, SEO massif), restaurer l'artefact précédent.
3. Restaurer la DB uniquement si une migration de données a eu lieu (ce n'est pas prévu ici).
4. Purger les caches et vérifier les assets.
5. Conserver les redirections actives même en rollback.
6. Communiquer l'incident et la nouvelle tentative.

**Critère de rollback :** retour au site CCM fonctionnel en moins de 30 minutes, sans perte de données.

---

## 10. Tâches conditionnelles

| Tâche | Condition | Si non réalisée |
|---|---|---|
| D04 — Détail service | Q21 = oui et contenus validés | Supprimer les liens « En savoir plus » et la route |
| D05 — Formulaire | Q51 = oui | Remplacer par `mailto:`/téléphone et retirer le formulaire |
| D08 — Pages manquantes | Q55 = oui | Retirer les liens de navigation/CTA |
| D10 — Espace client | Q56 = conserver | Fermer l'inscription, masquer le dashboard |
| C12 — Pages légales | Formulaire conservé | Requis ; ne pas reporter |
| E10 — Analytics | Q74 = oui | Aucun outil |
| G09 — Nettoyage assets | Après 30 jours | Conserver les anciens assets |

---

## 11. Matrice de dépendances détaillée

| Tâche | Dépend de | Débloque |
|---|---|---|
| A02 | — | B03, B06, B15 |
| A03 | — | C01–C08, D |
| A04 | — | B01, C, D, E |
| A05 | — | E07 |
| B01 | A02, A04 | B02, B07–B14 |
| B03 | A02 | B04, B05, B12 |
| B05 | B03, C01 | D11 |
| C01 | A03, A07 | C02–C10, E02, E04 |
| C04 | Q19, Q20 | D03, D04 |
| D03 | B, C04 | D04, D07 |
| D05 | Q51, Q52 | F03, E08 |
| D07 | C06 | E05, E12 |
| E01 | A07, D | E02, E04 |
| E05 | D07 | E06, E11 |
| E08 | D05 | G04 |
| F | B–E | G |
| G | F | — |

---

## 12. Répartition recommandée des commits

| Commit | Contenu |
|---|---|
| `chore(rebrand): baseline et documentation` | Docs, tag, branche (déjà fait) |
| `feat(design): thèmes et tokens JMC` | B01–B02 |
| `feat(brand): logo et favicons` | B03, B06 |
| `refactor(layout): header/footer JMC` | B04–B05 |
| `refactor(ui): composants sémantiques` | B07–B12 |
| `feat(theme): mode sombre` | B13 |
| `content: identité et pages JMC` | C01–C10 |
| `feat(contact): formulaire fonctionnel` | D05 |
| `fix(nav): liens et ancres` | D07–D08 |
| `feat(seo): métadonnées, sitemap, JSON-LD` | E02–E06 |
| `chore(mail): SMTP et délivrabilité` | E08 |
| `test: pages publiques et formulaire` | F02–F03 |
| `chore(release): build et déploiement` | G |

---

## 13. Définition de « terminé » (DoD) globale

Une tâche est terminée lorsque :

- [ ] Le code compile (`npm run build`, `vue-tsc`).
- [ ] Les tests concernés passent.
- [ ] Le rendu est vérifié en clair et sombre.
- [ ] Le rendu est vérifié à 375 px et 1280 px.
- [ ] Aucun texte CCM non justifié n'est introduit.
- [ ] Les liens ajoutés/modifiés ne renvoient pas 404.
- [ ] Les contrastes respectent AA.
- [ ] Le code respecte les conventions existantes (Pint, ESLint, Prettier).
- [ ] La documentation liée est mise à jour.
- [ ] Le commit est atomique et décrit.

---

## 14. Estimation globale

| Dimension | Évaluation |
|---|---|
| **Complexité globale** | **Moyenne à élevée** |
| Part mécanique (tokens, liens, textes) | ~50 % |
| Part dépendante de décisions externes | ~30 % |
| Part technique nouvelle (formulaire, SEO serveur, thème sombre) | ~20 % |
| Risque principal | Absence d'assets/contenus, pas le code |
| Chemin critique | Logo + contenus + décisions + SEO production |
| Effort indicatif | 21–38 jours-homme selon le périmètre retenu |

> L'estimation est indicative et inclut la coordination, les allers-retours éditoriaux et les tests. Elle exclut la création du logo et la production photographique.

---

## 15. Risques et mitigations

| Risque | P | I | Mitigation | Responsable |
|---|---|---|---|---|
| Logo absent/incomplet | Élevée | Critique | Bloquer B ; ne pas dessiner | Direction |
| Contenus non fournis | Élevée | Critique | Retirer/masquer les sections non validées | Direction |
| Perte SEO au changement | Moyenne | Élevé | A05, E07, G05, G08 | SEO |
| Formulaire non conforme | Moyenne | Élevé | Validation, consentement, confidentialité | Juridique/IT |
| Thème sombre illisible | Moyenne | Moyen | Table de contrastes, QA | Frontend |
| Oubli de CCM dans les bundles | Moyenne | Moyen | F01, rebuild, purge CDN | Frontend |
| Mélange avec les commits skills | Faible | Moyen | A01, A08 | Tech |
| Pages manquantes laissées en 404 | Élevée | Élevé | D07, D08 | Produit |
| E-mail en spam | Moyenne | Élevé | SPF/DKIM/DMARC, test | IT |
| Rollback impossible | Faible | Critique | G01, G07 | IT |

---

## 16. Critères d'acceptation finaux du projet

- [ ] Le site affiche l'identité JMC sur toutes les pages publiques.
- [ ] Aucune référence CCM non justifiée.
- [ ] Aucun lien interne mort.
- [ ] Le formulaire fonctionne et les e-mails arrivent.
- [ ] Les thèmes clair et sombre sont conformes.
- [ ] Les métadonnées et le JSON-LD sont serveur et à jour.
- [ ] Le sitemap et les redirections sont en place.
- [ ] Les tests passent.
- [ ] L'accessibilité et la performance sont validées.
- [ ] La sauvegarde et le rollback sont prêts.
- [ ] La direction a validé les contenus et les pages légales.
