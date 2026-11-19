# 06 — Informations à valider et décisions humaines

**Objet :** lister tout ce qui ne peut pas être déduit du code et qui conditionne la migration. Aucune réponse n'est inventée ici.

**Utilisation :** chaque ligne doit être renseignée par la direction JMC ou le responsable technique. Tant qu'une question `P0` n'est pas répondue, la tâche correspondante reste bloquée.

---

## 1. Niveaux de priorité

| Niveau | Signification | Effet |
|---|---|---|
| **P0 — Bloquant** | Sans réponse, la migration ne peut pas être finalisée correctement | Bloque une phase |
| **P1 — Haute** | Nécessaire avant mise en production | Peut être temporisé |
| **P2 — Moyenne** | Améliore la qualité, peut suivre | Non bloquant |
| **P3 — Basse** | Confort/documentation | Peut être fait après |

## 2. Légende des statuts

| Statut | Signification |
|---|---|
| `À obtenir` | Question posée, réponse attendue |
| `En cours` | Réponse partielle |
| `Validé` | Réponse écrite et confirmée |
| `Refusé` | Décision de ne pas traiter |
| `Sans objet` | La question ne s'applique pas |

---

## 3. Identité légale et nom

| ID | Question | Pourquoi | Impact | Hypothèse de travail (à confirmer) | Prio | Propriétaire |
|---|---|---|---|---|---|---|
| Q01 | Quelle est la **dénomination officielle exacte** à afficher ? « JMC Services S.P.R.L », « JMC Services S.P.R.L. », « JMC S.P.R.L. », autre ? | Le nom apparaît dans le header, le footer, les titles, le JSON-LD, les emails | `company.ts`, `constants`, `Header`, `Footer`, JSON-LD, SEO | Le dépôt et `.env` utilisent `JMC S.P.R.L.` ; la mission parle de `JMC Services S.P.R.L` | **P0** | Direction |
| Q02 | Quelle est la **raison sociale légale** (celle du RCCM/statuts) ? | Copyright, mentions légales, JSON-LD `legalName` | Footer, mentions légales, JSON-LD | Inconnue | **P0** | Direction/Juridique |
| Q03 | Le nom commercial diffère-t-il de la raison sociale ? | Affichage vs legal | Header/SEO | Inconnu | **P0** | Direction |
| Q04 | Faut-il afficher « anciennement CCM S.A.R.L » ? | Transition, confiance, SEO | Header/footer, page histoire, `alternateName` | Aucune mention par défaut | P1 | Direction |
| Q05 | JMC est-elle la **même entité juridique** que CCM (changement de nom) ou une **nouvelle entité** ? | Conditionne l'histoire, le JSON-LD, la continuité | Histoire, SEO, mentions légales | Inconnu | **P0** | Direction/Juridique |
| Q06 | Le logo contient-il un nom textuel intégré ou faut-il un wordmark séparé ? | Header, footer, variantes | `BrandLogo`, header | Le logo décrit contient « JMC » | P1 | Direction/Marque |
| Q07 | Existe-t-il une baseline/signature officielle (« Construction, infrastructures… ») ? | Slogan, footer, OG | `company.ts`, header | Aucune baseline confirmée | P1 | Direction |
| Q08 | Le nom doit-il être traduit/adapté en anglais ou en lingala ? | Site multilingue éventuel | Architecture i18n | Site FR uniquement | P2 | Direction |

---

## 4. Présentation institutionnelle

