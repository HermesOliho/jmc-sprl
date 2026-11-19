# 08 — Checklist de validation et de mise en production

**Objet :** fournir une checklist objective pour déclarer la migration terminée et le site prêt pour la production.

**Utilisation :** cocher chaque case avec une **preuve** (commande, capture, URL, test). Une case non cochée bloque la phase correspondante.

---

## 0. Légende

| Symbole | Signification |
|---|---|
| `[ ]` | À faire |
| `[x]` | Fait et vérifié |
| `[~]` | Fait partiellement / à revoir |
| `[N/A]` | Non applicable, justifié |
| **B** | Bloquant pour la production |

---

## 1. Go / No-Go — prérequis absolus

- [ ] **B** Le nom officiel exact est confirmé par écrit. (Q01, Q02)
- [ ] **B** La continuité juridique CCM → JMC est tranchée. (Q05)
- [ ] **B** Le logo SVG est fourni avec ses variantes claire/sombre. (Q41, Q42)
- [ ] **B** Le symbole seul est fourni pour le favicon. (Q43)
- [ ] **B** Les couleurs officielles sont fournies. (Q44)
- [ ] **B** Les coordonnées officielles sont fournies. (Q31–Q35)
- [ ] **B** Les contenus institutionnels sont validés. (Q09–Q18)
- [ ] **B** La liste officielle des services est validée. (Q19, Q20)
- [ ] **B** Le périmètre des pages est arbitré. (Q55)
- [ ] **B** La décision sur le formulaire est prise. (Q51, Q52)
- [ ] **B** La politique de confidentialité est rédigée si formulaire. (Q62–Q64)
- [ ] **B** Le domaine et les accès production sont connus. (Q38, Q67, Q72)
- [ ] **B** Une sauvegarde complète est réalisée et testée. (A11, G01)

> **No-Go** si l'une de ces cases manque. Ne pas démarrer la phase B sans logo, ni la phase C sans contenus.

---

## 2. Phase A — Préparation

### 2.1 Code et baseline

- [ ] Branche `rebrand/jmc` créée depuis `main`.
- [ ] Tag `pre-rebrand` créé.
- [ ] Arbre de travail propre (hors documentation de migration).
- [ ] Aucun fichier de skills/outillage inclus dans les commits de migration.
- [ ] Sauvegarde du code (archive ou dépôt distant) vérifiée.
- [ ] Sauvegarde DB vérifiée et restauration testée.
- [ ] Sauvegarde des médias vérifiée.

### 2.2 Inventaire production

- [ ] Export Search Console (16 mois) réalisé.
- [ ] Liste des URLs indexées exportée.
- [ ] Sitemap actuel récupéré (si existant).
- [ ] Crawl initial réalisé (Screaming Frog ou équivalent).
- [ ] Backlinks principaux listés.
- [ ] Analytics exporté (si existant).
- [ ] Google Business Profile identifié.
- [ ] Comptes sociaux et propriétaires listés.
- [ ] DNS, SMTP, hébergement documentés.

### 2.3 Décisions

- [ ] Journal de décisions rempli.
- [ ] Toutes les questions P0 répondues.
- [ ] Les hypothèses H1–H10 confirmées ou remplacées.
- [ ] La source de vérité de l'identité est choisie.
- [ ] La stratégie de métadonnées (SSR/props/package) est choisie.

---

## 3. Phase B — Fondation visuelle

### 3.1 Thèmes et tokens

- [ ] `themes: false` dans le plugin daisyUI.
- [ ] Thème `jmc-light` défini avec tous les tokens requis.
- [ ] Thème `jmc-dark` défini avec tous les tokens requis.
- [ ] `default: true` sur `jmc-light`.
- [ ] `prefersdark: true` sur `jmc-dark`.
- [ ] `color-scheme` correct pour chaque thème.
- [ ] `body` utilise `bg-base-200` et `text-base-content`.
- [ ] Le focus visible est défini et contrasté.
- [ ] Aucun token `--color-ccm-*` dans `app.css`.
- [ ] Aucune classe `text-gray-*`/`bg-white` dans les composants métier.

### 3.2 Logo

