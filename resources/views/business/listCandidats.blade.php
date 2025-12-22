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

    <!-- table header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
        <div class="d-flex align-items-center gap-2 flex-wrap">

            <div class="input-icon input-icon-start position-relative">
                <span class="input-icon-addon text-dark"><i class="ti ti-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">

            <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_candidat"><i class="ti ti-square-rounded-plus-filled me-1"></i>Créer</a>
            <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_categorie"><i class="ti ti-square-rounded-plus-filled me-1"></i>Ajouter catégorie</a>
            <div class="gap-2 d-flex align-items-center flex-wrap">
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown"><i class="ti ti-package-import me-2"></i>Importer</a>
                    <div class="dropdown-menu  dropdown-menu-end">
                        <ul>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-pdf me-1"></i>Importe en CSV </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-xls me-1"></i>Importe en Excel </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- table header -->

    <!-- Contact Grid -->
    <div class="row">
        <div class="col-xl-3 ">
            <div class="row mb-1">
                <div class="col-xl-12">
                    <form action="">
                        <div class="row mb-4 card card-body">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la campagne <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner une campagne</option>
                                    <option value="1">Campagne A</option>
                                    <option value="2">Campagne B</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la catégorie <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner la catégorie</option>
                                    <option value="1">Catégorie A</option>
                                    <option value="2">Catégorie B</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir l'étape <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner l'étape</option>
                                    <option value="1">Etape A</option>
                                    <option value="2">Etape B</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="col-xl-12">
                    <form action="">
                        <div class="row mb-4 card card-body">
                            <h5 class="mb-3 fs-17">Catégories</h5>
                            <div class="col-md-12 mb-3">
                                <label class="form-control">COIFFURE HOMME <i class="ti ti-edit text-blue"></i></label>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-control">COIFFURE FEMME <i class="ti ti-edit text-blue"></i></label>
                                
                            </div>
                            
                        </div>

                    </form>
                </div>
            </div>
            
        </div>


        <div class="col-xl-9">
            <div class="row">
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="#"
                                        class="avatar avatar-xl flex-shrink-0 me-2">
                                        <img src="assets/img/profiles/avatar-19.jpg" alt="img" class="rounded-1">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="#" class="fw-medium">Da Robertson</a></h6>
                                        <p class="text-default mb-0">Num: 001</p>
                                        <p class="text-default mb-0">Age: 36 ans</p>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#modal_edit_candidat"><i
                                                class="ti ti-edit text-blue"></i> Modifier</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Supprimer</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ti ti-eye text-blue-light"></i> Voir</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="#"
                                        class="avatar avatar-xl flex-shrink-0 me-2">
                                        <img src="assets/img/profiles/avatar-20.jpg" alt="img" class="rounded-1">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="#" class="fw-medium">Sharon
                                                Roy</a></h6>
                                        <p class="text-default mb-0">Num: 001</p>
                                        <p class="text-default mb-0">Age: 36 ans</p>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#modal_edit_candidat"><i
                                                class="ti ti-edit text-blue"></i> Modifier</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Supprimer</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ti ti-eye text-blue-light"></i> Voir</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="#"
                                        class="avatar avatar-xl flex-shrink-0 me-2">
                                        <img src="assets/img/profiles/avatar-21.jpg" alt="img" class="rounded-1">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="#"
                                                class="fw-medium">Vaughan Lewis</a></h6>
                                        <p class="text-default mb-0">Num: 001</p>
                                        <p class="text-default mb-0">Age: 36 ans</p>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#modal_edit_candidat"><i
                                                class="ti ti-edit text-blue"></i> Modifier</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Supprimer</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ti ti-eye text-blue-light"></i> Voir</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- /Contact Grid -->

    <!-- <div class="load-btn text-center">
        <a href="javascript:void(0);" class="btn btn-primary"><i class="ti ti-loader me-1"></i> Load More</a>
    </div> -->

</div>
<!-- End Content -->

<!-- Add offcanvas -->


