# Refonte — Dashboard (`business/index.blade.php`)
> Date : 2026-03-08
> Vue : `resources/views/business/index.blade.php`
> Layout : `@extends('refont.layout.app')`

---

## Avant
- Étend `layout.header.business` (sidebar gauche + topbar)
- 4 cartes stats Bootstrap (Campagnes, Campagnes actives, Etapes, Catégories)
- Pas de graphiques actifs

## Après — Structure body

```
[breadcrumb : Accueil › Tableau de bord]
[ligne déco orange centrée]

┌──────────────────┬──────────────────────────────────────────┐
│ FILTRER  [LIVE]  │  Tableau de bord          [Nouvelle sess]│
│                  │  Synthèse · performance · activité rés.  │
│ Session  ▾       │                                          │
│ Catégorie ▾      │  [stat] [stat] [stat] [stat]             │
│ Étape    ▾       ├──────────────────────────────────────────┤
│                  │  [Bar chart]  [Line chart]  [Donut]       │
│ ┌─────────────┐  ├──────────────────────────────────────────┤
│ │ Rappel :    │  │  Derniers votes           [Voir la liste] │
│ │ Commission  │  │  table headers + empty state             │
│ │ Prix unit.  │  └──────────────────────────────────────────┘
│ └─────────────┘
└──────────────────
```

---

## Composants spécifiques

### Panel filtre gauche (`.vt-filter-card`)
- `.vt-filter-header` : titre "FILTRER" + badge LIVE animé
- `.vt-filter-label` : labels orange
- `.vt-filter-select` : select avec chevron custom
- `.vt-filter-info` : box orange (Rappel / Commission / Prix unitaire)

### Stats (`.vt-stats-row`)
- Grid 4 colonnes avec séparateurs 1px
- `.vt-stat-item` : chaque stat (radio icon + label + valeur)

### Graphiques
| ID | Type | Librairie |
|---|---|---|
| `#chart-votes-jour` | Bar 7 jours | ApexCharts |
| `#chart-montant-jour` | Line 7 jours | ApexCharts |
| `#chart-votes-etapes` | Donut | ApexCharts |

### Tableau derniers votes (`.vt-table-card`)
- Colonnes : SESSION · ÉTAPE · QTÉ · MONTANT · CANDIDAT · DATE · STATUS
- État vide par défaut
- Lien "Voir la liste" → `route('business.list_vote')`

---

## Filtres dynamiques (TODO connecter)
```javascript
$('#filter-session').on('change', ...)  // Charge les étapes
$('#filter-etape').on('change', ...)    // Charge infos (commission, prix)
// Lignes commentées à décommenter et adapter à la route API
```

---

## IDs importants
| ID | Rôle |
|---|---|
| `#filter-session` | Select session |
| `#filter-etape` | Select étape |
| `#info-commission` | Span commission |
| `#info-prix` | Span prix unitaire |
| `#stat-etapes` | Compteur étapes |
| `#stat-candidats` | Compteur candidats |
| `#stat-votants` | Compteur votants |
| `#stat-montant` | Montant total votes |
| `#chart-votes-jour` | Container bar chart |
| `#chart-montant-jour` | Container line chart |
| `#chart-votes-etapes` | Container donut |
| `#table-derniers-votes` | Corps tableau votes |
