@extends('refont.layout.app')

@section('title', 'Sessions de votes')

{{-- ===== BREADCRUMB ===== --}}
@section('breadcrumb')
    <li>
        <a href="{{ route('business.espace') }}">
            <i class="ti ti-home" style="font-size:13px;"></i>&nbsp;Accueil
        </a>
    </li>
    <li class="vt-breadcrumb-sep">
        <i class="ti ti-chevron-right" style="font-size:11px;"></i>
    </li>
    <li class="active">Sessions</li>
@endsection

{{-- ===== CSS SPÉCIFIQUE ===== --}}
@section('extra-css')
<style>
    /* ---- Page header ---- */
    .vt-page-title {
        font-size: 28px; font-weight: 700;
        color: var(--vt-text-main); margin: 0 0 8px;
        letter-spacing: -.3px;
    }
    .vt-page-desc {
        font-size: 12.5px; color: var(--vt-text-muted);
        margin: 0 0 20px; max-width: 620px; line-height: 1.6;
    }

    /* ---- Toolbar ---- */
    .vt-toolbar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }
    .vt-counter-pill {
        display: inline-flex; align-items: center; gap: 7px;
        background: var(--vt-card-bg);
        border: 1px solid var(--vt-border);
        border-radius: 50px;
        padding: 7px 16px;
        font-size: 12.5px; font-weight: 600;
        color: var(--vt-text-main);
        box-shadow: var(--vt-shadow);
        white-space: nowrap;
    }
    .vt-counter-num {
        font-size: 13px; font-weight: 700;
        color: var(--vt-orange);
    }
    .vt-search-wrap {
        position: relative;
        flex: 1;
        max-width: 340px;
        min-width: 200px;
    }
    .vt-search-wrap .vt-search-icon {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: var(--vt-text-muted); font-size: 14px; pointer-events: none;
    }
    .vt-search-input {
        width: 100%;
        padding: 8px 14px 8px 36px;
        border: 1px solid var(--vt-border);
        border-radius: var(--vt-radius-sm);
        background: var(--vt-card-bg);
        font-size: 12.5px; color: var(--vt-text-main);
        box-shadow: var(--vt-shadow);
        transition: border-color .15s, box-shadow .15s;
        font-family: inherit;
    }
    .vt-search-input::placeholder { color: var(--vt-text-muted); }
    .vt-search-input:focus { 
        outline: none; 
        border-color: var(--vt-orange); 
        box-shadow: 0 0 0 3px var(--vt-orange-light), var(--vt-shadow);
    }

    .vt-btn-dark {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--vt-navy);
        color: #fff; border: none;
        border-radius: 50px;
        padding: 8px 18px;
        font-size: 12.5px; font-weight: 600;
        cursor: pointer; text-decoration: none;
        transition: background .15s, box-shadow .15s;
        white-space: nowrap;
        box-shadow: var(--vt-shadow);
    }
    .vt-btn-dark:hover { background: var(--vt-navy-dark); color: #fff; box-shadow: var(--vt-shadow-md); }

    /* ---- Sessions table card ---- */
    .vt-sessions-card {
        background: var(--vt-card-bg);
        border-radius: var(--vt-radius);
        box-shadow: var(--vt-shadow);
        overflow: hidden;
    }
    .vt-sessions-table {
        width: 100%; border-collapse: collapse;
    }
    .vt-sessions-table thead th {
        padding: 12px 16px;
        font-size: 10.5px; font-weight: 600;
        letter-spacing: .5px; text-transform: uppercase;
        color: var(--vt-text-muted);
        border-bottom: 1px solid var(--vt-border);
        background: var(--vt-card-bg);
        white-space: nowrap;
    }
    .vt-sessions-table tbody td {
        padding: 12px 16px;
        font-size: 12.5px; color: var(--vt-text-main);
        border-bottom: 1px solid var(--vt-border);
        vertical-align: middle;
    }
    .vt-sessions-table tbody tr:last-child td { border-bottom: none; }
    .vt-sessions-table tbody tr:hover { background: #f8fafc; }
    .vt-sessions-table tbody tr:hover td { background: transparent; }

    /* Lien nom de session */
    .vt-session-name {
        font-weight: 600; color: var(--vt-text-main);
        text-decoration: none; font-size: 12.5px;
        transition: color .15s;
    }
    .vt-session-name:hover { color: var(--vt-orange); text-decoration: underline; }

    /* Badge inscription */
    .vt-badge-on {
        display: inline-flex; align-items: center; gap: 4px;
        background: var(--vt-green-light); color: var(--vt-green);
        font-size: 11px; font-weight: 600;
        padding: 3px 10px; border-radius: 50px;
    }
    .vt-badge-on i { font-size: 10px; }
    .vt-badge-off {
        display: inline-flex; align-items: center; gap: 4px;
        background: #f1f5f9; color: var(--vt-text-muted);
        font-size: 11px; font-weight: 600;
        padding: 3px 10px; border-radius: 50px;
    }

    /* Boutons actions */
    .vt-action-btns { display: flex; align-items: center; gap: 4px; }
    .vt-action-btn {
        width: 32px; height: 32px;
        border-radius: var(--vt-radius-sm); border: 1px solid var(--vt-border);
        background: var(--vt-card-bg); color: var(--vt-text-muted);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 14px; cursor: pointer; text-decoration: none;
        transition: all .15s;
    }
    .vt-action-btn:hover { 
        border-color: var(--vt-text-muted); 
        color: var(--vt-text-main); 
        background: var(--vt-page-bg); 
    }
    .vt-action-btn.danger { color: #dc2626; }
    .vt-action-btn.danger:hover  { border-color: #fca5a5; background: #fff5f5; box-shadow: var(--vt-shadow); }
    .vt-action-btn.success { color: var(--vt-green); }
    .vt-action-btn.success:hover { border-color: #86efac; background: #f0fdf4; box-shadow: var(--vt-shadow); }
    .vt-action-btn.info { color: var(--vt-blue-chart); }
    .vt-action-btn.info:hover { border-color: #93c5fd; background: #eff6ff; box-shadow: var(--vt-shadow); }

    /* ---- Pied de tableau ---- */
    .vt-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        border-top: 1px solid var(--vt-border);
        font-size: 12px;
        color: var(--vt-text-muted);
        flex-wrap: wrap; gap: 8px;
        background: var(--vt-card-bg);
    }
    .vt-pagination {
        display: flex; align-items: center; gap: 3px;
    }
    .vt-pagination-btn {
        width: 28px; height: 28px;
        border-radius: var(--vt-radius-sm); border: 1px solid var(--vt-border);
        background: var(--vt-card-bg); color: var(--vt-text-muted);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 12px; cursor: pointer;
        transition: all .15s; text-decoration: none;
    }
    .vt-pagination-btn:hover { border-color: var(--vt-orange); color: var(--vt-orange); background: var(--vt-orange-light); }
    .vt-pagination-btn:disabled { opacity: .4; cursor: not-allowed; }
    .vt-pagination-label {
        padding: 0 8px;
        font-size: 11.5px; color: var(--vt-text-muted); font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .vt-toolbar { gap: 10px; margin-bottom: 16px; }
        .vt-search-wrap { min-width: 120px; }
        .vt-sessions-table { font-size: 11.5px; }
        .vt-sessions-table thead th,
        .vt-sessions-table tbody td { padding: 10px 12px; }
        .vt-action-btns { gap: 3px; }
    }
</style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

    {{-- Page header --}}
    <h1 class="vt-page-title">Sessions de votes</h1>
    <p class="vt-page-desc">
        Gérez vos campagnes : étapes, candidats, inscriptions, packs de votes et affichage (pourcentage / clair).
        Tout est modifiable par session.
    </p>

    <div class="col-sm-12">@include('layout.status')</div>

    {{-- Toolbar --}}
    <div class="vt-toolbar">

        {{-- Compteur --}}
        <div class="vt-counter-pill">
            <span class="vt-counter-num">{{ count($campagnes) }}</span>
            sessions
        </div>

        {{-- Recherche --}}
        <div class="vt-search-wrap">
            <i class="ti ti-search vt-search-icon"></i>
            <input type="text" id="searchSession" class="vt-search-input"
                   placeholder="Rechercher une session...">
        </div>

        {{-- Nouvelle session --}}
        <a href="javascript:void(0);" class="vt-btn-dark"
           data-bs-toggle="modal" data-bs-target="#modal_add_campaign">
            <i class="ti ti-plus" style="font-size:14px;"></i> Nouvelle session
        </a>

    </div>

    {{-- Tableau des sessions --}}
    <div class="vt-sessions-card">
        <div style="overflow-x: auto;">
            <table class="vt-sessions-table" id="sessions-table">
                <thead>
                    <tr>
                        <th style="width:40%;">Nom de session</th>
                        <th>Nbre d'étapes</th>
                        <th>Nbre de candidats</th>
                        <th>Créée le</th>
                        <th>Inscriptions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="sessions-tbody">
                    @forelse($campagnes as $item)
                    <tr class="session-row"
                        data-name="{{ strtolower($item['campagne']->name) }}">
                        <td>
                            <a href="{{ route('business.list_etape', [$customer->customer_id, $item['campagne']->campagne_id]) }}"
                               class="vt-session-name">
                                {{ $item['campagne']->name }}
                            </a>
                        </td>
                        <td>{{ $item['nbrEtape'] }}</td>
                        <td>{{ $item['nbrCandidat'] }}</td>
                        <td>{{ $item['campagne']->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($item['campagne']->inscription_isActive)
                                <span class="vt-badge-on">
                                    <i class="ti ti-check" style="font-size:11px;"></i> Autorisées
                                </span>
                            @else
                                <span class="vt-badge-off">Non‑autorisées</span>
                            @endif
                        </td>
                        <td>
                            <div class="vt-action-btns">
                                <a href="{{ route('business.site_campagne', [$item['campagne']->campagne_id]) }}"
                                   target="_blank"
                                   class="vt-action-btn success"
                                   title="Voir le site">
                                    <i class="ti ti-external-link"></i>
                                </a>
                                <a href="javascript:void(0);"
                                   class="vt-action-btn info"
                                   data-bs-toggle="modal"
                                   data-bs-target="#modal_edit_campaign_{{$item['campagne']->campagne_id}}"
                                   title="Modifier">
                                    <i class="ti ti-edit"></i>
                                </a>
                                @if($item['campagne']->inscription_isActive)
                                <a href="javascript:void(0);" class="vt-action-btn" title="Options">
                                    <i class="ti ti-menu-2"></i>
                                </a>
                                @endif
                                <a href="javascript:void(0);"
                                   class="vt-action-btn danger"
                                   data-bs-toggle="modal"
                                   data-bs-target="#delete_contact_{{$item['campagne']->campagne_id}}"
                                   title="Supprimer">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="6" style="padding: 20px; font-size:13px; color: var(--vt-text-muted);">
                            Aucune session trouvée.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pied de tableau --}}
        <div class="vt-table-footer">
            <span id="table-count">
                {{ count($campagnes) }} affichée(s) &bull; Données en direct
            </span>
            <div class="vt-pagination">
                <button class="vt-pagination-btn" disabled>
                    <i class="ti ti-chevron-left" style="font-size:12px;"></i>
                </button>
                <span class="vt-pagination-label">Page 1 / 1</span>
                <button class="vt-pagination-btn" disabled>
                    <i class="ti ti-chevron-right" style="font-size:12px;"></i>
                </button>
            </div>
        </div>

    </div>

@endsection

{{-- =====================================================
     MODALES (inchangées, juste déplacées hors du @section)
     ===================================================== --}}

{{-- Modale ajout campagne --}}
<div class="modal fade" id="modal_add_campaign" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter une nouvelle campagne</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="ajax-form" action="{{ route('business.save_campagne') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_form_id" value="form_create">

                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom de la campagne <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required placeholder="Ex: Élection Miss 2024">
                        </div>
                        <div class="col-md-12 mb-3">
                            <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Décrivez la campagne <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="4" name="description" required></textarea>
                        </div>
                    </div>

                    <div class="mb-4 image-upload-group">
                        <label class="form-label fw-bold">Image de couverture <span class="text-danger">*</span></label>
                        <p class="text-muted small">Format recommandé : 1920x1080px | Max : 2 Mo</p>
                        <div class="position-relative w-100 rounded border border-dashed bg-light d-flex align-items-center justify-content-center overflow-hidden drop-zone-target"
                            style="height: 250px; border-width: 2px !important; transition: all 0.3s ease;">
                            <div class="text-center p-4 placeholder-target">
                                <div class="avatar avatar-lg bg-white border rounded-circle mb-2 mx-auto">
                                    <i class="ti ti-cloud-upload text-primary fs-3"></i>
                                </div>
                                <h6 class="mb-1 fw-bold">Glissez une image ou cliquez</h6>
                            </div>
                            <img src="#" alt="Aperçu" class="preview-target position-absolute top-0 start-0 w-100 h-100 object-fit-cover d-none">
                            <input type="file" name="image_couverture"
                                class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                accept="image/*" onchange="handleImagePreview(this)">
                        </div>
                        <div class="d-flex justify-content-end mt-1">
                            <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none d-none remove-btn-target" onclick="handleImageRemove(this)">
                                <i class="ti ti-trash me-1"></i> Supprimer l'image
                            </button>
                        </div>
                    </div>

                    <hr class="my-4 border-secondary opacity-10">

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" role="switch" id="textCoverSwitch" name="text_cover_isActive" value="1">
                            <label class="form-check-label" for="textCoverSwitch">Texte sur le cover</label>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" role="switch" id="identifiants_personnalises_isActive" name="identifiants_personnalises_isActive" value="1">
                            <label class="form-check-label" for="identifiants_personnalises_isActive">Identifiants candidats personnalisés</label>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input inscriptionSwitch" type="checkbox" role="switch" id="inscriptionSwitchNew" name="inscription_isActive" value="1">
                                    <label class="form-check-label fw-medium" for="inscriptionSwitchNew">Autoriser les inscriptions</label>
                                </div>
                            </div>
                            <div id="blocDatesNew" class="blocDates d-none">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Date de début</label>
                                        <input type="date" class="form-control" name="inscription_date_debut">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Date de fin</label>
                                        <input type="date" class="form-control" name="inscription_date_fin">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Heure de début</label>
                                        <input type="time" class="form-control" name="heure_debut_inscription">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Heure de fin</label>
                                        <input type="time" class="form-control" name="heure_fin_inscription">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Afficher les montants en pourcentage (%)</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="option1" value="clair" checked>
                                <label class="btn btn-outline-secondary" for="option1">Clair</label>
                                <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="option2" value="pourcentage">
                                <label class="btn btn-outline-secondary" for="option2">Pourcentage</label>
                                <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="option3" value="les_deux">
                                <label class="btn btn-outline-secondary" for="option3">Les deux</label>
                            </div>
                        </div>
                        <div class="bg-light p-3 rounded mb-3">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="ordonner_candidats_new" name="ordonner_candidats_votes_decroissants" value="1">
                                <label class="form-check-label" for="ordonner_candidats_new">Ordonner les candidats par votes décroissants</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Couleur Primaire</label>
                            <input type="color" class="form-control form-control-color" name="color_primaire" value="#000" title="Choisir">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Couleur Secondaire</label>
                            <input type="color" class="form-control form-control-color" name="color_secondaire" value="#000" title="Choisir">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Condition de participation (Document) <span class="text-danger">*</span></label>
                            <input type="file" name="condition_participation" class="form-control" accept=".pdf">
                        </div>
                    </div>

                    <div class="modal-footer border-top px-0 pb-0 mt-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-check me-1"></i> Créer la campagne</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modales édition --}}
@foreach($campagnes as $item)
<div class="modal fade" id="modal_edit_campaign_{{$item['campagne']->campagne_id}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Modifier : {{$item['campagne']->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="ajax-form" action="{{ route('business.update_campagne') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="campagne_id" value="{{ $item['campagne']->campagne_id }}">
                    <input type="hidden" name="old_image_couverture" value="{{ $item['campagne']->image_couverture }}">
                    <input type="hidden" name="old_condition_participation" value="{{ $item['campagne']->condition_participation }}">

                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom de la campagne <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required value="{{$item['campagne']->name}}">
                        </div>
                        <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">
                        <div class="col-md-12">
                            <label class="form-label">Décrivez la campagne <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="4" name="description" required>{{ $item['campagne']->description }}</textarea>
                        </div>
                    </div>

                    <div class="mb-4 image-upload-group">
                        <label class="form-label fw-bold">Image de couverture <span class="text-danger">*</span></label>
                        <p class="text-muted small">Format recommandé : 1920x1080px | Max : 2 Mo</p>
                        <div class="position-relative w-100 rounded border {{ $item['campagne']->image_couverture ? 'border-primary' : 'border-dashed' }} bg-light d-flex align-items-center justify-content-center overflow-hidden drop-zone-target"
                            style="height: 250px; border-width: 2px !important; transition: all 0.3s ease;">
                            <div class="text-center p-4 placeholder-target {{ $item['campagne']->image_couverture ? 'd-none' : '' }}">
                                <div class="avatar avatar-lg bg-white border rounded-circle mb-2 mx-auto">
                                    <i class="ti ti-cloud-upload text-primary fs-3"></i>
                                </div>
                                <h6 class="mb-1 fw-bold">Glissez une image ou cliquez</h6>
                            </div>
                            <img src="{{ $item['campagne']->image_couverture ? env('IMAGES_PATH').'/'.$item['campagne']->image_couverture : '#' }}"
                                alt="Aperçu"
                                class="preview-target position-absolute top-0 start-0 w-100 h-100 object-fit-cover {{ $item['campagne']->image_couverture ? '' : 'd-none' }}">
                            <input type="file" name="image_couverture"
                                class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                accept="image/*" onchange="handleImagePreview(this)">
                        </div>
                        <div class="d-flex justify-content-end mt-1">
                            <button type="button"
                                class="btn btn-sm btn-link text-danger text-decoration-none remove-btn-target {{ $item['campagne']->image_couverture ? '' : 'd-none' }}"
                                onclick="handleImageRemove(this)">
                                <i class="ti ti-trash me-1"></i> Supprimer l'image
                            </button>
                        </div>
                    </div>

                    <hr class="my-4 border-secondary opacity-10">

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" role="switch" name="text_cover_isActive" value="1" {{ $item['campagne']->text_cover_isActive ? 'checked' : '' }}>
                            <label class="form-check-label">Texte sur le cover</label>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" role="switch" name="identifiants_personnalises_isActive" value="1" {{ $item['campagne']->identifiants_personnalises_isActive ? 'checked' : '' }}>
                            <label class="form-check-label">Identifiants candidats personnalisés</label>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input inscriptionSwitch" type="checkbox" role="switch" name="inscription_isActive" value="1" {{ $item['campagne']->inscription_isActive ? 'checked' : '' }}>
                                    <label class="form-check-label fw-medium">Autoriser les inscriptions</label>
                                </div>
                            </div>
                            <div class="blocDates {{ $item['campagne']->inscription_isActive ? '' : 'd-none' }}">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Date de début</label>
                                        <input type="date" class="form-control" name="inscription_date_debut" value="{{ $item['campagne']->inscription_date_debut }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Date de fin</label>
                                        <input type="date" class="form-control" name="inscription_date_fin" value="{{ $item['campagne']->inscription_date_fin }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Heure de début</label>
                                        <input type="time" class="form-control" name="heure_debut_inscription" value="{{ $item['campagne']->heure_debut_inscription }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Heure de fin</label>
                                        <input type="time" class="form-control" name="heure_fin_inscription" value="{{ $item['campagne']->heure_fin_inscription }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Afficher les montants en pourcentage (%)</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="clair{{ $item['campagne']->campagne_id }}" value="clair" {{ $item['campagne']->afficher_montant_pourcentage == 'clair' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary" for="clair{{ $item['campagne']->campagne_id }}">Clair</label>
                                <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="pourcentage{{ $item['campagne']->campagne_id }}" value="pourcentage" {{ $item['campagne']->afficher_montant_pourcentage == 'pourcentage' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary" for="pourcentage{{ $item['campagne']->campagne_id }}">Pourcentage</label>
                                <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="les_deux{{ $item['campagne']->campagne_id }}" value="les_deux" {{ $item['campagne']->afficher_montant_pourcentage == 'les_deux' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary" for="les_deux{{ $item['campagne']->campagne_id }}">Les deux</label>
                            </div>
                        </div>
                        <div class="bg-light p-3 rounded mb-3">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" name="ordonner_candidats_votes_decroissants" value="1" {{ $item['campagne']->ordonner_candidats_votes_decroissants ? 'checked' : '' }}>
                                <label class="form-check-label">Ordonner les candidats par votes décroissants</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Couleur Primaire</label>
                            <input type="color" class="form-control form-control-color" name="color_primaire" value="{{ $item['campagne']->color_primaire }}" title="Choisir">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Couleur Secondaire</label>
                            <input type="color" class="form-control form-control-color" name="color_secondaire" value="{{ $item['campagne']->color_secondaire }}" title="Choisir">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Condition de participation (Document) <span class="text-danger">*</span></label>
                            @if($item['campagne']->condition_participation)
                            <a href="{{ env('IMAGES_PATH') }}/{{ $item['campagne']->condition_participation }}" target="_blank" class="d-block mb-2 text-primary">
                                📄 Voir le document actuel
                            </a>
                            @endif
                            <input type="file" name="condition_participation" class="form-control" accept=".pdf">
                        </div>
                    </div>

                    <div class="modal-footer border-top px-0 pb-0 mt-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-check me-1"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- Modales suppression --}}
@foreach($campagnes as $item)
<div class="modal fade" id="delete_contact_{{$item['campagne']->campagne_id}}" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <span class="avatar avatar-xl badge-soft-danger border-0 text-danger rounded-circle">
                        <i class="ti ti-trash fs-24"></i>
                    </span>
                </div>
                <h5 class="mb-1">Confirmer la suppression</h5>
                <p class="mb-3">Êtes-vous sûr de vouloir supprimer cette session ?</p>
                <form method="POST" action="{{ route('business.delete_campagne') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="campagne_id" value="{{$item['campagne']->campagne_id}}">
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger w-100">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- Modale catégorie --}}
<div class="modal fade" id="modal_add_categorie" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="ajax-form" action="{{ route('business.save_categorie') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom catégorie <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Choisir la campagne <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="campagne_id" required>
                                <option value="">Sélectionner une campagne</option>
                                @foreach($campagnes as $item)
                                <option value="{{ $item['campagne']->campagne_id }}">{{ $item['campagne']->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Décrivez la catégorie <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="4" name="description" required></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Choisir icone</label>
                            <select class="form-control form-select" name="icon">
                                <option value="">Sélectionner</option>
                                <option value="homme">Homme</option>
                                <option value="femme">Femme</option>
                                <option value="enfant">Enfant</option>
                                <option value="jeune">Jeune</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top mt-4 pb-0 px-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ===== SCRIPTS ===== --}}
@section('extra-js')
<script>
$(document).ready(function () {

    /* Recherche en temps réel */
    $('#searchSession').on('input', function () {
        var q = $(this).val().toLowerCase();
        var visible = 0;
        $('.session-row').each(function () {
            var match = $(this).data('name').includes(q);
            $(this).toggle(match);
            if (match) visible++;
        });
        $('#table-count').text(visible + ' affichée(s)');
        $('#empty-row').toggle(visible === 0);
    });

    /* Toggle inscription dates */
    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('inscriptionSwitch')) return;
        const modalBody = e.target.closest('.modal-body');
        if (!modalBody) return;
        const bloc = modalBody.querySelector('.blocDates');
        if (bloc) bloc.classList.toggle('d-none', !e.target.checked);
    });

});
</script>
@endsection