| ID | Question | Pourquoi | Impact | Hypothèse | Prio | Propriétaire |
|---|---|---|---|---|---|---|
| Q09 | Quelle est la **présentation officielle** en 2–3 phrases ? | Hero, description, meta, OG | `company.ts`, `home.ts`, SEO | Texte CCM actuel non réutilisable | **P0** | Direction |
| Q10 | Quels sont la **mission**, la **vision** et les **valeurs** officielles ? | Page À propos | `about.ts` | Valeurs CCM non validées | P1 | Direction |
| Q11 | Quels sont les **différenciateurs** réels (délais, sécurité, équipe, matériel) ? | Sections « pourquoi nous » | `home.ts`, `about.ts` | Non vérifiés | P1 | Direction |
| Q12 | Quels **chiffres clés** peuvent être publiés (projets, années, effectifs, clients) ? | Stats hero + compteurs | `statistics.ts`, `home.ts`, `company.ts` | Chiffres actuels incohérents et non prouvés | **P0** | Direction |
| Q13 | Depuis quelle **année** l'activité existe-t-elle ? | « X années d'expérience » | Stats, À propos | 2009 dans le contenu CCM, non confirmé | **P0** | Direction |
| Q14 | Quelles **zones géographiques** sont réellement couvertes ? | FAQ, SEO local, promesses | `services.ts` FAQ, contact | « Toute la RDC » non vérifié | P1 | Direction |
| Q15 | Quels **secteurs** sont réellement adressés ? | Taxonomie services | `services.ts` | 12 services non validés | **P0** | Direction |
| Q16 | Existe-t-il des **labels, agréments, certifications** valides ? | Section certifications | `certifications.ts` | ISO/OHSAS non vérifiés | **P0** | Direction/Qualité |
| Q17 | Quels **partenaires** peuvent être affichés (avec autorisation) ? | Carrousel partenaires | `partners.ts` | Génériques | P1 | Direction/Commercial |
| Q18 | Quels **projets** peuvent être publiés (nom, lieu, année, photo, autorisation) ? | Réalisations | `projects.ts` | Fictifs | **P0** | Direction/Commercial |

---

## 5. Activités et services

| ID | Question | Pourquoi | Impact | Hypothèse | Prio | Propriétaire |
|---|---|---|---|---|---|---|
| Q19 | Quelle est la **liste officielle des services** (4, 6, 12, autre) ? | Navigation, cartes, footer, JSON-LD | `services.ts`, `company.ts`, `navigation.ts` | Trois listes incohérentes existent | **P0** | Direction |
| Q20 | Pour chaque service : description courte, livrables, bénéfices, photo | Contenu des cartes/détails | `services.ts` | Contenu CCM non validé | **P0** | Direction/Technique |
| Q21 | Faut-il des **pages de détail** par service ? | Route `/services/{slug}` | `Services.vue`, routes | Route existante mais vide | P1 | Direction/Produit |
| Q22 | Quelles **allégations** sont autorisées (garantie décennale, assurance, normes, certifications) ? | Risque juridique | `services.ts` FAQ, cartes | Non vérifiées | **P0** | Direction/Juridique |
| Q23 | Proposez-vous des **devis gratuits** ? Sous quel délai ? | CTA, FAQ, meta | `home.ts`, `contact.ts` | Promesse actuelle non validée | P1 | Direction |
| Q24 | Assurez-vous des **interventions d'urgence** 7j/7 ? | Contact, FAQ | `contact.ts` | Non vérifié | P1 | Direction |

---

## 6. Histoire, équipe, preuve sociale

| ID | Question | Pourquoi | Impact | Hypothèse | Prio | Propriétaire |
|---|---|---|---|---|---|---|
| Q25 | Faut-il conserver l'**histoire de CCM** (2009–2024) ? | Page À propos | `about.ts` | À retirer par défaut | **P0** | Direction |
| Q26 | Si oui, quels **jalons** sont exacts et pubiables ? | Timeline | `about.ts` | Non vérifiés | P1 | Direction |
| Q27 | Faut-il publier une **équipe** (noms, rôles, photos) ? | Section équipe | `team.ts` | Personnes non vérifiées | P1 | Direction/RH |
| Q28 | Quelles **personnes** et quelles **photos** sont autorisées ? | Équipe | `team.ts`, assets | Aucune | P1 | Direction/RH |
| Q29 | Quels **témoignages** clients sont autorisés ? | Preuve sociale (non présente) | Nouvelle section éventuelle | Aucun | P2 | Commercial |
| Q30 | Quels **actualités/communiqués** peuvent être publiés ? | Section news | `news.ts` | Fictifs | P1 | Communication |

---

## 7. Coordonnées, domaine et présence numérique