- [ ] `BrandLogo.vue` créé.
- [ ] Variante claire utilisée sur fond clair.
- [ ] Variante sombre utilisée sur fond sombre.
- [ ] Header utilise le logo JMC.
- [ ] Footer utilise le logo JMC.
- [ ] Hero utilise le logo JMC ou aucun logo (décoratif).
- [ ] Pages auth utilisent le logo JMC.
- [ ] `alt` textuel correct.
- [ ] Logo non déformé, proportions respectées.
- [ ] Zone de protection respectée.

### 3.3 Favicon / manifest / OG

- [ ] `favicon.ico` JMC.
- [ ] `favicon-16x16.png` JMC.
- [ ] `favicon-32x32.png` JMC.
- [ ] `apple-touch-icon.png` JMC.
- [ ] `android-chrome-192x192.png` JMC.
- [ ] `android-chrome-512x512.png` JMC.
- [ ] Icône maskable fournie.
- [ ] `site.webmanifest` : nom, short_name, description remplis.
- [ ] `theme_color` = `#0B2545` (ou officiel).
- [ ] `background_color` = `#FFFFFF`.
- [ ] `lang: "fr"`.
- [ ] `og:image` par défaut 1200×630.
- [ ] Favicon visible à 16 px.

### 3.4 Composants communs

- [ ] Boutons : primaire, secondaire, outline, ghost conformes.
- [ ] Boutons : hover, focus, disabled, loading.
- [ ] Champs : label, placeholder, focus, erreur, disabled.
- [ ] Cartes : fond, bordure, ombre, hover.
- [ ] Badges : variantes sémantiques.
- [ ] Titres : couleurs et tailles.
- [ ] Sections : fonds `base-100/200`, pas de blanc forcé.
- [ ] CTA : fond navy, bouton orange, contraste.
- [ ] Header de page : fond navy, texte blanc, fil d'Ariane lisible.
- [ ] Modal : fond, ombre, focus trap.
- [ ] Erreurs : layout brandé.

### 3.5 Thème sombre

- [ ] Bascule visible dans le header.
- [ ] `aria-label` et `aria-pressed` corrects.
- [ ] Persistance `localStorage`.
- [ ] Respect de `prefers-color-scheme`.
- [ ] Pas de flash au chargement.
- [ ] Logo variante sombre.
- [ ] Contrastes vérifiés.
- [ ] Footer lisible.
- [ ] Formulaires lisibles.
- [ ] Cartes et bordures visibles.
- [ ] Images/overlays corrects.
- [ ] Aucun composant avec fond blanc forcé.

---

## 4. Phase C — Contenus

### 4.1 Identité

- [ ] Nom d'affichage officiel unique partout.
- [ ] Raison sociale exacte dans le footer et les mentions légales.
- [ ] Slogan/baseline validé ou absent.
- [ ] Description officielle utilisée dans les métadonnées.
- [ ] Aucune mention « CCM » non justifiée.
- [ ] Aucun « Congo Construction & Métallique » non justifié.

### 4.2 Accueil

- [ ] Hero : titre JMC, sous-titre validé.
- [ ] CTA principal valide (pas de 404).
- [ ] CTA secondaire valide.
- [ ] Chiffres cohérents avec la source unique.
- [ ] Section « Qui sommes-nous » validée.
- [ ] Services cohérents avec la taxonomie officielle.
- [ ] Réalisations : réelles ou section retirée.
- [ ] Actualités : réelles ou section retirée.
- [ ] Partenaires : autorisés ou section retirée.
- [ ] Images réelles (aucun `placehold.co`).

### 4.3 À propos

- [ ] Présentation validée.
- [ ] Histoire : conservée/retirée selon décision.
- [ ] Mission/vision validées.
- [ ] Valeurs validées.
- [ ] Équipe : validée ou section retirée.
- [ ] Certifications : valides ou section retirée.
- [ ] Aucune allégation non prouvée.

### 4.4 Services

- [ ] Une seule taxonomie officielle.
- [ ] Chaque service a une description validée.
- [ ] Livrables validés.
- [ ] Bénéfices validés.
- [ ] Aucune garantie/certification non prouvée.
- [ ] Ancres cohérentes.
- [ ] Liens de détail valides ou supprimés.

### 4.5 Contact

- [ ] Adresse officielle.
- [ ] Téléphone officiel.
- [ ] E-mail officiel.
- [ ] WhatsApp officiel.
- [ ] Horaires validés.
- [ ] GPS validés.
- [ ] Réseaux sociaux officiels.
- [ ] FAQ validée.
- [ ] Délai de réponse tenu ou supprimé.
- [ ] Mention d'urgence validée ou supprimée.

