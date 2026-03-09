# Refonte — Sessions (`business/listCampagnes.blade.php`)
> Date : 2026-03-08
> Vue : `resources/views/business/listCampagnes.blade.php`
> Layout : `@extends('refont.layout.app')`

---

## Avant
- Layout sidebar Bootstrap (`layout.header.business`)
- Tableau avec DataTables
- Colonnes : NOM DE CAMPAGNE · N° ETAPES · N° CANDIDATS · N° CATEGORIES · CRÉÉE LE · INSCRIPTION · Action

## Après — Structure body

```
[breadcrumb : Accueil › Sessions]

Sessions de votes
Gérez vos campagnes : étapes, candidats...

[0 sessions]  [🔍 Rechercher une session...]  [+ Nouvelle session]

┌──────────────────────────────────────────────────────────────┐
│  NOM DE SESSION  │ NBRE D'ÉTAPES │ NBRE DE CANDIDATS │ ...   │
├──────────────────────────────────────────────────────────────┤
│  [lignes ou état vide]                                        │
├──────────────────────────────────────────────────────────────┤
│  N affichée(s) · Données en direct         ‹ Page 1/1 ›      │
└──────────────────────────────────────────────────────────────┘
```

---

## Composants spécifiques

### Toolbar
| Classe | Description |
|---|---|
| `.vt-counter-pill` | Pill blanc : compte + "sessions" |
| `.vt-counter-num` | Nombre en bleu |
| `.vt-search-wrap` | Input search arrondi avec icône |
| `.vt-btn-dark` | Bouton navy pill "Nouvelle session" |

### Tableau sessions (`.vt-sessions-card`)
- Colonnes : NOM DE SESSION · NBRE D'ÉTAPES · NBRE DE CANDIDATS · CRÉÉE LE · INSCRIPTIONS · ACTIONS
- `.vt-session-name` : lien nom en uppercase bold
- `.vt-badge-on` / `.vt-badge-off` : badge inscription vert/gris
- `.vt-action-btns` : groupe boutons icônes (externe, éditer, options, supprimer)

### Pied de tableau (`.vt-table-footer`)
- Compteur "N affichée(s)"
- Pagination minimal : `‹ Page 1/1 ›`

---

## Recherche côté client
```javascript
$('#searchSession').on('input', function () {
    // Filtre les lignes .session-row par data-name
    // Met à jour le compteur #table-count
});
```

---

## Modales (conservées intactes)
| ID | Action |
|---|---|
| `#modal_add_campaign` | Créer une campagne (AJAX form) |
| `#modal_edit_campaign_{id}` | Modifier campagne (AJAX form, 1 modale par campagne) |
| `#delete_contact_{id}` | Supprimer campagne |
| `#modal_add_categorie` | Ajouter catégorie |

## Routes utilisées
| Route | Usage |
|---|---|
| `business.save_campagne` | POST créer campagne |
| `business.update_campagne` | POST modifier campagne |
| `business.delete_campagne` | DELETE supprimer campagne |
| `business.save_categorie` | POST créer catégorie |
| `business.site_campagne` | Voir site campagne (nouvel onglet) |
| `business.list_etape` | Voir étapes d'une campagne |

---

## Variables passées par le contrôleur
```php
$campagnes  // Collection : [{campagne, nbrEtape, nbrCandidat, nbrCategory}]
$customer   // Objet Customer
```
