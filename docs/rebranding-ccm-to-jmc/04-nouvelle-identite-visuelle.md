# 04 — Nouvelle identité visuelle JMC

**Objet :** proposer un système de design cohérent avec le nouveau logo JMC (montagnes, soleil orange, lettres JMC, bleu foncé/orange/blanc), compatible avec l'architecture Tailwind 4 + daisyUI 5 existante.

> **Avertissement :** aucun logo JMC, aucune charte graphique et aucun code couleur officiel ne sont présents dans le dépôt. La palette ci-dessous est une **proposition provisoire**, construite sur les couleurs décrites dans la mission. Elle devra être recalibrée sur le SVG officiel (échantillonnage des aplats) avant validation finale. **Ne pas redessiner le logo.**

---

## 1. Principes directeurs

| Principe | Traduction concrète |
|---|---|
| **Institutionnel, pas décoratif** | Bleu marine dominant, blanc respirant, orange réservé au signal (CTA, accents, chiffres clés) |
| **Cohérence avec le logo** | Formes angulaires discrètes (montagnes), pas de dégradés arc-en-ciel, pas d'effets gratuits |
| **Lisibilité d'abord** | Contrastes AA minimum, texte secondaire suffisamment foncé, pas d'orange sur blanc |
| **Un seul système** | daisyUI + Tailwind existants ; pas de deuxième librairie, pas de CSS parallèle |
| **Sobriété du mouvement** | Animations courtes, utiles, désactivables via `prefers-reduced-motion` |
| **Photographie réelle** | Projets, équipes, chantiers ; aucune illustration générique en production |
| **Continuité technique** | Réutiliser `Section`, `Container`, les boutons, les cartes et les layouts existants |

### Positionnement visuel recommandé

> **« Le sérieux d'une entreprise de construction, la clarté d'un partenaire institutionnel. »**

Le bleu marine porte l'autorité et la stabilité. L'orange signal l'énergie, le soleil et l'action. Le blanc crée la respiration nécessaire à un site institutionnel. Les montagnes peuvent apparaître comme **motif géométrique discret** (séparateurs, filigrane), jamais comme une réinterprétation du logo.

---

## 2. Palette de couleurs

### 2.1 Palette primitive

| Token | HEX | Rôle |
|---|---|---|
| `navy-950` | `#061626` | Fond le plus sombre, footer, thème sombre |
| `navy-900` | `#0B2545` | **Bleu primaire de marque** |
| `navy-800` | `#123A63` | Surface élevée, boutons secondaires |
| `navy-700` | `#1B4C7E` | Bordures/hover en thème sombre |
| `navy-100` | `#DCE7F5` | Fond d'icônes, badges |
| `orange-600` | `#C2410C` | **Orange accessible pour texte/lien sur blanc** |
| `orange-500` | `#F97316` | **Orange d'accent / CTA** |
| `orange-400` | `#FB923C` | Accent en thème sombre |
| `orange-100` | `#FFEDD5` | Fond d'alerte douce |
| `orange-50` | `#FFF7ED` | Fond de section accent |
| `white` | `#FFFFFF` | Surface principale |
| `slate-50` | `#F8FAFC` | Fond de page alternatif |
| `slate-100` | `#F1F5F9` | Surface secondaire |
| `slate-200` | `#E2E8F0` | Bordures |
| `slate-300` | `#CBD5E1` | Bordures fortes, séparateurs |
| `slate-500` | `#64748B` | Texte discret (à utiliser avec prudence) |
| `slate-600` | `#475569` | Texte secondaire |
| `slate-700` | `#334155` | Texte fort |
| `slate-900` | `#0F172A` | Texte principal |
| `success-600` | `#15803D` | Succès |
| `warning-600` | `#B45309` | Avertissement |
| `error-600` | `#B91C1C` | Erreur |
| `info-600` | `#1D4ED8` | Information |

### 2.2 Rôles sémantiques — thème clair

| Rôle | HEX | Usage |
|---|---|---|
| Fond principal | `#FFFFFF` | `base-100` |
| Fond alternatif | `#F8FAFC` | `base-200`, sections grises |
| Surface élevée | `#F1F5F9` | `base-300`, cartes secondaires |
| Texte principal | `#0F172A` | `base-content` |
| Texte secondaire | `#475569` | Paragraphes, descriptions |
| Texte discret | `#64748B` | Légendes, métadonnées (≥ 16 px ou gras) |
| Bordure | `#E2E8F0` | Cartes, séparateurs |
| Primaire | `#0B2545` | Boutons principaux, header, footer |
| Sur primaire | `#FFFFFF` | Texte sur navy |
| Secondaire / accent | `#F97316` | CTA de conversion, chiffres clés, icônes |
| Sur accent | `#0B2545` | Texte sur orange |
| Lien | `#0B2545` | Liens sur fond clair |
| Lien hover | `#C2410C` | Survol |
| Succès | `#15803D` | Messages positifs |
| Avertissement | `#B45309` | Messages d'attention |
| Erreur | `#B91C1C` | Erreurs, suppressions |
| Information | `#1D4ED8` | Aides, informations |

### 2.3 Rôles sémantiques — thème sombre

