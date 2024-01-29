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

                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title">
                                        Nomor Transaksi Header : <span id="id_transaksi_header"></span>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-striped">
                                            <thead>
                                              <tr>
                                                <th>Product</th>
                                                <th>Dus</th>
                                                <th>Pcs</th>
                                              </tr>
                                            </thead>
                                            <tbody id="table_body_detail">
                                            </tbody>
                                          </table>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                                </div>
                            </div>

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
                                            <th>Detail</th>
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
                                                <td class="text-center">
                                                    <a class="feather-icon"
                                                        data-id="{{ $row->TrxInPK }}"
                                                        onclick="showDetail(this)">
                                                        <i data-feather="list" class="text-success"></i>
                                                    </a>
                                                </td>
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

        function showDetail(e) {
            const id = $(e).attr('data-id')

            $.ajax({
                url: "{{ route('penerimaan-barang.detail', '') }}/"+id,
                method: 'GET',
                type: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#id_transaksi_header').text('')
                    $('#table_body_detail').html('')
                },
                success: function(response) {
                    console.log(response)
                    const { data } = response
                    const headerTransactionID = response.data[0].TrxInNo;

                    // Set element id = id_transaksi_header
                    $('#id_transaksi_header').text(headerTransactionID)

                    let tableBodyDetail = '';

                    data.forEach((detail) => {
                        console.log(detail.ProductName)

                        tableBodyDetail += `
                        <tr>
                            <td>${detail.ProductName}</td>
                            <td>${detail.TrxInDQtyDus}</td>
                            <td>${detail.TrxInDQtyPcs}</td>
                        </tr>
                        `
                    });

                    // Set element id = id_transaksi_header
                    $('#table_body_detail').html(tableBodyDetail)
                }
            })

            $('#myModal').modal({
                show: true
            });
        }
    </script>
@endpush
