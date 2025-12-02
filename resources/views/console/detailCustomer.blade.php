@extends('layout.header.console')

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
        <div class="col-md-12">

            <div class="card">
                <div class="card-body pb-2">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar avatar-xxl avatar-rounded me-3 flex-shrink-0">
                                <img src="assets/img/profiles/avatar-14.jpg" alt="img">
                                <span class="status online"></span>
                            </div>
                            <div>
                                <h5 class="mb-1">Jackson Daniel</h5>
                                <p class="mb-2">Facility Manager, Global INC</p>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-soft-danger border-0 me-2"><i class="ti ti-lock me-1"></i>Actif</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <a href="#" class="btn btn-dark" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add_campagne">
                                <i class="ti ti-plus me-1"></i>Créer campagne
                            </a>
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_compose">
                                <i class="ti ti-mail me-1"></i>Envoyer Email
                            </a>
                            <a href="#" class="btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit-circle"></i></a>
                            <div class="act-dropdown">
                                <a href="#" data-bs-toggle="dropdown" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash me-1"></i>Supprimer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Contact User -->

        </div>

        <!-- Contact Sidebar -->
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body p-3">
                    <h6 class="mb-3 fw-semibold">Autres informations</h6>
                    <div class="border-bottom mb-3 pb-3">
                        <div class="d-flex align-items-center mb-2">
                            <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                <i class="ti ti-mail fs-14"></i>
                            </span>
                            <p class="mb-0"> email@gmail.com</p>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                <i class="ti ti-phone fs-14"></i>
                            </span>
                            <p class="mb-0">+1 12445-47878</p>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                <i class="ti ti-map-pin fs-14"></i>
                            </span>
                            <p class="mb-0">22, Ave Street, Newyork, USA</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <span
                                class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                <i class="ti ti-calendar-exclamation fs-14"></i>
                            </span>
                            <p class="mb-0">Created on 27 Sep 2025, 11:45 PM</p>
                        </div>
                    </div>
                    <h6 class="mb-3 fw-semibold">Other Information</h6>
                    <ul class="border-bottom mb-3 pb-3">
                        <li class="row mb-2"><span class="col-6">Pays</span><span class="col-6 text-dark">Côte d'ivoire</span></li>
                        <li class="row mb-2"><span class="col-6">Devise</span><span class="col-6 text-dark">Franc cfa</span></li>
                        <li class="row mb-2"><span class="col-6">Dernière modification</span><span class="col-6 text-dark">27 Sep 2023, 11:45 pm</span></li>
                        <li class="row"><span class="col-6">Source</span><span class="col-6 text-dark">Paid Campaign</span></li>
                    </ul>

                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <h6 class="mb-3 fw-semibold">Entreprise</h6>
                        <!-- <a href="javascript:void(0);" class="link-primary mb-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-circle-plus me-1"></i>Add New</a> -->
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-lg rounded me-2 border">
                                <img src="assets/img/icons/google-icon.svg" alt="Img" class="img-fluid w-auto h-auto">
                            </span>
                            <div>
                                <h6 class="fw-medium mb-1">Google. Inc <i class="ti ti-circle-check-filled text-success fs-16"></i></h6>
                                <p class="mb-0">www.google.com</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6 class="mb-3 fw-semibold">Profil social</h6>
                    <ul class="d-flex align-items-center">
                        <li>
                            <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle fs-14 text-dark"><i class="ti ti-brand-youtube"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle fs-14 text-dark"><i class="ti ti-brand-facebook"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle fs-14 text-dark"><i class="ti ti-brand-instagram"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle fs-14 text-dark"><i class="ti ti-brand-whatsapp"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle fs-14 text-dark"><i class="ti ti-brand-pinterest"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="avatar avatar-sm rounded-circle fs-14 text-dark"><i class="ti ti-brand-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Contact Sidebar -->

        <!-- Contact Details -->
        <div class="col-xl-9">
            <div class="card mb-3">
                <div class="card-body pb-0 pt-2">
                    <ul class="nav nav-tabs nav-bordered mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tab_1" data-bs-toggle="tab" aria-expanded="false" class="nav-link active border-3" aria-selected="true" role="tab">
                                <span class="d-md-inline-block"><i class="ti ti-alarm-minus me-1"></i>Campagnes</span>
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a href="#tab_5" data-bs-toggle="tab" aria-expanded="false" class="nav-link border-3" aria-selected="false" tabindex="-1" role="tab">
                                <span class="d-md-inline-block"><i class="ti ti-mail-check me-1"></i>Email</span>
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a href="#tab_2" data-bs-toggle="tab" aria-expanded="true" class="nav-link border-3" aria-selected="false" role="tab" tabindex="-1">
                                <span class="d-md-inline-block"><i class="ti ti-notes me-1"></i>Profil</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content pt-0">

                <!-- Activities -->
                <div class="tab-pane active show" id="tab_1">
                    <div class="card">
                        <div
                            class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                            <h5 class="fw-semibold mb-0">Liste Campagnes</h5>
                            <div class="table-search" style="margin-bottom:0 !important;">
                                <div class="search-input">
                                    <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-nowrap datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>NOM DE SESSION</th>
                                            <th>NBRE D'ETAPES</th>
                                            <th>NBRE DE CANDIDATS</th>
                                            <th>CRÉÉE LE</th>
                                            <th>INSCRIPTION</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Campagne N°001</td>
                                            <td>1 étape</td>
                                            <td>1 Candidats</td>
                                            <td>23/11/2025</td>
                                            <td>Autorisées</td>
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
                                            <td>Campagne N°050</td>
                                            <td>3 étape</td>
                                            <td>25 Candidats</td>
                                            <td>23/11/2025</td>
                                            <td>Non-autorisées</td>
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
                    </div>
                </div>
                <!-- /Activities -->

                <!-- Email -->
                <div class="tab-pane fade" id="tab_5">
                    <div class="card">
                        <div
                            class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                            <h5 class="mb-1">Email</h5>
                            <div class="d-inline-flex align-items-center">
                                <a href="javascript:void(0);" class="link-primary fw-medium" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-dark" data-bs-original-title="There are no email accounts configured, Please configured your email account in order to Send/ Create EMails"><i class="ti ti-circle-plus me-1"></i>Create Email</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card border mb-0">
                                <div class="card-body pb-0">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="mb-1">Manage Emails</h6>
                                                <p>You can send and reply to emails directly via this section.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <div class="mb-3">
                                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#create_email">Connect Account</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Email -->

                <!-- Notes -->
                <div class="tab-pane fade" id="tab_2">
                    <div class="card">
                        <div
                            class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                            <div class="mb-3">
                                <h6 class="mb-1">Information de l’employé</h6>
                                <p class="mb-0">Veuillez fournir les informations ci-dessous</p>
                            </div>
                            <div class="d-inline-flex align-items-center">
                                <div class="dropdown me-2">
                                    <!-- <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown"><i class="ti ti-sort-ascending-2 me-2"></i>Sort By</a>
                                    <div class="dropdown-menu">
                                        <ul>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item">Newest</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item">Oldest</a>
                                            </li>
                                        </ul>
                                    </div> -->
                                </div>
                                <!-- <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_notes" class="link-primary fw-medium"><i class="ti ti-circle-plus me-1"></i>Add New</a> -->
                            </div>
                        </div>
                        <div class="card-body">

                            <form action="#">

                                <div class="mb-3">
                                    <div class="profile-upload d-flex align-items-center">
                                        <div class="profile-upload-img avatar avatar-xxl border border-dashed rounded position-relative flex-shrink-0">
                                            <span><i class="ti ti-photo"></i></span>
                                            <img id="ImgPreview" src="assets/img/profiles/avatar-02.jpg" alt="img" class="preview1">
                                            <a href="javascript:void(0);" id="removeImage1" class="profile-remove">
                                                <i class="ti ti-x"></i>
                                            </a>
                                        </div>
                                        <div class="profile-upload-content ms-3">
                                            <label class="d-inline-flex align-items-center position-relative btn btn-primary btn-sm mb-2">
                                                <i class="ti ti-file-broken me-1"></i>Importer un fichier
                                                <input type="file" id="imag" class="input-img position-absolute w-100 h-100 opacity-0 top-0 end-0">
                                            </label>
                                            <p class="mb-0">JPG, GIF ou PNG. Taille maximale : 800K</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-bottom mb-3">
                                    <!-- start row -->
                                    <div class="row">

                                        <!-- <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Prénom <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div> -->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Nom <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Nom d’utilisateur <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Mot de passe <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Email <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                    <!-- end row -->
                                </div>

                                <!-- <div class="border-bottom mb-3"> -->
                                    <!-- <div class="mb-3">
                                        <h6 class="mb-1">Adresse</h6>
                                        <p class="mb-0">Veuillez renseigner les détails de l'adresse</p>
                                    </div> -->

                                    <!-- start row -->
                                    <!-- <div class="row">

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Adresse
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Pays
                                                </label>
                                                <select class="select">
                                                    <option>États-Unis</option>
                                                    <option>Canada</option>
                                                    <option>Allemagne</option>
                                                    <option>France</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    État / Province
                                                </label>
                                                <select class="select">
                                                    <option>Californie</option>
                                                    <option>New York</option>
                                                    <option>Texas</option>
                                                    <option>Floride</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Ville
                                                </label>
                                                <select class="select">
                                                    <option>Los Angeles</option>
                                                    <option>San Diego</option>
                                                    <option>Fresno</option>
                                                    <option>San Francisco</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Code postal
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>

                                    </div> -->
                                    <!-- end row -->
                                <!-- </div> -->

                                <div class="d-flex align-items-center justify-content-end flex-wrap gap-2">
                                    <button type="submit" class="btn btn-sm btn-primary">Enregistrer les modifications</button>
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