| Rôle | HEX | Usage |
|---|---|---|
| Fond principal | `#061626` | `base-100` |
| Fond alternatif | `#0B2545` | `base-200` |
| Surface élevée | `#123A63` | `base-300` |
| Texte principal | `#F1F5F9` | `base-content` |
| Texte secondaire | `#CBD5E1` | Paragraphes |
| Texte discret | `#94A3B8` | Légendes |
| Bordure | `#1E3A5F` | Cartes, séparateurs |
| Primaire | `#2F6BA8` | Boutons principaux (navy éclairci pour rester visible) |
| Sur primaire | `#FFFFFF` | Texte sur primaire |
| Secondaire / accent | `#FB923C` | CTA, liens, accents |
| Sur accent | `#0B2545` | Texte sur orange |
| Lien | `#FDBA74` | Liens sur fond sombre |
| Lien hover | `#FED7AA` | Survol |
| Succès | `#4ADE80` | Messages positifs |
| Avertissement | `#FBBF24` | Messages d'attention |
| Erreur | `#F87171` | Erreurs |
| Information | `#60A5FA` | Aides |

> **Note daisyUI :** l'orange reste `secondary` dans les deux thèmes. Le navy devient `primary` en clair et une version éclaircie en sombre. Les CTA de conversion utilisent `secondary` (orange), pas `primary`.

---

## 3. Contrastes vérifiés (WCAG 2.1)

Seuils : **4,5:1** texte normal, **3:1** grand texte (≥ 24 px ou ≥ 18,66 px gras) et composants non textuels.

| Combinaison | Ratio | Verdict | Usage autorisé |
|---|---:|---|---|
| `#0B2545` sur `#FFFFFF` | **15,39** | AAA | Texte, titres |
| `#FFFFFF` sur `#0B2545` | **15,39** | AAA | Texte sur navy |
| `#0B2545` sur `#F8FAFC` | **14,71** | AAA | Texte sur fond alternatif |
| `#F1F5F9` sur `#0B2545` | **14,05** | AAA | Texte sombre sur navy |
| `#CBD5E1` sur `#0B2545` | **10,36** | AAA | Texte secondaire sombre |
| `#94A3B8` sur `#0B2545` | **6,00** | AA | Texte discret sombre |
| `#0B2545` sur `#F97316` | **5,49** | AA | Texte sur CTA orange |
| `#F97316` sur `#0B2545` | **5,49** | AA | Accent sur navy |
| `#FFFFFF` sur `#C2410C` | **5,18** | AA | Bouton orange foncé |
| `#C2410C` sur `#FFFFFF` | **5,18** | AA | Lien/texte orange |
| `#475569` sur `#FFFFFF` | **7,58** | AAA | Texte secondaire |
| `#475569` sur `#F8FAFC` | **7,24** | AAA | Texte secondaire |
| `#64748B` sur `#FFFFFF` | **4,76** | AA | Légendes |
| `#15803D` sur `#FFFFFF` | **5,02** | AA | Succès |
| `#B45309` sur `#FFFFFF` | **5,02** | AA | Avertissement |
| `#B91C1C` sur `#FFFFFF` | **6,47** | AA | Erreur |
| `#1D4ED8` sur `#FFFFFF` | **6,70** | AA | Information |
| `#F97316` sur `#FFFFFF` | **2,80** | ❌ | **Interdit en texte** |
| `#EA580C` sur `#FFFFFF` | **3,56** | ❌ normal / ✅ grand | À éviter en petit texte |
| `#6C757D` sur `#F8F9FA` (existant) | **4,45** | ❌ | Remplacer par `#475569` |
| `#FFFFFF` sur `#D4A843` (existant) | **2,21** | ❌ | Ne pas reproduire |
| `white/40` sur `#2C2C2C` (footer) | **3,54** | ❌ | Remplacer par `white/70` |

### Règles de contraste à appliquer

1. **Jamais d'orange `#F97316` en texte sur blanc.** Utiliser `#C2410C`.
2. **Texte sur orange** : toujours navy `#0B2545`, jamais blanc.
3. **Texte secondaire** : `#475569` sur fond clair, `#CBD5E1` sur fond sombre.
4. **Footer** : copyright en `white/70`, pas `white/40`.
5. **Focus** : anneau de 2 px, contraste ≥ 3:1 avec le fond adjacent. Sur fond navy, utiliser un anneau orange ou blanc.
6. **Icônes décoratives** : contraste non exigé, mais ne pas porter d'information seule.

---

## 4. Intégration daisyUI 5

### 4.1 Configuration cible recommandée

Remplacer, dans `resources/css/app.css` :

```css
@plugin "daisyui" {
    themes: light --default;
}
```

par :

