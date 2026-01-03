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

    <!-- start row -->
    <div class="row">

        <!-- Contact Sidebar -->
        <div class="col-xl-3">
            <div class="card mb-3 mb-xl-0">
                <div class="card-body">
                    <div class="settings-sidebar" role="tablist" aria-orientation="vertical">
                        <h5 class="mb-3 fs-17">Paramètres compte</h5>
                        <div class="list-group list-group-flush settings-sidebar">
                            <a href="#tab_1" data-bs-toggle="tab" aria-expanded="false" aria-selected="true" role="tab" class="d-block p-2 fw-medium active"> <i class="ti ti-wallet me-1"></i>Entreprise</a>
                            <a href="#tab_5" data-bs-toggle="tab" aria-expanded="false" aria-selected="false" tabindex="-1" role="tab" class="d-block p-2 fw-medium"><i class="ti ti-wallet me-1"></i>Compte de retrait</a>
                            <a href="#tab_2" data-bs-toggle="tab" aria-expanded="true" aria-selected="false" role="tab" tabindex="-1" class="d-block p-2 fw-medium"><i class="ti ti-user me-1"></i>Profil</a>
                        </div>
                    </div>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div>
        <!-- /Contact Sidebar -->

        <!-- Contact Details -->
        <div class="col-xl-9">

            <!-- Tab Content -->
            <div class="tab-content pt-0">

                <!-- Activities -->
                <div class="tab-pane active show" id="tab_1">
                    <div class="card">
                        <div
                            class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                            <h5 class="fw-semibold mb-0">Entreprise</h5>
                            <div class="table-search" style="margin-bottom:0 !important;">
                                <div class="search-input">
                                    <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('business.update_customer') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="user_id" value="{{ $user->user_id }}">
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
                                                <input type="text" class="form-control phone" name="phonenumber" required>
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
                        </div><!-- end card body -->
                    </div>
                </div>
                <!-- /Activities -->

                <!-- Email -->
                <div class="tab-pane fade" id="tab_5">
                    <!-- Settings Info -->

                    <div class="card mb-0">
                        <div class="card-body">

                            <div class="border-bottom mb-3 pb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <h4 class="fs-17 mb-0">Compte de retrait</h4>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_bank"><i class="ti ti-square-rounded-plus-filled me-1"></i>Créer Compte</a>
                            </div>

                            <div class="row">

                                <!-- Email Wrap -->
                                <div class="col-md-12">
                                    <!-- Payment -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span>
                                                        <img src="assets/img/payments/payment-1.svg" alt="Img">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#php-mail"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_paypal"><i
                                                                class="ti ti-tool me-1"></i>Modifer</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="php-mail">
                                            <div>
                                                <p class="mb-0">PayPal Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment -->

                                    <!-- Payment-2 -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span>
                                                        <img src="assets/img/payments/payment-2.svg" alt="Img">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#stripe-pay"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_stripe"><i
                                                                class="ti ti-tool me-1"></i>Modifer</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="stripe-pay">
                                            <div>
                                                <p class="mb-0">Stripe Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment-2 -->

                                    <!-- Payment-3 -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span>
                                                        <img src="assets/img/payments/payment-3.svg" alt="Img">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#brain-pay"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_brain"><i
                                                                class="ti ti-tool me-1"></i>Modifer</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="brain-pay">
                                            <div>
                                                <p class="mb-0">Braintree Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment-3 -->


                                </div>
                                <!-- /Email Wrap -->

                            </div>
                        </div>
                    </div>
                    <!-- /Settings Info -->
                </div>
                <!-- /Email -->

                <!-- Notes -->
                <div class="tab-pane fade" id="tab_2">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                            <div class="mb-0">
                                <h6 class="d-flex align-items-center text-primary">
                                    <i class="ti ti-user-shield fs-5 me-2"></i> Informations Utilisateur (Customer)
                                </h6>
                            </div>

                        </div>
                        <div class="card-body">

                            <form action="{{ route('business.update_profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                                <!-- SECTION 1 : INFORMATIONS UTILISATEUR (Compte de connexion) -->
                                <div class="bg-light p-3 rounded mb-4">

                                    <div class="row">
                                        <!-- Mapping: name (Schema users) -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                        </div>

                                        <!-- Mapping: password (Schema users) -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Numéro de téléphone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phonenumber" value="{{ $user->phonenumber }}" required>
                                        </div>

                                        <!-- Mapping: email (Schema users) -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email (Identifiant) <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                        </div>

                                        <!-- Mapping: password (Schema users) -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Bouton Soumettre -->
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
                                </div>
                            </form>

                        </div> <!-- end card body -->
                    </div>
                </div>
                <!-- /Notes -->

            </div>
            <!-- /Tab Content -->

        </div>
        <!-- /Contact Details -->

    </div>
    <!-- end row -->