### 4.6 Pages légales

- [ ] Mentions légales publiées.
- [ ] Politique de confidentialité publiée.
- [ ] Lien depuis le footer.
- [ ] Lien depuis le formulaire.
- [ ] Contenu validé par le juridique.

### 4.7 Qualité rédactionnelle

- [ ] Aucune faute bloquante.
- [ ] Ton cohérent.
- [ ] Pas de promesse non tenue.
- [ ] Pas de contenu dupliqué.
- [ ] Pas de texte anglais résiduel sur les pages publiques.
- [ ] Dates et chiffres cohérents.

---

## 5. Phase D — Pages et fonctionnalités

### 5.1 Parcours public

- [ ] `/` répond 200.
- [ ] `/a-propos` répond 200.
- [ ] `/services` répond 200.
- [ ] `/contact` répond 200.
- [ ] `/services/{slug}` : page réelle ou route supprimée.
- [ ] Toutes les pages ont un H1 unique.
- [ ] Toutes les pages ont un title et une description.
- [ ] Aucun lien interne ne renvoie 404.
- [ ] Aucune ancre interne ne pointe dans le vide.
- [ ] Le menu mobile fonctionne.
- [ ] Le menu desktop fonctionne.
- [ ] Le footer ne contient aucun lien mort.
- [ ] Les CTA “devis” mènent à une page existante.
- [ ] Les liens “Réalisations/Carrières/Actualités” sont valides ou retirés.

### 5.2 Formulaire de contact `[C]`

- [ ] Route POST créée.
- [ ] Validation serveur complète.
- [ ] Messages d'erreur clairs.
- [ ] Rate limiting actif.
- [ ] Anti-spam (honeypot/captcha) actif.
- [ ] CSRF actif.
- [ ] E-mail reçu à l'adresse officielle.
- [ ] `replyTo` correct.
- [ ] Message de succès affiché.
- [ ] Message d'erreur affiché.
- [ ] État de chargement.
- [ ] Consentement obligatoire.
- [ ] Lien confidentialité.
- [ ] Aucune donnée dans `console.log`.
- [ ] Test avec Gmail/Outlook.
- [ ] Pas de fuite de données dans les logs.

### 5.3 Auth / espace interne `[C]`

- [ ] Inscription fermée ou accès restreint.
- [ ] Pages auth en français.
- [ ] Logo JMC.
- [ ] Titles français.
- [ ] `noindex` sur les pages internes.
- [ ] Dashboard réellement utile ou retiré.
- [ ] Profil fonctionnel.
- [ ] Aucun lien public vers le dashboard.

### 5.4 Erreurs

- [ ] 404 branché et brandé.
- [ ] 403 branché.
- [ ] 500 branché.
- [ ] Statuts HTTP corrects.
- [ ] Liens de retour fonctionnels.
- [ ] Aucune fuite de stack trace en production.

---

## 6. Phase E — SEO et intégrations

### 6.1 Métadonnées

- [ ] Title unique par page.
- [ ] Pas de double suffixe.
- [ ] Description unique par page.
- [ ] Canonical absolu.
- [ ] `og:title`, `og:description`, `og:image`, `og:url`, `og:type`, `og:site_name`, `og:locale`.
- [ ] `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`.
- [ ] Aucun CCM dans les métadonnées.
- [ ] Aperçu social testé (Facebook/LinkedIn/WhatsApp).

### 6.2 JSON-LD

- [ ] `Organization` présent avec nom JMC.
- [ ] `legalName` exact.
- [ ] `url` absolu.
- [ ] `logo` absolu.
- [ ] `sameAs` réseaux officiels.
- [ ] `ContactPoint` si pertinent.
- [ ] `BreadcrumbList`.
- [ ] Pas de doublon après navigation SPA.
- [ ] Validation Schema.org / Rich Results Test.
- [ ] Aucune donnée CCM.

### 6.3 Sitemap / robots

- [ ] `sitemap.xml` généré.
- [ ] URLs publiques uniquement.
- [ ] `lastmod` correct.
- [ ] `robots.txt` référence le sitemap.
- [ ] Pages internes bloquées.
- [ ] Sitemap soumis à Search Console.
- [ ] Sitemap soumis à Bing.

