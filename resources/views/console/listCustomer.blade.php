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
                    <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Créer</a>
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
                                <tr>
                                    <td>
                                        <img src="{{ asset('assets/img/users/user-40.jpg') }}" width="38" class="rounded-1 d-flex" alt="user-image">
                                    </td>
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
                                    <td>
                                        <img src="{{ asset('assets/img/users/user-40.jpg') }}" width="38" class="rounded-1 d-flex" alt="user-image">
                                    </td>
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
        <h5 class="mb-0">Ajouter un nouveau client</h5>
        <button type="button"
            class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
            data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <div class="offcanvas-body">
        <!-- Ajoutez method="POST" et enctype pour le logo -->
        <form action="#" method="POST" enctype="multipart/form-data">
            <!-- CSRF Token si vous utilisez Laravel Blade -->
            <!-- @csrf -->

            <div class="accordion accordion-bordered" id="main_accordion">

                <!-- Basic Info -->
                <div class="accordion-item rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#basic">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-user-plus"></i></span>
                            Informations de base
                        </a>
                    </div>
                    <div class="accordion-collapse collapse show" id="basic" data-bs-parent="#main_accordion">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Logo Upload -->
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center mb-3">
                                       <div class="avatar avatar-xxl border border-dashed me-3 flex-shrink-0">
                                            <div class="position-relative d-flex align-items-center">
                                                 <i class="ti ti-photo text-dark fs-16"></i>
                                            </div>
                                        </div>

                                        <div class="d-inline-flex flex-column align-items-start">
                                            <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                                <i class="ti ti-file-broken me-1"></i>Télécharger le logo
                                                <!-- Mapping: logo -->
                                                <input type="file" class="form-control image-sign" name="logo" accept="image/png, image/gif, image/jpeg">
                                            </div>
                                            <span>JPG, GIF ou PNG. Max 800K</span>
                                        </div>
                                    </div>
                                    <!-- <div class="profile-upload d-flex align-items-center">
                                        <div class="profile-upload-img avatar avatar-xxl border border-dashed rounded position-relative flex-shrink-0">
                                            <span><i class="ti ti-photo"></i></span>
                                            <img id="ImgPreview" src="assets/img/profiles/avatar-02.jpg" alt="img" class="preview1">
                                            <a href="javascript:void(0);" id="removeImage1" class="profile-remove">
                                                <i class="ti ti-x"></i>
                                            </a>
                                        </div>
                                        <div class="profile-upload-content ms-3">
                                            <label class="d-inline-flex align-items-center position-relative btn btn-primary btn-sm mb-2">
                                                <i class="ti ti-file-broken me-1"></i>Upload File
                                                <input type="file" id="imag" class="input-img position-absolute w-100 h-100 opacity-0 top-0 end-0">
                                            </label>
                                            <p class="mb-0">JPG, GIF or PNG. Max size of 800K</p>
                                        </div>
                                    </div> -->
                                </div>

                                <!-- Customer ID -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">ID Client <span class="text-danger">*</span></label>
                                        <!-- Mapping: customer_id -->
                                        <input type="text" class="form-control" name="customer_id" placeholder="ex: CUST-001" required>
                                    </div>
                                </div>

                                <!-- Entreprise -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Entreprise <span class="text-danger">*</span></label>
                                        <!-- Mapping: entreprise -->
                                        <input type="text" class="form-control" name="entreprise" required>
                                    </div>
                                </div>

                                <!-- Email & Is Active -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label">Email <span class="text-danger ms-1">*</span></label>
                                            <div class="form-check form-switch mb-1">
                                                <label class="form-check-label d-flex align-items-center gap-2">
                                                    <span>Compte Actif</span>
                                                    <!-- Mapping: is_active -->
                                                    <!-- Astuce Laravel: input hidden pour envoyer 0 si non coché -->
                                                    <input type="hidden" name="is_active" value="0">
                                                    <input class="form-check-input form-check-input-sm switchCheckDefault ms-auto" name="is_active" value="1" type="checkbox" role="switch" checked>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Mapping: email -->
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                        <!-- Mapping: phonenumber -->
                                        <input type="text" class="form-control phone" name="phonenumber" required>
                                    </div>
                                </div>

                                <!-- Website -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Site Web</label>
                                        <!-- Mapping: link_website -->
                                        <input type="url" class="form-control" name="link_website" placeholder="https://...">
                                    </div>
                                </div>

                                <!-- Data (Description/Notes) -->
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Données supplémentaires (Data) <span class="text-danger">*</span></label>
                                        <!-- Mapping: data -->
                                        <textarea class="form-control" rows="3" name="data" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Basic Info -->

                <!-- Address Info -->
                <div class="accordion-item border-top rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#address">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-map-pin-cog"></i></span>
                            Adresse & Localisation
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="address" data-bs-parent="#main_accordion">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Adresse -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Adresse Complète <span class="text-danger">*</span></label>
                                        <!-- Mapping: adresse -->
                                        <input type="text" class="form-control" name="adresse" required>
                                    </div>
                                </div>
                                <!-- Pays Siege -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Pays du siège <span class="text-danger">*</span></label>
                                        <!-- Mapping: pays_siege -->
                                        <select class="select form-control" name="pays_siege">
                                            <option value="">Sélectionner</option>
                                            <option value="France">France</option>
                                            <option value="USA">USA</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                            <!-- Ajoutez vos pays ici -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Address Info -->

                <!-- Social Profile -->
                <div class="accordion-item border-top rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#social">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-social"></i></span>
                            Réseaux Sociaux
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="social" data-bs-parent="#main_accordion">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Facebook -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Facebook</label>
                                        <!-- Mapping: link_facebook -->
                                        <input type="url" class="form-control" name="link_facebook" placeholder="https://facebook.com/...">
                                    </div>
                                </div>
                                <!-- Instagram -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Instagram</label>
                                        <!-- Mapping: link_instagram -->
                                        <input type="url" class="form-control" name="link_instagram" placeholder="https://instagram.com/...">
                                    </div>
                                </div>
                                <!-- Twitter -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Twitter (X)</label>
                                        <!-- Mapping: link_twitter -->
                                        <input type="url" class="form-control" name="link_twitter" placeholder="https://twitter.com/...">
                                    </div>
                                </div>
                                <!-- LinkedIn -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">LinkedIn</label>
                                        <!-- Mapping: link_linkedin -->
                                        <input type="url" class="form-control" name="link_linkedin" placeholder="https://linkedin.com/in/...">
                                    </div>
                                </div>
                                <!-- YouTube -->
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">YouTube</label>
                                        <!-- Mapping: link_youtube -->
                                        <input type="url" class="form-control" name="link_youtube" placeholder="https://youtube.com/...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Social Profile -->

            </div>

            <!-- Actions -->
            <div class="d-flex align-items-center justify-content-end">
                <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Annuler</button>
                <button type="submit" class="btn btn-primary">Créer le client</button>
            </div>
        </form>
    </div>
