# Refonte — Retraits d'argent (`business/listRetraits.blade.php`)
> Date : 2026-03-08
> Vue : `resources/views/business/listRetraits.blade.php`
> Layout : `@extends('refont.layout.app')`

---

## Avant
- Layout sidebar Bootstrap
- Tableau statique (données hardcodées)
- Modal simple "Effectuer un retrait"

## Après — Structure body

```
[breadcrumb : Accueil › Retraits]

Retraits d'argent                          [+ Retirer de l'argent]

┌──────────────────────┬──────────────────────────────────────────────┐
│ Filtrer              │  Historique des retraits   0 opération        │
│                      │  STATUT ▾  DESTINATION ▾  DU [date]          │
│ Destination ▾        │  AU [date]  RECHERCHE [text input]           │
│ À partir du [date]   │  ────────────────────────────────────────────│
│ Jusqu'au    [date]   │  RÉFÉRENCE │ DESTINATION │ MONTANT │ STATUT  │
│                      │  RET-001   │ Mara        │ 850     │ ✓ Conf  │
│ ┌ Dispo imméd. ───┐  │                                               │
│ │ 0 FCFA (vert)   │  │                                               │
│ ├ Sur demande ────┤  │                                               │
│ │ 170 FCFA        │  │                                               │
│ ├ Total ──────────┤  │                                               │
│ │ 170 FCFA (navy) │  │                                               │
│ └─────────────────┘  │                                               │
│ Il reste 10 retraits │                                               │
└──────────────────────┴──────────────────────────────────────────────┘
```

---

## Composants spécifiques

### Filtre gauche (`.vt-ret-filter`)
| Classe | Description |
|---|---|
| `.vt-ret-filter-title` | "Filtrer" bold |
| `.vt-ret-field-label` | Label orange |
| `.vt-ret-input-wrap` | Wrapper icône + input |
| `.vt-ret-select` | Select destination |
| `.vt-ret-date` | Input date |
| `.vt-solde-immediate` | Card verte (Solde dispo immédiat) |
| `.vt-solde-demande` | Card blanche bordée (Sur demande) |
| `.vt-solde-total` | Card navy (Total) |
| `.vt-retrait-remaining` | "Il vous reste N retraits..." |

### Barre de contrôles tableau (`.vt-ret-controls`)
- **Ligne 1** : label + compteur opérations + STATUT + DESTINATION + DU
- **Ligne 2** : AU + RECHERCHE (full width)

### IDs filtres tableau
| ID | Rôle |
|---|---|
| `#ctrl-statut` | Filtre statut |
| `#ctrl-destination` | Filtre destination |
| `#ctrl-date-du` | Date début tableau |
| `#ctrl-date-au` | Date fin tableau |
| `#ctrl-search` | Recherche texte |
| `#ops-count` | "N opération(s)" |

### Tableau (`.vt-ret-table`)
- Colonnes : RÉFÉRENCE · DESTINATION · MONTANT · INITIÉ LE · TRAITÉ LE · STATUT
- `.cell-ref` : référence en orange
- `.cell-dest` : destination bold
- `.cell-montant` : montant bold
- `.vt-status-confirmed` : badge vert

### Filtrage JS côté client
```javascript
$('#ctrl-search').on('input', ...)   // Filtre texte sur toutes colonnes
$('#ctrl-statut').on('change', ...)  // Filtre statut
$('#ctrl-destination').on('change', ...) // Filtre destination
// Les filtres latéraux (destination, dates) sont indépendants (TODO API)
```

---

## Modal "Demande de retrait" (`#modalRetrait`)

> Classe `.vt-modal-retrait` appliquée sur `.modal`

### Design
- Header : gradient `linear-gradient(to bottom, #fff7ed, #ffffff)`
- Icône : carré orange arrondi avec `+`
- Titre : "Demande de retrait"

### Champs
| Champ | Type | Icône |
|---|---|---|
| Destination | Select | `ti-layout-list` |
| Montant (FCFA) | Number | `ti-currency-dollar` |
| Motif (optionnel) | Text | `ti-calendar` |

### Boutons footer
- "Annuler" → `.vt-btn-modal-cancel` (outline)
- "Confirmer" → `.vt-btn-modal-confirm` (orange, avec `✓`)

### Form action
```
action="#"  ← À connecter à la route de retrait
id="form-retrait"  ← Le bouton Confirmer utilise form="form-retrait"
```

---

## Variables passées par le contrôleur
> Actuellement le contrôleur `RetraitController::listRetrait()` ne passe que `$title`, `$title_back`, `$link_back`.
> Les données (soldes, retraits) sont statiques dans la vue — **à connecter** à un service backend.

## TODO Backend à connecter
- [ ] Charger les retraits réels via AJAX (route à créer)
- [ ] Charger les soldes depuis `VoteService`
- [ ] Connecter les filtres (destination, dates) au backend
- [ ] Connecter la modale "Demande de retrait" à une route POST