### 6.4 Redirections / URLs

- [ ] Anciennes URLs inventoriées.
- [ ] Table de redirection 301 testée.
- [ ] Aucune chaîne de redirection.
- [ ] Aucune redirection massive vers `/`.
- [ ] URLs conservées quand possible.
- [ ] Slugs cohérents.
- [ ] Aucun `/services/{slug}` dupliqué si non implémenté.

### 6.5 Intégrations

- [ ] SMTP configuré.
- [ ] `MAIL_FROM_ADDRESS` officiel.
- [ ] `MAIL_FROM_NAME` officiel.
- [ ] SPF/DKIM/DMARC vérifiés.
- [ ] Test d'envoi réussi.
- [ ] Réseaux sociaux à jour.
- [ ] Google Business Profile à jour.
- [ ] Analytics configuré ou décision de ne pas en mettre.
- [ ] Consentement cookies si nécessaire.
- [ ] Aucune dépendance à `placehold.co`.
- [ ] Polices auto-hébergées ou externalisées proprement.

---

## 7. Phase F — Qualité

### 7.1 Résidus CCM

- [ ] `grep -rIn --exclude-dir={node_modules,vendor,.git,build,bootstrap} -iE 'ccm|congo construction' .` ne renvoie que des exceptions documentées.
- [ ] `grep -rIl -i ccm public/build bootstrap/ssr` ne renvoie rien après rebuild.
- [ ] Aucun `ccm` dans les noms de fichiers.
- [ ] Aucun `ccm` dans les métadonnées générées.
- [ ] Aucun `ccm` dans les bundles JS.
- [ ] Aucun `ccm` dans le sitemap.
- [ ] Aucun `ccm` dans les images/alt.
- [ ] Ancien logo supprimé ou archivé après validation.

### 7.2 Tests automatisés

- [ ] `tests/Feature/PublicPagesTest.php` créé.
- [ ] `/` 200 + contenu JMC.
- [ ] `/a-propos` 200 + contenu JMC.
- [ ] `/services` 200 + contenu JMC.
- [ ] `/contact` 200 + contenu JMC.
- [ ] Aucun « CCM » dans le HTML rendu.
- [ ] `tests/Feature/ContactTest.php` créé (si formulaire).
- [ ] Validation formulaire testée.
- [ ] Envoi e-mail testé (`Mail::fake`).
- [ ] Rate limit testé.
- [ ] `tests/Feature/SeoTest.php` créé.
- [ ] Canonicals testés.
- [ ] Sitemap testé.
- [ ] Robots testé.
- [ ] `php artisan test --compact` passe.
- [ ] Aucun test supprimé sans justification.

### 7.3 Responsive

- [ ] 375 px : pas de débordement horizontal.
- [ ] 390 px : OK.
- [ ] 768 px : OK.
- [ ] 1024 px : OK.
- [ ] 1280 px : OK.
- [ ] 1440 px : OK.
- [ ] Menu mobile : ouverture/fermeture.
- [ ] Menu mobile : focus clavier.
- [ ] Hero : hauteur correcte sur mobile.
- [ ] Carrousels : utilisables au doigt.
- [ ] Tableaux/grilles : pas de contenu coupé.
- [ ] Footer : lisible et aligné.

### 7.4 Accessibilité

- [ ] Un seul H1 par page.
- [ ] Hiérarchie Hn continue.
- [ ] Skip link présent.
- [ ] Navigation clavier complète.
- [ ] Focus visible sur fond clair.
- [ ] Focus visible sur fond sombre.
- [ ] `aria-current` sur la navigation.
- [ ] `aria-expanded` sur le menu/FAQ.
- [ ] `aria-controls` sur le menu.
- [ ] Labels de formulaire liés.
- [ ] Erreurs annoncées (`role="alert"`).
- [ ] `aria-invalid` et `aria-describedby`.
- [ ] Images : `alt` pertinent ou vide.
- [ ] Icônes décoratives : `aria-hidden`.
- [ ] Contraste texte ≥ 4,5:1.
- [ ] Contraste grand texte ≥ 3:1.
- [ ] Contraste composants ≥ 3:1.
- [ ] `prefers-reduced-motion` respecté.
- [ ] Zoom 200 % sans perte.
- [ ] Cibles tactiles ≥ 44 px.
- [ ] Langue `fr`.
- [ ] Aucun contenu clignotant.

