# Journal des actions — VOTIUM Refont
> Toutes les sessions de travail, dans l'ordre chronologique.

---

## Session 1 — 2026-03-08

### ✅ Création du Design System (refont v1)
- **Fichier** : `resources/views/refont/layout/app.blade.php`
- **Fichier** : `resources/views/refont/partials/navbar.blade.php`
- **Action** : Nouveau layout avec navbar horizontale dark navy, variables CSS centralisées, composants réutilisables

### ✅ Refonte Dashboard (`business/index.blade.php`)
- **Avant** : Layout sidebar, 4 stat cards Bootstrap, pas de graphiques
- **Après** : Deux colonnes (filter panel + main), 4 stats inline, 3 graphiques ApexCharts (bar, line, donut), tableau derniers votes
- **Référence image** : Image du tableau de bord Votium promoteur

### ✅ Refonte Sessions (`business/listCampagnes.blade.php`)
- **Avant** : Tableau DataTables dans layout sidebar
- **Après** : Toolbar (compteur + recherche + CTA), tableau custom, pagination, recherche côté client
- **Référence image** : "Sessions de votes"

### ✅ Refonte Candidats (`business/listCandidats.blade.php`)
- **Avant** : Sidebar filtres + grille Bootstrap de grandes cartes
- **Après** : Sidebar (filtres + liste catégories + exporter), colonne droite (recherche + grille cartes AJAX), nouvelles modales catégories
- **Référence image** : "Candidats" avec sidebar catégories

### ✅ Refonte Votes (`business/listVotes.blade.php`)
- **Avant** : Stats boutons + filtre gauche onChange + tableau
- **Après** : Stats pills (LIVE/FCFA), filtre avec bouton "Appliquer" explicite, tableau avec barre de contrôles
- **Référence image** : "Votes" avec stats top

### ✅ Refonte Paramètres (`business/profile.blade.php`)
- **Avant** : Tabs Bootstrap en colonne droite, formulaires inline
- **Après** : Card centrale avec sidebar tabs (Entreprise / Comptes retrait / Profil), système de tabs custom JS, logo upload custom, grille comptes retrait
- **Référence images** : 3 images (onglet Entreprise, Comptes de retrait, Profil)

### ✅ Refonte Retraits (`business/listRetraits.blade.php`)
- **Avant** : Tableau statique, filtre simple, modal basique
- **Après** : Deux colonnes (filtre + soldes / barre contrôles + tableau), modal redessinée avec gradient orange
- **Référence images** : Image 9 (body) + Image 10 (modal)

---

## Session 2 — 2026-03-09

### ✅ Amélioration cartes candidats (`business/listCandidats.blade.php`)
- **Problème** : Photo trop grande, affichage peu organisé
- **Solution** : Redesign complet des cartes JS (`renderCandidatCards`)
  - Bandeau photo 250px (object-fit cover, object-position top)
  - Numéro badge en overlay coin haut-gauche
  - Menu dropdown en overlay coin haut-droit
  - Corps : nom uppercase tronqué + pills âge/profession
  - Pied : compteur votes orange + boutons d'action iconiques
  - Fallback initiale si pas de photo
- **Classes ajoutées** : `.vt-cand-card`, `.vt-cand-photo-wrap`, `.vt-cand-num`, `.vt-cand-body`, `.vt-cand-footer`, etc.

### ✅ Création du dossier `.historisation/`
- `README.md` : index des fichiers
- `JOURNAL.md` : ce fichier
- `01_design-system.md` : variables CSS + composants
- `02_refont-index.md` : dashboard
- `03_refont-listCampagnes.md` : sessions
- `04_refont-listCandidats.md` : candidats
- `05_refont-listVotes.md` : votes
- `06_refont-profile.md` : paramètres
- `07_refont-listRetraits.md` : retraits

### ✅ Refonte `listEtapesCampagne.blade.php`
- **Avant** : Layout sidebar Bootstrap, sélect campagne basique, tableau Bootstrap
- **Après** : Layout `refont.layout.app`, deux colonnes (filtre + tableau), stat pills (Nbre étapes + Session active), bouton Créer conditionnel, packages de vote redessinés (`.vt-pkg-row`), modales ajout/édition/suppression avec nouveau style
- **Référence image** : Design listVotes adapté pour les étapes

