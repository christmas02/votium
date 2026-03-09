# Design System — VOTIUM Refont v1
> Date : 2026-03-08
> Fichiers créés : `resources/views/refont/layout/app.blade.php`, `resources/views/refont/partials/navbar.blade.php`

---

## Objectif
Remplacer l'ancien layout sidebar (`layout.header.business`) par un système basé sur :
- Navbar horizontale dark navy fixée en haut
- Page body avec breadcrumb + contenu `@yield('content')`
- Variables CSS centralisées réutilisables dans toutes les vues de refonte

---

## Structure des fichiers créés

```
resources/views/refont/
├── layout/
│   └── app.blade.php          ← Layout de base (navbar + breadcrumb + contenu)
└── partials/
    └── navbar.blade.php       ← Barre de navigation horizontale isolée
```

---

## Variables CSS (`:root`)

| Variable | Valeur | Usage |
|---|---|---|
| `--vt-navy` | `#1a2535` | Fond navbar |
| `--vt-navy-dark` | `#111c2d` | Hover navbar |
| `--vt-orange` | `#f97316` | CTAs, accents, labels |
| `--vt-orange-hover` | `#ea6c0a` | Hover boutons orange |
| `--vt-orange-light` | `#fff7ed` | Fond info boxes |
| `--vt-orange-border` | `#fed7aa` | Bordures info boxes |
| `--vt-green` | `#16a34a` | Badge LIVE, statuts positifs |
| `--vt-green-light` | `#dcfce7` | Fond badge LIVE |
| `--vt-blue-chart` | `#60a5fa` | Couleur graphiques ApexCharts |
| `--vt-page-bg` | `#eef0f3` | Fond général de page |
| `--vt-card-bg` | `#ffffff` | Fond des cartes |
| `--vt-text-main` | `#1e293b` | Texte principal |
| `--vt-text-muted` | `#64748b` | Texte secondaire / labels |
| `--vt-border` | `#e2e8f0` | Bordures |
| `--vt-navbar-h` | `52px` | Hauteur navbar fixe |
| `--vt-radius` | `14px` | Border-radius cartes |
| `--vt-radius-sm` | `8px` | Border-radius champs / boutons |
| `--vt-shadow` | `0 1px 4px rgba(0,0,0,.07)` | Ombre légère |
| `--vt-shadow-md` | `0 4px 12px rgba(0,0,0,.08)` | Ombre medium |

---

## Composants CSS réutilisables (dans `app.blade.php`)

### Navbar
| Classe | Description |
|---|---|
| `.vt-navbar` | Barre fixe dark navy |
| `.vt-logo-circle` | Carré orange "V" |
| `.vt-nav-links` | Liste des liens centrés |
| `.vt-nav-links li.active a` | Lien actif |
| `.vt-nav-links li a.vt-nav-disabled` | Lien désactivé |
| `.vt-promoteur-btn` | Bouton profil orange pill |

### Layout & Breadcrumb
| Classe | Description |
|---|---|
| `.vt-breadcrumb-bar` | Conteneur breadcrumb |
| `.vt-breadcrumb` | Liste breadcrumb |
| `.vt-breadcrumb-sep` | Séparateur `›` |
| `.vt-deco-line` | Ligne déco orange centrée (optionnelle) |
| `.vt-page-body` | Zone de contenu paddinée |

### Tableaux
| Classe | Description |
|---|---|
| `.vt-table-card` | Carte table avec shadow |
| `.vt-table-header` | En-tête titre + action |
| `.vt-table` | Table sans Bootstrap |
| `.vt-table-empty` | Cellule état vide |

### Boutons
| Classe | Description |
|---|---|
| `.vt-btn-primary` | Orange pill (CTA principal) |

---

## Sections `@yield` disponibles

```blade
@extends('refont.layout.app')

@section('title', 'Titre de page')

{{-- Breadcrumb (obligatoire) --}}
@section('breadcrumb')
    <li><a href="...">Accueil</a></li>
    <li class="vt-breadcrumb-sep">›</li>
    <li class="active">Ma page</li>
@endsection

{{-- Ligne déco orange (optionnelle) --}}
@section('deco-line')@endsection

{{-- CSS page-spécifique --}}
@section('extra-css') <style>...</style> @endsection

{{-- Contenu --}}
@section('content') ... @endsection

{{-- Scripts page-spécifiques --}}
@section('extra-js') <script>...</script> @endsection
```

---

## Scripts JS inclus automatiquement (layout)
- jQuery 3.7.1
- Bootstrap Bundle 5
- DataTables + Bootstrap5
- Select2
- ApexCharts
- Gestionnaire global AJAX (`ajax-form`) avec gestion erreurs 422
