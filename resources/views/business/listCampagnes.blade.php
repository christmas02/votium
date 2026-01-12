@extends('layout.header.business')

@section('content')

<!-- Start Content -->
<div class="content pb-0">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
        <div class="row col-12">
            <div class="col-sm-6">
                <h4 class="mb-0">{{ $title }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ $link_back }}">{{ $title_back }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-6">@include('layout.status')</div>
        </div>
    </div>
    <!-- End Page Header -->

    <div class="tab-content pt-0">
        <div class="tab-pane active show" id="tab_1" role="tabpanel">
            <!-- Content for Liste Campagnes tab -->
            <!-- start row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">

                        <div class="card-header d-flex align-items-center justify-content-between gap-2 flex-wrap">
                            <div class="table-search" style="margin-bottom:0 !important;">
                                <div class="search-input">
                                    <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
                                </div>
                            </div>
                            <!-- Bouton déclencheur -->

                            <div class="d-flex align-items-center gap-2 flex-wrap">

                                <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal_add_campaign">
                                    <i class="ti ti-square-rounded-plus-filled me-1"></i>Créer
                                </a>

                                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_categorie"><i class="ti ti-square-rounded-plus-filled me-1"></i>Ajouter catégorie</a>

                            </div>
                        </div>
                        <!-- end card header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-nowrap datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>NOM DE CAMPAGNE</th>
                                            <th>NBRE D'ETAPES</th>
                                            <th>NBRE DE CANDIDATS</th>
                                            <th>CRÉÉE LE</th>
                                            <th>INSCRIPTION</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($campagnes as $campagne)
                                        <tr>
                                            <td class="text-uppercase fw-bold" class="text-uppercase fw-bold">
                                                <a href="{{ route('business.list_etape', [$customer->customer_id]) }}">
                                                    {{$campagne->name}}
                                                </a>
                                            </td>
                                            <td>1 étape</td>
                                            <td>1 Candidats</td>
                                            <td>{{ $campagne->created_at->format('d/m/Y') }}</td>
                                            <td>@if($campagne->inscription_isActive) Autorisées @else Non-autorisées @endif</td>
                                            <td>
                                                <div class="d-inline-flex gap-2">
                                                    <a href="{{ route('business.detail_campagne', [$campagne->campagne_id]) }}" class="btn btn-icon btn-sm btn-success"><i class="ti ti-location"></i></a>
                                                    <a class="btn btn-icon btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal_edit_campaign_{{$campagne->campagne_id}}"><i class="ti ti-edit"></i></a>
                                                    @if($campagne->inscription_isActive)<a href="#;" class="btn btn-icon btn-sm btn-light"><i class="ti ti-menu-2"></i></a>@endif
                                                    <a class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_contact_{{$campagne->campagne_id}}"><i class="ti ti-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div>
            <!-- end row -->
        </div>

    </div>


</div>
<!-- End Content -->