```css
@plugin "daisyui" {
    themes: false;
}

@plugin "daisyui/theme" {
    name: "jmc-light";
    default: true;
    prefersdark: false;
    color-scheme: light;

    --color-base-100: #ffffff;
    --color-base-200: #f8fafc;
    --color-base-300: #e2e8f0;
    --color-base-content: #0f172a;

    --color-primary: #0b2545;
    --color-primary-content: #ffffff;
    --color-secondary: #f97316;
    --color-secondary-content: #0b2545;
    --color-accent: #c2410c;
    --color-accent-content: #ffffff;
    --color-neutral: #123a63;
    --color-neutral-content: #ffffff;

    --color-info: #1d4ed8;
    --color-info-content: #ffffff;
    --color-success: #15803d;
    --color-success-content: #ffffff;
    --color-warning: #b45309;
    --color-warning-content: #ffffff;
    --color-error: #b91c1c;
    --color-error-content: #ffffff;

    --radius-selector: 0.5rem;
    --radius-field: 0.5rem;
    --radius-box: 0.75rem;
    --size-selector: 0.25rem;
    --size-field: 0.25rem;
    --border: 1px;
    --depth: 0;
    --noise: 0;
}

@plugin "daisyui/theme" {
    name: "jmc-dark";
    default: false;
    prefersdark: true;
    color-scheme: dark;

    --color-base-100: #061626;
    --color-base-200: #0b2545;
    --color-base-300: #123a63;
    --color-base-content: #f1f5f9;

    --color-primary: #2f6ba8;
    --color-primary-content: #ffffff;
    --color-secondary: #fb923c;
    --color-secondary-content: #0b2545;
    --color-accent: #fdba74;
    --color-accent-content: #0b2545;
    --color-neutral: #123a63;
    --color-neutral-content: #f1f5f9;

    --color-info: #60a5fa;
    --color-info-content: #082f49;
    --color-success: #4ade80;
    --color-success-content: #052e16;
    --color-warning: #fbbf24;
    --color-warning-content: #451a03;
    --color-error: #f87171;
    --color-error-content: #450a0a;

    --radius-selector: 0.5rem;
    --radius-field: 0.5rem;
    --radius-box: 0.75rem;
    --size-selector: 0.25rem;
    --size-field: 0.25rem;
    --border: 1px;
    --depth: 0;
    --noise: 0;
}
```

> daisyUI 5 accepte le HEX ; les valeurs OKLCH sont également valides et recommandées si l'on veut des variations `color-mix` parfaites. La syntaxe `@plugin "daisyui/theme"` avec `default` et `prefersdark` est la syntaxe officielle daisyUI 5.

### 4.2 Pourquoi deux thèmes nommés `jmc-light` / `jmc-dark` ?

- Évite de dépendre des thèmes intégrés `light`/`dark` qui peuvent évoluer.
- Permet de documenter explicitement les rôles JMC.
- Permet un futur thème « haute saison » ou « campagne » sans casser le reste.
- `prefersdark: true` active automatiquement le thème sombre si l'OS le demande, sans JavaScript.

### 4.3 Variante du `dark:` Tailwind

daisyUI recommande de **ne pas utiliser `dark:` avec ses couleurs sémantiques**. Si des classes `dark:` subsistent (composants Breeze), définir un variant explicite :

```css
@custom-variant dark (&:where([data-theme="jmc-dark"], [data-theme="jmc-dark"] *));
```

➜ Objectif final : **supprimer les classes `dark:`** des composants métier et les remplacer par des tokens sémantiques. Le variant ne sert que de transition pour les composants Breeze non encore migrés.

---

## 5. Architecture CSS recommandée

### 5.1 Le problème actuel

Les composants utilisent `bg-[var(--color-ccm-blue)]`, `text-[var(--color-ccm-gray-600)]`, etc. Ces variables sont **mono-thème** : même si `data-theme` change, les valeurs ne changent pas.

### 5.2 Deux options

| Option | Description | Avantages | Inconvénients | Verdict |
|---|---|---|---|---|
| **A. Renommer les tokens** | `--color-ccm-blue` → `--color-jmc-blue` | Rapide, faible risque | Ne règle pas le thème sombre ; conserve des couleurs figées | ❌ Insuffisant seul |
| **B. Migrer vers les tokens sémantiques daisyUI** | `bg-[var(--color-ccm-blue)]` → `bg-primary`, `text-[var(--color-ccm-gray-600)]` → `text-base-content/70` | Thème clair/sombre automatique, moins de CSS, cohérent daisyUI | Touche 49 fichiers, demande une revue visuelle | ✅ **Recommandé** |
| **C. Hybride** | Renommer puis migrer progressivement | Progression sûre | Deux systèmes temporaires | ◐ Acceptable comme transition |

➜ **Recommandation : Option B**, avec une étape intermédiaire C pour ne pas bloquer les tests. La migration peut être mécanique par lots (layout → UI kit → sections → pages).

### 5.3 Table de correspondance des tokens

| Ancien token | Nouveau rôle sémantique | Exemple de classe |
|---|---|---|
| `--color-ccm-blue` | `primary` | `bg-primary`, `text-primary`, `border-primary` |
| `--color-ccm-blue-light` | `primary` hover / `primary/80` | `hover:bg-primary/90` |
| `--color-ccm-blue-dark` | `primary` foncé | `bg-[#071b31]` ou token `primary-strong` |
| `--color-ccm-yellow` | `secondary` | `bg-secondary`, `text-secondary` |
| `--color-ccm-yellow-light` | `secondary` hover | `hover:bg-secondary/90` |
| `--color-ccm-yellow-dark` | `accent` | `text-accent` |
| `--color-ccm-gray-50` | `base-200` | `bg-base-200` |
| `--color-ccm-gray-100` | `base-200` / `base-300` | `bg-base-200` |
| `--color-ccm-gray-200` | `base-300` | `border-base-300` |
| `--color-ccm-gray-300` | `base-300` | `border-base-300` |
| `--color-ccm-gray-400` | `base-content/40` | `text-base-content/40` |
| `--color-ccm-gray-500` | `base-content/60` | `text-base-content/60` |
| `--color-ccm-gray-600` | `base-content/70` | `text-base-content/70` |
| `--color-ccm-gray-700` | `base-content/80` | `text-base-content/80` |
| `--color-ccm-gray-900` | `base-content` | `text-base-content` |
| `--color-ccm-anthracite` | `neutral` | `bg-neutral`, `text-neutral-content` |

