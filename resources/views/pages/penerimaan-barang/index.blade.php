@extends('layouts.main')

@section('title', 'Penerimaan Barang')

@section('breadcrumb_1', 'Data')

@section('href_breadcrumb_1', '#')

@section('breadcrumb_2', 'Penerimaan Barang')

@push('styles')
    <!-- Data Table CSS -->
    <link href="{{ asset('assets/vendors/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}"
        rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                            data-feather="plus-square"></i></span></span>Penerimaan Barang</h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <a class="btn btn-primary mb-3" type="submit" id="button-submit"
                                href="{{ route('penerimaan-barang.create') }}">Tambah Data</a>
                            <div class="table-wrap table-responsive">
                                <table id="table"
                                    class="table table-bordered w-100 display pb-30 dataTable dtr-inline"
                                    role="grid" aria-describedby="data_user">

                                    <thead class="thead-primary">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nomor Transaksi</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Catatan Transaksi</th>
                                            <th>Warehouse</th>
                                            <th>Supplier</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $row)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $row->TrxInNo }}</td>
                                                <td>{{ date('d-m-Y', strtotime($row->TrxInDate)) }}</td>
                                                <td class="text-center">{{ $row->TrxInNotes }}</td>
                                                <td class="text-center">{{ $row->WhsName }}</td>
                                                <td class="text-center">{{ $row->SupplierName }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>
@endsection

@push('scripts')
    <!-- Data Table JavaScript -->
    <script src="{{ asset('assets/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable({
                responsive: true,
                autoWidth: true,
                language: {
                    search: "",
                    searchPlaceholder: "Cari",
                    sLengthMenu: "_MENU_Baris"
                }
            })
        })
    </script>
@endpush
