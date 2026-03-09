# Refonte — Paramètres du compte (`business/profile.blade.php`)
> Date : 2026-03-08
> Vue : `resources/views/business/profile.blade.php`
> Layout : `@extends('refont.layout.app')`

---

## Avant
- Layout sidebar Bootstrap
- Onglets Bootstrap (`tab-pane`) dans colonne droite
- Formulaires inline dans les onglets

## Après — Structure body

```
Paramètres du compte                              [Accueil]
Gérez votre entreprise, vos comptes de retrait et votre profil.

┌──────────────────┬────────────────────────────────────────────┐
│ 🏢 Entreprise    │  [contenu de l'onglet actif]               │
│                  │                                            │
│ 💳 Comptes de    │                                            │
│    retrait       │                                            │
│                  │                                            │
│ 👤 Profil        │                                            │
└──────────────────┴────────────────────────────────────────────┘
```

---

## Système de tabs custom (JS + CSS)

> Bootstrap tabs remplacés par un système CSS/JS maison pour correspondre au design.

```javascript
$('.vt-tab-btn').on('click', function () {
    const target = $(this).data('tab');
    // active le bon panel, désactive les autres
});
// Navigation par hash URL : #tab-retrait, #tab-profil
```

| Attribut | Valeur |
|---|---|
| `data-tab="tab-entreprise"` | Panel Entreprise |
| `data-tab="tab-retrait"` | Panel Comptes de retrait |
| `data-tab="tab-profil"` | Panel Profil |

---

## Onglet 1 — Entreprise (`#tab-entreprise`)

### Logo upload custom
| Élément | Description |
|---|---|
| `#logo-avatar-wrap` | Conteneur carré orange 48px |
| `#logo-preview` | `<img>` preview |
| `#logo-letter` | Initiale (fallback) |
| `.vt-btn-upload` | Bouton violet "Charger une image" avec `<input type="file">` |
| `#logo-del-btn` | Bouton rouge supprimer |
| `handleLogoPreview(input)` | JS preview FileReader |
| `handleLogoRemove()` | JS suppression preview |

### Champs (`.vt-field` + `.vt-input-wrap`)
- Nom organisation, Pays siège, Email, Téléphone, Adresse
- Réseaux : Facebook, Twitter/X, LinkedIn, Youtube, Tiktok, Site web
- Chaque champ a une icône Tabler à gauche

### Form action
```
POST → route('business.update_customer')
Champs cachés : user_id, customer_id, old_logo
```

---

## Onglet 2 — Comptes de retrait (`#tab-retrait`)

### Grille de comptes (`.vt-comptes-grid`)
- 3 colonnes, responsive 2→1
- Chaque `.vt-compte-card` : icône paiement + nom + numéro masqué (`••••••XXXX`)
- Bouton `×` ouvre modale vue détail
- Toggle switch activation/désactivation via AJAX

```javascript
// URL : route('business.delete_compte_retrait')
// Params : _token, account_id, is_active
```

### Modales
| ID | Action |
|---|---|
| `#add_paypal{id}` | Voir détails compte (lecture seule) + toggle switch |
| `#add_bank` | Ajouter compte retrait (AJAX form) |

---

## Onglet 3 — Profil (`#tab-profil`)

### Champs
- Nom (input text)
- Email (input email)
- Sécurité / Mot de passe (input password)

### Note informative
> "En V1 (front-only) : pas de vrai changement de mot de passe. En PHP, on branchera l'API + hashing."

### Form action
```
POST → route('business.update_profile')
Champs cachés : user_id, old_password
```

---

## Variables passées par le contrôleur
```php
$user           // Objet User (name, email, phonenumber, password, role)
$customer       // Objet Customer (entreprise, logo, email, phonenumber, pays_siege, adresse, link_*)
$paymentMethods // Enum PaymentMethod[] (cases)
$compteRetraits // Collection WithdrawalAccount
```

## Routes utilisées
| Route | Usage |
|---|---|
| `business.update_customer` | POST maj entreprise |
| `business.update_profile` | POST maj profil user |
| `business.save_compte_retrait` | POST créer compte retrait |
| `business.delete_compte_retrait` | POST activer/désactiver compte |