<!-- Structure de la Modale -->
<div class="modal fade" id="modal_add_candidat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter candidat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <!-- @csrf -->
                    <div>
                        <div class="row">
                            <!-- Logo Upload avec Prévisualisation -->
                            <div class="col-md-12 mb-3">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <!-- Zone de l'image -->
                                    <div class="avatar avatar-xl border border-dashed me-3 flex-shrink-0 d-flex justify-content-center align-items-center bg-light position-relative overflow-hidden">
                                        <!-- Icône par défaut (sera cachée au chargement) -->
                                        <i class="ti ti-photo text-muted fs-4" id="logo_placeholder"></i>

                                        <!-- Image de prévisualisation (cachée par défaut) -->
                                        <img src="#" alt="Aperçu" id="logo_preview" class="d-none w-100 h-100 object-fit-cover">
                                    </div>

                                    <div class="d-flex flex-column">
                                        <label class="form-label mb-1">Image du candidat</label>
                                        <!-- Ajout de l'événement onchange -->
                                        <input type="file"
                                            class="form-control form-control-sm"
                                            name="logo"
                                            id="logo_input"
                                            accept="image/png, image/gif, image/jpeg"
                                            onchange="previewLogo(this)">
                                        <small class="text-muted">JPG, GIF ou PNG. Max 800K</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Nom Entreprise -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nom candidat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="entreprise" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Age candidat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="age" required>
                            </div>


                            <!-- Téléphone -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone" name="phonenumber" required>
                            </div>

                            <!-- Adresse -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="adresse" placeholder="Siège social" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la campagne <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner une campagne</option>
                                    <option value="1">Campagne A</option>
                                    <option value="2">Campagne B</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la catégorie <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner la catégorie</option>
                                    <option value="1">Catégorie A</option>
                                    <option value="2">Catégorie B</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir l'étape <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner l'étape</option>
                                    <option value="1">Etape A</option>
                                    <option value="2">Etape B</option>
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
<!-- /Add offcanvas -->

<!-- Structure de la Modale -->
<div class="modal fade" id="modal_add_categorie" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <!-- @csrf -->
                    <div>
                        <div class="row">

                            <!-- Nom Entreprise -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nom catégorie <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="entreprise" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la campagne <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner une campagne</option>
                                    <option value="1">Campagne A</option>
                                    <option value="2">Campagne B</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir l'étape <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner l'étape</option>
                                    <option value="1">Etape A</option>
                                    <option value="2">Etape B</option>
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
<!-- /Add offcanvas -->

<!-- edit offcanvas -->
<!-- Modale de modification (ID statique pour test) -->
<div class="modal fade" id="modal_edit_candidat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Modifier candidat : Kini KONIN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <!-- @csrf -->
                    <div>
                        <div class="row">
                            <!-- Logo Upload avec Prévisualisation -->
                            <div class="col-md-12 mb-3">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <!-- Zone de l'image -->
                                    <div class="avatar avatar-xl border border-dashed me-3 flex-shrink-0 d-flex justify-content-center align-items-center bg-light position-relative overflow-hidden">
                                        <!-- Icône par défaut (sera cachée au chargement) -->
                                        <i class="ti ti-photo text-muted fs-4" id="logo_placeholder"></i>

                                        <!-- Image de prévisualisation (cachée par défaut) -->
                                        <img src="#" alt="Aperçu" id="logo_preview" class="d-none w-100 h-100 object-fit-cover">
                                    </div>

                                    <div class="d-flex flex-column">
                                        <label class="form-label mb-1">Image du candidat</label>
                                        <!-- Ajout de l'événement onchange -->
                                        <input type="file"
                                            class="form-control form-control-sm"
                                            name="logo"
                                            id="logo_input"
                                            accept="image/png, image/gif, image/jpeg"
                                            onchange="previewLogo(this)">
                                        <small class="text-muted">JPG, GIF ou PNG. Max 800K</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Nom Entreprise -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nom candidat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="entreprise" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Age candidat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="age" required>
                            </div>


                            <!-- Téléphone -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone" name="phonenumber" required>
                            </div>

                            <!-- Adresse -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="adresse" placeholder="Siège social" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la campagne <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner une campagne</option>
                                    <option value="1">Campagne A</option>
                                    <option value="2">Campagne B</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la catégorie <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner la catégorie</option>
                                    <option value="1">Catégorie A</option>
                                    <option value="2">Catégorie B</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir l'étape <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner l'étape</option>
                                    <option value="1">Etape A</option>
                                    <option value="2">Etape B</option>
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


<!-- Script JavaScript pour gérer l'affichage -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const switchBtn = document.getElementById('inscriptionSwitch');
        const blocDates = document.getElementById('blocDates');

        // Fonction pour afficher/masquer
        function toggleDates() {
            if (switchBtn.checked) {
                blocDates.style.display = 'flex'; // 'flex' car c'est une row bootstrap
            } else {
                blocDates.style.display = 'none';
                // Optionnel : Réinitialiser les dates si on décoche
                // blocDates.querySelectorAll('input').forEach(input => input.value = '');
            }
        }

        // Écouter le changement (clic)
        switchBtn.addEventListener('change', toggleDates);

        // Vérifier l'état au chargement de la page (utile en cas d'erreur de formulaire ou d'édition)
        toggleDates();
    });
</script>
@endsection
<!-- section js -->
@section('extra-js')

@endsection