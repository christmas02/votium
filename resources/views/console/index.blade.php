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

        <!-- <div class="col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h6 class="mb-0">Recently Created Deals</h6>
                    <div class="dropdown">
                        <a class="dropdown-toggle btn btn-outline-light shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                            Last 30 days
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0);" class="dropdown-item">
                                Last 15 days
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item">
                                Last 30 days
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive custom-table">
                        <table class="table dataTable table-nowrap" id="deals-project">
                            <thead class="table-light">
                            <tr>
                                <th>Deal Name</th>
                                <th>Stage</th>
                                <th>Deal Value</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div> -->

        <!-- <div class="col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <h6 class="mb-0">Deals By Stage</h6>
                        <div class="d-flex align-items-center flex-wrap row-gap-3">
                            <div class="dropdown me-2">
                                <a class="dropdown-toggle btn btn-outline-light shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                    Sales Pipeline
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        Marketing Pipeline
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        Sales Pipeline
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        Email
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        Chats
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        Operational
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle btn btn-outline-light shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                    Last 30 Days
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        Last 30 Days
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        Last 15 Days
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        Last 7 Days
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body py-0">
                    <div id="deals-chart"></div>
                </div> 
            </div>
        </div> -->

    </div>
    <!-- end row -->

</div>
<!-- End Content -->
@endsection
<!-- section js -->
@section('extra-js')

@endsection