### 5.4 Rôles complémentaires à définir

daisyUI ne couvre pas tout. Ajouter, dans `@theme` puis surcharge par thème, quatre tokens utiles :

```css
@theme {
    --color-link: #0b2545;
    --color-link-hover: #c2410c;
    --color-muted: #475569;
    --color-border-subtle: #e2e8f0;
}

[data-theme="jmc-dark"] {
    --color-link: #fdba74;
    --color-link-hover: #fed7aa;
    --color-muted: #cbd5e1;
    --color-border-subtle: #1e3a5f;
}
```

➜ Génère `text-link`, `text-muted`, `border-border-subtle`. À utiliser pour les liens éditoriaux et les textes secondaires, afin de ne pas détourner `primary`/`secondary`.

### 5.5 Règles de codage

- ❌ Ne plus écrire de HEX dans les composants.
- ❌ Ne plus utiliser `text-gray-*`, `bg-white`, `text-black` dans les composants métier.
- ✅ Utiliser `bg-base-100`, `bg-base-200`, `text-base-content`, `border-base-300`, `bg-primary`, `bg-secondary`.
- ✅ Utiliser les opacités sémantiques (`text-base-content/70`) plutôt que des gris codés en dur.
- ✅ Centraliser les variantes de boutons dans `Components/ui/buttons/*`, pas dans les pages.

---

## 6. Thème clair / sombre — mise en œuvre

### 6.1 État actuel

- `@plugin "daisyui" { themes: light --default; }` : un seul thème.
- `useTheme.ts` écrit `data-theme="light|dark"` mais n'est **jamais appelé**.
- Aucun bouton de bascule.
- `body` force un fond clair et un texte foncé.
- Les classes `dark:` ne concernent que Breeze/Welcome.

### 6.2 Comportement cible

1. **Thème par défaut** : `jmc-light` (ou `jmc-dark` si `prefers-color-scheme: dark`).
2. **Bascule manuelle** dans le header : bouton soleil/lune, `aria-label` explicite, `aria-pressed`.
3. **Persistance** : `localStorage` (`jmc-theme`), avec respect de `prefers-color-scheme` si aucune préférence.
4. **Application avant peinture** : script inline minimal dans `app.blade.php` pour éviter le flash de thème clair.
5. **Synchronisation** : `useTheme` met à jour `document.documentElement.dataset.theme` et `color-scheme`.
6. **Logo** : variante claire sur fond clair, variante sombre sur fond sombre.
7. **Images** : pas de variante nécessaire, mais vérifier les overlays et les textes sur photos.
8. **Graphiques/illustrations** : couleurs sémantiques, pas de navy codé en dur.

### 6.3 Implémentation recommandée de `useTheme`

```ts
type ThemeMode = 'light' | 'dark'

const STORAGE_KEY = 'jmc-theme'
const theme = ref<ThemeMode>('light')

function resolveInitialTheme(): ThemeMode {
    const stored = localStorage.getItem(STORAGE_KEY)
    if (stored === 'light' || stored === 'dark') return stored
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
}

function applyTheme(mode: ThemeMode) {
    const daisyTheme = mode === 'dark' ? 'jmc-dark' : 'jmc-light'
    document.documentElement.setAttribute('data-theme', daisyTheme)
    document.documentElement.style.colorScheme = mode
    localStorage.setItem(STORAGE_KEY, mode)
}
```

➜ Le composable doit être initialisé **une seule fois** (au montage du layout public ou dans `app.ts`), pas à chaque appel.

### 6.4 Script anti-flash dans `app.blade.php`

```html
<script>
    (function () {
        const stored = localStorage.getItem('jmc-theme');
        const dark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.setAttribute('data-theme', dark ? 'jmc-dark' : 'jmc-light');
        document.documentElement.style.colorScheme = dark ? 'dark' : 'light';
    })();
</script>
```

> Ce script doit rester minuscule, sans dépendance, et être placé dans le `<head>` avant le CSS.

### 6.5 Points de vigilance

| Point | Risque | Mitigation |
|---|---|---|
| `body` avec couleurs fixes | Thème sombre inopérant | Remplacer par `bg-base-200 text-base-content` |
| Header `bg-white/70` | Devient blanc en sombre | `bg-base-100/80` |
| Footer `bg-anthracite` | Hors palette | `bg-neutral` ou `bg-[#061626]` |
| Ombres | Invisibles en sombre | Réduire, utiliser bordures `base-300` |
| Images avec overlay navy | Peuvent devenir trop sombres | Ajuster l'opacité selon le thème |
| Logo | Mauvais contraste | Variante dédiée |
| Focus | Anneau navy invisible sur navy | Anneau `secondary` ou blanc en sombre |

---

## 7. Typographie

### 7.1 Recommandation principale

**Conserver Figtree** comme famille unique, car :