| ID | Question | Pourquoi | Impact | Hypothèse | Prio | Propriétaire |
|---|---|---|---|---|---|---|
| Q31 | Quelle est l'**adresse officielle** complète ? | Contact, footer, JSON-LD, Maps | `company.ts`, Contact | Adresse actuelle probablement fictive | **P0** | Direction |
| Q32 | Quel est le **numéro de téléphone** officiel ? | Contact, footer, CTA | `company.ts`, `home.ts`, `contact.ts` | `+243 81 234 5678` non confirmé | **P0** | Direction |
| Q33 | Quel est le **numéro WhatsApp** officiel ? | Lien social | `company.ts` | Ancien numéro | P1 | Direction |
| Q34 | Quelle est l'**adresse e-mail** officielle ? | Contact, footer, formulaire, SMTP | `company.ts`, `mail.php` | `info@ccmsarl.cd` probablement obsolète | **P0** | Direction/IT |
| Q35 | Quels sont les **horaires** officiels ? | Contact, footer | `company.ts` | Non confirmés | P1 | Direction |
| Q36 | Quelles sont les **coordonnées GPS** exactes ? | Carte | `company.ts` | Kinshasa générique | P2 | Direction |
| Q37 | Quels **comptes sociaux** sont conservés/renommés/créés ? | Footer, contact, `sameAs` | `company.ts` | Anciens comptes `ccmsarl` | P1 | Communication |
| Q38 | Le **domaine actuel** doit-il être conservé ? | SEO, redirections | Toute la config | À conserver (recommandé) | **P0** | Direction/IT |
| Q39 | Existe-t-il un **Google Business Profile** ? Qui le gère ? | SEO local | Hors code | Inconnu | P1 | Communication |
| Q40 | Qui gère **Search Console / Analytics / DNS / SMTP** ? | Migration et suivi | Hors code | Inconnu | **P0** | IT |

---

## 8. Actifs visuels et marque

| ID | Question | Pourquoi | Impact | Hypothèse | Prio | Propriétaire |
|---|---|---|---|---|---|---|
| Q41 | Le **logo SVG officiel** est-il disponible ? | Tout le site | Header, footer, favicon, OG | **Absent du dépôt** | **P0** | Marque |
| Q42 | Existe-t-il une **déclinaison fond clair** et une **fond sombre** ? | Header/footer/thème | `BrandLogo` | Décrites mais non fournies | **P0** | Marque |
| Q43 | Existe-t-il un **symbole seul** (mark) pour le favicon ? | Favicon/PWA | `public/*` | Non fourni | **P0** | Marque |
| Q44 | Quelles sont les **couleurs officielles** (HEX/CMJN/Pantone) ? | Palette finale | `app.css` | Palette provisoire du doc 04 | **P0** | Marque |
| Q45 | Quelle est la **typographie officielle** ? | Design system | `app.css`, polices | Figtree conservée par défaut | P1 | Marque |
| Q46 | Quelles sont les **règles de zone de protection / taille min / usages interdits** ? | Intégration logo | `BrandLogo` | Règles génériques du doc 04 | P1 | Marque |
| Q47 | Existe-t-il des **photographies institutionnelles** (chantiers, équipe, matériel) ? | Tout le visuel | 45 placeholders | Aucune dans le dépôt | **P0** | Direction/Communication |
| Q48 | Quelles **autorisations** avons-nous sur les photos (personnes, clients, sites) ? | Juridique | Assets | Inconnues | **P0** | Direction/Juridique |
| Q49 | Existe-t-il une **image Open Graph** officielle ? | Partage social | `og:image` | À créer | P1 | Marque |
| Q50 | Existe-t-il des **logos partenaires** autorisés ? | Carrousel | `partners.ts` | Aucun | P2 | Commercial |

---

## 9. Décisions fonctionnelles

