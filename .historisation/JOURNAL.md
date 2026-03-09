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

---

## État actuel des vues refontées

| Vue | Statut | Layout | Notes |
|---|---|---|---|
| `business/index` | ✅ Done | refont.layout.app | Graphiques init vides, filtres à connecter |
| `business/listCampagnes` | ✅ Done | refont.layout.app | Toutes modales conservées |
| `business/listCandidats` | ✅ Done | refont.layout.app | Cartes v2 (2026-03-09) |
| `business/listVotes` | ✅ Done | refont.layout.app | HTML lignes rendu côté serveur |
| `business/profile` | ✅ Done | refont.layout.app | 3 onglets, tabs custom JS |
| `business/listRetraits` | ✅ Done | refont.layout.app | Données statiques (TODO API) |

## Vues non refontées (hors scope actuel)

| Vue | Description |
|---|---|
| `business/listEtapesCampagne` | Étapes d'une campagne |
| `auth/*` | Pages de connexion/inscription |
| `siteCampagne/*` | Site public de vote |
| `console/*` | Espace admin console |
| `invoice/*` | Factures |
