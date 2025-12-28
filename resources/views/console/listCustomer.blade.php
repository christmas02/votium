@extends('layout.header.console')

@section('content')

<!-- Start Content -->
<div class="content pb-0">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
        <div class="row col-12">
            <div class="col-sm-6">
                <h4 class="mb-0">List Customer</h4>
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
                    <!-- Bouton déclencheur de la modale -->
                    <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal_add_client">
                        <i class="ti ti-square-rounded-plus-filled me-1"></i>Créer
                    </a>
                    <!-- <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Créer</a> -->
                </div>
                <!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>Logo</th>
                                    <th>Entreprise</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Adresse</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($customers as $customer)
                                <tr>
                                    <td>
                                        <img src="{{ env('IMAGES_PATH') }}/{{ $customer->logo }}" width="38" class="rounded-1 d-flex" alt="user-image">
                                    </td>
                                    <td>{{ $customer->entreprise }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phonenumber }}</td>
                                    <td>{{ $customer->adresse }}</td>
                                    <td>
                                        <div class="d-inline-flex gap-2">
                                            <a href="{{ route('detail_customer', $customer->customer_id) }}" class="btn btn-icon btn-sm btn-success"><i class="ti ti-eye"></i></a>
                                            <!-- <a class="btn btn-icon btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal_edit_client"><i class="ti ti-edit"></i></a> -->

                                            <a class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_contact_{{ $customer->customer_id }}"><i class="ti ti-trash"></i></a>
                                            <a href="#" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal_add_campaign_{{ $customer->customer_id }}">
                                                <i class="ti ti-plus me-1"></i>Créer campagne
                                            </a>
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
<!-- End Content -->

<!-- Add Customer -->
<!-- Structure de la Modale -->
<div class="modal fade" id="modal_add_client" tabindex="-1" aria-labelledby="modalAddClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="modalAddClientLabel">Ajouter un nouveau client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('save_customer') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- SECTION 1 : INFORMATIONS UTILISATEUR (Compte de connexion) -->
                    <div class="bg-light p-3 rounded mb-4">
                        <h6 class="mb-3 d-flex align-items-center text-primary">
                            <i class="ti ti-user-shield fs-5 me-2"></i> Informations Utilisateur (Customer)
                        </h6>
                        <div class="row">
                            <!-- Mapping: name (Schema users) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Ex: Jean Dupont" required>
                            </div>

                            <!-- Mapping: password (Schema users) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Numéro de téléphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phonenumber" placeholder="+225 0747548163" required>
                            </div>

                            <!-- Mapping: email (Schema users) -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email (Identifiant) <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email_customer" placeholder="jean@entreprise.com" required>
                            </div>
                            <!-- Rôle par défaut (Hidden) -->
                            <input type="hidden" name="role" value="customer">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                        </div>
                    </div>

                    <!-- HR Divider -->
                    <div class="d-flex align-items-center mb-4">
                        <hr class="flex-grow-1">
                        <span class="mx-3 text-muted fw-bold">DÉTAILS ENTREPRISE</span>
                        <hr class="flex-grow-1">
                    </div>

                    <!-- SECTION 2 : INFORMATIONS ENTREPRISE -->
                    <div>
                        <h6 class="mb-3 d-flex align-items-center text-dark">
                            <i class="ti ti-building-skyscraper fs-5 me-2"></i> Informations de l'Entreprise
                        </h6>

                        <div class="row">
                            <!-- Logo Upload avec Prévisualisation -->
                            <div class="col-md-12 mb-3 image-upload-group">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <!-- Zone de l'image -->
                                    <div class="avatar avatar-xl border border-dashed me-3 flex-shrink-0 d-flex justify-content-center align-items-center bg-light position-relative overflow-hidden">
                                        <!-- Placeholder -->
                                        <i class="ti ti-photo text-muted fs-4 placeholder-target"></i>
                                        <!-- Preview -->
                                        <img src="#" alt="Aperçu" class="preview-target d-none w-100 h-100 object-fit-cover">
                                    </div>

                                    <div class="d-flex flex-column">
                                        <label class="form-label mb-1">Logo de l'entreprise</label>
                                        <input type="file"
                                            class="form-control form-control-sm"
                                            name="logo"
                                            accept="image/*"
                                            onchange="handleImagePreview(this)">
                                        <small class="text-muted">JPG, GIF ou PNG. Max 800K</small>

                                        <!-- Bouton supprimer pour le logo (optionnel) -->
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0 d-none remove-btn-target text-start" onclick="handleImageRemove(this)">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Nom Entreprise -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom de l'organisation <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="entreprise" required>
                            </div>

                            <!-- Pays -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Pays siège <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="pays_siege" required>
                                    <option value="">Sélectionner</option>
                                    <option value="France">France</option>
                                    <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                    <option value="Senegal">Sénégal</option>
                                    <option value="USA">USA</option>
                                    <option value="Canada">Canada</option>
                                </select>
                            </div>

                            <!-- NOUVEAU : Email de l'entreprise -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email de l'organisation</label>
                                <!-- Nommé 'company_email' pour ne pas écraser l'email du User -->
                                <input type="email" class="form-control" name="email" placeholder="contact@entreprise.com">
                            </div>

                            <!-- Téléphone -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone" name="phonenumber_entreprise" required>
                            </div>

                            <!-- Adresse -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Adresse <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="adresse" placeholder="Siège social" required>
                            </div>
                        </div>

                        <!-- SECTION : RÉSEAUX SOCIAUX -->
                        <div class="mt-3">

                            <div class="row">
                                <!-- Facebook -->
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="ti ti-brand-facebook"></i></span>
                                        <input type="url" class="form-control" name="link_facebook" placeholder="Facebook URL">
                                    </div>
                                </div>

                                <!-- Instagram -->
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="ti ti-brand-instagram"></i></span>
                                        <input type="url" class="form-control" name="link_instagram" placeholder="Instagram URL">
                                    </div>
                                </div>

                                <!-- LinkedIn -->
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="ti ti-brand-linkedin"></i></span>
                                        <input type="url" class="form-control" name="link_linkedin" placeholder="LinkedIn URL">
                                    </div>
                                </div>

                                <!-- Lien youtube / X -->
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="ti ti-brand-youtube"></i></span>
                                        <input type="url" class="form-control" name="link_youtube" placeholder="Youtube URL">
                                    </div>
                                </div>

                                <!-- Lien Tiktok -->
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="ti ti-brand-tiktok"></i></span>
                                        <input type="url" class="form-control" name="link_tiktok" placeholder="Tiktok URL">
                                    </div>
                                </div>

                                <!-- Site Web -->
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="ti ti-brand-telegram"></i></span>
                                        <input type="url" class="form-control" name="link_website" placeholder="https://...">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer (Actions) -->
                <div class="modal-footer border-top mt-4 pb-0 px-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Customer -->