- elle est déjà chargée et intégrée ;
- elle est moderne, lisible et neutre ;
- elle évite une dépendance supplémentaire ;
- elle fonctionne bien en institutionnel.

**Corrections nécessaires :**

- Ajouter la graisse **700** (et éventuellement 800 pour les grands titres).
- Auto-héberger les fichiers WOFF2 dans `public/fonts/` ou `resources/fonts/`.
- Déclarer `font-display: swap`.
- Précharger la graisse 400 et 700 utilisées above-the-fold.
- Supprimer la dépendance à `fonts.bunny.net` si l'auto-hébergement est retenu.

**Fallback :**

```css
--font-sans: 'Figtree', 'Inter', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif;
```

### 7.2 Option si une police officielle JMC existe

- Utiliser la police officielle pour les **titres uniquement** (H1–H2), et Figtree pour le corps.
- Ne pas charger plus de deux familles.
- Vérifier les licences web.
- Ne pas utiliser une police décorative pour les paragraphes.

### 7.3 Échelle typographique proposée

| Style | Desktop | Mobile | Graisse | Line-height |
|---|---|---|---|---:|
| Display | 56–64 px | 36–40 px | 700 | 1,05 |
| H1 | 48 px | 34 px | 700 | 1,1 |
| H2 | 36 px | 28 px | 700 | 1,2 |
| H3 | 28 px | 22 px | 600 | 1,3 |
| H4 | 22 px | 19 px | 600 | 1,35 |
| Corps | 16–18 px | 16 px | 400 | 1,6 |
| Petit | 14 px | 14 px | 400 | 1,5 |
| Légende | 12–13 px | 12 px | 500 | 1,4 |
| Eyebrow | 12 px | 12 px | 600 | 1,2, letter-spacing 0.08em, uppercase |

### 7.4 Règles

- Longueur de ligne : **60–75 caractères**.
- Pas de paragraphe en majuscules.
- Pas de texte justifié.
- Les titres peuvent être en `text-balance` ; les paragraphes en `text-pretty`.
- Les libellés de boutons sont des verbes d'action : « Demander un devis », « Nous contacter », « Voir nos services ».

---

## 8. Grille, espacements, formes

| Élément | Valeur recommandée |
|---|---|
| Largeur max | `1280px` (conserver) |
| Colonnes | 12 desktop, 4 mobile |
| Gouttière | 24 px mobile, 32 px desktop |
| Padding section | 64 px mobile, 96 px desktop |
| Padding carte | 24 px mobile, 32 px desktop |
| Rayon carte | 12 px |
| Rayon bouton/champ | 8 px |
| Bordure | 1 px `base-300` |
| Ombre | Très légère, réservée aux éléments flottants (header, dropdown, modal) |
| Séparateur | 1 px, jamais une ombre lourde |
| Icônes | Lucide, trait 1,75–2 px, taille 16/20/24 |

### Motif montagne

- Séparateur de section en angle doux (SVG local), très léger.
- Filigrane topographique dans le hero ou le footer.
- **Ne pas** reproduire le logo en grand, ni découper ses montagnes pour en faire un motif.
- Si le motif n'est pas fourni par la charte, rester sobre : une simple diagonale ou aucun motif suffit.

### Photo et overlays

- Overlay navy `#0B2545` à 70–85 % sur les photos de hero.
- Texte blanc sur overlay, contraste vérifié.
- Pas de texte blanc directement sur une photo claire.
- Pas de filtre coloré orange sur les photos (aspect « filtre Instagram »).

---

## 9. Système de logo

### 9.1 Fichiers à fournir par la direction

| Fichier attendu | Usage | Format |
|---|---|---|
| `jmc-logo-horizontal-light.svg` | Header/footer sur fond clair | SVG vectoriel |
| `jmc-logo-horizontal-dark.svg` | Header/footer sur fond sombre | SVG vectoriel |
| `jmc-mark.svg` | Favicon, avatar, petites tailles | SVG carré |
| `jmc-logo-horizontal-light.png` | Fallback email/vieil email | PNG 2x |
| `jmc-logo-horizontal-dark.png` | Fallback | PNG 2x |
| `jmc-mark-512.png` | PWA | PNG 512×512 |
| `jmc-mark-maskable-512.png` | PWA maskable | PNG 512×512 avec zone de sécurité |
| `jmc-og-1200x630.jpg` | Open Graph | JPG/WebP 1200×630 |

**Nommage proposé dans le dépôt :**

```text
resources/images/brand/
├── jmc-logo-horizontal-light.svg
├── jmc-logo-horizontal-dark.svg
├── jmc-mark.svg
├── jmc-logo-horizontal-light.png
├── jmc-logo-horizontal-dark.png
└── jmc-mark-512.png

public/
├── favicon.ico
├── favicon-16x16.png
├── favicon-32x32.png
├── apple-touch-icon.png
├── android-chrome-192x192.png
├── android-chrome-512x512.png
├── android-chrome-maskable-512x512.png
├── og/jmc-default-1200x630.jpg
└── site.webmanifest
```

### 9.2 Règles d'usage

