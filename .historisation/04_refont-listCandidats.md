# Refonte — Candidats (`business/listCandidats.blade.php`)
> Date : 2026-03-08 / Mise à jour cartes : 2026-03-09
> Vue : `resources/views/business/listCandidats.blade.php`
> Layout : `@extends('refont.layout.app')`

---

## Avant
- Layout sidebar Bootstrap
- Colonne gauche : filtres (select campagne/étape/catégorie)
- Colonne droite : grille Bootstrap de cartes avec grand avatar

## Après — Structure body

```
[breadcrumb : Accueil › Sessions › Candidats]

Candidats                    [+ Créer]  [Importer ▾]  [Exporter]

┌──────────────────────┬───────────────────────────────────────────┐
│ CHOISIR LA SESSION   │  🔍 Rechercher un candidat ...            │
│ Session ▾            │                                           │
│ Toutes catégories ▾  │  [grille de cartes candidats via AJAX]    │
│ Toutes étapes ▾      │                                           │
│ ──────────────────   │         [Charger plus (20 / 31)]          │
│ Catégories       [+] │                                           │
│ Gérer les cat...     │                                           │
│ ┌───────────────┐    │                                           │
│ │ R  NOM CAT    │    │                                           │
│ │   0 candidat  │    │                                           │
│ └───────────────┘    │                                           │
│ [    Exporter    ]   │                                           │
└──────────────────────┴───────────────────────────────────────────┘
```

---

## Composants sidebar (`.vt-candidat-sidebar`)
| Classe | Description |
|---|---|
| `.vt-sidebar-section` | Bloc filtre session/catégorie/étape |
| `.vt-sidebar-section-title` | "CHOISIR LA SESSION" uppercase |
| `.vt-sidebar-select` | Select avec chevron custom |
| `.vt-sidebar-divider` | Séparateur |
| `.vt-cat-item` | Carte catégorie (avatar orange + nom + count) |
| `.vt-cat-avatar` | Cercle orange initiale |
| `.vt-cat-btn` | Bouton icône éditer/supprimer |
| `.vt-sidebar-export` | Bouton orange pleine largeur |

---

## Carte candidat — Design v2 (2026-03-09)

> **Mise à jour** : photo plus petite, meilleure organisation des informations

```
┌─────────────────────────────┐
│ # 001              [⋮]      │  ← overlay sur photo
│                             │
│    [photo 250px bandeau]    │  ← object-fit cover, object-position top
│                             │
├─────────────────────────────┤
│ NOM DU CANDIDAT             │  ← uppercase, tronqué
│ [📅 25 ans] [💼 Profession] │  ← pills compactes
├─────────────────────────────┤
│ 🎫 150 votes   [✏️]  [🗑️]  │  ← orange + actions iconiques
└─────────────────────────────┘
```

### Classes CSS cartes
| Classe | Description |
|---|---|
| `.vt-cand-card` | Conteneur carte flex colonne |
| `.vt-cand-photo-wrap` | Bandeau photo 250px |
| `.vt-cand-num` | Badge numéro overlay (coin haut-gauche) |
| `.vt-cand-menu` | Dropdown overlay (coin haut-droit) |
| `.vt-cand-no-photo` | Fallback initiale si pas de photo |
| `.vt-cand-body` | Corps : nom + pills méta |
| `.vt-cand-name` | Nom uppercase tronqué |
| `.vt-cand-meta-item` | Pill : icône + valeur |
| `.vt-cand-footer` | Pied : votes + actions |
| `.vt-cand-votes` | Compteur votes orange |
| `.vt-cand-action-btn.edit` | Bouton modifier (bleu hover) |
| `.vt-cand-action-btn.del` | Bouton supprimer (rouge hover) |

---

## AJAX — Chargement candidats
```javascript
// URL : /business/recherche_candidat
// Params : campagne_id, etape_id, category_id, search, page
// Response : { data: [...], current_page, last_page, total }
```

### Classes JS critiques (ne pas renommer)
| Classe | Rôle |
|---|---|
| `.js-select-campagne` | Select session (sidebar filtre) |
| `.js-select-etape` | Select étape (sidebar filtre) |
| `.js-select-categorie` | Select catégorie (sidebar filtre) |
| `.js-search-candidat` | Input recherche |
| `.js-candidat-table-body` | Container grille cartes |
| `.js-load-more` | Bouton charger plus |
| `.load-btn` | Wrapper bouton (show/hide) |
| `.js-add-campagne` | Select campagne (formulaire ajout) |
| `.js-add-etape` | Select étape (formulaire ajout) |
| `.js-add-categorie` | Select catégorie (formulaire ajout) |
| `.js-btn-save-candidat` | Bouton submit ajout |
| `.js-btn-edit` | Déclenche modale édition (data-candidat) |
| `.js-btn-delete` | Déclenche modale suppression (data-id) |
| `.js-btn-edit-cat` | Déclenche modale édition catégorie |
| `.js-btn-delete-cat` | Déclenche modale suppression catégorie |
| `.js-cat-item` | Item catégorie sidebar (filtrable) |

---

## Modales
| ID | Action |
|---|---|
| `#modal_add_candidat` | Créer candidat (AJAX form) |
| `#modal_edit_candidat` | Modifier candidat (AJAX form, rempli dynamiquement) |
| `#delete_contact` | Supprimer candidat |
| `#modal_add_categorie` | Créer catégorie |
| `#modal_edit_categorie` | Modifier catégorie |
| `#modal_delete_categorie` | Supprimer catégorie |

## Routes utilisées
| Route | Usage |
|---|---|
| `business.recherche_candidat` | GET AJAX chargement |
| `business.save_candidat` | POST créer |
| `business.update_candidat` | POST modifier |
| `business.delete_candidat` | DELETE supprimer |
| `business.save_categorie` | POST créer catégorie |
| `business.update_categorie` | POST modifier catégorie |
| `business.delete_categorie` | DELETE supprimer catégorie |

## Variables passées par le contrôleur
```php
$campagnes   // [{campagne, ...}]
$etapes      // Collection Etape
$categories  // Collection CategoryCampagne
```
