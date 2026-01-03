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

                    <div class="row mb-4 card card-body">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Choisir la campagne</label>
                            <select class="select form-control form-select js-select-campagne">
                                <option value="" selected disabled>Sélectionner</option>
                                @foreach($campagnes as $campagne)
                                <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Choisir l'étape</label>
                            <select class="select form-control form-select js-select-etape">
                                <option value="" selected disabled>Sélectionner</option>
                                @foreach($etapes as $etape)
                                <option value="{{ $etape->etape_id }}">{{ $etape->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Choisir la catégorie</label>
                            <select class="select form-control form-select js-select-categorie">
                                <option value="" selected disabled>Sélectionner</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                </div>

            </div>

        </div>


        <div class="col-xl-9">
            <div class="row bg-light js-candidat-table-body">
                <!-- Les cartes des candidats seront chargées ici via AJAX -->

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
                <form action="{{ route('business.save_candidat') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <!-- ================= PHOTO ================= -->
                        <div class="col-md-12 mb-4">
                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                <div class="avatar avatar-xl border border-dashed me-3 flex-shrink-0 d-flex justify-content-center align-items-center bg-light position-relative overflow-hidden">
                                    <i class="ti ti-photo text-muted fs-4" id="logo_placeholder"></i>
                                    <img src="#" alt="Aperçu" id="logo_preview" class="d-none w-100 h-100 object-fit-cover">
                                </div>

                                <div>
                                    <label class="form-label mb-1">Photo du candidat</label>
                                    <input type="file"
                                        class="form-control form-control-sm"
                                        name="photo"
                                        id="logo_input"
                                        accept="image/png, image/gif, image/jpeg"
                                        onchange="previewLogo(this)">
                                    <small class="text-muted">JPG, PNG ou GIF – max 800 Ko</small>
                                </div>
                            </div>
                        </div>

                        <!-- ================= IDENTITÉ ================= -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom complet<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sexe <span class="text-danger">*</span></label>
                            <select class="form-select" name="sexe" required>
                                <option value="">Choisir</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_naissance" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Profession <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="profession" required>
                        </div>

                        <!-- ================= CONTACT ================= -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="telephone" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="candidat@exemple.com" required>
                        </div>

                        <!-- ================= LOCALISATION ================= -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pays <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pays" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ville <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ville" required>
                        </div>

                        <!-- ================= CANDIDATURE ================= -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Campagne <span class="text-danger">*</span></label>
                            <select class="form-select" name="campagne_id" required>
                                <option value="">Sélectionner une campagne</option>
                                @foreach($campagnes as $campagne)
                                <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Catégorie</label>
                            <select class="form-select" name="category_id">
                                <option value="">Sélectionner</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Étape <span class="text-danger">*</span></label>
                            <select class="form-select" name="etape_id" required>
                                <option value="">Sélectionner</option>
                                @foreach($etapes as $etape)
                                <option value="{{ $etape->etape_id }}">{{ $etape->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- ================= DESCRIPTION ================= -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Présentation du candidat <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" rows="4" required
                                placeholder="Parlez brièvement de lui, son parcours, ces ambitions..."></textarea>
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
                                            name="photo"
                                            id="logo_input"
                                            accept="image/png, image/gif, image/jpeg"
                                            onchange="previewLogo(this)">
                                        <small class="text-muted">JPG, GIF ou PNG. Max 800K</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Nom Entreprise -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nom" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="prenom" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sexe <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="sexe" required>
                                    <option value="">Choix</option>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>

                            <!-- Téléphone -->
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone" name="telephone" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="email" placeholder="candidat@exemple.com" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Pays <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone" name="pays" required>
                            </div>
                            <!-- Ville -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Ville <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="ville" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Profession <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone" name="profession" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la campagne <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="campagne_id" required>
                                    <option value="">Sélectionner une campagne</option>
                                    <option value="1">Campagne A</option>
                                    <option value="2">Campagne B</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la catégorie <span class="text-danger"></span></label>
                                <select class="select form-control form-select" name="category_id">
                                    <option value="">Sélectionner la catégorie</option>
                                    <option value="1">Catégorie A</option>
                                    <option value="2">Catégorie B</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir l'étape <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="etape_id" required>
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
    // Ce script centralise toute la logique jQuery pour la gestion des étapes de campagne
    $(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Écouter le changement sur n'importe lequel des 3 selects
    $(document).on('change', '.js-select-campagne, .js-select-etape, .js-select-categorie', function() {
        chargerCandidats();
    });

    function chargerCandidats() {
        // Récupérer les valeurs des 3 filtres
        const campagneId = $('.js-select-campagne').val();
        const etapeId = $('.js-select-etape').val();
        const categorieId = $('.js-select-categorie').val();

        // On n'envoie la requête que si au moins la campagne est sélectionnée (ou selon votre logique)
        if (!campagneId) return;

        $('.js-candidat-table-body').html('<div class="col-12 text-center"><div class="spinner-border text-primary"></div></div>');

        $.ajax({
            url: `/business/recherche_candidat`, // URL plus générique
            method: 'GET',
            data: {
                campagne_id: campagneId,
                etape_id: etapeId,
                category_id: categorieId
            },
            success: function(candidats) {
                renderCandidatCards(candidats);
            },
            error: function() {
                $('.js-candidat-table-body').html('<div class="col-12"><p class="text-danger text-center">Erreur de chargement des candidats.</p></div>');
            }
        });
    }

    function renderCandidatCards(candidats) {
        let html = '';
        if (candidats.length === 0) {
            html = '<div class="col-12"><p class="text-center bg-white p-4 shadow-sm">Aucun candidat trouvé pour ces critères.</p></div>';
        } else {
            candidats.forEach(candidat => {
                const dataStr = encodeURIComponent(JSON.stringify(candidat));
                // Utilisation d'une image par défaut si photo vide
                const photoUrl = candidat.photo ? `{{ env('IMAGES_PATH') }}/${candidat.photo}` : 'assets/img/profiles/avatar-01.jpg';
                
                html += `
                <div class="col-xxl-3 col-xl-4 col-md-6 mb-3">
                    <div class="card border shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xl flex-shrink-0 me-2">
                                        <img src="${photoUrl}" alt="img" class="rounded-1 object-fit-cover w-100 h-100">
                                    </div>
                                    <div>
                                        <h6 class="fs-14 mb-0"><a href="#" class="fw-medium text-dark">${candidat.nom} ${candidat.prenom}</a></h6>
                                        <p class="text-muted mb-0 small">Num: 00${candidat.id}</p>
                                        <p class="text-muted mb-0 small">${candidat.profession || ''}</p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <a href="#" class="btn btn-icon btn-sm btn-outline-light" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item js-btn-edit" href="javascript:void(0);" data-candidat="${dataStr}">
                                            <i class="ti ti-edit text-blue me-1"></i> Modifier
                                        </a>
                                        <a class="dropdown-item js-btn-delete" href="javascript:void(0);" data-id="${candidat.candidat_id || candidat.id}">
                                            <i class="ti ti-trash text-danger me-1"></i> Supprimer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
        }
        $('.js-candidat-table-body').html(html);
    }

    // Gestion de l'édition (Remplissage de la modale)
    $(document).on('click', '.js-btn-edit', function() {
        const data = JSON.parse(decodeURIComponent($(this).data('candidat')));
        const $modal = $('#modal_edit_candidat');

        // Remplissage des champs
        $modal.find('input[name="nom"]').val(data.nom);
        $modal.find('input[name="prenom"]').val(data.prenom);
        $modal.find('select[name="sexe"]').val(data.sexe);
        $modal.find('input[name="telephone"]').val(data.telephone);
        $modal.find('input[name="email"]').val(data.email);
        $modal.find('input[name="pays"]').val(data.pays);
        $modal.find('input[name="ville"]').val(data.ville);
        $modal.find('input[name="profession"]').val(data.profession);
        $modal.find('select[name="campagne_id"]').val(data.campagne_id);
        $modal.find('select[name="category_id"]').val(data.category_id);
        $modal.find('select[name="etape_id"]').val(data.etape_id);

        $modal.modal('show');
    });
});
</script>
@endsection
<!-- section js -->
@section('extra-js')

@endsection