- **Ne pas redessiner**, ne pas déformer, ne pas changer les proportions.
- Zone de protection : au moins la hauteur des lettres « JMC » ou 25 % de la hauteur du symbole.
- Taille minimale : symbole 24 px, logo horizontal 96 px de large.
- Sur photo : utiliser la version monochrome blanche (ou la version officielle prévue pour fonds chargés) avec un overlay suffisant.
- Ne pas placer le logo sur un fond orange saturé sans validation.
- Ne pas utiliser le logo comme élément décoratif répété.
- Toujours fournir un `alt` textuel : « JMC Services S.P.R.L. » (ou le nom officiel).
- Pour un logo purement décoratif (hero), utiliser `alt=""` et `aria-hidden="true"` afin d'éviter la répétition.

### 9.3 Emplacements et variantes

| Emplacement | Variante | Remarque |
|---|---|---|
| Header (fond clair) | `light` | Hauteur 40–48 px, lien vers `/` |
| Header (fond sombre) | `dark` | Hauteur 40–48 px |
| Footer (fond navy) | `dark` | Hauteur 40–48 px |
| Hero | `dark` si overlay navy | Souvent décoratif |
| Pages auth | `light` sur fond clair | Lien vers `/` |
| Favicon | `mark` | 16/32/48 |
| PWA | `mark` | 192/512 + maskable |
| Open Graph | logo + photo | 1200×630 |
| JSON-LD | URL absolue du logo | Champ `logo` de `Organization` |
| Emails transactionnels | `light` PNG | Si des emails sont ajoutés |

### 9.4 Composant recommandé

Créer `resources/js/Components/common/BrandLogo.vue` :

```vue
<script setup lang="ts">
type Variant = 'light' | 'dark' | 'auto'

withDefaults(defineProps<{
    variant?: Variant
    context?: 'header' | 'footer' | 'hero' | 'auth'
    alt?: string
}>(), {
    variant: 'auto',
    context: 'header',
    alt: 'JMC Services S.P.R.L.',
})
</script>
```

Le composant centralise :

- le choix de la variante ;
- les imports d'assets ;
- la taille selon le contexte ;
- l'`alt` ;
- le fallback PNG si nécessaire.

➜ Remplacer les 4 imports directs de logo (`Header`, `Footer`, `HeroBanner`, `ApplicationLogo`) par ce composant.

---

## 10. Favicon, manifest et Open Graph

### 10.1 Favicon

- Utiliser le symbole seul (montagnes/soleil/JMC), pas le logo horizontal.
- Vérifier la lisibilité à 16×16 : éviter les détails fins.
- Fournir `.ico` (16/32), PNG 16/32, Apple 180, Android 192/512, maskable.
- Ajouter `<meta name="theme-color">` avec `#0B2545` (ou `#061626` en sombre).
- Optionnel : favicon SVG avec `media="(prefers-color-scheme: dark)"`.

### 10.2 Manifest

```json
{
  "name": "JMC Services S.P.R.L.",
  "short_name": "JMC Services",
  "description": "[Description officielle courte]",
  "icons": [
    { "src": "/android-chrome-192x192.png", "sizes": "192x192", "type": "image/png" },
    { "src": "/android-chrome-512x512.png", "sizes": "512x512", "type": "image/png" },
    { "src": "/android-chrome-maskable-512x512.png", "sizes": "512x512", "type": "image/png", "purpose": "maskable" }
  ],
  "theme_color": "#0B2545",
  "background_color": "#FFFFFF",
  "display": "standalone",
  "lang": "fr"
}
```

### 10.3 Open Graph

- Image par défaut : 1200×630, logo + photo de chantier + baseline.
- Décliner par page si possible (services, à propos).
- Toujours renseigner `og:image`, `og:image:alt`, `og:site_name`, `og:locale`.
- Éviter les images générées à la volée sans cache.

---

## 11. Imagerie et iconographie

### 11.1 Photographies

| Type | Recommandation |
|---|---|
| Hero | Chantier réel, lumière naturelle, plan large, personnels identifiables avec accord |
| Services | Une photo par service, cohérente en cadrage et colorimétrie |
| Réalisations | Avant/après ou vue finale, légende avec lieu et année |
| Équipe | Portraits sobres, même fond, même cadrage (si publication validée) |
| Partenaires | Logos officiels, fond transparent, autorisation écrite |
| À propos | Équipe au travail, bureau, matériel, pas de banque d'images générique |

**Traitement :** saturation légèrement réduite, contraste naturel, pas de filtre orange. Formats : AVIF/WebP + fallback JPEG, tailles responsives, `width`/`height` corrects, `loading="lazy"` hors above-the-fold.

### 11.2 Icônes

- Conserver Lucide (`@lucide/vue`).
- Une seule taille par contexte (16, 20, 24).
- Trait 1,75–2 px.
- Ne pas mélanger icônes pleines et linéaires.
- Les icônes seules doivent avoir un `aria-label` si elles sont interactives.

### 11.3 Mouvement

| Interaction | Durée | Courbe |
|---|---:|---|
| Hover bouton/lien | 150–200 ms | ease-out |
| Ouverture menu | 200 ms | ease-out |
| Apparition section | 300–400 ms | ease-out, 20 px max |
| Compteur | 1,2–2 s | ease-out |
| Carrousel | 300 ms | ease-in-out |

- Respecter `prefers-reduced-motion: reduce` : désactiver translations, compteurs et carrousels automatiques.
- Ne pas animer le LCP (image hero) de façon bloquante.
- Pas de parallaxe lourde, pas de particules, pas de curseur personnalisé.

