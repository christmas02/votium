@extends('layout.header.console')

@section('content')

<!-- Start Content -->
<div class="content pb-0">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
        <div class="row col-12">
            <div class="col-sm-6">
                <h4 class="mb-0">Liste Campagnes</h4>
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
                    <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Créer</a>
                </div>
                <!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom campagne</th>
                                    <th>Clients</th>
                                    <th>Debut</th>
                                    <th>Fin</th>
                                    <th>Inscription</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>61</td>
                                    <td>2011 Apr 25</td>
                                    <td>
                                        <div class="d-inline-flex gap-2">
                                            <a href="#" class="btn btn-icon btn-sm btn-success"><i class="ti ti-location"></i></a>
                                            <a class="btn btn-icon btn-sm btn-info" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i></a>
                                            <a href="#;" class="btn btn-icon btn-sm btn-light"><i class="ti ti-menu-2"></i></a>
                                            <a class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Garrett Winters</td>
                                    <td>Accountant</td>
                                    <td>Tokyo</td>
                                    <td>63</td>
                                    <td>2011 Jul 25</td>
                                    <td>
                                        <div class="d-inline-flex gap-2">
                                            <a href="#" class="btn btn-icon btn-sm btn-success"><i class="ti ti-location"></i></a>
                                            <a class="btn btn-icon btn-sm btn-info" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i></a>
                                            <a href="#;" class="btn btn-icon btn-sm btn-light"><i class="ti ti-menu-2"></i></a>
                                            <a class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <!-- end row -->

</div>
<!-- End Content -->

