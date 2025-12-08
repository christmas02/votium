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

            <a href="javascript:void(0);" class="btn btn-primary">Nbre votes: 1200000</a>

            <a href="javascript:void(0);" class="btn btn-outline-light px-2 shadow">Total: 1200000 cfa</a>

        </div>
    </div>
    <!-- table header -->

    <!-- Contact Grid -->
    <div class="row">
        <div class="col-xl-3 ">
            <form action="">
                <div class="row mb-4 card card-body">
                    <h6>Filtre</h6>
                    <hr>
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
                    <div class="col-md-12 mb-3">
                        <label class="form-label">A partir du</label>
                        <input type="date" class="form-control" name="inscription_date_debut">
                    </div>
                    <div class="col-md-12 mb-3">Jusqu'au</label>
                        <input type="date" class="form-control" name="inscription_date_fin">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Jusqu'au <span class="text-danger">*</span></label>
                        <select class="select form-control form-select" name="customer_id" required>
                            <option value="">Confirmé</option>
                            <option value="1">Catégorie A</option>
                            <option value="2">Catégorie B</option>
                        </select>
                    </div>
                </div>

            </form>
        </div>
        <div class="col-xl-9">
            <div class="card">

                <div class="card-header d-flex align-items-center justify-content-between gap-2 flex-wrap">
                    <div class="table-search" style="margin-bottom:0 !important;">
                        <div class="search-input">
                            <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
                        </div>
                    </div>
                    
                </div>
                <!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>CAMPAGNE</th>
                                    <th>ETAPES</th>
                                    <th>QTE</th>
                                    <th>MONTANT</th>
                                    <th>CANDIDAT</th>
                                    <th>DATE</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Campagne N°001</td>
                                    <td>1 étape</td>
                                    <td>14</td>
                                    <td>200</td>
                                    <td>candidat n°2</td>
                                    <td>23/11/2025</td>
                                    <td>Confirmé</td>
                                    
                                </tr>
                                <tr>
                                    <td>Campagne N°001</td>
                                    <td>1 étape</td>
                                    <td>14</td>
                                    <td>200</td>
                                    <td>candidat n°2</td>
                                    <td>23/11/2025</td>
                                    <td>Confirmé</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>


    </div>
    <!-- /Contact Grid -->

</div>
<!-- End Content -->

@endsection
<!-- section js -->
@section('extra-js')

@endsection