---

## 12. Matrice d'adaptation des composants

| Composant / fichier | Ce qui change | Priorité |
|---|---|---|
| `resources/css/app.css` | Thèmes daisyUI, tokens, base | **Critique** |
| `Components/layout/Header.vue` | Logo, wordmark, couleurs, CTA, hauteur, focus | **Critique** |
| `Components/layout/Footer.vue` | Logo sombre, fond navy, copyright, réseaux | **Critique** |
| `Components/ApplicationLogo.vue` | Remplacé par `BrandLogo` ou mis à jour | **Critique** |
| `Components/common/PageHeader.vue` | Fond navy, motif, contraste, support image optionnel | Haute |
| `Components/sections/HeroBanner.vue` | Logo, overlay, CTA, image réelle | Haute |
| `Components/sections/HeroSection.vue` | Couleurs ; vérifier s'il est encore utilisé | Moyenne |
| `Components/sections/CtaSection.vue` | Dégradé navy, bouton orange | Haute |
| `Components/sections/FeaturesSection.vue` | Titre paramétrable, couleurs | Haute |
| `Components/sections/StatisticsSection.vue` | Titre `COMPANY.name`, fond, contraste | Haute |
| `Components/sections/TeamSection.vue` | Titre, cartes, données validées | Haute |
| `Components/sections/CertificationGrid.vue` | Images réelles ou section retirée | Haute |
| `Components/sections/ProjectsCarousel.vue` | Images, liens, couleurs | Haute |
| `Components/sections/NewsSection.vue` | Images, liens, couleurs, décision | Haute |
| `Components/sections/PartnersCarousel.vue` | Logos réels, pause accessibilité | Moyenne |
| `Components/sections/ServiceCard.vue` | Couleurs, CTA, liens de détail | Haute |
| `Components/sections/ContactForm.vue` | Couleurs + implémentation fonctionnelle | **Critique** |
| `Components/sections/ContactCard.vue` | Coordonnées officielles | Haute |
| `Components/sections/GoogleMapPlaceholder.vue` | Carte réelle ou lien Maps | Moyenne |
| `Components/sections/FAQAccordion.vue` | Couleurs, icônes, focus | Moyenne |
| `Components/sections/CompanyHistory.vue` | Contenu validé, couleurs | Haute |
| `Components/sections/MissionSection.vue` | Couleurs, images | Moyenne |
| `Components/sections/ValuesGrid.vue` | Couleurs | Moyenne |
| `Components/sections/AboutPreviewSection.vue` | Image réelle, couleurs | Haute |
| `Components/sections/Section.vue` | Fonds sémantiques | Haute |
| `Components/ui/buttons/*` | Couleurs, focus, tailles | **Critique** |
| `Components/ui/inputs/*` | Couleurs, focus, erreurs | Haute |
| `Components/ui/cards/*` | Bordures, ombres, fond | Haute |
| `Components/ui/badges/*` | Couleurs sémantiques | Moyenne |
| `Components/ui/typography/*` | Couleurs, tailles | Haute |
| `Components/ui/navigation/Breadcrumb.vue` | Contraste sur fond navy | Haute |
| `Components/ui/overlays/Modal.vue` | Fond, ombre, focus | Moyenne |
| `Layouts/GuestLayout.vue` | Logo, fond, carte, français | Haute |
| `Layouts/AuthenticatedLayout.vue` | Logo, couleurs, navigation | Moyenne |
| `Layouts/ErrorLayout.vue` | Couleurs, logo, liens | Moyenne |
| `Pages/Auth/*` | Traduction FR, styles Breeze | Moyenne |
| `Pages/Profile/*`, `Dashboard.vue` | Traduction FR, styles | Basse/Moyenne |

---

## 13. Direction artistique par page

### Accueil

- Hero : photo réelle de chantier ou de réalisation, overlay navy, un titre court (6–8 mots), un sous-titre de 1–2 lignes, **un CTA principal** orange « Demander un devis » + un CTA secondaire « Découvrir nos services ».
- Supprimer le logo géant du hero s'il concurrence le titre ; le logo est déjà dans le header.
- Remplacer les 3 stats du hero par 3 preuves vérifiées, ou les supprimer.
- Section « Qui sommes-nous » : photo réelle + 3 valeurs maximum.
- Services : 4–6 services maximum, cartes sobres, pas de grille de 12 sur la homepage.
- Réalisations : 3–6 projets réels, avec lieu et catégorie.
- Chiffres : une seule source, 4 chiffres maximum.
- Partenaires : uniquement des logos autorisés.
- Actualités : 3 actualités récentes ou section supprimée.
- CTA final : navy, une phrase, un bouton.

### À propos

- Commencer par une phrase de positionnement claire, pas par l'histoire.
- Timeline uniquement si l'histoire est validée ; sinon remplacer par « Nos engagements ».
- Équipe : uniquement si les personnes et photos sont autorisées.
- Certifications : uniquement les certificats valides.
- Mission/vision : textes courts, validés.

### Services

- Taxonomie unique (4–6 familles).
- Chaque carte : icône, titre, 1 phrase, 3 livrables maximum.
- Pages de détail : contexte, prestations, méthode, preuves, CTA.
- Pas d'allégations non prouvées (garantie, certification, norme).
- FAQ courte et factuelle.