</div>
<!-- End Content -->

<!-- Add offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add_campagne">
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

                                <!-- Nom de la campagne -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nom de la campagne <span class="text-danger">*</span></label>
                                        <!-- Mapping: name -->
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Description courte <span class="text-danger">*</span></label>
                                        <!-- Mapping: description -->
                                        <textarea class="form-control" rows="4" name="description" required></textarea>
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
<!-- Modale de modification (ID statique pour test) -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit">
    <div class="offcanvas-header border-bottom">
        <h5 class="mb-0">Modifier la campagne : Campagne Été 2024</h5>
        <button type="button"
            class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
            data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <div class="offcanvas-body">
        <form action="#" method="POST" enctype="multipart/form-data">

            <div class="accordion accordion-bordered" id="campagne_accordion_edit">

                <!-- 1. Informations Générales -->
                <div class="accordion-item rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#general_edit">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-info-circle"></i></span>
                            Informations Générales
                        </a>
                    </div>
                    <div class="accordion-collapse collapse show" id="general_edit" data-bs-parent="#campagne_accordion_edit">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Image Couverture (Simulation: Image déjà présente) -->
                                <div class="col-md-12">
                                    <label class="form-label">Image de couverture</label>

                                    <!-- Zone de l'image (Bordure pleine car image présente) -->
                                    <div class="position-relative w-100 rounded border border-primary bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                        style="height: 300px; border-width: 2px !important; transition: all 0.3s ease;"
                                        id="drop-zone-edit">

                                        <!-- Placeholder (Caché car image présente) -->
                                        <div class="text-center p-4 d-none" id="upload-placeholder-edit">
                                            <div class="avatar avatar-xl bg-white border rounded-circle mb-3 mx-auto">
                                                <i class="ti ti-cloud-upload text-primary fs-2"></i>
                                            </div>
                                            <h5 class="mb-1 fw-bold">Modifier l'image</h5>
                                            <p class="text-muted mb-0 fs-12">Cliquez pour remplacer (Max 5MB)</p>
                                        </div>

                                        <!-- Image de prévisualisation (Affichée) -->
                                        <!-- J'ai mis une image placeholder pour l'exemple -->
                                        <img id="image-preview-edit"
                                            src="https://placehold.co/600x400/563d7c/ffffff?text=Cover+Image"
                                            alt="Aperçu"
                                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">

                                        <!-- Input file -->
                                        <input type="file"
                                            name="image_couverture"
                                            id="input-image-edit"
                                            class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                            accept="image/png, image/jpeg, image/jpg"
                                            onchange="previewImageEdit(this)">
                                    </div>

                                    <!-- Bouton Supprimer (Affiché) -->
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button"
                                            id="remove-btn-edit"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="removeImageEdit()">
                                            <i class="ti ti-trash me-1"></i> Retirer l'image
                                        </button>
                                    </div>
                                </div>

                                <!-- Campagne ID -->
                                <input type="hidden" class="form-control" name="campagne_id" value="CAMP-2024-001" required>

                                <!-- Nom -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nom de la campagne <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" value="Campagne Été 2024" required>
                                    </div>
                                </div>

                                <!-- Customer Select -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Client associé <span class="text-danger">*</span></label>
                                        <select class="select form-control" name="customer_id" required>
                                            <option value="">Sélectionner un client</option>
                                            <option value="1" selected>Coca-Cola (CUST-001)</option>
                                            <option value="2">Orange (CUST-002)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Description courte <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="4" name="description" required>Campagne promotionnelle pour la saison estivale avec voting système.</textarea>
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
                            data-bs-toggle="collapse" data-bs-target="#inscription_sec_edit">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-calendar-event"></i></span>
                            Inscription & Règles
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="inscription_sec_edit" data-bs-parent="#campagne_accordion_edit">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Switch Inscription -->
                                <div class="col-md-12">
                                    <div class="mb-3 form-check form-switch">
                                        <input type="hidden" name="inscription" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch" id="inscriptionSwitchEdit" name="inscription" value="1" checked>
                                        <label class="form-check-label" for="inscriptionSwitchEdit">Activer les inscriptions</label>
                                    </div>
                                </div>

                                <!-- Date Début -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Date de début</label>
                                        <input type="datetime-local" class="form-control" name="inscription_date_debut" value="2024-06-01T08:00">
                                    </div>
                                </div>

                                <!-- Date Fin -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Date de fin</label>
                                        <input type="datetime-local" class="form-control" name="inscription_date_fin" value="2024-08-31T23:59">
                                    </div>
                                </div>

                                <!-- Conditions -->
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Conditions de participation <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="4" name="condition_participation" required>1. Être majeur.
2. Résider dans le pays.
3. Accepter les CGU.</textarea>
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
                            data-bs-toggle="collapse" data-bs-target="#config_edit">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-settings"></i></span>
                            Apparence & Configuration
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="config_edit" data-bs-parent="#campagne_accordion_edit">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Couleurs -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Couleur Primaire</label>
                                        <input type="color" class="form-control form-control-color w-100" name="color_primaire" value="#563d7c" title="Choisir une couleur">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Couleur Secondaire</label>
                                        <input type="color" class="form-control form-control-color w-100" name="color_secondaire" value="#ffc107" title="Choisir une couleur">
                                    </div>
                                </div>

                                <!-- Switch Text Cover -->
                                <div class="col-md-6">
                                    <div class="mb-3 form-check form-switch">
                                        <input type="hidden" name="text_cover" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch" id="textCoverSwitchEdit" name="text_cover" value="1">
                                        <label class="form-check-label" for="textCoverSwitchEdit">Texte sur couverture</label>
                                    </div>
                                </div>

                                <!-- Ordre -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ordre des candidats</label>
                                        <select class="form-control" name="ordonner_candidats_votes_decroissants">
                                            <option value="non">Par défaut</option>
                                            <option value="oui" selected>Votes décroissants</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Affichage Montant -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Affichage Montant/Pourcentage</label>
                                        <select class="form-control" name="afficher_montant_pourcentage">
                                            <option value="clair">Clair</option>
                                            <option value="masque">Masqué</option>
                                            <option value="pourcentage_seul" selected>Pourcentage seul</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Quantité Vote -->
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label class="form-label">Quantité de votes</label>
                                        <input type="text" class="form-control" name="quantite_vote" value="10">
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