<!-- delete modal -->
@foreach($customers as $customer)
<div class="modal fade" id="delete_contact_{{ $customer->customer_id }}">
    <div class="modal-dialog modal-dialog-centered modal-sm rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-body p-4 text-center position-relative">
                <div class="mb-3 position-relative z-1">
                    <span class="avatar avatar-xl badge-soft-danger border-0 text-danger rounded-circle"><i class="ti ti-trash fs-24"></i></span>
                </div>
                <h5 class="mb-1">Confirmer la suppression</h5>
                <p class="mb-3">Êtes-vous sûr de vouloir supprimer l'entreprise sélectionnée ?</p>

                <!-- Formulaire de suppression -->
                <form id="deleteCustomerForm" method="POST" action="{{ route('delete_customer') }}">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-center">
                        <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">
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

<!-- Structure de la Modale -->
@foreach($customers as $customer)
<div class="modal fade" id="modal_add_campaign_{{ $customer->customer_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter une nouvelle campagne</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('save_campagne') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- 2. INFORMATIONS PRINCIPALES -->
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom de la campagne <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required placeholder="Ex: Élection Miss 2024">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Promoteur <span class="text-danger">*</span></label>
                            <select class="select form-control form-select" name="customer_id" required readonly>
                                <option value="{{ $customer->customer_id }}">{{ $customer->entreprise }}</option>
                            </select>
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
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="clair{{ $customer->customer_id }}" value="clair" checked>
                                    <label class="btn btn-outline-custom" for="clair{{ $customer->customer_id }}">Clair</label>

                                    <!-- Option 2 : Pourcentage -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="pourcentage{{ $customer->customer_id }}" value="pourcentage">
                                    <label class="btn btn-outline-custom" for="pourcentage{{ $customer->customer_id }}">Pourcentage</label>

                                    <!-- Option 3 : Les deux -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="les_deux{{ $customer->customer_id }}" value="les_deux">
                                    <label class="btn btn-outline-custom" for="les_deux{{ $customer->customer_id }}">Les deux</label>
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
                            <div class="col-12 mb-3">
                                <label class="form-label fw-medium">Quantité de votes visibles</label>
                                <input type="text" class="form-control" name="quantite_vote" placeholder="Ex: 10,20,50,100">
                                <!-- Texte d'aide en gris -->
                                <div class="form-text text-muted mt-2">
                                    Ce sont les quantités de votes que vos clients pourront choisir pour le paiement.
                                    <span class="fw-bold">Les packs dont le montant est inferieur à 200f seront ignorés.</span>
                                </div>
                            </div>

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
@endforeach
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
</script>

@endsection
<!-- section js -->
@section('extra-js')

@endsection