### 7.5 Performance

- [ ] Aucun `placehold.co` en production.
- [ ] Images en WebP/AVIF avec fallback.
- [ ] `width`/`height` corrects.
- [ ] `loading="lazy"` hors above-the-fold.
- [ ] Logo optimisé (SVG ou PNG < 50 Ko).
- [ ] Police auto-hébergée et préchargée.
- [ ] Pas de graisse manquante.
- [ ] Pas de JS bloquant inutile.
- [ ] Animations non bloquantes pour le LCP.
- [ ] Lighthouse mobile : performance correcte.
- [ ] LCP < 2,5 s (objectif).
- [ ] CLS < 0,1 (objectif).
- [ ] INP < 200 ms (objectif).
- [ ] Bundle JS raisonnable.
- [ ] Aucun console.log en production.

### 7.6 Sécurité

- [ ] `APP_DEBUG=false` en production.
- [ ] `APP_ENV=production`.
- [ ] HTTPS actif.
- [ ] Cookies `secure` en production.
- [ ] `SESSION_ENCRYPT` selon politique.
- [ ] CSRF actif sur tous les POST.
- [ ] Validation serveur sur le formulaire.
- [ ] Rate limiting sur le formulaire.
- [ ] Inscription fermée ou protégée.
- [ ] Aucun secret dans le dépôt.
- [ ] `composer audit` sans vulnérabilité critique.
- [ ] `npm audit` sans vulnérabilité critique non justifiée.
- [ ] Debugbar absent en production.
- [ ] Aucune stack trace publique.
- [ ] En-têtes de sécurité de base (si infra le permet).
- [ ] Sauvegardes chiffrées/contrôlées.

---

## 8. Phase G — Production

### 8.1 Avant déploiement

- [ ] Sauvegarde DB vérifiée.
- [ ] Sauvegarde médias vérifiée.
- [ ] Sauvegarde code/artefact vérifiée.
- [ ] `npm run build` réussi.
- [ ] `php artisan test` réussi.
- [ ] `vendor/bin/pint --dirty --format agent` réussi.
- [ ] `public/hot` absent.
- [ ] Caches locaux purgés.
- [ ] Variables d'environnement de production vérifiées.
- [ ] `APP_URL` correct.
- [ ] `APP_NAME` correct.
- [ ] `MAIL_*` correct.
- [ ] Plan de rollback écrit.
- [ ] Fenêtre de déploiement communiquée.

### 8.2 Déploiement

- [ ] Code déployé.
- [ ] Assets build déployés.
- [ ] `php artisan config:cache` (si utilisé).
- [ ] `php artisan route:cache` (si compatible).
- [ ] `php artisan view:cache`.
- [ ] `php artisan migrate --force` (si migration).
- [ ] `php artisan storage:link` (si médias).
- [ ] Caches CDN purgés.
- [ ] Ancien service worker invalidé (si PWA).

### 8.3 Après déploiement — smoke tests

- [ ] `/` 200.
- [ ] `/a-propos` 200.
- [ ] `/services` 200.
- [ ] `/contact` 200.
- [ ] Favicon JMC visible.
- [ ] Logo JMC visible.
- [ ] Thème clair OK.
- [ ] Thème sombre OK.
- [ ] Formulaire : envoi test reçu.
- [ ] Menu mobile OK.
- [ ] Aucun 404 sur les liens principaux.
- [ ] Aucun 500 dans les logs.
- [ ] `robots.txt` accessible.
- [ ] `sitemap.xml` accessible.
- [ ] Aucun CCM visible.
- [ ] Aperçu social correct.
- [ ] Redirections testées.

### 8.4 SEO post-déploiement

- [ ] Sitemap soumis à Search Console.
- [ ] Sitemap soumis à Bing.
- [ ] URLs clés inspectées.
- [ ] Couverture indexée surveillée.
- [ ] Erreurs 404 surveillées.
- [ ] Erreurs 500 surveillées.
- [ ] Core Web Vitals surveillés.
- [ ] Google Business Profile mis à jour.
- [ ] Réseaux sociaux mis à jour.
- [ ] Backlinks principaux vérifiés.

### 8.5 Rollback

- [ ] Procédure écrite.
- [ ] Artefact précédent disponible.
- [ ] Sauvegarde DB disponible.
- [ ] Responsable identifié.
- [ ] Test de rollback réalisé en staging.
- [ ] Communication d'incident prête.