| ID | Question | Pourquoi | Impact | Hypothèse | Prio | Propriétaire |
|---|---|---|---|---|---|---|
| Q51 | Le **formulaire de contact** doit-il être implémenté ou retiré ? | Fonction critique | `ContactForm`, routes, mail | À implémenter | **P0** | Direction/IT |
| Q52 | Vers quelle **adresse** doivent aller les messages ? | Livraison | Mailable, config | Inconnue | **P0** | Direction |
| Q53 | Faut-il un **accusé de réception** à l'expéditeur ? | UX | Mailable | Optionnel | P2 | Direction |
| Q54 | Faut-il une **page de demande de devis** dédiée ? | CTA mort | Routes/pages | Rediriger vers contact par défaut | P1 | Direction |
| Q55 | Faut-il des pages **Réalisations / Carrières / Actualités** ? | Navigation | Routes/pages | Retirer les liens par défaut | **P0** | Direction |
| Q56 | L'**espace client / inscription** doit-il rester ouvert ? | Sécurité/produit | Routes auth, dashboard | Fermer l'inscription publique | P1 | Direction/IT |
| Q57 | Faut-il une **carte Google Maps** intégrée ? | Contact | `GoogleMapPlaceholder` | Lien Maps par défaut | P2 | Direction |
| Q58 | Faut-il un **thème sombre** avec bascule visible ou uniquement `prefers-color-scheme` ? | UX | `useTheme`, header | Bascule visible + système | P1 | Direction/Produit |
| Q59 | Faut-il un **sélecteur de langue** ? | i18n | Architecture | Non | P2 | Direction |
| Q60 | Faut-il une **newsletter** ou un formulaire d'abonnement ? | Marketing | Nouvelle fonctionnalité | Non | P3 | Marketing |

---

## 10. Contenu légal et conformité

| ID | Question | Pourquoi | Impact | Hypothèse | Prio | Propriétaire |
|---|---|---|---|---|---|---|
| Q61 | Qui rédige les **mentions légales** ? | Obligation légale | Nouvelle page | À créer | P1 | Juridique |
| Q62 | Qui rédige la **politique de confidentialité** ? | Consentement du formulaire | Nouvelle page + lien | À créer | **P0** si formulaire | Juridique |
| Q63 | Quel **fondement juridique** pour le traitement des messages ? | Conformité | Formulaire | Consentement/intérêt légitime à valider | **P0** | Juridique |
| Q64 | Quelle **durée de conservation** des messages ? | Conformité | Backend | À définir | **P0** | Juridique/IT |
| Q65 | Faut-il une **bannière cookies** ? | Analytics/Maps | Layout | Uniquement si cookies non essentiels | P1 | Juridique/IT |
| Q66 | Quelles **mentions** pour les certifications et allégations ? | Risque juridique | Contenus | Aucune allégation par défaut | **P0** | Juridique |

---

## 11. Technique, SEO et déploiement

| ID | Question | Pourquoi | Impact | Hypothèse | Prio | Propriétaire |
|---|---|---|---|---|---|---|
| Q67 | Le **domaine de production** et son registrar ? | SEO/DNS | Config | Inconnu | **P0** | IT |
| Q68 | L'hébergement supporte-t-il **Node/SSR** ? | SEO/rendu | `ssr.ts` | Non supposé | P1 | IT |
| Q69 | Quelles sont les **variables d'environnement** de production ? | Config | `.env` | Inconnues | **P0** | IT |
| Q70 | Quel **SMTP** est utilisé en production ? | Formulaire/emails | `mail.php` | Inconnu | **P0** | IT |
| Q71 | Quelles **sauvegardes** existent (DB, médias, code) ? | Risque | `backup.php` | Non planifiées | P1 | IT |
| Q72 | Quel est le **processus de déploiement** (CI/CD, FTP, Forge, Cloud) ? | Mise en production | Hors code | Inconnu | **P0** | IT |
| Q73 | Existe-t-il un **environnement de staging** ? | Tests | Hors code | Inconnu | P1 | IT |
| Q74 | Quels **outils analytics** sont autorisés ? | Mesure | Layout | Aucun | P2 | Marketing |
| Q75 | Qui a accès à **Search Console / Bing / Google Business** ? | SEO | Hors code | Inconnu | P1 | Marketing |
| Q76 | Faut-il **conserver les anciennes URLs** CCM ? | SEO | Redirections | Oui, si identifiées | **P0** | SEO/IT |
| Q77 | Existe-t-il un **sitemap** ou un crawl de l'ancien site ? | SEO | Redirections | Inconnu | **P0** | SEO |
| Q78 | Quelles **polices** sont autorisées (licences) ? | Design | Assets | Figtree | P2 | Marque |

