# 05 — Audit SEO et intégrations

**Objet :** évaluer le référencement actuel, les métadonnées, les URLs, la présence numérique et les intégrations externes, puis définir une stratégie de transition sans perte de visibilité.

> **Limite majeure :** le domaine de production, l'historique d'URLs, les backlinks, Search Console, Analytics et le site CCM public ne sont pas accessibles depuis le dépôt. Les constats ci-dessous portent sur le code et les fichiers locaux. Les actions externes sont marquées ⚠.

---

## 1. Synthèse SEO

| Élément | État vérifié | Verdict |
|---|---|---|
| `<title>` par page | Présent via `SeoHead.vue` | ◐ Fonctionnel mais risque de double suffixe |
| Meta description | Présente sur les 4 pages | ✅ Mais contient CCM |
| Canonical | Présent, **relatif** (`/`, `/a-propos`…) | ⚠ À rendre absolu |
| Open Graph | Titre, description, type, URL | ⚠ Pas d'image, pas de site_name/locale |
| Twitter Cards | `summary_large_image` | ⚠ Aucune image |
| Données structurées | 4 blocs JSON-LD injectés côté client | ⚠ Non fiables pour les crawlers |
| Sitemap | **Absent** | ❌ |
| `robots.txt` | Minimal, sans sitemap | ⚠ |
| Favicon | Ancien logo CCM | ❌ |
| Manifest | Nom vide, couleurs blanches, icônes CCM | ❌ |
| Pages d'erreur | Non branchées | ⚠ |
| URLs | Propres, en français, stables | ✅ À préserver |
| Hiérarchie Hn | Globalement correcte | ◐ Quelques écarts |
| Analytics | Aucun outil | ⚠ Décision |
| Search Console | Non vérifiable | ⚠ |
| Domaine | Inconnu (`ccmsarl.cd` suggéré par l'e-mail) | ⚠ |

**Conclusion :** le SEO est **artisanal et fragile**, pas catastrophique. Les URLs sont bonnes, les titles/descriptions existent, mais tout repose sur du rendu client, sans sitemap ni métadonnées serveur. Le changement de nom est l'occasion de corriger ces fondations.

---

## 2. Audit page par page

### 2.1 Accueil `/`

| Élément | Valeur actuelle | Problème |
|---|---|---|
| Title | `Accueil — CCM SARL` (via `SeoHead` + `APP_NAME`) | Ancien nom ; double suffixe probable |
| Description | `COMPANY.description` (« Entreprise congolaise de référence… ») | CCM, promesse non validée |
| Canonical | `/` | Relatif |
| OG title | Idem title | Ancien nom |
| OG description | Idem description | Ancien nom |
| OG image | **Absent** | Pas d'aperçu social |
| OG URL | `/` | Relatif |
| Twitter | `summary_large_image` sans image | Incohérent |
| H1 | Titre du hero | ✅ Un seul H1 |
| H2 | Sections | ✅ |
| JSON-LD | `Organization` avec `legalName` CCM, `alternateName`, `url: "/"`, `sameAs` réseaux | Ancien nom, URL relative, injecté client |

### 2.2 À propos `/a-propos`

| Élément | Valeur | Problème |
|---|---|---|
| Title | `À propos — CCM SARL` | Ancien nom |
| Description | `COMPANY.description` | Générique + CCM |
| Canonical | `/a-propos` | Relatif |
| OG image | Absent | — |
| H1 | `ABOUT_HERO.title` = « À propos de CCM SARL » | Ancien nom en H1 |
| JSON-LD | `AboutPage` + `Organization` CCM | Ancien nom |
| Contenu | Histoire, équipe, certifications | Risque E-E-A-T si non vérifié |

### 2.3 Services `/services`

| Élément | Valeur | Problème |
|---|---|---|
| Title | `Services — CCM SARL` | Ancien nom |
| Description | « Découvrez tous les services de CCM SARL… » | Ancien nom |
| Canonical | `/services` | Relatif |
| OG image | Absent | — |
| H1 | « Nos services » | ✅ |
| JSON-LD | `CollectionPage` + `ItemList` de 12 `Service` | Ancien nom, descriptions non validées |
| URL `/services/{slug}` | Rend le même contenu, canonical `/services` | Duplication potentielle, aucune page détail |
| Contenu | 12 services, allégations | Risque juridique/SEO |

### 2.4 Contact `/contact`

| Élément | Valeur | Problème |
|---|---|---|
| Title | `Contact — CCM SARL` | Ancien nom |
| Description | « Contactez CCM SARL… Demandez un devis gratuit. » | Ancien nom + promesse de devis |
| Canonical | `/contact` | Relatif |
| OG image | Absent | — |
| H1 | « Contactez-nous » | ✅ |
| JSON-LD | `ContactPage` + `Organization` (téléphone, email, adresse) | Données probablement fictives |
| H3 | Cartes d'information sous H1 | Hiérarchie H2 manquante |

### 2.5 Pages d'erreur

- ❌ Les composants `Errors/*` ne sont pas branchés.
- ⚠ En production, un 404 peut renvoyer la page Laravel par défaut, sans navigation de marque.
- ➜ Configurer les exceptions Inertia et vérifier les statuts HTTP.

### 2.6 Pages internes

- `/login`, `/register`, `/dashboard`, `/profile` : titles anglais, non indexés ? Aucun `noindex` explicite.
- ⚠ Les pages d'authentification ne devraient pas être indexées. Ajouter `noindex, nofollow` sur ces pages ou `robots.txt` ciblé.
- ⚠ L'inscription publique peut générer du contenu utilisateur/spam.

---

## 3. Problèmes techniques détaillés

### 3.1 Métadonnées générées côté client

✅ `SeoHead.vue` utilise `<Head>` d'Inertia. Les balises sont injectées après hydratation.
✅ Aucun `@inertiaHead` n'est alimenté côté serveur en dehors du title initial.
◐ Google sait exécuter JavaScript, mais :
- les crawlers sociaux (Facebook, LinkedIn, WhatsApp) ne le font généralement pas ;
- les aperçus peuvent être vides ou utiliser le title Blade ;
- les données structurées ne sont pas garanties ;
- le temps de rendu peut retarder l'indexation.

➜ **Options :**
1. **Activer le SSR Inertia** (le build existe déjà) et servir les pages rendues.
2. **Passer les métadonnées par des props serveur** et les rendre dans `app.blade.php` via `@inertiaHead`.
3. **Utiliser `ralphjsmit/laravel-seo`** côté serveur (déjà installé, non configuré).

**Recommandation :** option 2 ou 3 pour un site institutionnel, car elle ne dépend pas d'un runtime Node en production. L'option 1 est valable si l'infrastructure supporte Node.

### 3.2 Double suffixe de title (risque)

✅ `app.ts:10` et `ssr.ts:9` définissent :

```ts
title: (title) => `${title} — ${appName}`
```

✅ `SeoHead.vue` définit déjà `pageTitle = `${title} — ${APP_NAME}`` puis `<title>{{ pageTitle }}</title>`.

◐ Selon le comportement d'Inertia, le titre peut devenir :

```text
Accueil — CCM SARL — CCM SARL
```

➜ **À vérifier dans le navigateur** et corriger en supprimant l'un des deux suffixes. C'est un défaut SEO classique et visible.

### 3.3 Canonicals relatifs

✅ Les pages passent `ROUTE_HOME = '/'`, `ROUTE_ABOUT = '/a-propos'`, etc.
⚠ Un canonical relatif est interprété par rapport à l'URL courante, mais les moteurs recommandent une URL absolue. De plus, `og:url` **doit** être absolu.
➜ Générer `url()->current()` ou `config('app.url') . route(...)` côté serveur, ou une constante `SITE_URL` côté frontend.

### 3.4 JSON-LD

| Problème | Détail | Impact |
|---|---|---|
| Injecté dans `onMounted` | Ajout d'un `<script>` à chaque montage | Doublons après navigation SPA |
| Aucun nettoyage | Les scripts précédents restent dans `<head>` | Données contradictoires |
| URLs relatives | `url: '/'`, `url: '/a-propos'` | Invalides pour Schema.org |
| Ancien nom | `legalName`, `name`, descriptions | Identité incorrecte |
| Pas de `logo` | Aucun champ `logo` | Opportunité manquée |
| Pas de `BreadcrumbList` | Fil d'Ariane visuel mais non structuré | Opportunité |
| Pas de `LocalBusiness` | `Organization` seul | Selon les besoins locaux |
| `sameAs` inclut WhatsApp | `wa.me` n'est pas un profil | Acceptable mais à revoir |
| `areaServed: 'CD'` | Code pays | Correct |
| `availableLanguage: 'French'` | Chaîne | Devrait être `["fr"]` |

➜ **Recommandation :** un seul bloc JSON-LD `Organization` + `WebSite` au niveau du layout, généré côté serveur, avec `@id` stables, puis des blocs spécifiques par page (`AboutPage`, `ContactPage`, `CollectionPage`, `Service`, `BreadcrumbList`). Ne jamais injecter via `onMounted`.

### 3.5 Sitemap

❌ Aucun `public/sitemap.xml`, aucune route, aucune commande.
✅ `spatie/laravel-sitemap` 8.2.0 est installé.
✅ `spatie/laravel-sitemap` n'apparaît ni dans `routes/console.php` ni dans un contrôleur.
➜ Créer une commande planifiée ou une route `/sitemap.xml`, inclure uniquement les URLs publiques indexables (pas auth/profile/dashboard), avec `lastmod` et priorités raisonnables.

### 3.6 Robots

✅ `public/robots.txt` :

```text
User-agent: *
Disallow:
```

**Problèmes :**
- Aucun `Sitemap:`.
- Aucun `Host`.
- Autorise l'indexation de `/login`, `/register`, `/dashboard`, `/profile`.
- Aucune distinction staging/production.

➜ Cible :

```text
User-agent: *
Disallow: /dashboard
Disallow: /profile
Disallow: /login
Disallow: /register
Disallow: /forgot-password
Disallow: /reset-password
Disallow: /confirm-password
Disallow: /verify-email

Sitemap: https://[domaine]/sitemap.xml
```

⚠ Ne pas bloquer `/` ou `/services`.

### 3.7 Favicon et manifest

- Favicon CCM.
- `site.webmanifest` : `name` et `short_name` vides.
- `theme_color` et `background_color` blancs.
- Pas de `theme-color` dans le `<head>`.
- Pas d'icône maskable.
➜ Remplacer par les assets JMC (doc 04).

### 3.8 Pages d'erreur et statuts HTTP

- ❌ Composants non branchés.
- ⚠ Vérifier que les 404 renvoient bien un statut 404 (pas 200).
- ⚠ Vérifier que les redirections renvoient 301/308, pas 302.

### 3.9 Duplication `/services/{slug}`

✅ Chaque slug rend la même page, avec le même canonical `/services`.
◐ Si les liens sont suivis, Google peut crawler 12 URLs identiques. Le canonical limite la duplication, mais ces URLs n'ont aucun contenu unique.
➜ Soit implémenter de vraies pages, soit supprimer la route et les liens.

### 3.10 Ancres et liens internes

- Liens morts → mauvaise expérience et gaspillage de crawl.
- Ancres footer sans cible → aucun bénéfice.
- `?subject=` ignoré → duplication d'URL potentielle (`/contact?subject=x`), canonical `/contact` heureusement présent.

### 3.11 Hiérarchie des titres

| Page | H1 | H2 | H3 | Verdict |
|---|---|---|---|---|
| Accueil | Hero | Sections | Sous-sections | ✅ |
| À propos | PageHeader | Sections | Cartes | ✅ |
| Services | PageHeader | Sections | Cartes | ✅ |
| Contact | PageHeader | Sections | Cartes d'info | ⚠ H3 sous H1 sans H2 |
| Auth | — | — | — | ⚠ Pas de H1 explicite |
| Erreurs | H1 | — | — | ✅ |

### 3.12 Images et SEO

- 45 placeholders, aucun `alt` de marque exploitable.
- Les noms de fichiers `logo.png` / `logo-full.png` sont génériques.
- Aucun `og:image`.
- Pas de `ImageObject` dans le JSON-LD.
- Les images de contenu n'ont pas de texte alternatif descriptif au-delà du titre.
➜ Utiliser des noms de fichiers descriptifs (`chantier-kinshasa-2025.webp`), des `alt` utiles, et une image OG par page clé.

---

## 4. Identité numérique

### 4.1 Ancien nom dans les métadonnées

| Emplacement | Occurrence |
|---|---|
| `APP_NAME` frontend | `CCM SARL` |
| Titres `SeoHead` | Suffixe CCM |
| Descriptions | CCM |
| JSON-LD | `legalName`, `name`, descriptions |
| `alt` des logos | CCM |
| Favicon/manifest | Visuel CCM |
| README | CCM |

### 4.2 Anciennes coordonnées

- `info@ccmsarl.cd`
- `+243 81 234 5678`
- Adresse « Avenue de la Libération, n° 15 »
- Réseaux `ccmsarl`
- Domaine probable `ccmsarl.cd` (déduit de l'e-mail, ⚠ non confirmé)

### 4.3 Conséquences

- Les moteurs peuvent associer le site à l'ancienne entité.
- Les aperçus sociaux afficheront l'ancien nom.
- Les utilisateurs peuvent douter de la légitimité du changement.
- Les backlinks pointent vers d'anciennes pages/ancien nom.

➜ Une **communication de transition** est nécessaire (bandeau ou page « JMC, anciennement CCM ») **uniquement si la continuité est confirmée**.

---

## 5. Stratégie de transition

### 5.1 Nom commercial vs nom de domaine

| Concept | Action |
|---|---|
| **Changement de nom commercial** | Mise à jour du site, des métadonnées, des réseaux, de Google Business Profile. **Ne nécessite pas** l'outil « Change of Address » de Search Console. |
| **Changement de nom de domaine** | Nécessite 301, vérification des deux propriétés, « Change of Address », conservation de l'ancien domaine, mise à jour des backlinks. |

➜ **Recommandation : conserver le domaine actuel** sauf raison stratégique majeure. Le changement de nom ne justifie pas un changement de domaine. Si le domaine contient « ccm », il peut rester techniquement valide ; un nouveau domaine serait un projet séparé avec un plan de redirection dédié.

### 5.2 Conservation des URLs

✅ Les URLs actuelles sont propres :

```text
/
/a-propos
/services
/services/{slug}
/contact
```

➜ **Les conserver.** Aucun gain SEO à renommer `/a-propos` ou `/services`. Si un renommage est décidé :

| Ancienne URL | Nouvelle URL | Redirection |
|---|---|---|
| `/a-propos` | `/a-propos` (conservée) | — |
| `/services` | `/services` (conservée) | — |
| `/contact` | `/contact` (conservée) | — |
| Anciennes URLs CCM inconnues | À mapper | 301 page à page |

### 5.3 Redirections

**À faire :**
- Inventorier les URLs indexées avant migration (Search Console, crawl, sitemap existant, analytics).
- Créer une table de redirection `ancienne → nouvelle` si des URLs changent.
- Rediriger page à page, jamais tout vers `/`.
- Utiliser 301 (permanent) pour les changements définitifs.
- Tester les chaînes de redirection (pas de 301 → 301 → 200).
- Conserver les anciennes URLs actives au moins 12 mois.

**À ne pas faire :**
- Rediriger `/` vers `/`.
- Supprimer une page sans redirection.
- Utiliser une redirection JavaScript ou meta refresh.
- Rediriger les assets (sauf si renommés).

### 5.4 Sitemap et robots

1. Générer `sitemap.xml` avec les URLs publiques.
2. Ajouter `Sitemap:` dans `robots.txt`.
3. Soumettre dans Search Console et Bing Webmaster Tools.
4. Vérifier l'absence d'URLs internes/auth.
5. Mettre à jour à chaque ajout de page.

### 5.5 Search Console / Bing / outils

| Action | Quand | Responsable |
|---|---|---|
| Vérifier la propriété du domaine (DNS ou HTML) | Avant migration | ⚠ Responsable technique |
| Exporter les performances 16 mois | Avant migration | ⚠ SEO |
| Exporter les pages indexées | Avant migration | ⚠ SEO |
| Crawler le site (Screaming Frog ou équivalent) | Avant migration | ⚠ SEO |
| Soumettre le nouveau sitemap | Après déploiement | ⚠ SEO |
| Inspecter les URLs clés | Après déploiement | ⚠ SEO |
| Surveiller les erreurs 404/500 | 30 jours après | ⚠ SEO |
| Mettre à jour Google Business Profile (nom, site, photos) | Après validation légale | ⚠ Direction |
| Mettre à jour les profils sociaux (nom, URL, logo, description) | Après validation | ⚠ Communication |
| Mettre à jour les annuaires/backlinks | 30–90 jours | ⚠ Communication |

### 5.6 Faut-il utiliser `alternateName: CCM SARL` ?

**Seulement si :**
- JMC est la même entité juridique que CCM (changement de nom) ;
- la direction confirme la continuité ;
- le nom historique est utile à la transition.

**Sinon :** ne pas l'inclure. Un `alternateName` erroné peut entretenir la confusion.

### 5.7 Backlinks

- Conserver le domaine = conservation naturelle des backlinks.
- Si des pages changent, rediriger.
- Contacter les partenaires pour mettre à jour le nom, sans exiger un changement d'URL.
- Ne pas acheter de backlinks, ne pas générer de pages doorway.

---

## 6. Intégrations et éléments opérationnels

### 6.1 Inventaire

| Intégration | État vérifié | Identité CCM ? | Action |
|---|---|---|---|
| E-mail public `info@ccmsarl.cd` | Affiché sur Contact/Footer/JSON-LD | **Oui** | Nouvelle adresse officielle |
| Téléphone `+243 81 234 5678` | Affiché sur Contact/Footer/CTA/FAQ | **Oui** | Nouveau numéro officiel |
| WhatsApp `wa.me/243812345678` | Lien social + icône | **Oui** | Nouveau numéro |
| Facebook `facebook.com/ccmsarl` | Footer/Contact | **Oui** | Nouveau compte ou conservation validée |
| LinkedIn `linkedin.com/company/ccmsarl` | Footer/Contact | **Oui** | Idem |
| YouTube `youtube.com/@ccmsarl` | Footer/Contact | **Oui** | Idem |
| Google Maps | **Aucun** ; placeholder | — | Décider intégration |
| Formulaire de contact | **Aucun backend** | — | Implémenter ou retirer |
| SMTP / mailer | `MAIL_MAILER=log`, `MAIL_FROM_ADDRESS=hello@example.com` | Non | Configurer la production |
| Stockage | `local` (privé), pas de `public/storage` | Non | Configurer si médias |
| APIs externes | Aucune | — | — |
| Analytics | Aucun | — | Décider (Matomo/Plausible/GA4) |
| Cookies / consentement | Aucun | — | Requis si analytics/maps |
| Documents téléchargeables | Aucun | — | — |
| Polices | Bunny Fonts (externe) | Non | Auto-héberger |
| Images | `placehold.co` (externe) | Partiellement (textes CCM) | Remplacer par assets locaux |
| Schema.org | Contexte externe (pas un appel réseau) | — | RAS |
| Backups | `spatie/laravel-backup` installé, non planifié | — | Décider |
| PDF | `spatie/laravel-pdf` installé, non utilisé | — | Retirer ou prévoir |
| Média library | Installé, non utilisé | — | Retirer ou prévoir |
| Permissions | Installé, non utilisé | — | Retirer ou prévoir |
| Activity log | Installé, non utilisé | — | Retirer ou prévoir |

### 6.2 Formulaire de contact — intégration cible

Si la décision est d'implémenter :

1. Route `POST /contact` nommée `contact.store`.
2. `ContactRequest` avec validation serveur.
3. Rate limiting (`throttle:5,1` ou équivalent).
4. Honeypot ou captcha discret.
5. Mailable vers l'adresse officielle, avec `replyTo` de l'expéditeur.
6. Accusé de réception optionnel.
7. Message de succès via flash Inertia.
8. Gestion des erreurs.
9. Lien vers la politique de confidentialité.
10. Journalisation sans données sensibles.
11. Configuration SMTP de production (SPF/DKIM/DMARC).

**Ne pas** envoyer d'e-mail sans validation serveur. **Ne pas** stocker le message en base sans politique de rétention.

### 6.3 Google Maps

Options :

| Option | Avantages | Inconvénients |
|---|---|---|
| Iframe Google Maps | Simple | Cookies tiers, consentement, performance |
| Lien « Ouvrir dans Maps » | Léger, sans cookie | Moins visuel |
| Carte statique | Léger, contrôlé | Nécessite une image à jour |
| Aucune carte | Plus simple | Moins pratique |

➜ **Recommandation :** lien « Ouvrir dans Google Maps » + adresse texte, sauf besoin commercial fort. Si iframe, charger uniquement après consentement.

### 6.4 Analytics

Aucun outil actuellement. Recommandation :

- **Matomo** ou **Plausible** (auto-hébergé ou SaaS léger) pour un site institutionnel ;
- ou GA4 si l'équipe marketing le maîtrise ;
- consentement si cookies non essentiels ;
- ne pas installer avant d'avoir validé la politique de confidentialité.

### 6.5 E-mail et délivrabilité

⚠ Points à vérifier en production :

- domaine d'envoi ;
- SPF, DKIM, DMARC ;
- `MAIL_FROM_ADDRESS` (actuellement `hello@example.com`) ;
- `MAIL_FROM_NAME` (actuellement `${APP_NAME}`) ;
- boîte de réception réelle ;
- test d'envoi vers Gmail/Outlook ;
- conformité RGPD/loi locale si données personnelles.

### 6.6 Réseaux sociaux

- Si les comptes sont renommés, les URLs changent : mettre à jour `COMPANY.social`.
- Si de nouveaux comptes sont créés, vérifier la disponibilité des handles.
- Ne pas afficher d'icône si le compte n'existe pas.
- Utiliser `rel="noopener noreferrer"` (déjà présent).
- Vérifier que les liens s'ouvrent correctement sur mobile.

---

## 7. Métadonnées cibles recommandées

> Les textes ci-dessous sont des **gabarits**. Ils ne doivent pas être publiés sans validation de la présentation officielle JMC.

| Page | Title (≤ 60 car.) | Description (≤ 155 car.) |
|---|---|---|
| Accueil | `JMC Services S.P.R.L. — [activité principale]` | `[Présentation officielle courte, 1 phrase, activités et zone d'intervention.]` |
| À propos | `À propos — JMC Services S.P.R.L.` | `Découvrez [mission officielle], nos valeurs et notre engagement.` |
| Services | `Services — JMC Services S.P.R.L.` | `[Liste des activités officielles], de [préstation] à [prestation].` |
| Contact | `Contact — JMC Services S.P.R.L.` | `Contactez JMC Services S.P.R.L. : [adresse], [téléphone], [email].` |
| Mentions légales | `Mentions légales — JMC Services S.P.R.L.` | `Informations légales et éditeur du site.` |
| Confidentialité | `Politique de confidentialité — JMC Services S.P.R.L.` | `Comment nous collectons et traitons vos données.` |

### Règles

- Un title unique par page.
- Pas de bourrage de mots-clés.
- Pas de « meilleur », « n°1 », « leader » sans preuve.
- Description = résumé utile, pas une liste de mots-clés.
- Utiliser le nom officiel exact, sans variation.
- `og:site_name` = nom d'affichage officiel.
- `og:locale` = `fr_CD` ou `fr_FR` selon la cible (⚠ à décider).

---

## 8. Plan d'action SEO

| # | Action | Priorité | Dépend de |
|---:|---|---|---|
| S01 | Inventorier les URLs/backlinks/GSC avant migration | **Critique** | Accès production |
| S02 | Décider conservation du domaine | **Critique** | Direction |
| S03 | Centraliser les métadonnées (source unique) | **Critique** | Architecture |
| S04 | Rendre les canonicals absolus | Haute | S03 |
| S05 | Corriger le double suffixe de title | Haute | — |
| S06 | Ajouter `og:image`, `og:site_name`, `og:locale` | Haute | Assets |
| S07 | Générer le JSON-LD côté serveur | Haute | S03 |
| S08 | Créer le sitemap XML | Haute | Routes |
| S09 | Mettre à jour `robots.txt` | Haute | S08 |
| S10 | Brancher les pages d'erreur | Moyenne | — |
| S11 | Ajouter `noindex` aux pages auth/profil | Moyenne | — |
| S12 | Supprimer ou implémenter `/services/{slug}` | Haute | Décision |
| S13 | Corriger les liens morts et ancres | Haute | Décision |
| S14 | Remplacer favicon/manifest | Haute | Assets |
| S15 | Soumettre le sitemap et surveiller | Haute | Déploiement |
| S16 | Mettre à jour Google Business Profile et réseaux | Moyenne | Validation |
| S17 | Ajouter analytics + consentement | Basse | Décision |
| S18 | Corriger les coordonnées et l'e-mail | **Critique** | Direction |
| S19 | Configurer SMTP/SPF/DKIM/DMARC | Haute | Infra |
| S20 | Tester les aperçus sociaux | Moyenne | S06 |

---

## 9. Critères d'acceptation SEO et intégrations

- [ ] Toutes les pages publiques ont un title unique, absolu et sans double suffixe.
- [ ] Chaque page a une meta description validée.
- [ ] Les canonicals sont absolus et cohérents.
- [ ] `og:image`, `og:site_name`, `og:locale` sont présents.
- [ ] Le JSON-LD est généré côté serveur, sans doublon.
- [ ] `sitemap.xml` contient uniquement les URLs publiques.
- [ ] `robots.txt` référence le sitemap et bloque les pages internes.
- [ ] Les pages 404/403/500 sont brandées et renvoient le bon statut.
- [ ] Aucune page interne n'est indexable.
- [ ] Aucun lien interne ne renvoie 404.
- [ ] Les anciennes URLs sont redirigées en 301 si elles ont changé.
- [ ] Le favicon et le manifest sont JMC.
- [ ] Les coordonnées affichées sont officielles.
- [ ] Le formulaire de contact fonctionne et respecte la confidentialité.
- [ ] Le SMTP de production est testé.
- [ ] Les profils sociaux et Google Business sont à jour.
- [ ] Search Console/Bing sont vérifiés et le sitemap soumis.
- [ ] Aucune référence CCM ne subsiste dans les métadonnées, les données structurées ou les images.