<!-- Add offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
    <div class="offcanvas-header border-bottom">
        <h5 class="mb-0">Ajouter une nouvelle campagne</h5>
        <button type="button"
            class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
            data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <div class="offcanvas-body">
        <form action="#" method="POST" enctype="multipart/form-data">
            <!-- @csrf -->

            <div class="accordion accordion-bordered" id="campagne_accordion">

                <!-- 1. Informations Générales -->
                <div class="accordion-item rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#general">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-info-circle"></i></span>
                            Informations Générales
                        </a>
                    </div>
                    <div class="accordion-collapse collapse show" id="general" data-bs-parent="#campagne_accordion">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Image Couverture -->
                                <!-- Image Couverture Large avec Preview -->
                                <div class="col-md-12">
                                    <label class="form-label">Image de couverture <span class="text-danger">*</span></label>

                                    <!-- Zone de l'image -->
                                    <div class="position-relative w-100 rounded border border-dashed bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                        style="height: 300px; border-width: 2px !important; transition: all 0.3s ease;"
                                        id="drop-zone">

                                        <!-- Contenu par défaut (Texte + Icone) -->
                                        <div class="text-center p-4" id="upload-placeholder">
                                            <div class="avatar avatar-xl bg-white border rounded-circle mb-3 mx-auto">
                                                <i class="ti ti-cloud-upload text-primary fs-2"></i>
                                            </div>
                                            <h5 class="mb-1 fw-bold">Glissez une image ou cliquez ici</h5>
                                            <p class="text-muted mb-0 fs-12">Format accepté : JPG, PNG. Taille Max : 5MB</p>
                                        </div>

                                        <!-- L'image de prévisualisation (Cachée par défaut) -->
                                        <img id="image-preview" src="#" alt="Aperçu"
                                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover d-none">

                                        <!-- L'input file (Invisible mais couvre toute la zone pour être cliquable) -->
                                        <input type="file"
                                            name="image_couverture"
                                            id="input-image"
                                            class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                            accept="image/png, image/jpeg, image/jpg"
                                            onchange="previewImage(this)">
                                    </div>

                                    <!-- Bouton pour supprimer l'image (Caché par défaut) -->
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button"
                                            id="remove-btn"
                                            class="btn btn-sm btn-outline-danger d-none"
                                            onclick="removeImage()">
                                            <i class="ti ti-trash me-1"></i> Supprimer l'image
                                        </button>
                                    </div>
                                </div>

                                <!-- Campagne ID -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">ID Campagne <span class="text-danger">*</span></label>
                                        <!-- Mapping: campagne_id -->
                                        <input type="text" class="form-control" name="campagne_id" placeholder="ex: CAMP-2024-01" required>
                                    </div>
                                </div>

                                <!-- Nom de la campagne -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nom de la campagne <span class="text-danger">*</span></label>
                                        <!-- Mapping: name -->
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                </div>

                                <!-- Customer ID (Select) -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Client associé (Customer ID) <span class="text-danger">*</span></label>
                                        <!-- Mapping: customer_id -->
                                        <select class="select form-control" name="customer_id" required>
                                            <option value="">Sélectionner un client</option>
                                            <!-- Bouclez sur vos clients ici -->
                                            <option value="1">Client A</option>
                                            <option value="2">Client B</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Description courte <span class="text-danger">*</span></label>
                                        <!-- Mapping: description -->
                                        <textarea class="form-control" rows="2" name="description" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Inscription & Conditions -->
                <div class="accordion-item border-top rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#inscription_sec">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-calendar-event"></i></span>
                            Inscription & Règles
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="inscription_sec" data-bs-parent="#campagne_accordion">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Activer Inscription -->
                                <div class="col-md-12">
                                    <div class="mb-3 form-check form-switch">
                                        <input type="hidden" name="inscription" value="0">
                                        <!-- Mapping: inscription -->
                                        <input class="form-check-input" type="checkbox" role="switch" id="inscriptionSwitch" name="inscription" value="1">
                                        <label class="form-check-label" for="inscriptionSwitch">Activer les inscriptions</label>
                                    </div>
                                </div>

                                <!-- Date Début -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Date de début</label>
                                        <!-- Mapping: inscription_date_debut -->
                                        <input type="datetime-local" class="form-control" name="inscription_date_debut">
                                    </div>
                                </div>

                                <!-- Date Fin -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Date de fin</label>
                                        <!-- Mapping: inscription_date_fin -->
                                        <input type="datetime-local" class="form-control" name="inscription_date_fin">
                                    </div>
                                </div>

                                <!-- Conditions de participation -->
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Conditions de participation (Long Text) <span class="text-danger">*</span></label>
                                        <!-- Mapping: condition_participation -->
                                        <textarea class="form-control" rows="4" name="condition_participation" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Apparence & Configuration -->
                <div class="accordion-item border-top rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#config">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-settings"></i></span>
                            Apparence & Configuration
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="config" data-bs-parent="#campagne_accordion">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Couleurs -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Couleur Primaire</label>
                                        <!-- Mapping: color_primaire -->
                                        <input type="color" class="form-control form-control-color w-100" name="color_primaire" value="#563d7c" title="Choisir une couleur">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Couleur Secondaire</label>
                                        <!-- Mapping: color_secondaire -->
                                        <input type="color" class="form-control form-control-color w-100" name="color_secondaire" value="#cccccc" title="Choisir une couleur">
                                    </div>
                                </div>

                                <!-- Text Cover Toggle -->
                                <div class="col-md-6">
                                    <div class="mb-3 form-check form-switch">
                                        <input type="hidden" name="text_cover" value="0">
                                        <!-- Mapping: text_cover -->
                                        <input class="form-check-input" type="checkbox" role="switch" id="textCoverSwitch" name="text_cover" value="1">
                                        <label class="form-check-label" for="textCoverSwitch">Afficher le texte sur la couverture</label>
                                    </div>
                                </div>

                                <!-- Ordonner Candidats Toggle/Select -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ordre des candidats</label>
                                        <!-- Mapping: ordonner_candidats_votes_decroissants -->
                                        <select class="form-control" name="ordonner_candidats_votes_decroissants">
                                            <option value="non">Par défaut</option>
                                            <option value="oui">Votes décroissants (Top en premier)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Affichage Montant -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Affichage Montant/Pourcentage</label>
                                        <!-- Mapping: afficher_montant_pourcentage -->
                                        <select class="form-control" name="afficher_montant_pourcentage">
                                            <option value="clair" selected>Clair</option>
                                            <option value="masque">Masqué</option>
                                            <option value="pourcentage_seul">Pourcentage seul</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Quantité Vote -->
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label class="form-label">Quantité de votes autorisés</label>
                                        <!-- Mapping: quantite_vote -->
                                        <input type="text" class="form-control" name="quantite_vote" placeholder="ex: Illimité ou 100">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Actions -->
            <div class="d-flex align-items-center justify-content-end">
                <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Annuler</button>
                <button type="submit" class="btn btn-primary">Créer la campagne</button>
            </div>
        </form>
    </div>
</div>
<!-- /Add offcanvas -->

