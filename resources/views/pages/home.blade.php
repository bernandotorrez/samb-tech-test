@extends('layouts.main')

@section('title', 'Home')

@section('breadcrumb_1', 'Home')

@section('href_breadcrumb_1', '#')

@section('breadcrumb_2', 'Home Page')

@push('backend_styles')
<!-- Data Table CSS -->
<link href="{{ asset('assets/vendors/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="container">

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <p>Selamat Datang di Warehouse Management System</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>
@endsection