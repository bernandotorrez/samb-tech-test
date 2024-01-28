@extends('layouts.main')

@section('title', 'Master Product')

@section('breadcrumb_1', 'Data')

@section('href_breadcrumb_1', '#')

@section('breadcrumb_2', 'Master Product')

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
                            data-feather="truck"></i></span></span>Master Product</h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <a class="btn btn-primary mb-3" type="submit" id="button-submit"
                                href="{{ route('master-product.create') }}">Tambah Data</a>
                            <div class="table-wrap table-responsive">
                                <table id="table"
                                    class="table table-bordered w-100 display pb-30 dataTable dtr-inline"
                                    role="grid" aria-describedby="data_user">

                                    <thead class="thead-primary">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Product Name</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $row)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $row->ProductName }}</td>
                                                <td>{{ $row->created_at->format('d-m-Y') }}</td>
                                                <td class="text-center">
                                                    <a class="feather-icon"
                                                        href="{{ route('master-product.edit', ['master_product' => base64_encode($row->ProductPK)]) }}">
                                                        <i data-feather="edit" class="text-success"></i>
                                                    </a>

                                                    &nbsp;
                                                    <a class="feather-icon"
                                                        data-id="{{ base64_encode($row->ProductPK) }}"
                                                        data-name="{{ $row->ProductName }}"
                                                        onclick="deleteData(this)">
                                                        <i data-feather="trash" class="text-danger"></i>
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

        function deleteData(el) {
            var id = el.getAttribute('data-id')
            var name = el.getAttribute('data-name')

            Swal.fire({
                title: 'Yakin ingin Hapus?',
                text: name,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#0058a2',
                cancelButtonColor: '#f83f37',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return $.ajax({
                        method: 'DELETE',
                        url: "{{ route('master-product.destroy', '') }}/" + id,
                        type: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            $('.btn-danger').prop('disabled', true)
                        },
                        success: function(response) {
                            var {
                                code,
                                success,
                                message,
                                data
                            } = response;

                            var swalData = success ? {
                                'class': 'success',
                                'title': 'Sukses',
                                'text': message
                            } : {
                                'class': 'error',
                                'title': 'Gagal',
                                'text': message
                            }

                            Swal.fire({
                                title: swalData.title,
                                text: swalData.text,
                                icon: swalData.class,
                                showCancelButton: false,
                                confirmButtonText: 'Tutup',
                                confirmButtonColor: '#0058a2',
                            }).then(function() {
                                if (success) {
                                    window.location = "{{ route('master-product.index') }}";
                                }
                            });

                            $('.btn-danger').prop('disabled', false)
                        },
                        error: function(err) {
                            Swal.fire({
                                title: 'Gagal',
                                text: 'Terjadi Kesalahan',
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonText: 'Tutup',
                                confirmButtonColor: '#0058a2',
                            })
                        },
                        statusCode: {
                            422: function(response, data) {
                                var responseJSON = response.responseJSON
                                var errors = responseJSON.errors

                                $.each(errors, function(index, value) {
                                    $('#error-' + index).text(value)
                                })

                                $('.btn-danger').prop('disabled', false)
                            },
                            500: function() {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: 'Terjadi Kesalahan',
                                    icon: 'warning',
                                    showCancelButton: false,
                                    confirmButtonText: 'Tutup',
                                    confirmButtonColor: '#0058a2',
                                })

                                $('.btn-danger').prop('disabled', false)
                            }
                        }
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {

            })
        }
    </script>
@endpush