### Contact

- Formulaire fonctionnel, labels visibles, messages d'erreur clairs.
- Coordonnées officielles, horaires validés.
- Carte optionnelle avec consentement, ou lien « Ouvrir dans Google Maps ».
- Lien vers la politique de confidentialité sous le formulaire.
- Délai de réponse uniquement s'il est tenu.

### Auth / espace interne

- Logo, fond navy ou blanc, carte centrée.
- Traduction française.
- Si l'espace client n'est pas un produit réel, fermer l'inscription et retirer les promesses du README.

### Erreurs

- Logo, code HTTP, message utile, liens vers Accueil/Services/Contact.
- Pas de blague, pas d'illustration lourde.

---

## 14. Accessibilité — exigences de la nouvelle identité

| Exigence | Seuil |
|---|---|
| Contraste texte normal | ≥ 4,5:1 |
| Contraste grand texte | ≥ 3:1 |
| Contraste composants/focus | ≥ 3:1 |
| Navigation clavier | Tous les liens, boutons, accordéons, menus |
| Skip link | « Aller au contenu principal » |
| Langue | `lang="fr"` |
| Titres | Un seul H1 par page, hiérarchie continue |
| Images | `alt` pertinent ou `alt=""` si décoratif |
| Formulaires | Label lié, erreur annoncée, `aria-invalid`, `aria-describedby` |
| Mouvement | `prefers-reduced-motion` respecté |
| Thème sombre | Contrastes vérifiés dans les deux thèmes |
| Zoom | 200 % sans perte de contenu |
| Cibles tactiles | 44×44 px minimum |

### Corrections d'accessibilité à intégrer à la migration

- Ajouter un skip link dans `PublicLayout`.
- Remplacer `#6c757d` par `#475569` pour le texte secondaire.
- Remplacer `white/40` du copyright par `white/70`.
- Lier le label « Sujet » au `select` ( `for`/`id` ).
- Ajouter `aria-controls` au bouton de menu mobile.
- Éviter le double `alt="CCM SARL"` du logo hero.
- Ajouter `prefers-reduced-motion` aux animations et carrousels.
- Rendre le focus visible sur les fonds navy (anneau orange/blanc).
- Ne pas masquer le header au clavier sans raison.

---

## 15. Anti-patterns à proscrire

| Anti-pattern | Pourquoi |
|---|---|
| Créer un second système de composants | Doublon avec le kit UI existant |
| Redessiner le logo ou modifier ses proportions | Interdit sans autorisation |
| Utiliser l'orange `#F97316` en texte sur blanc | Contraste 2,8:1 |
| Blanc sur orange | Contraste 2,21:1 (or) / 2,8:1 (orange) |
| Dégradés multicolores, effets « glassmorphism » partout | Aspect générique, contraire au positionnement |
| Animations permanentes, parallaxe, particules | Distraction, performance, accessibilité |
| Photos de banque d'images génériques | Perte de crédibilité |
| Chiffres et certifications non vérifiés | Risque juridique |
| Icônes de styles différents | Incohérence visuelle |
| Texte en majuscules sur plusieurs lignes | Lisibilité |
| `dark:` avec les couleurs daisyUI | Le thème ne suit pas |
| HEX codés en dur dans les pages | Maintenance impossible |

---

## 16. Checklist de validation visuelle

- [ ] Le logo officiel est fourni en SVG, variantes claire/sombre.
- [ ] Le favicon et le manifest sont à jour.
- [ ] Les deux thèmes daisyUI sont définis et testés.
- [ ] Aucun token `ccm` ne subsiste.
- [ ] Aucun HEX codé en dur dans les composants métier.
- [ ] Les contrastes de la table § 3 sont respectés.
- [ ] Le texte secondaire est lisible (≥ 4,5:1).
- [ ] Le footer est lisible (copyright ≥ 4,5:1).
- [ ] Le focus est visible sur fond clair et sombre.
- [ ] Le logo reste lisible à 16 px (favicon) et 40 px (header).
- [ ] Les images réelles remplacent tous les `placehold.co`.
- [ ] Les animations respectent `prefers-reduced-motion`.
- [ ] Les deux thèmes sont testés sur les 4 pages publiques + auth + erreurs.
- [ ] Le rendu mobile 375 px est validé.
- [ ] Le rendu desktop 1280/1440 px est validé.
- [ ] Aucun composant ne dépend d'un fond blanc pour être lisible.

---

## 17. Ressources nécessaires

| Ressource | Bloquant ? | Utilisée par |
|---|---|---|
| Logo SVG clair | **Oui** | Header, auth, favicon, OG |
| Logo SVG sombre | **Oui** | Footer, hero, thème sombre |
| Symbole seul | **Oui** | Favicon, PWA, avatar |
| Charte couleur officielle | Haute | Palette finale |
| Charte typographique | Moyenne | Police |
| Photographies réelles | **Oui** | Toutes les pages |
| Logos partenaires autorisés | Moyenne | Carrousel |
| Certificats | Haute | Section certifications |
| Portraits équipe | Haute (si équipe publiée) | Section équipe |
| Image Open Graph | Haute | SEO social |

Voir [`06-informations-a-valider.md`](./06-informations-a-valider.md) pour la collecte.
