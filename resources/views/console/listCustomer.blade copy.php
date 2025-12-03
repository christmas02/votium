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
                                            <a href="{{ route('detail_customer') }}" class="btn btn-icon btn-sm btn-success"><i class="ti ti-eye"></i></a>
                                            <a class="btn btn-icon btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal_edit_client"><i class="ti ti-edit"></i></a>

                                            <a class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash"></i></a>
                                            <a href="#" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal_add_campaign">
                                                <i class="ti ti-plus me-1"></i>Créer campagne
                                            </a>
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
                                            <a href="{{ route('detail_customer') }}" class="btn btn-icon btn-sm btn-success"><i class="ti ti-eye"></i></a>
                                            <a class="btn btn-icon btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal_edit_client"><i class="ti ti-edit"></i></a>

                                            <a class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash"></i></a>
                                            <a href="#" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal_add_campaign">
                                                <i class="ti ti-plus me-1"></i>Créer campagne
                                            </a>
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
<!-- Structure de la Modale -->
<div class="modal fade" id="modal_add_client" tabindex="-1" aria-labelledby="modalAddClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- modal-lg pour plus de largeur -->
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="modalAddClientLabel">Ajouter un nouveau client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <!-- @csrf -->

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
                                <input type="text" class="form-control" name="phone" placeholder="+225 0747548163" required>
                            </div>

                            <!-- Mapping: email (Schema users) -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email (Identifiant) <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="jean@entreprise.com" required>
                            </div>

                            <!-- Confirmation Mot de passe -->
                            <!-- <div class="col-md-6 mb-3">
                                <label class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div> -->

                            <!-- Statut Actif -->
                            <!-- <div class="col-md-6 mb-3">
                                <div class="form-check form-switch p-2 border rounded bg-light d-flex align-items-center">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input ms-0 me-2" name="is_active" value="1" type="checkbox" role="switch" id="activeSwitch" checked>
                                    <label class="form-check-label cursor-pointer mb-0" for="activeSwitch">Compte Entreprise Actif</label>
                                </div>
                            </div> -->
                            <!-- Rôle par défaut (Hidden) -->
                            <input type="hidden" name="role" value="customer">
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
                                        <label class="form-label mb-1">Logo de l'entreprise</label>
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
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom de l'organisation <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="entreprise" required>
                            </div>

                            <!-- Pays -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Pays siège <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="pays_siege">
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
                                <input type="email" class="form-control" name="company_email" placeholder="contact@entreprise.com">
                            </div>

                            <!-- Téléphone -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone" name="phonenumber" required>
                            </div>

                            <!-- Adresse -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Adresse <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="adresse" placeholder="Siège social" required>
                            </div>

                            <!-- Site Web -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Site internet</label>
                                <input type="url" class="form-control" name="link_website" placeholder="https://...">
                            </div>

                            <!-- Description / Data -->
                            <!-- <div class="col-md-12 mb-3">
                                <label class="form-label">Notes / Données supplémentaires <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="2" name="data" required></textarea>
                            </div> -->
                        </div>

                        <!-- SECTION : RÉSEAUX SOCIAUX -->
                        <div class="mt-3">
                            <!-- <h6 class="mb-3 d-flex align-items-center text-dark">
                                <i class="ti ti-social fs-5 me-2"></i> Réseaux Sociaux
                            </h6> -->

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

                                <!-- Twitter / X -->
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="ti ti-brand-x"></i></span>
                                        <input type="url" class="form-control" name="link_twitter" placeholder="Twitter/X URL">
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

                                <!-- Site Web
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="ti ti-brand-web"></i></span>
                                        <input type="url" class="form-control" name="link_website" placeholder="https://...">
                                    </div>
                                    
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <!-- ... -->
                </form>
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
</div>
<!-- /Add offcanvas -->

<!-- edit offcanvas -->
<div class="modal fade" id="modal_edit_client" tabindex="-1" aria-labelledby="modalEditClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- modal-lg pour plus de largeur -->
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="modalEditClientLabel">Modification un nouveau client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <!-- @csrf -->

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
                                <input type="text" class="form-control" name="phone" placeholder="+225 0747548163" required>
                            </div>

                            <!-- Mapping: email (Schema users) -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email (Identifiant) <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="jean@entreprise.com" required>
                            </div>

                            <!-- Confirmation Mot de passe -->
                            <!-- <div class="col-md-6 mb-3">
                                <label class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div> -->

                            <!-- Statut Actif -->
                            <!-- <div class="col-md-6 mb-3">
                                <div class="form-check form-switch p-2 border rounded bg-light d-flex align-items-center">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input ms-0 me-2" name="is_active" value="1" type="checkbox" role="switch" id="activeSwitch" checked>
                                    <label class="form-check-label cursor-pointer mb-0" for="activeSwitch">Compte Entreprise Actif</label>
                                </div>
                            </div> -->
                            <!-- Rôle par défaut (Hidden) -->
                            <input type="hidden" name="role" value="customer">
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
                                        <label class="form-label mb-1">Logo de l'entreprise</label>
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
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom de l'organisation <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="entreprise" required>
                            </div>

                            <!-- Pays -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Pays siège <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="pays_siege">
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
                                <input type="email" class="form-control" name="company_email" placeholder="contact@entreprise.com">
                            </div>

                            <!-- Téléphone -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone" name="phonenumber" required>
                            </div>

                            <!-- Adresse -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Adresse <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="adresse" placeholder="Siège social" required>
                            </div>

                            <!-- Site Web -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Site internet</label>
                                <input type="url" class="form-control" name="link_website" placeholder="https://...">
                            </div>

                            <!-- Description / Data -->
                            <!-- <div class="col-md-12 mb-3">
                                <label class="form-label">Notes / Données supplémentaires <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="2" name="data" required></textarea>
                            </div> -->
                        </div>

                        <!-- SECTION : RÉSEAUX SOCIAUX -->
                        <div class="mt-3">
                            <!-- <h6 class="mb-3 d-flex align-items-center text-dark">
                                <i class="ti ti-social fs-5 me-2"></i> Réseaux Sociaux
                            </h6> -->

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

                                <!-- Twitter / X -->
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="ti ti-brand-x"></i></span>
                                        <input type="url" class="form-control" name="link_twitter" placeholder="Twitter/X URL">
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

                                <!-- Site Web
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="ti ti-brand-web"></i></span>
                                        <input type="url" class="form-control" name="link_website" placeholder="https://...">
                                    </div>
                                    
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <!-- ... -->
                </form>
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