</div>
<!-- /Add offcanvas -->

<!-- edit offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit">
    <div class="offcanvas-header border-bottom">
        <h5 class="mb-0">Modifier le client</h5>
        <button type="button"
            class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
            data-bs-dismiss="offcanvas" aria-label="Close">
        </button>
    </div>
    <div class="offcanvas-body">
        <!-- Ajoutez method="POST" et enctype pour le logo -->
        <form action="#" method="POST" enctype="multipart/form-data">
            <!-- CSRF Token si vous utilisez Laravel Blade -->
            <!-- @csrf -->

            <div class="accordion accordion-bordered" id="main_accordion_edit">

                <!-- Basic Info -->
                <div class="accordion-item rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#basic_edit">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-user-plus"></i></span>
                            Informations de base
                        </a>
                    </div>
                    <div class="accordion-collapse collapse show" id="basic_edit" data-bs-parent="#main_accordion_edit">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Logo Upload -->
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-xxl border border-dashed me-3 flex-shrink-0">
                                            <div class="position-relative d-flex align-items-center">
                                                <i class="ti ti-photo text-dark fs-16"></i>
                                            </div>
                                        </div>
                                        <div class="d-inline-flex flex-column align-items-start">
                                            <div class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                                <i class="ti ti-file-broken me-1"></i>Télécharger le logo
                                                <!-- Mapping: logo -->
                                                <input type="file" class="form-control image-sign" name="logo" accept="image/png, image/gif, image/jpeg">
                                            </div>
                                            <span>JPG, GIF ou PNG. Max 800K</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Customer ID -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">ID Client <span class="text-danger">*</span></label>
                                        <!-- Mapping: customer_id -->
                                        <input type="text" class="form-control" name="customer_id" placeholder="ex: CUST-001" required>
                                    </div>
                                </div>

                                <!-- Entreprise -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Entreprise <span class="text-danger">*</span></label>
                                        <!-- Mapping: entreprise -->
                                        <input type="text" class="form-control" name="entreprise" required>
                                    </div>
                                </div>

                                <!-- Email & Is Active -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label">Email <span class="text-danger ms-1">*</span></label>
                                            <div class="form-check form-switch mb-1">
                                                <label class="form-check-label d-flex align-items-center gap-2">
                                                    <span>Compte Actif</span>
                                                    <!-- Mapping: is_active -->
                                                    <!-- Astuce Laravel: input hidden pour envoyer 0 si non coché -->
                                                    <input type="hidden" name="is_active" value="0">
                                                    <input class="form-check-input form-check-input-sm switchCheckDefault ms-auto" name="is_active" value="1" type="checkbox" role="switch" checked>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Mapping: email -->
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                        <!-- Mapping: phonenumber -->
                                        <input type="text" class="form-control phone" name="phonenumber" required>
                                    </div>
                                </div>

                                <!-- Website -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Site Web</label>
                                        <!-- Mapping: link_website -->
                                        <input type="url" class="form-control" name="link_website" placeholder="https://...">
                                    </div>
                                </div>

                                <!-- Data (Description/Notes) -->
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">Données supplémentaires (Data) <span class="text-danger">*</span></label>
                                        <!-- Mapping: data -->
                                        <textarea class="form-control" rows="3" name="data" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Basic Info -->

                <!-- Address Info -->
                <div class="accordion-item border-top rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#address_edit">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-map-pin-cog"></i></span>
                            Adresse & Localisation
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="address_edit" data-bs-parent="#main_accordion_edit">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Adresse -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Adresse Complète <span class="text-danger">*</span></label>
                                        <!-- Mapping: adresse -->
                                        <input type="text" class="form-control" name="adresse" required>
                                    </div>
                                </div>
                                <!-- Pays Siege -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Pays du siège <span class="text-danger">*</span></label>
                                        <!-- Mapping: pays_siege -->
                                        <select class="select form-control" name="pays_siege">
                                            <option value="">Sélectionner</option>
                                            <option value="France">France</option>
                                            <option value="USA">USA</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                            <!-- Ajoutez vos pays ici -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Address Info -->

                <!-- Social Profile -->
                <div class="accordion-item border-top rounded mb-3">
                    <div class="accordion-header">
                        <a href="#"
                            class="accordion-button accordion-custom-button rounded"
                            data-bs-toggle="collapse" data-bs-target="#social_edit">
                            <span class="avatar avatar-md rounded me-1"><i class="ti ti-social"></i></span>
                            Réseaux Sociaux
                        </a>
                    </div>
                    <div class="accordion-collapse collapse" id="social_edit" data-bs-parent="#main_accordion_edit">
                        <div class="accordion-body border-top">
                            <div class="row">
                                <!-- Facebook -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Facebook</label>
                                        <!-- Mapping: link_facebook -->
                                        <input type="url" class="form-control" name="link_facebook" placeholder="https://facebook.com/...">
                                    </div>
                                </div>
                                <!-- Instagram -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Instagram</label>
                                        <!-- Mapping: link_instagram -->
                                        <input type="url" class="form-control" name="link_instagram" placeholder="https://instagram.com/...">
                                    </div>
                                </div>
                                <!-- Twitter -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Twitter (X)</label>
                                        <!-- Mapping: link_twitter -->
                                        <input type="url" class="form-control" name="link_twitter" placeholder="https://twitter.com/...">
                                    </div>
                                </div>
                                <!-- LinkedIn -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">LinkedIn</label>
                                        <!-- Mapping: link_linkedin -->
                                        <input type="url" class="form-control" name="link_linkedin" placeholder="https://linkedin.com/in/...">
                                    </div>
                                </div>
                                <!-- YouTube -->
                                <div class="col-md-12">
                                    <div class="mb-0">
                                        <label class="form-label">YouTube</label>
                                        <!-- Mapping: link_youtube -->
                                        <input type="url" class="form-control" name="link_youtube" placeholder="https://youtube.com/...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Social Profile -->

            </div>

            <!-- Actions -->
            <div class="d-flex align-items-center justify-content-end">
                <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Annuler</button>
                <button type="submit" class="btn btn-primary">Modifier le client</button>
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

@endsection
<!-- section js -->
@section('extra-js')

@endsection