<!-- Paypal -->
<div class="modal fade" id="add_paypal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier compte</h5>
                <button type="button"
                    class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="mb-3 ">
                        <label class="form-label">Type de compte <span class="text-danger">*</span></label>
                        <select class="select">
                            <option>Select</option>
                            <option>MTN</option>
                            <option>WAVE</option>
                            <option>ORANGE</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom du compte <span class="text-danger">*</span></label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Numéro du compte <span class="text-danger">*</span></label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-end m-0">
                        <a href="#" class="btn btn-sm btn-light me-2" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-sm btn-primary">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Paypal -->

<!-- Add Bank Account -->
<div class="modal fade" id="add_bank" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un compte</h5>
                <button type="button"
                    class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="mb-3 ">
                        <label class="form-label">Type de compte <span class="text-danger">*</span></label>
                        <select class="select">
                            <option>Select</option>
                            <option>MTN</option>
                            <option>WAVE</option>
                            <option>ORANGE</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom du compte <span class="text-danger">*</span></label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Numéro du compte <span class="text-danger">*</span></label>
                        <input type="text" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-end m-0">
                        <a href="#" class="btn btn-sm btn-light me-2" data-bs-dismiss="modal">Annuler</a>
                        <button type="submit" class="btn btn-sm btn-primary">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Bank Account -->

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