<!-- Structure de la Modale -->
<div class="modal fade" id="modal_add_campaign" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter une nouvelle campagne</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <!-- @csrf -->

                    <!-- 2. INFORMATIONS PRINCIPALES -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom de la campagne <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required placeholder="Ex: Élection Miss 2024">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Promoteur <span class="text-danger">*</span></label>
                            <select class="select form-control form-select" name="customer_id" required>
                                <option value="">Sélectionner un Promoteur</option>
                                <option value="1">Promoteur A</option>
                                <option value="2">Promoteur B</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Décrivez la campagne<span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="4" name="description" required></textarea>
                        </div>
                    </div>

                    <!-- 1. IMAGE DE COUVERTURE (Mise en avant) -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Image de couverture <span class="text-danger">*</span></label>

                        <div class="position-relative w-100 rounded border border-dashed bg-light d-flex align-items-center justify-content-center overflow-hidden"
                            style="height: 250px; border-width: 2px !important; transition: all 0.3s ease;"
                            id="drop-zone">

                            <!-- Contenu par défaut -->
                            <div class="text-center p-4" id="upload-placeholder">
                                <div class="avatar avatar-lg bg-white border rounded-circle mb-2 mx-auto">
                                    <i class="ti ti-cloud-upload text-primary fs-3"></i>
                                </div>
                                <h6 class="mb-1 fw-bold">Glissez une image ou cliquez</h6>
                                <p class="text-muted mb-0 fs-12">JPG, PNG. Max 5MB</p>
                            </div>

                            <!-- Image Preview -->
                            <img id="image-preview" src="#" alt="Aperçu" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover d-none">

                            <!-- Input File Invisible -->
                            <input type="file" name="image_couverture" id="input-image"
                                class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                accept="image/png, image/jpeg, image/jpg"
                                onchange="previewImage(this)">
                        </div>

                        <!-- Bouton Supprimer -->
                        <div class="d-flex justify-content-end mt-1">
                            <button type="button" id="remove-btn" class="btn btn-sm btn-link text-danger text-decoration-none d-none" onclick="removeImage()">
                                <i class="ti ti-trash me-1"></i> Supprimer l'image
                            </button>
                        </div>
                    </div>

                    <hr class="my-4 border-secondary opacity-10">

                    <!-- 3. CONFIGURATION & RÈGLES (Groupés sur fond gris) -->
                    <div class="bg-light p-3 rounded mb-4">
                        <!-- <h6 class="mb-3 d-flex align-items-center text-primary">
                            <i class="ti ti-settings-cog fs-5 me-2"></i> Configuration & Dates
                        </h6> -->

                        <div class="row">
                            <!-- Toggle Inscription -->
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="inscription" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="inscriptionSwitch" name="inscription" value="1">
                                    <label class="form-check-label fw-medium" for="inscriptionSwitch">Autoriser les inscriptions</label>
                                </div>
                            </div>

                            <!-- Dates -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de début</label>
                                <input type="datetime-local" class="form-control" name="inscription_date_debut">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date de fin</label>
                                <input type="datetime-local" class="form-control" name="inscription_date_fin">
                            </div>

                            <!-- Conditions -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Règles & Conditions</label>
                                <textarea class="form-control" rows="3" name="condition_participation" required placeholder="Les règles du jeu..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- 4. APPARENCE & OPTIONS -->
                    <div>
                        <h6 class="mb-3 d-flex align-items-center text-dark">
                            <i class="ti ti-palette fs-5 me-2"></i> Apparence & Options
                        </h6>
                        <div class="row">
                            <!-- Couleurs -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Couleur Primaire</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="color_primaire" value="#563d7c" title="Choisir">
                                    <input type="text" class="form-control" value="#563d7c" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Couleur Secondaire</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="color_secondaire" value="#cccccc" title="Choisir">
                                    <input type="text" class="form-control" value="#cccccc" readonly>
                                </div>
                            </div>

                            <!-- Options Selects -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ordre des candidats</label>
                                <select class="form-select" name="ordonner_candidats_votes_decroissants">
                                    <option value="non">Par défaut (Aléatoire/ID)</option>
                                    <option value="oui">Votes décroissants (Top 1er)</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Affichage Résultats</label>
                                <select class="form-select" name="afficher_montant_pourcentage">
                                    <option value="clair" selected>Clair (Tout afficher)</option>
                                    <option value="masque">Masqué</option>
                                    <option value="pourcentage_seul">Pourcentage seul</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Limite de votes</label>
                                <input type="text" class="form-control" name="quantite_vote" placeholder="Ex: Illimité">
                            </div>

                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input type="hidden" name="text_cover" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="textCoverSwitch" name="text_cover" value="1">
                                    <label class="form-check-label" for="textCoverSwitch">Afficher texte sur couverture</label>
                                </div>
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

@endsection
<!-- section js -->
@section('extra-js')

@endsection