---

## 9. Surveillance 30 jours

### Semaine 1

- [ ] Vérifier les logs d'erreur quotidiens.
- [ ] Vérifier les 404.
- [ ] Vérifier les formulaires reçus.
- [ ] Vérifier les Core Web Vitals.
- [ ] Vérifier l'indexation.
- [ ] Vérifier les e-mails (SPAM).
- [ ] Vérifier les retours utilisateurs.

### Semaines 2–4

- [ ] Comparer le trafic Search Console avant/après.
- [ ] Vérifier les positions des pages clés.
- [ ] Vérifier les backlinks.
- [ ] Vérifier les conversions (contacts).
- [ ] Corriger les régressions détectées.
- [ ] Mettre à jour la documentation.
- [ ] Planifier le nettoyage des anciens assets.

---

## 10. Checklist « zéro CCM » — commandes

```bash
# 1. Sources (hors artefacts)
grep -rIn --exclude-dir={node_modules,vendor,.git,build,bootstrap} \
  -iE 'ccm|congo construction' .

# 2. Fichiers suivis
git ls-files | xargs grep -Il -i 'ccm'

# 3. Tokens CSS
grep -rIo --exclude-dir={node_modules,vendor} \
  'var(--color-ccm-[a-z0-9-]*' resources/js resources/css

# 4. Bundles générés
grep -rIl -i 'ccm' public/build bootstrap/ssr 2>/dev/null

# 5. Sitemap / robots / manifest
grep -in 'ccm' public/sitemap.xml public/robots.txt public/site.webmanifest 2>/dev/null

# 6. HTML rendu (adapter l'URL)
curl -s https://[domaine]/ | grep -i ccm
curl -s https://[domaine]/a-propos | grep -i ccm
curl -s https://[domaine]/services | grep -i ccm
curl -s https://[domaine]/contact | grep -i ccm

# 7. Métadonnées
curl -s https://[domaine]/ | grep -iE 'title|description|og:|twitter:|application/ld\+json'
```

**Résultat attendu :** seules les exceptions documentées (histoire validée, redirections, mentions légales historiques) peuvent subsister.

---

## 11. Checklist de contenu (anti-invention)

- [ ] Chaque chiffre publié a une source validée.
- [ ] Chaque certification publiée a un certificat vérifié.
- [ ] Chaque membre d'équipe a donné son accord.
- [ ] Chaque photo a une autorisation d'utilisation.
- [ ] Chaque partenaire a autorisé son logo.
- [ ] Chaque projet publié est réel et autorisé.
- [ ] Chaque actualité publiée est réelle et datée.
- [ ] Chaque allégation commerciale est prouvée.
- [ ] Chaque coordonnée est officielle.
- [ ] Chaque page légale est validée.
- [ ] Aucun texte n'a été inventé pour « faire joli ».
- [ ] Les contenus non validés sont masqués, pas publiés.

---

## 12. Sign-off

| Rôle | Nom | Décision | Date | Signature / preuve |
|---|---|---|---|---|
| Direction JMC | | ☐ Approuvé ☐ Refusé | | |
| Responsable technique | | ☐ Approuvé ☐ Refusé | | |
| SEO / Marketing | | ☐ Approuvé ☐ Refusé | | |
| Juridique / conformité | | ☐ Approuvé ☐ Refusé | | |
| QA | | ☐ Approuvé ☐ Refusé | | |
| Communication | | ☐ Approuvé ☐ Refusé | | |

**La production ne doit être déclarée « prête » que si tous les signataires ont approuvé et si toutes les cases `B` sont cochées.**

---

## 13. Journal des preuves

| Date | Check | Preuve (commande, URL, capture) | Résultat | Validé par |
|---|---|---|---|---|
| | | | | |
| | | | | |
| | | | | |

---

## 14. Critères de clôture du projet

- [ ] Toutes les cases `B` sont cochées.
- [ ] Le site est stable 30 jours.
- [ ] Aucune régression SEO majeure.
- [ ] Le formulaire fonctionne et les e-mails arrivent.
- [ ] Les deux thèmes sont validés.
- [ ] La documentation est à jour.
- [ ] Les anciens assets sont archivés/supprimés selon la politique.
- [ ] La direction a signé.
- [ ] Le plan de surveillance est actif.