### ✅ Refonte modal "Nouvelle session" (`business/listCampagnes.blade.php`)
- **Avant** : Modal Bootstrap standard avec labels/inputs génériques
- **Après** : Header gradient crème/orange + icône "+" orange + titre + "×" circulaire, champs avec `.vt-ns-*` (labels uppercase, inputs avec icônes), options en cartes cliquables avec checkbox droite, radio pills [Clair/Pourcentage/Les deux], couleurs hex+swatch, section "Étape active" encadrée, footer sticky [Annuler / 💾 Valider]
- **Correctif CSS** : Style déplacé dans `@section('extra-css')` (était hors section → body)
- **Référence images** : 2 images du prototype Nouvelle session

### ✅ Refonte modal "Modifier session" (`business/listCampagnes.blade.php`)
- **Même design** que "Nouvelle session" appliqué à chaque modale `@foreach`
- IDs HTML unifiés : suffixe `{{ $cid }}` (campagne_id) sur tous les éléments pour éviter les conflits entre modales
- Pré-remplissage : couleurs, inscriptions, checkboxes, radios reflètent les valeurs réelles de la campagne
- **Correctif sélecteurs** : suppression du scope `#modal_add_campaign` → classes globales applicables aux deux modales

---

## Session 3 — 2026-03-10

### ✅ Refonte modal "Ajouter un candidat" (`business/listCandidats.blade.php`)
- **Avant** : Modal Bootstrap standard, grand avatar carré, champs simples sans icônes, layout monocolonne
- **Après** : Design "Demande de retrait" — gradient header crème/orange, icône "+" dans carré arrondi, titre "Ajouter un candidat", "×" circulaire
  - Zone photo compacte (52×52px, dashed border) avec bouton "Choisir" et bouton "Supprimer"
  - 3 sections séparées par `.vt-cm-section` (tiret avec texte uppercase) : **Identité** / **Contact** / **Candidature**
  - Tous les champs avec icône Tabler à gauche (`.vt-cm-icon` dans `.vt-cm-input-wrap`)
  - Selects avec même style (`.vt-cm-select`)
  - Message d'alerte étape manquante (`.vt-cm-hint`) à la place du `<small>` Bootstrap
  - Footer fixe : [Annuler] (outline) + [✓ Confirmer] (orange, `.vt-cm-btn-submit`)
- **CSS** : Injecté dans `@section('extra-css')` (lignes 627–693)
- **Classes JS conservées** : `.js-add-campagne`, `.js-add-etape`, `.js-add-categorie`, `.js-btn-save-candidat`, `.js-msg-no-etape`
- **Référence image** : Modal "Demande de retrait" de listRetraits

---

## Session 4 — 2026-03-13

### ✅ Refonte modal "Nouvelle étape" (`business/listEtapesCampagne.blade.php`)
- **Avant** : Modal Bootstrap standard, `modal-header` + `btn-close`, `form-control` génériques, footer inline dans le body
- **Après** : Design "Demande de retrait" — gradient header crème/orange, icône "+" dans carré arrondi (`.vt-ae-icon`), "×" circulaire (`.vt-ae-close`)
  - 3 sections séparées par `.vt-ae-section` (tiret + texte uppercase) : **Informations** / **Période** / **Vote**
  - Tous les champs avec icône Tabler à gauche (`.vt-ae-field-icon` dans `.vt-ae-input-wrap`)
  - Inputs stylisés (`.vt-ae-input`) avec border orange au focus
  - Grille 2 colonnes (`.vt-ae-row`) pour les paires date/heure
  - Footer sticky séparé du body : [Annuler] (outline `.vt-ae-btn-cancel`) + [✓ Confirmer] (orange `.vt-ae-btn-submit`)
  - Packages de vote (`.vt-pkg-*`) conservés à l'identique
