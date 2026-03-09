# Refonte — Votes (`business/listVotes.blade.php`)
> Date : 2026-03-08
> Vue : `resources/views/business/listVotes.blade.php`
> Layout : `@extends('refont.layout.app')`

---

## Avant
- Layout sidebar Bootstrap
- Stats : 2 boutons en haut (Nbre votes, Total)
- Filtre gauche : campagne, étape, dates, statut + bouton reset
- Tableau droit avec `onChange` auto-chargement

## Après — Structure body

```
[breadcrumb : Accueil › Sessions › Candidats › Votes]

Votes          ┌────────────────┐  ┌───────────────────────┐
               │ Nbre votes     │  │ Total                 │
               │ 290   [LIVE]   │  │ 58 000 FCFA  [FCFA]   │
               └────────────────┘  └───────────────────────┘

┌──────────────────────┬──────────────────────────────────────────┐
│ Filtrer              │  Historique des votes       N résultat(s) │
│                      │                                           │
│ Choisir la session ▾ │  SESSION │ ÉTAPE │ QTE │ MONTANT │ CANDIDAT│
│ Choisir l'étape   ▾  │  ──────────────────────────────────────── │
│ À partir du [date]   │  [lignes ou état vide]                    │
│ Jusqu'au    [date]   │                                           │
│ Statut            ▾  │                                           │
│                      │                                           │
│ [   Appliquer   ]    │                                           │
│ [ Réinitialiser ]    │                                           │
└──────────────────────┴──────────────────────────────────────────┘
```

---

## Composants spécifiques

### Stats pills (`.vt-stat-pills`)
| Classe | Description |
|---|---|
| `.vt-stat-pill` | Carte stat avec badge |
| `.vt-stat-pill-label` | Label "Nbre votes" / "Total" |
| `.vt-stat-pill-value` | Valeur grande (mis à jour AJAX) |
| `.vt-stat-pill-badge` | Badge orange "LIVE" / "FCFA" |

### Filtre gauche (`.vt-votes-filter`)
| Classe | Description |
|---|---|
| `.vt-filter-field-label` | Label orange |
| `.vt-filter-input-wrap` | Wrapper avec icône |
| `.vt-filter-select-icon` | Select avec chevron + icône gauche |
| `.vt-filter-date-icon` | Date input avec icône gauche |
| `.vt-btn-apply` | Bouton orange pleine largeur |
| `.vt-btn-reset` | Bouton outline pleine largeur |

### Tableau (`.vt-votes-table-card`)
- En-tête : "Historique des votes" + compteur résultats
- Colonnes : SESSION · ÉTAPE · QTE · MONTANT · CANDIDAT · DATE · STATUS
- `.cell-session` : texte orange bold (nom de session)
- `.vt-status-confirmed/pending/rejected` : badges colorés

---

## AJAX — Chargement votes
```javascript
// URL : route('business.recherche_vote')
// Params : campagne_id, etape_id, date_debut, date_fin, status
// Response : { html, total_votes, total_montant }
```

### Comportement
- `#filter-campagne` onChange → cascade étapes + loadVotes()
- `#btn-apply-filters` click → loadVotes()
- `#btn-reset-filters` click → reset tous champs + reset stats

---

## IDs importants
| ID | Rôle |
|---|---|
| `#filter-campagne` | Select session |
| `#filter-etape` | Select étape |
| `#filter-date-debut` | Date début |
| `#filter-date-fin` | Date fin |
| `#filter-status` | Statut |
| `#btn-apply-filters` | Bouton Appliquer |
| `#btn-reset-filters` | Bouton Réinitialiser |
| `#btn-total-votes` | Stat Nbre votes |
| `#btn-total-montant` | Stat Total FCFA |
| `#results-label` | "N résultat(s)" |
| `#votes-table-body` | Corps tableau |

## Variables passées par le contrôleur
```php
$campagnes   // [{campagne, ...}]
$etapes      // Collection Etape
```
