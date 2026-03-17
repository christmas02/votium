Agis comme un architecte backend senior spécialisé en Laravel, systèmes de paiement et conception de ledger comptables robustes.

Je développe une plateforme appelée Votium qui gère des paiements liés à des campagnes de vote. Lorsqu’une transaction est complétée, un système de ledger doit générer automatiquement les écritures comptables correspondantes.

Je souhaite mettre en place un service de ledger exécuté par un Job Laravel (queue ou scheduler) qui va traiter automatiquement les transactions complétées et générer les écritures financières associées.

OBJECTIF

Créer un service qui :

- récupère les transactions complétées
- calcule les différentes commissions
- génère les écritures ledger
- met à jour les balances des comptes concernés
- marque la transaction comme comptabilisée

TABLE PRINCIPALE

transactions

CONDITIONS DE SELECTION

Le job doit récupérer toutes les transactions qui respectent :

status = "completed"
is_ecriture_comptable = 0

Ces transactions n'ont pas encore généré d’écriture comptable.

INFORMATIONS DISPONIBLES DANS LA TRANSACTION

Pour chaque transaction récupérer :

- transaction_id
- vote_id
- payment_method
- api_processing
- amount_paid

PROCESSUS METIER

1. Récupération des informations métier

À partir du vote_id :

- récupérer dans la table votes
- récupérer campaign_id

À partir de la campagne :

- récupérer dans campaigns
- récupérer customer_id

À partir du customer_id :

- récupérer dans accounts
- récupérer billing_rate (taux de facturation du client)

2. Récupération du partenaire de paiement

À partir des champs :

payment_method
api_processing

retrouver dans la table api_processing :

processing_rate

Ce taux correspond à la commission prélevée par le partenaire de paiement.

3. Calcul des montants

Montant brut payé :

amount_paid

Commission du partenaire :

processing_amount = amount_paid * processing_rate

Montant restant après processing :

amount_after_processing = amount_paid - processing_amount

Part du client :

customer_amount = amount_paid * billing_rate

Part de la plateforme Votium :

platform_amount = amount_after_processing - customer_amount

Ainsi :

amount_paid =
processing_amount +
customer_amount +
platform_amount

4. Création des écritures ledger

Pour chaque transaction, créer 3 écritures dans la table ledger_entries :

Écriture 1 : Commission partenaire

type = processing_fee
account_type = processing_partner
amount = processing_amount
transaction_id

Écriture 2 : Crédit client

type = customer_credit
account_type = customer
account_id = customer_id
amount = customer_amount
transaction_id

Écriture 3 : Revenu plateforme Votium

type = platform_revenue
account_type = platform
amount = platform_amount
transaction_id

5. Mise à jour des balances

Mettre à jour la balance du client :

accounts.balance = accounts.balance + customer_amount

Mettre à jour la balance de la plateforme :

platform.balance = platform.balance + platform_amount

6. Marquer la transaction comme traitée

is_ecriture_comptable = 1

ARCHITECTURE ATTENDUE

Je veux une implémentation Laravel propre avec :

Job Laravel :
ProcessLedgerTransactionsJob

Service métier :
LedgerServicePayment

Utiliser :

DB::transaction pour garantir la cohérence

Traitement optimisé avec :

chunk() ou cursor()

Gestion des logs :

Log::info pour chaque écriture créée

Gestion des erreurs :

retry automatique du job

BONNES PRATIQUES IMPORTANTES

- Le système doit être idempotent
- Ne jamais modifier une écriture ledger existante
- Toujours créer de nouvelles écritures
- Utiliser UUID pour les ledger_entries
- Ajouter un audit trail

STRUCTURE DE LA TABLE LEDGER_ENTRIES

Proposer une migration Laravel pour :

ledger_entries

avec :

id (uuid)
transaction_id
account_type
account_id nullable
entry_type
amount
description
created_at

LIVRABLE ATTENDU

Je veux :

- migration de ledger_entries
- code complet du Job Laravel
- code du LedgerService
- exemple d’utilisation de DB transactions
- requêtes Eloquent optimisées
- explication des choix d’architecture

Le code doit être prêt pour un système de paiement réel et scalable.