@extends('refont.layout.app')

@section('title', 'Retraits d\'argent')

{{-- ===== BREADCRUMB ===== --}}
@section('breadcrumb')
    <li><a href="{{ route('business.espace') }}"><i class="ti ti-home" style="font-size:13px;"></i>&nbsp;Accueil</a></li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li class="active">Retraits</li>
@endsection

{{-- ===== CSS SPÉCIFIQUE ===== --}}
@section('extra-css')
    <style>
        /* ---- En-tête ---- */
        .vt-ret-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .vt-ret-title {
            font-size: 32px;
            font-weight: 800;
            color: var(--vt-text-main);
            margin: 0;
            letter-spacing: -.5px;
        }

        /* ---- Layout ---- */
        .vt-ret-layout {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        /* ---- Colonne filtre gauche ---- */
        .vt-ret-filter {
            width: 268px;
            flex-shrink: 0;
            background: var(--vt-card-bg);
            border-radius: var(--vt-radius);
            box-shadow: var(--vt-shadow);
            padding: 20px 18px;
        }

        .vt-ret-filter-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--vt-text-main);
            margin: 0 0 16px;
        }

        .vt-ret-field-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--vt-orange);
            margin-bottom: 6px;
        }

        .vt-ret-input-wrap {
            position: relative;
            margin-bottom: 14px;
        }

        .vt-ret-input-wrap .ri-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 15px;
            pointer-events: none;
        }

        .vt-ret-select,
        .vt-ret-date {
            width: 100%;
            padding: 9px 30px 9px 34px;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            font-size: 13px;
            color: var(--vt-text-main);
            background: #fff;
            transition: border-color .15s;
        }

        .vt-ret-select {
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center / 15px;
            appearance: none;
            cursor: pointer;
        }

        .vt-ret-select:focus,
        .vt-ret-date:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        /* Solde cards */
        .vt-solde-immediate {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: var(--vt-radius-sm);
            padding: 14px 16px;
            margin-bottom: 8px;
        }

        .vt-solde-immediate .label {
            font-size: 11.5px;
            color: #166534;
            margin-bottom: 4px;
        }

        .vt-solde-immediate .value {
            font-size: 24px;
            font-weight: 800;
            color: #16a34a;
            display: flex;
            align-items: baseline;
            gap: 6px;
        }

        .vt-solde-immediate .value .unit {
            font-size: 12px;
            font-weight: 600;
        }

        .vt-solde-demande {
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            padding: 14px 16px;
            margin-bottom: 8px;
            background: #fff;
        }

        .vt-solde-demande .label {
            font-size: 11.5px;
            color: var(--vt-text-muted);
            margin-bottom: 4px;
        }

        .vt-solde-demande .value {
            font-size: 24px;
            font-weight: 800;
            color: var(--vt-text-main);
            display: flex;
            align-items: baseline;
            gap: 6px;
        }

        .vt-solde-demande .value .unit {
            font-size: 12px;
            font-weight: 600;
            color: var(--vt-text-muted);
        }

        .vt-solde-total {
            background: var(--vt-navy);
            border-radius: var(--vt-radius-sm);
            padding: 14px 16px;
            margin-bottom: 12px;
        }

        .vt-solde-total .label {
            font-size: 11.5px;
            color: rgba(255, 255, 255, .6);
            margin-bottom: 4px;
        }

        .vt-solde-total .value {
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            display: flex;
            align-items: baseline;
            gap: 6px;
        }

        .vt-solde-total .value .unit {
            font-size: 13px;
            font-weight: 600;
            opacity: .7;
        }

        .vt-retrait-remaining {
            font-size: 13px;
            color: var(--vt-text-muted);
            line-height: 1.5;
        }

        .vt-retrait-remaining strong {
            color: var(--vt-orange);
        }

        /* ---- Colonne droite (tableau) ---- */
        .vt-ret-main {
            flex: 1;
            min-width: 0;
        }

        .vt-ret-table-card {
            background: var(--vt-card-bg);
            border-radius: var(--vt-radius);
            box-shadow: var(--vt-shadow);
            overflow: hidden;
        }

        /* Barre de contrôles du tableau */
        .vt-ret-controls {
            padding: 16px 20px 14px;
            border-bottom: 1px solid var(--vt-border);
        }

        .vt-ret-controls-top {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }

        .vt-ret-hist-label {
            font-size: 14px;
            font-weight: 700;
            color: var(--vt-text-main);
            white-space: nowrap;
        }

        .vt-ret-ops-count {
            font-size: 12.5px;
            color: var(--vt-orange);
            font-weight: 600;
            margin-right: auto;
        }

        .vt-ctrl-group {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .vt-ctrl-label {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .5px;
            color: var(--vt-text-muted);
            text-transform: uppercase;
            white-space: nowrap;
        }

        .vt-ctrl-select {
            padding: 6px 24px 6px 9px;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 6px center / 13px;
            appearance: none;
            font-size: 12.5px;
            color: var(--vt-text-main);
            cursor: pointer;
            transition: border-color .15s;
        }

        .vt-ctrl-select:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        .vt-ctrl-date {
            padding: 6px 9px;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #fff;
            font-size: 12.5px;
            color: var(--vt-text-main);
            transition: border-color .15s;
        }

        .vt-ctrl-date:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        .vt-ctrl-search {
            padding: 6px 12px;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #fff;
            font-size: 12.5px;
            color: var(--vt-text-main);
            transition: border-color .15s;
            min-width: 200px;
        }

        .vt-ctrl-search::placeholder {
            color: #94a3b8;
        }

        .vt-ctrl-search:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        .vt-ret-controls-bottom {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Table */
        .vt-ret-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .vt-ret-table thead th {
            padding: 11px 16px;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .6px;
            text-transform: uppercase;
            color: var(--vt-text-muted);
            border-bottom: 1px solid var(--vt-border);
            white-space: nowrap;
        }

        .vt-ret-table tbody td {
            padding: 13px 16px;
            border-bottom: 1px solid var(--vt-border);
            color: var(--vt-text-main);
            vertical-align: middle;
        }

        .vt-ret-table tbody tr:last-child td {
            border-bottom: none;
        }

        .vt-ret-table tbody tr:hover td {
            background: #fafbfc;
        }

        .vt-ret-table .cell-ref {
            font-weight: 600;
            color: var(--vt-orange);
        }

        .vt-ret-table .cell-dest {
            font-weight: 600;
        }

        .vt-ret-table .cell-montant {
            font-weight: 700;
        }

        .vt-ret-empty {
            padding: 32px 16px;
            text-align: center;
            color: var(--vt-text-muted);
            font-size: 13px;
        }

        /* ---- MODAL "Demande de retrait" ---- */
        .vt-modal-retrait .modal-content {
            border-radius: 16px;
            border: none;
            overflow: hidden;
        }

        .vt-modal-retrait .modal-header {
            background: linear-gradient(to bottom, #fff7ed 0%, #ffffff 100%);
            border-bottom: 1px solid var(--vt-orange-border);
            padding: 18px 22px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .vt-modal-icon-wrap {
            width: 36px;
            height: 36px;
            background: var(--vt-orange-light);
            border: 1.5px solid var(--vt-orange-border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--vt-orange);
            flex-shrink: 0;
        }

        .vt-modal-retrait .modal-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--vt-text-main);
        }

        .vt-modal-retrait .modal-body {
            padding: 22px 22px 14px;
        }

        /* Champs modal */
        .vt-modal-field {
            margin-bottom: 16px;
        }

        .vt-modal-field label {
            font-size: 12px;
            font-weight: 600;
            color: var(--vt-text-muted);
            display: block;
            margin-bottom: 5px;
        }

        .vt-modal-input-wrap {
            position: relative;
        }

        .vt-modal-input-wrap .mi-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
        }

        .vt-modal-select,
        .vt-modal-input {
            width: 100%;
            padding: 9px 12px 9px 34px;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            font-size: 13px;
            color: var(--vt-text-main);
            background: #fff;
            transition: border-color .15s;
        }

        .vt-modal-select {
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center / 15px;
            appearance: none;
            cursor: pointer;
        }

        .vt-modal-select:focus,
        .vt-modal-input:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        .vt-modal-hint {
            font-size: 11.5px;
            color: var(--vt-text-muted);
            margin: 0px 0 12px;
        }

        .vt-modal-hint-orange {
            font-size: 12px;
            color: var(--vt-orange);
            margin: 4px 0 14px;
        }

        .vt-modal-retrait .modal-footer {
            padding: 14px 22px;
            border-top: 1px solid var(--vt-border);
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .vt-btn-modal-cancel {
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #fff;
            color: var(--vt-text-main);
            padding: 9px 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .vt-btn-modal-cancel:hover {
            border-color: #94a3b8;
        }

        .vt-btn-modal-confirm {
            background: var(--vt-orange);
            color: #fff;
            border: none;
            border-radius: var(--vt-radius-sm);
            padding: 9px 22px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .vt-btn-modal-confirm:hover {
            background: var(--vt-orange-hover);
        }

        @media (max-width: 860px) {
            .vt-ret-layout {
                flex-direction: column;
            }

            .vt-ret-filter {
                width: 100%;
            }

            .vt-ret-controls-top {
                flex-wrap: wrap;
            }
        }
    </style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

    {{-- En-tête --}}
    <div class="vt-ret-header">
        <h1 class="vt-ret-title">Retraits d'argent</h1>
        <button class="vt-btn-primary" style="border-radius: 50px; padding: 10px 22px;" data-bs-toggle="modal"
            data-bs-target="#modalRetrait">
            <i class="ti ti-plus" style="font-size:14px;"></i> Retirer de l'argent
        </button>
    </div>
    <div class="col-sm-12">@include('layout.status')</div>

    {{-- Layout deux colonnes --}}
    <div class="vt-ret-layout">

        {{-- =====================================================
             COLONNE GAUCHE — FILTRES + SOLDES
             ===================================================== --}}
        <div class="vt-ret-filter">
            <h2 class="vt-ret-filter-title">Filtrer</h2>

            {{-- Destination --}}
            <p class="vt-ret-field-label">Choisir la destination</p>
            <div class="vt-ret-input-wrap">
                <i class="ti ti-layout-list ri-icon"></i>
                <select class="vt-ret-select" id="filter-destination">
                    <option value="">Choisir la destination</option>
                    @foreach ($compteRetraits as $compte)
                        <option value="{{ $compte->withdrawal_account_id }}">{{ strtoupper($compte->account_name) }} -
                            {{ strtoupper($compte->payment_methode) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Date début --}}
            <p class="vt-ret-field-label">À partir du</p>
            <div class="vt-ret-input-wrap">
                <i class="ti ti-calendar ri-icon"></i>
                <input type="date" class="vt-ret-date" id="filter-date-debut" placeholder="jj/mm/aaaa">
            </div>

            {{-- Date fin --}}
            <p class="vt-ret-field-label">Jusqu'au</p>
            <div class="vt-ret-input-wrap">
                <i class="ti ti-calendar ri-icon"></i>
                <input type="date" class="vt-ret-date" id="filter-date-fin" placeholder="jj/mm/aaaa">
            </div>

            {{-- Soldes --}}
            <div class="vt-solde-immediate">
                <div class="label">Solde disponible immédiatement</div>
                <div class="value">
                    <span id="solde-immediat">0</span>
                    <span class="unit">FCFA</span>
                </div>
            </div>

            <div class="vt-solde-demande">
                <div class="label">Solde disponible sur demande</div>
                <div class="value">
                    <span id="solde-demande">170</span>
                    <span class="unit">FCFA</span>
                </div>
            </div>

            <div class="vt-solde-total">
                <div class="label">Solde total</div>
                <div class="value">
                    <span id="solde-total">170</span>
                    <span class="unit">FCFA</span>
                </div>
            </div>

            <p class="vt-retrait-remaining">
                Il vous reste <strong>10</strong> retrait(s) possible(s) aujourd'hui.
            </p>
        </div>

        {{-- =====================================================
             COLONNE DROITE — TABLEAU DES RETRAITS
             ===================================================== --}}
        <div class="vt-ret-main">
            <div class="vt-ret-table-card">

                {{-- Barre de contrôles --}}
                <div class="vt-ret-controls">
                    {{-- Ligne 1 --}}
                    <div class="vt-ret-controls-top">
                        <span class="vt-ret-hist-label">Historique des retraits</span>
                        <span class="vt-ret-ops-count" id="ops-count">0 opération</span>

                        <div class="vt-ctrl-group">
                            <span class="vt-ctrl-label">Statut</span>
                            <select class="vt-ctrl-select" id="ctrl-statut">
                                <option value="">Tous</option>
                                <option value="confirmed">Confirmé</option>
                                <option value="pending">En attente</option>
                                <option value="rejected">Rejeté</option>
                            </select>
                        </div>

                        <div class="vt-ctrl-group">
                            <span class="vt-ctrl-label">Destination</span>
                            <select class="vt-ctrl-select" id="ctrl-destination">
                                <option value="">Toutes</option>
                                @foreach ($compteRetraits as $compte)
                                    <option value="{{ $compte->withdrawal_account_id }}">
                                        {{ strtoupper($compte->account_name) }} - {{ strtoupper($compte->payment_methode) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="vt-ctrl-group">
                            <span class="vt-ctrl-label">Du</span>
                            <input type="date" class="vt-ctrl-date" id="ctrl-date-du">
                        </div>
                    </div>

                    {{-- Ligne 2 --}}
                    <div class="vt-ret-controls-bottom">
                        <div class="vt-ctrl-group">
                            <span class="vt-ctrl-label">Au</span>
                            <input type="date" class="vt-ctrl-date" id="ctrl-date-au">
                        </div>

                        <div class="vt-ctrl-group" style="flex:1;">
                            <span class="vt-ctrl-label">Recherche</span>
                            <input type="text" class="vt-ctrl-search" id="ctrl-search"
                                placeholder="Réf, destination, statut...">
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div style="overflow-x: auto;">
                    <table class="vt-ret-table" id="table-retraits">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Destination</th>
                                <th>Montant</th>
                                <th>Initié le</th>
                                <th>Traité le</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody id="retraits-tbody">
                            {{-- Données statiques de démo --}}
                            <tr>
                                <td class="cell-ref">RET-001</td>
                                <td class="cell-dest">Mara</td>
                                <td class="cell-montant">850 FCFA</td>
                                <td>11/09/2025</td>
                                <td class="text-muted" style="font-size:11.5px;">2025-09-11 11:35</td>
                                <td><span class="vt-status-confirmed"><i class="ti ti-check" style="font-size:10px;"></i>
                                        Confirmé</span></td>
                            </tr>
                            <tr>
                                <td class="cell-ref">RET-002</td>
                                <td class="cell-dest">MARA MOMO</td>
                                <td class="cell-montant">307 020 FCFA</td>
                                <td>04/05/2025</td>
                                <td class="text-muted" style="font-size:11.5px;">2025-05-04 23:37</td>
                                <td><span class="vt-status-confirmed"><i class="ti ti-check" style="font-size:10px;"></i>
                                        Confirmé</span></td>
                            </tr>
                            <tr>
                                <td class="cell-ref">RET-003</td>
                                <td class="cell-dest">MARA MOMO</td>
                                <td class="cell-montant">553 350 FCFA</td>
                                <td>04/05/2025</td>
                                <td class="text-muted" style="font-size:11.5px;">2025-05-04 17:20</td>
                                <td><span class="vt-status-confirmed"><i class="ti ti-check" style="font-size:10px;"></i>
                                        Confirmé</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

@endsection

{{-- =====================================================
     MODAL — DEMANDE DE RETRAIT
     ===================================================== --}}
<div class="modal fade vt-modal-retrait" id="modalRetrait" tabindex="-1" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content">

            {{-- Header avec gradient --}}
            <div class="modal-header">
                <div class="vt-modal-icon-wrap">
                    <i class="ti ti-plus"></i>
                </div>
                <h5 class="modal-title">Demande de retrait</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="ajax-form" action="{{ route('business.demande_retrait') }}" method="POST"
                    id="form-retrait">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ auth()->user()->customer->customer_id }}">
                    {{-- Destination --}}
                    <div class="vt-modal-field">
                        <label>Destination <span class="text-danger">*</span></label>
                        <div class="vt-modal-input-wrap">
                            <i class="ti ti-layout-list mi-icon"></i>
                            <select class="vt-modal-select" name="destination" required>
                                <option value="">Choisir la destination</option>
                                @foreach ($compteRetraits as $compte)
                                    <option value="{{ $compte->withdrawal_account_id }}">{{ strtoupper($compte->account_name) }} - {{ strtoupper($compte->payment_methode) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p class="vt-modal-hint">
                            Choisissez le compte de retrait (Mobile Money, Wave, etc.).
                        </p>
                    </div>

                    {{-- Montant + Motif --}}
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="vt-modal-field">
                                <label>Montant (FCFA) <span class="text-danger">*</span></label>
                                <div class="vt-modal-input-wrap">
                                    <i class="ti ti-currency-dollar mi-icon"></i>
                                    <input type="number" class="vt-modal-input" name="montant"
                                        placeholder="Ex : 10000" min="1" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-modal-field">
                                <label>Motif (optionnel)</label>
                                <div class="vt-modal-input-wrap">
                                    <i class="ti ti-calendar mi-icon"></i>
                                    <input type="text" class="vt-modal-input" name="motif"
                                        placeholder="Ex : Retrait campagne Z">
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="vt-modal-hint-orange">
                        Vos demandes de retrait apparaissent ici.
                    </p>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="vt-btn-modal-cancel" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="form-retrait" class="vt-btn-modal-confirm">
                    <i class="ti ti-check" style="font-size:13px;"></i> Confirmer
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ===== SCRIPTS ===== --}}
@section('extra-js')
    <script>
        $(document).ready(function() {

            /* -------------------------------------------------------
               Recherche en temps réel dans le tableau
               ------------------------------------------------------- */
            $('#ctrl-search').on('input', function() {
                const q = $(this).val().toLowerCase();
                let count = 0;
                $('#retraits-tbody tr').each(function() {
                    const text = $(this).text().toLowerCase();
                    const show = text.includes(q);
                    $(this).toggle(show);
                    if (show) count++;
                });
                updateOpsCount(count);
            });

            /* -------------------------------------------------------
               Filtre statut
               ------------------------------------------------------- */
            $('#ctrl-statut').on('change', function() {
                filterTable();
            });
            $('#ctrl-destination').on('change', function() {
                filterTable();
            });

            function filterTable() {
                const statut = $('#ctrl-statut').val().toLowerCase();
                const dest = $('#ctrl-destination').val().toLowerCase();
                let count = 0;
                $('#retraits-tbody tr').each(function() {
                    const rowStatut = $(this).find('td:last').text().toLowerCase();
                    const rowDest = $(this).find('td:nth-child(2)').text().toLowerCase();
                    const show = (!statut || rowStatut.includes(statut)) &&
                        (!dest || rowDest.includes(dest));
                    $(this).toggle(show);
                    if (show) count++;
                });
                updateOpsCount(count);
            }

            function updateOpsCount(n) {
                $('#ops-count').text(n + ' opération' + (n > 1 ? 's' : ''));
            }

            /* Compter au chargement */
            updateOpsCount($('#retraits-tbody tr').length);

        });
    </script>
@endsection