- **CSS** : Classes `.vt-ae-*` ajoutées dans `@section('extra-css')`
- **Classes JS conservées** : `#form_add_step`, `#modal_add_campagne_id`, `.js-prix-unitaire`, `.js-package-votes`, `.js-package-amount`, `.packages-wrapper`, `.packages-container`, `.add-package`, `.remove-package`, `.package-itemadd`
- **Référence image** : Modal "Demande de retrait" de listRetraits

---

## Session 5 — 2026-03-13 (suite)

### ✅ Refonte modal "Modifier l'étape" (`business/listEtapesCampagne.blade.php`)
- **Avant** : Bootstrap standard, identique à l'ancien modal création
- **Après** : Même design `.vt-ae-*` que le modal création — header gradient, icône crayon, 3 sections (Informations / Période / Vote), footer sticky [Annuler] + [✓ Mettre à jour]
- **CSS** : Sélecteur `#modal_update_step .modal-content` et `.modal-body` ajoutés aux règles existantes (aucune duplication)
- **IDs conservés** : `upd_etape_id`, `upd_campagne_id`, `upd_name`, `upd_date_debut`, `upd_heure_debut`, `upd_date_fin`, `upd_heure_fin`, `upd_description`, `upd_prix_vote`, `.js-upd-packages-container`, `.js-add-package-upd`

---

## Session 5 — 2026-03-13

### ✅ Refonte modal "Ajouter un compte retrait" (`business/profile.blade.php`)
- **Avant** : Modal Bootstrap standard, `modal-header` + `btn-close`, `form-select` / `form-control` génériques, footer Bootstrap
- **Après** : Design "Demande de retrait" — gradient header crème/orange, icône "+" dans carré arrondi (`.vt-acr-icon`), "×" circulaire (`.vt-acr-close`)
  - 3 champs avec icône Tabler à gauche (`.vt-acr-field-icon` dans `.vt-acr-input-wrap`) : Type (select), Nom, Numéro
  - Select stylisé (`.vt-acr-select`) avec chevron custom et icône gauche
  - Footer : [Annuler] (outline `.vt-acr-btn-cancel`) + [✓ Confirmer] (orange `.vt-acr-btn-submit`)
- **CSS** : Classes `.vt-acr-*` ajoutées dans `@section('extra-css')` de `profile.blade.php`
- **Classes / attributs conservés** : `#add_bank`, `form.ajax-form`, `name="payment_methode"`, `name="account_name"`, `name="phone_number"`, `name="customer_id"`
- **Référence image** : Modal "Demande de retrait" de listRetraits

---

## Session 6 — 2026-03-15

### ✅ Refonte espace admin — Console (`console/index.blade.php`)
- **Avant** : `@extends('layout.header.console')`, contenu quasi vide (code commenté), layout Bootstrap sidebar
- **Après** : Même design system que l'espace promoteur
  - Nouveau layout `refont/layout/console.blade.php` (copie de `refont/layout/app.blade.php` avec `navbar_console`)
  - Nouveau partial `refont/partials/navbar_console.blade.php` : liens Accueil / Clients / Sessions / Paramètres + dropdown admin (initiale à la place du logo)
  - Dashboard deux colonnes (filtre gauche + contenu droit) identique au pattern business/index
  - 4 stats : Clients / Sessions / Candidats / Votes
  - 3 graphiques ApexCharts : Sessions par mois (barres orange), Clients actifs/inactifs (donut vert), Votes par session (barres bleues)
  - Tableau "Derniers clients enregistrés" avec avatar initiale, statut badge, lien détail
- **Bugfix inclus** : `ConsoleController::index()` plantait en cherchant `$customer` pour l'admin (n'existe pas) — lignes supprimées

### ✅ Refonte liste clients (`console/listCustomer.blade.php`)
- **Avant** : `@extends('layout.header.console')`, tableau DataTables Bootstrap, modales Bootstrap standard
- **Après** : Layout `refont.layout.console`, tableau custom `.vt-lc-table`, toolbar (compteur + recherche + CTA), badges statut
  - Modal `#modal_add_client` : header gradient, 3 sections (Compte / Entreprise / Réseaux sociaux), zone logo upload `.vt-ac-logo-zone`, grille sociale `.vt-social-grid`
  - Modales `@foreach` suppression : `.vt-delete-modal`, icône danger centrée
  - Modales `@foreach` création session par client : `.vt-campaign-modal`, 5 sections (Informations / Couverture / Options / Apparence / Document)
  - JS : recherche client-side, toggle inscription, preview logo/couverture, sync couleurs