<!-- edit offcanvas -->
<!-- Modale de modification (ID unique par campagne) -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit_{{ $campagne->id }}">
    <div class="offcanvas-header border-bottom">
        <h5 class="mb-0">Modifier la campagne : {{ $campagne->name }}</h5>
        <button type="button"
            class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
            data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <div class="offcanvas-body">
        <!-- Route Update avec l'ID de la campagne -->
        <form action="{{ route('campagnes.update', $campagne->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="accordion accordion-bordered" id="campagne_accordion_edit_{{ $campagne->id }}">

                <!-- 1. Informations Générales -->
                <div class="accordion-item rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#general_{{ $campagne->id }}">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-info-circle"></i></span>
                            Informations Générales
                        </a>
                    </div>
                    <div class="accordion-collapse collapse show" id="general_{{ $campagne->id }}" data-bs-parent="#campagne_accordion_edit_{{ $campagne->id }}">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Image Couverture Large avec Preview (Gestion existante) -->
                                <div class="col-md-12">
                                    <label class="form-label">Image de couverture</label>
                                    
                                    <!-- Zone de l'image -->
                                    <div class="position-relative w-100 rounded border bg-light d-flex align-items-center justify-content-center overflow-hidden 
                                         {{ $campagne->image_couverture ? 'border-primary' : 'border-dashed' }}" 
                                         style="height: 300px; border-width: 2px !important; transition: all 0.3s ease;" 
                                         id="drop-zone-{{ $campagne->id }}">
                                        
                                        <!-- Placeholder (Caché si image existe) -->
                                        <div class="text-center p-4 {{ $campagne->image_couverture ? 'd-none' : '' }}" id="upload-placeholder-{{ $campagne->id }}">
                                            <div class="avatar avatar-xl bg-white border rounded-circle mb-3 mx-auto">
                                                <i class="ti ti-cloud-upload text-primary fs-2"></i>
                                            </div>
                                            <h5 class="mb-1 fw-bold">Modifier l'image</h5>
                                            <p class="text-muted mb-0 fs-12">Cliquez pour remplacer (Max 5MB)</p>
                                        </div>

                                        <!-- Image de prévisualisation (Affichée si image existe) -->
                                        <img id="image-preview-{{ $campagne->id }}" 
                                             src="{{ $campagne->image_couverture ? asset('storage/'.$campagne->image_couverture) : '#' }}" 
                                             alt="Aperçu" 
                                             class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover {{ $campagne->image_couverture ? '' : 'd-none' }}">

                                        <!-- Input file -->
                                        <!-- On passe l'ID PHP à la fonction JS pour cibler les bons éléments -->
                                        <input type="file" 
                                               name="image_couverture" 
                                               id="input-image-{{ $campagne->id }}" 
                                               class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" 
                                               accept="image/png, image/jpeg, image/jpg"
                                               onchange="previewImageEdit(this, '{{ $campagne->id }}')">
                                    </div>

                                    <!-- Bouton Supprimer/Reset -->
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button" 
                                                id="remove-btn-{{ $campagne->id }}" 
                                                class="btn btn-sm btn-outline-danger {{ $campagne->image_couverture ? '' : 'd-none' }}" 
                                                onclick="removeImageEdit('{{ $campagne->id }}')">
                                            <i class="ti ti-trash me-1"></i> Retirer l'image
                                        </button>
                                    </div>
                                </div>

                                <!-- Campagne ID -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">ID Campagne <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="campagne_id" value="{{ $campagne->campagne_id }}" required>
                                    </div>
                                </div>

                                <!-- Nom -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nom de la campagne <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" value="{{ $campagne->name }}" required>
                                    </div>
                                </div>

                                <!-- Customer Select -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Client associé <span class="text-danger">*</span></label>
                                        <select class="select form-control" name="customer_id" required>
                                            <option value="">Sélectionner un client</option>
                                            <!-- Exemple de boucle Clients -->
                                            @foreach($clients as $client)
                                                <option value="{{ $client->id }}" {{ $campagne->customer_id == $client->id ? 'selected' : '' }}>
                                                    {{ $client->entreprise }} ({{ $client->customer_id }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Description courte <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="2" name="description" required>{{ $campagne->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Inscription & Conditions -->
                <div class="accordion-item border-top rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#inscription_sec_{{ $campagne->id }}">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-calendar-event"></i></span>
                            Inscription & Règles
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="inscription_sec_{{ $campagne->id }}" data-bs-parent="#campagne_accordion_edit_{{ $campagne->id }}">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Switch Inscription -->
                                <div class="col-md-12">
                                    <div class="mb-3 form-check form-switch">
                                        <input type="hidden" name="inscription" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                               id="inscriptionSwitch_{{ $campagne->id }}" 
                                               name="inscription" value="1" 
                                               {{ $campagne->inscription ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inscriptionSwitch_{{ $campagne->id }}">Activer les inscriptions</label>
                                    </div>
                                </div>

                                <!-- Date Début -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Date de début</label>
                                        <!-- Note: datetime-local requiert le format Y-m-d\TH:i -->
                                        <input type="datetime-local" class="form-control" name="inscription_date_debut" 
                                               value="{{ $campagne->inscription_date_debut ? \Carbon\Carbon::parse($campagne->inscription_date_debut)->format('Y-m-d\TH:i') : '' }}">
                                    </div>
                                </div>

                                <!-- Date Fin -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Date de fin</label>
                                        <input type="datetime-local" class="form-control" name="inscription_date_fin" 
                                               value="{{ $campagne->inscription_date_fin ? \Carbon\Carbon::parse($campagne->inscription_date_fin)->format('Y-m-d\TH:i') : '' }}">
                                    </div>
                                </div>

                                <!-- Conditions -->
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Conditions de participation <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="4" name="condition_participation" required>{{ $campagne->condition_participation }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Apparence & Configuration -->
                <div class="accordion-item border-top rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#config_{{ $campagne->id }}">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-settings"></i></span>
                            Apparence & Configuration
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="config_{{ $campagne->id }}" data-bs-parent="#campagne_accordion_edit_{{ $campagne->id }}">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Couleurs -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Couleur Primaire</label>
                                        <input type="color" class="form-control form-control-color w-100" name="color_primaire" 
                                               value="{{ $campagne->color_primaire }}" title="Choisir une couleur">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Couleur Secondaire</label>
                                        <input type="color" class="form-control form-control-color w-100" name="color_secondaire" 
                                               value="{{ $campagne->color_secondaire }}" title="Choisir une couleur">
                                    </div>
                                </div>

                                <!-- Switch Text Cover -->
                                <div class="col-md-6">
                                    <div class="mb-3 form-check form-switch">
                                        <input type="hidden" name="text_cover" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                               id="textCoverSwitch_{{ $campagne->id }}" 
                                               name="text_cover" value="1" 
                                               {{ $campagne->text_cover ? 'checked' : '' }}>
                                        <label class="form-check-label" for="textCoverSwitch_{{ $campagne->id }}">Texte sur couverture</label>
                                    </div>
                                </div>

                                <!-- Ordre -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ordre des candidats</label>
                                        <select class="form-control" name="ordonner_candidats_votes_decroissants">
                                            <option value="non" {{ $campagne->ordonner_candidats_votes_decroissants == 'non' ? 'selected' : '' }}>Par défaut</option>
                                            <option value="oui" {{ $campagne->ordonner_candidats_votes_decroissants == 'oui' ? 'selected' : '' }}>Votes décroissants</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Affichage Montant -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Affichage Montant/Pourcentage</label>
                                        <select class="form-control" name="afficher_montant_pourcentage">
                                            <option value="clair" {{ $campagne->afficher_montant_pourcentage == 'clair' ? 'selected' : '' }}>Clair</option>
                                            <option value="masque" {{ $campagne->afficher_montant_pourcentage == 'masque' ? 'selected' : '' }}>Masqué</option>
                                            <option value="pourcentage_seul" {{ $campagne->afficher_montant_pourcentage == 'pourcentage_seul' ? 'selected' : '' }}>Pourcentage seul</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Quantité Vote -->
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label class="form-label">Quantité de votes</label>
                                        <input type="text" class="form-control" name="quantite_vote" value="{{ $campagne->quantite_vote }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex align-items-center justify-content-end">
                <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>
<!-- /edit offcanvas -->

<!-- delete modal -->
<div class="modal fade" id="delete_contact">
    <div class="modal-dialog modal-dialog-centered modal-sm rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-body p-4 text-center position-relative">
                <div class="mb-3 position-relative z-1">
                    <span class="avatar avatar-xl badge-soft-danger border-0 text-danger rounded-circle"><i class="ti ti-trash fs-24"></i></span>
                </div>
                <h5 class="mb-1">Confirmer la suppression</h5>
                <p class="mb-3">Êtes-vous sûr de vouloir supprimer l'entreprise sélectionnée ?</p>
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-light position-relative z-1 me-2 w-100" data-bs-dismiss="modal">Annuler</a>
                    <a href="#" class="btn btn-primary position-relative z-1 w-100" data-bs-dismiss="modal">Oui, supprimer</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- delete modal -->

<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        const removeBtn = document.getElementById('remove-btn');
        const dropZone = document.getElementById('drop-zone');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Affiche l'image
                preview.src = e.target.result;
                preview.classList.remove('d-none');

                // Masque le texte d'upload
                placeholder.classList.add('d-none');

                // Affiche le bouton supprimer
                removeBtn.classList.remove('d-none');

                // Change la bordure pour indiquer le succès
                dropZone.classList.remove('border-dashed');
                dropZone.classList.add('border-primary');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        const input = document.getElementById('input-image');
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        const removeBtn = document.getElementById('remove-btn');
        const dropZone = document.getElementById('drop-zone');

        // Reset de l'input
        input.value = '';

        // Masque l'image et le bouton
        preview.src = '#';
        preview.classList.add('d-none');
        removeBtn.classList.add('d-none');

        // Réaffiche le placeholder
        placeholder.classList.remove('d-none');

        // Remet le style par défaut
        dropZone.classList.add('border-dashed');
        dropZone.classList.remove('border-primary');
    }
</script>
@endsection
<!-- section js -->
@section('extra-js')

@endsection