<!-- Structure de la Modale add new campagne -->
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

                    <!-- 2. INFORMATIONS PRINCIPALES -->
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom de la campagne <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required placeholder="Ex: Élection Miss 2024">
                        </div>

                        <div class="col-md-12 mb-3">
                            <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Décrivez la campagne<span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="4" name="description" required></textarea>
                        </div>
                    </div>

                    <!-- 1. IMAGE DE COUVERTURE (Mise en avant) -->
                    <div class="mb-4 image-upload-group">
                        <label class="form-label fw-bold">Image de couverture <span class="text-danger">*</span></label>
                        <p class="text-muted small">Format recommandé : 1920x1080px | Max : 2 Mo</p>
                        <div class="position-relative w-100 rounded border border-dashed bg-light d-flex align-items-center justify-content-center overflow-hidden drop-zone-target"
                            style="height: 250px; border-width: 2px !important; transition: all 0.3s ease;">

                            <!-- Placeholder -->
                            <div class="text-center p-4 placeholder-target">
                                <div class="avatar avatar-lg bg-white border rounded-circle mb-2 mx-auto">
                                    <i class="ti ti-cloud-upload text-primary fs-3"></i>
                                </div>
                                <h6 class="mb-1 fw-bold">Glissez une image ou cliquez</h6>
                            </div>

                            <!-- Image Preview -->
                            <img src="#" alt="Aperçu" class="preview-target position-absolute top-0 start-0 w-100 h-100 object-fit-cover d-none">

                            <!-- Input File -->
                            <input type="file" name="image_couverture"
                                class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                accept="image/*"
                                onchange="handleImagePreview(this)">
                        </div>

                        <!-- Bouton Supprimer -->
                        <div class="d-flex justify-content-end mt-1">
                            <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none d-none remove-btn-target" onclick="handleImageRemove(this)">
                                <i class="ti ti-trash me-1"></i> Supprimer l'image
                            </button>
                        </div>
                    </div>

                    <hr class="my-4 border-secondary opacity-10">
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="col-md-12 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="textCoverSwitch" name="text_cover_isActive" value="1">
                                <label class="form-check-label" for="textCoverSwitch">Texte sur le cover</label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="col-md-12 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="identifiants_personnalises_isActive" name="identifiants_personnalises_isActive" value="1">
                                <label class="form-check-label" for="identifiants_personnalises_isActive">Identifiants candidats personnalisés</label>
                            </div>
                        </div>
                    </div>

                    <!-- 3. CONFIGURATION & RÈGLES (Groupés sur fond gris) -->
                    <div class="bg-light p-3 rounded mb-4">

                        <div class="row">
                            <!-- Toggle Inscription -->
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input inscriptionSwitch" type="checkbox" role="switch" id="inscriptionSwitch" name="inscription_isActive" value="1">
                                    <label class="form-check-label fw-medium" for="inscriptionSwitch">Autoriser les inscriptions</label>
                                </div>
                            </div>

                            <!-- Bloc Conteneur (Masqué par défaut) -->
                            <div id="blocDates" class="blocDates d-none">

                                <!-- Ligne Début -->
                                <div class="row">

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Date de début</label>
                                        <input type="date" class="form-control" name="inscription_date_debut">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Date de fin</label>
                                        <input type="date" class="form-control" name="inscription_date_fin">
                                    </div>


                                </div>

                                <!-- Ligne Fin -->
                                <div class="row">
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

                    <!-- 4. APPARENCE & OPTIONS -->
                    <div>
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Afficher les montants en pourcentage (%)</label>

                                <!-- Conteneur du groupe de boutons -->
                                <div class="btn-group w-100" role="group" aria-label="Affichage montant">

                                    <!-- Option 1 : Clair -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="option1" value="clair" checked>
                                    <label class="btn btn-outline-custom" for="option1">Clair</label>

                                    <!-- Option 2 : Pourcentage -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="option2" value="pourcentage">
                                    <label class="btn btn-outline-custom" for="option2">Pourcentage</label>

                                    <!-- Option 3 : Les deux -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="option3" value="les_deux">
                                    <label class="btn btn-outline-custom" for="option3">Les deux</label>
                                </div>
                            </div>

                            <!-- Options Selects -->
                            <div class="bg-light p-3 rounded mb-3">
                                <div class="col-md-12 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" role="switch" id="ordonner_candidats_votes_decroissants" name="ordonner_candidats_votes_decroissants" value="1">
                                        <label class="form-check-label" for="ordonner_candidats_votes_decroissants">Ordonner les candidats par votes décroissants</label>
                                    </div>
                                </div>
                            </div>

                            <!-- 1. Quantité de votes (Tout en haut, pleine largeur) -->
                            <!-- <div class="col-12 mb-3"> -->
                            <!-- <label class="form-label fw-medium">Quantité de votes visibles</label> -->
                            <!-- <input type="text" class="form-control" name="quantite_vote" placeholder="Ex: 10,20,50,100"> -->
                            <!-- Texte d'aide en gris -->
                            <!-- <div class="form-text text-muted mt-2">
                                    Ce sont les quantités de votes que vos clients pourront choisir pour le paiement.
                                    <span class="fw-bold">Les packs dont le montant est inferieur à 200f seront ignorés.</span>
                                </div>
                            </div> -->

                            <!-- Couleurs -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Couleur Primaire</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="color_primaire" value="#000" title="Choisir">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Couleur Secondaire</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="color_secondaire" value="#000" title="Choisir">
                                </div>
                            </div>

                            <!-- 1. IMAGE DE COUVERTURE (Mise en avant) -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Condition de participation (Document)<span class="text-danger">*</span></label>
                                <input type="file" name="condition_participation" class="form-control" accept=".pdf">
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="modal-footer border-top px-0 pb-0 mt-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-check me-1"></i> Créer la campagne</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add offcanvas -->