### ✅ Refonte liste sessions (`console/listCampagnes.blade.php`)
- **Avant** : `@extends('layout.header.console')`, tableau DataTables Bootstrap, modales Bootstrap standard
- **Après** : Layout `refont.layout.console`, même pattern `.vt-lc-*` que listCustomer
  - Colonnes : Session / Promoteur / Étapes / Candidats / Créée le / Inscription / Actions
  - Modal `#modal_add_campaign` (unique) : header gradient icône `ti-calendar-plus`, 5 sections (Informations / Couverture / Options / Apparence / Document)
  - Modales `@foreach` édition `.vt-edit-campaign` : même design, icône crayon, pré-remplissage complet
  - Modales `@foreach` suppression `.vt-delete-modal` : design danger centré
  - JS : recherche client-side, toggle inscription/dates, preview couverture, sync couleurs swatch↔texte
- **Classes CSS conservées** : `.inscriptionSwitch`, `.blocDates`
- **Routes conservées** : `console.save_campagne`, `console.update_campagne`, `console.delete_campagne`, `console.site_campagne`

---

## État actuel des vues refontées

| Vue | Statut | Layout | Notes |
|---|---|---|---|
| `business/index` | ✅ Done | refont.layout.app | Graphiques init vides, filtres à connecter |
| `business/listCampagnes` | ✅ Done | refont.layout.app | Modales create + edit redessinées (v2) |
| `business/listCandidats` | ✅ Done | refont.layout.app | Cartes v2, modal ajout v2 (2026-03-10) |
| `business/listVotes` | ✅ Done | refont.layout.app | HTML lignes rendu côté serveur |
| `business/listEtapesCampagne` | ✅ Done | refont.layout.app | Stat pills, packages redessinés, modal ajout v2 (2026-03-13) |
| `business/profile` | ✅ Done | refont.layout.app | 3 onglets, tabs custom JS, modal ajout compte v2 (2026-03-13) |
| `business/listRetraits` | ✅ Done | refont.layout.app | Données statiques (TODO API) |
| `console/index` | ✅ Done | refont.layout.console | Dashboard admin, graphiques ApexCharts |
| `console/listCustomer` | ✅ Done | refont.layout.console | Tableau clients, 3 types de modales |
| `console/listCampagnes` | ✅ Done | refont.layout.console | Tableau sessions, modales create+edit+delete |

## Composants CSS transversaux créés

| Préfixe | Fichier source | Usage |
|---|---|---|
| `.vt-*` | `refont/layout/app.blade.php` | Design system global |
| `.vt-ns-*` | `business/listCampagnes @section('extra-css')` | Modales sessions business (create + edit) |
| `.vt-cand-*` / `.vt-cm-*` | `listCandidats @section('extra-css')` | Cartes candidats + modal ajout |
| `.vt-pkg-*` | `listEtapesCampagne @section('extra-css')` | Packages de vote |
| `.vt-ret-*` | `listRetraits @section('extra-css')` | Retraits (filtre + tableau) |
| `.vt-modal-retrait` | `listRetraits @section('extra-css')` | Modal demande retrait |
| `.vt-lc-*` | `console/listCustomer + listCampagnes` | Tableau + toolbar console (partagé) |
| `.vt-mhg-*` / `.vt-mf-*` / `.vt-mfooter-*` | `console/*` | Modales console (header gradient, champs, footer) |
| `.vt-del-*` | `console/*` | Modales de suppression |

## Vues non refontées (hors scope actuel)

| Vue | Description |
|---|---|
| `auth/*` | Pages de connexion/inscription |
| `siteCampagne/*` | Site public de vote |
| `console/detailCustomer` | Détail d'un client |
| `console/profile` | Profil admin |
| `console/editpasswordCustomer` | Changement MDP client |
| `console/detailCampagne` | Détail d'une session |
| `invoice/*` | Factures |
| Modal edit candidat | `business/listCandidats` — même design à appliquer |