---

## 12. Matrice de blocage par phase

| Phase | Questions bloquantes | Conséquence si non répondu |
|---|---|---|
| A — Préparation | Q01, Q02, Q05, Q34, Q38, Q40, Q41, Q42, Q43, Q44, Q47, Q72, Q76, Q77 | Impossible de figer le périmètre et les assets |
| B — Fondation visuelle | Q41–Q46, Q49 | Impossible de remplacer le logo et les thèmes |
| C — Migration éditoriale | Q09–Q18, Q25–Q30, Q31–Q35, Q51, Q52, Q66 | Contenu non publiable |
| D — Pages | Q19–Q23, Q54–Q57, Q61–Q64 | Pages manquantes ou fausses |
| E — SEO/intégrations | Q31–Q38, Q67–Q77 | Risque de perte de trafic et d'e-mails |
| F — Qualité | Q62–Q65, Q73 | Recette incomplète |
| G — Production | Q38, Q40, Q67–Q73 | Déploiement risqué |

---

## 13. Hypothèses de travail à confirmer

Ces hypothèses permettent de rédiger le plan sans bloquer, mais **ne doivent pas être publiées** avant validation.

| # | Hypothèse | Conséquence si fausse |
|---|---|---|
| H1 | Le nom affiché sera « JMC Services S.P.R.L. » | Tous les textes, SEO, footer |
| H2 | Le domaine actuel sera conservé | Plan de redirection complet |
| H3 | Les 4 pages publiques seront conservées | Navigation et SEO |
| H4 | Les pages Réalisations/Carrières/Actualités seront retirées si non fournies | Liens morts supprimés |
| H5 | Le formulaire de contact sera implémenté | Backend/mail à créer |
| H6 | L'inscription publique sera fermée | Routes auth à restreindre |
| H7 | Figtree sera conservée | Design system |
| H8 | Le thème sombre sera activable | Refonte tokens |
| H9 | Les certifications/équipe ne seront publiées qu'après validation | Sections masquées |
| H10 | Les URLs existantes seront conservées | Redirections limitées |

---

## 14. Modèle de journal de décision

À remplir au fil des réponses :

| Date | ID | Question | Décision | Justification | Validé par | Impact |
|---|---|---|---|---|---|---|
| | Q01 | Nom exact | | | | |
| | Q05 | Continuité juridique | | | | |
| | Q19 | Taxonomie services | | | | |
| | Q38 | Domaine | | | | |
| | Q51 | Formulaire | | | | |
| | Q55 | Pages manquantes | | | | |
| | Q56 | Espace client | | | | |
| | Q58 | Thème sombre | | | | |

---

## 15. Ce qu'il ne faut pas faire en attendant les réponses

- ❌ Remplacer les coordonnées par des valeurs plausibles.
- ❌ Publier l'équipe, les certifications ou les projets actuels.
- ❌ Conserver l'histoire CCM par défaut.
- ❌ Créer des pages vides pour éviter les 404.
- ❌ Supprimer l'ancien nom des documents légaux/historiques sans arbitrage.
- ❌ Choisir un domaine à la place de la direction.
- ❌ Redessiner le logo.
- ❌ Inventer une mission, une vision ou des valeurs.

---

## 16. Critères de sortie

- [ ] Toutes les questions **P0** ont une réponse écrite.
- [ ] Les questions **P1** ont une réponse ou une décision de report explicite.
- [ ] Le journal de décision est rempli.
- [ ] Les hypothèses H1–H10 sont confirmées ou remplacées.
- [ ] Les assets de marque sont reçus et vérifiés.
- [ ] Les coordonnées officielles sont confirmées.
- [ ] Le périmètre des pages est arbitré.
- [ ] Le formulaire et sa conformité sont arbitrés.
- [ ] Le plan de redirection/SEO est validé.