<!-- Modale de modification (ID statique pour test) -->
@foreach($campagnes as $campagne)
<div class="modal fade" id="modal_edit_campaign_{{$campagne->campagne_id}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Modifier la campagne : {{$campagne->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="ajax-form" action="{{ route('business.update_campagne') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="campagne_id" value="{{ $campagne->campagne_id }}">
                    <input type="hidden" name="old_image_couverture" value="{{ $campagne->image_couverture }}">
                    <input type="hidden" name="old_condition_participation" value="{{ $campagne->condition_participation }}">
                    <!-- 2. INFORMATIONS PRINCIPALES -->
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom de la campagne <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required value="{{$campagne->name}}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Décrivez la campagne<span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="4" name="description" required>{{ $campagne->description }}</textarea>
                        </div>
                    </div>

                    <!-- 1. IMAGE DE COUVERTURE (Mise en avant) -->
                    <div class="mb-4 image-upload-group">
                        <label class="form-label fw-bold">Image de couverture <span class="text-danger">*</span></label>
                        <p class="text-muted small">Format recommandé : 1920x1080px | Max : 2 Mo</p>
                        <!-- Condition sur la bordure : border-primary si image existe, border-dashed sinon -->
                        <div class="position-relative w-100 rounded border {{ $campagne->image_couverture ? 'border-primary' : 'border-dashed' }} bg-light d-flex align-items-center justify-content-center overflow-hidden drop-zone-target"
                            style="height: 250px; border-width: 2px !important; transition: all 0.3s ease;">

                            <!-- Placeholder : d-none si l'image existe -->
                            <div class="text-center p-4 placeholder-target {{ $campagne->image_couverture ? 'd-none' : '' }}">
                                <div class="avatar avatar-lg bg-white border rounded-circle mb-2 mx-auto">
                                    <i class="ti ti-cloud-upload text-primary fs-3"></i>
                                </div>
                                <h6 class="mb-1 fw-bold">Glissez une image ou cliquez</h6>
                                <p class="text-muted mb-0 fs-12">JPG, PNG. Max 5MB</p>
                            </div>

                            <!-- Image Preview : d-none seulement si pas d'image, sinon affiche l'URL -->
                            <img src="{{ $campagne->image_couverture ? env('IMAGES_PATH').'/'.$campagne->image_couverture : '#' }}"
                                alt="Aperçu"
                                class="preview-target position-absolute top-0 start-0 w-100 h-100 object-fit-cover {{ $campagne->image_couverture ? '' : 'd-none' }}">

                            <!-- Input File -->
                            <input type="file" name="image_couverture"
                                class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                accept="image/*"
                                onchange="handleImagePreview(this)">
                        </div>

                        <!-- Bouton Supprimer : visible (pas de d-none) si l'image existe -->
                        <div class="d-flex justify-content-end mt-1">
                            <button type="button"
                                class="btn btn-sm btn-link text-danger text-decoration-none remove-btn-target {{ $campagne->image_couverture ? '' : 'd-none' }}"
                                onclick="handleImageRemove(this)">
                                <i class="ti ti-trash me-1"></i> Supprimer l'image
                            </button>
                        </div>
                    </div>

                    <hr class="my-4 border-secondary opacity-10">
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="col-md-12 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="textCoverSwitch" name="text_cover_isActive" value="1" {{ $campagne->text_cover_isActive ? 'checked' : '' }}>
                                <label class="form-check-label" for="textCoverSwitch">Texte sur le cover</label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="col-md-12 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="identifiants_personnalises_isActive" name="identifiants_personnalises_isActive" value="1" {{ $campagne->identifiants_personnalises_isActive ? 'checked' : '' }}>
                                <label class="form-check-label" for="identifiants_personnalises_isActive">Identifiants candidats personnalisés</label>
                            </div>
                        </div>
                    </div>

                    <!-- 3. CONFIGURATION & RÈGLES (Groupés sur fond gris) -->
                    <div class="bg-light p-3 rounded mb-4">

                        <div class="row">
                            <!-- Toggle Inscription -->
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input inscriptionSwitch" type="checkbox" role="switch" id="inscriptionSwitch" name="inscription_isActive" value="1" {{ $campagne->inscription_isActive ? 'checked' : '' }}>
                                    <label class="form-check-label fw-medium" for="inscriptionSwitch">Autoriser les inscriptions</label>
                                </div>
                            </div>

                            <!-- Bloc Conteneur (Masqué par défaut) -->
                            <div id="blocDates" class="blocDates {{ $campagne->inscription_isActive ? '' : 'd-none' }}">

                                <!-- Ligne Début -->
                                <div class="row">

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Date de début</label>
                                        <input type="date" class="form-control" name="inscription_date_debut" value="{{ $campagne->inscription_date_debut }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Date de fin</label>
                                        <input type="date" class="form-control" name="inscription_date_fin" value="{{ $campagne->inscription_date_fin }}">
                                    </div>


                                </div>

                                <!-- Ligne Fin -->
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Heure de début</label>
                                        <input type="time" class="form-control" name="heure_debut_inscription" value="{{ $campagne->heure_debut_inscription }}">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Heure de fin</label>
                                        <input type="time" class="form-control" name="heure_fin_inscription" value="{{ $campagne->heure_fin_inscription }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- 4. APPARENCE & OPTIONS -->
                    <div>
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Afficher les montants en pourcentage (%)</label>

                                <!-- Conteneur du groupe de boutons -->
                                <div class="btn-group w-100" role="group" aria-label="Affichage montant">

                                    <!-- Option 1 : Clair -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="clair{{ $campagne->campagne_id }}" value="{{ $campagne->afficher_montant_pourcentage }}" {{ $campagne->afficher_montant_pourcentage == 'clair' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-custom" for="clair{{ $campagne->campagne_id }}">Clair</label>

                                    <!-- Option 2 : Pourcentage -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="pourcentage{{ $campagne->campagne_id }}" value="{{ $campagne->afficher_montant_pourcentage }}" {{ $campagne->afficher_montant_pourcentage == 'pourcentage' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-custom" for="pourcentage{{ $campagne->campagne_id }}">Pourcentage</label>

                                    <!-- Option 3 : Les deux -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="les_deux{{ $campagne->campagne_id }}" value="{{ $campagne->afficher_montant_pourcentage }}" {{ $campagne->afficher_montant_pourcentage == 'les_deux' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-custom" for="les_deux{{ $campagne->campagne_id }}">Les deux</label>
                                </div>
                            </div>

                            <!-- Options Selects -->
                            <div class="bg-light p-3 rounded mb-3">
                                <div class="col-md-12 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" role="switch" id="ordonner_candidats_votes_decroissants" name="ordonner_candidats_votes_decroissants" value="1" {{ $campagne->ordonner_candidats_votes_decroissants ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ordonner_candidats_votes_decroissants">Ordonner les candidats par votes décroissants</label>
                                    </div>
                                </div>
                            </div>

                            <!-- 1. Quantité de votes (Tout en haut, pleine largeur) -->
                            <!-- <div class="col-12 mb-3"> -->
                            <!-- <label class="form-label fw-medium">Quantité de votes visibles</label> -->
                            <!-- <input type="text" class="form-control" name="quantite_vote" value=""> -->
                            <!-- Texte d'aide en gris -->
                            <!-- <div class="form-text text-muted mt-2">
                                    Ce sont les quantités de votes que vos clients pourront choisir pour le paiement.
                                    <span class="fw-bold">Les packs dont le montant est inferieur à 200f seront ignorés.</span>
                                </div>
                            </div> -->

                            <!-- Couleurs -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Couleur Primaire</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="color_primaire" value="{{ $campagne->color_primaire }}" title="Choisir">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Couleur Secondaire</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="color_secondaire" value="{{ $campagne->color_secondaire }}" title="Choisir">
                                </div>
                            </div>

                            <!-- 1. IMAGE DE COUVERTURE (Mise en avant) -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Condition de participation (Document)<span class="text-danger">*</span></label>
                                @if($campagne->condition_participation)
                                <a href="{{ env('IMAGES_PATH') }}/{{ $campagne->condition_participation }}"
                                    target="_blank"
                                    class="d-block mb-2 text-primary">
                                    📄 Voir le document actuel
                                </a>
                                @endif
                                <input type="file" name="condition_participation" class="form-control" accept=".pdf">
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="modal-footer border-top px-0 pb-0 mt-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-check me-1"></i> Enregistre la campagne</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- /edit offcanvas -->

<!-- delete modal -->
@foreach($campagnes as $campagne)
<div class="modal fade" id="delete_contact_{{$campagne->campagne_id}}" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-body p-4 text-center position-relative">
                <div class="mb-3 position-relative z-1">
                    <span class="avatar avatar-xl badge-soft-danger border-0 text-danger rounded-circle"><i class="ti ti-trash fs-24"></i></span>
                </div>
                <h5 class="mb-1">Confirmer la suppression</h5>
                <p class="mb-3">Êtes-vous sûr de vouloir supprimer l'entreprise sélectionnée ?</p>
                <!-- Formulaire de suppression -->
                <form method="POST" action="{{ route('business.delete_campagne') }}">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-center">
                        <input type="hidden" name="campagne_id" value="{{$campagne->campagne_id}}">
                        <button type="button" class="btn btn-light position-relative z-1 me-2 w-100" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary position-relative z-1 w-100">Oui, supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- delete modal -->

<!-- Modale pour ajouter une nouvelle catégorie campagne -->
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
                    <div>
                        <div class="row">

                            <!-- Nom catégorie -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nom catégorie <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la campagne <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="campagne_id" required>
                                    <option value="">Sélectionner une campagne</option>
                                    @foreach($campagnes as $campagne)
                                    <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Décrivez la catégorie<span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="4" name="description" required></textarea>
                            </div>

                            <!-- icone catégorie -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir icone <span class="text-danger"></span></label>
                                <select class="select form-control form-select" name="icon">
                                    <option value="">Sélectionner</option>
                                    <option value="homme">Homme</option>
                                    <option value="femme">Femme</option>
                                    <option value="enfant">Enfant</option>
                                    <option value="jeune">Jeune</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- Modal Footer (Actions) -->
                    <div class="modal-footer border-top mt-4 pb-0 px-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Enregistrer</button>
                    </div>
                    <!-- ... -->
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script JavaScript pour gérer l'affichage -->
<script>
    document.addEventListener('change', function(e) {

        // Vérifie si l'élément déclencheur est un toggle inscription
        if (!e.target.classList.contains('inscriptionSwitch')) return;

        // On travaille dans la modale courante
        const modalBody = e.target.closest('.modal-body');
        if (!modalBody) return;

        const blocDates = modalBody.querySelector('.blocDates');

        if (!blocDates) return;

        blocDates.classList.toggle('d-none', !e.target.checked);

    });

    // Fonction pour gérer le package des votes
    document.addEventListener('click', function(e) {

        // Ajouter un package
        if (e.target.classList.contains('add-package')) {

            const wrapper = e.target.closest('.packages-wrapper');
            const container = wrapper.querySelector('.packages-container');

            let index = parseInt(container.dataset.index);

            const html = `
        <div class="row g-2 align-items-end package-item mb-2">
            <div class="col-5">
                <input type="number" name="packages[${index}][votes]" class="form-control bg-light border-0" placeholder="Nombre de votes" required>
            </div>
            <div class="col-5">
                <input type="number" name="packages[${index}][montant]" class="form-control bg-light border-0" placeholder="Prix (FCFA)" readonly required>
            </div>
            <div class="col-2 text-end">
                <button type="button" class="btn btn-danger btn-sm remove-package">✕</button>
            </div>
        </div>
        `;

            container.insertAdjacentHTML('beforeend', html);
            container.dataset.index = index + 1;
        }

        // Supprimer un package
        if (e.target.classList.contains('remove-package')) {
            e.target.closest('.package-item').remove();
        }

    });

    // Quand on change le prix du vote
    document.addEventListener('input', function(e) {
        if (e.target.name === 'prix_vote' || e.target.name.includes('[votes]')) {
            calculerMontants();
        }
    });

    // Calculer les montants en fonction du prix par vote
    function calculerMontants() {
        const prixVote = parseFloat(document.querySelector('input[name="prix_vote"]').value) || 0;

        document.querySelectorAll('.package-item').forEach(package => {
            const votesInput = package.querySelector('input[name*="[votes]"]');
            const montantInput = package.querySelector('input[name*="[montant]"]');

            const votes = parseFloat(votesInput.value) || 0;

            const montant = prixVote * votes;

            montantInput.value = montant > 0 ? montant : '';
        });
    }

</script>
@endsection
<!-- section js -->
@section('extra-js')

@endsection