@extends('layouts.main')

@section('title', 'Tambah Data Master Supplier')

@section('breadcrumb_1', 'Data')

@section('href_breadcrumb_1', route('master-supplier.index'))

@section('breadcrumb_2', 'Tambah Data Master Supplier')

@push('styles')
    <!-- Bootstrap Dropzone CSS -->
    <link href="{{ asset('assets/vendors/dropify/dist/css/dropify.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                            data-feather="plus"></i></span></span>Tambah Data Master Supplier</h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <form id="form">
                                <div class="form-group">
                                    <p class="">Supplier Name</p>
                                    <input type="text" class="form-control"
                                        id="SupplierName" name="SupplierName"
                                        autocomplete="off"
                                        placeholder="Contoh : Supplier 1"
                                        minlength="3" maxlength="150"
                                        required>
                                    <span class="text-danger" id="error-SupplierName"></span>
                                </div>

                                <button class="btn btn-primary" type="submit" id="button-submit">Simpan</button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>
@endsection

@push('scripts')
    <!-- Dropify JavaScript -->
    <script src="{{ asset('assets/vendors/dropify/dist/js/dropify.min.js') }}"></script>

    <script text="type/javascript">
        $('#form').submit(function(e) {
            e.preventDefault();

            var SupplierName = $('#SupplierName').val()

            Swal.fire({
                    title: 'Yakin ingin Submit?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#0058a2',
                    cancelButtonColor: '#f83f37',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return $.ajax({
                            method: 'POST',
                            url: "{{ route('master-supplier.store') }}",
                            type: 'JSON',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                SupplierName
                            },
                            beforeSend: function() {
                                $('#button-submit').prop('disabled', true)
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
                                    if(success) {
                                        window.location = "{{ route('master-supplier.index') }}";
                                    }
                                });

                                $('#button-submit').prop('disabled', false)
                            },
                            error: function (err) {
                                const response = err.responseJSON

                                Swal.fire({
                                    title: 'Gagal',
                                    text: response.message,
                                    icon: 'warning',
                                    showCancelButton: false,
                                    confirmButtonText: 'Tutup',
                                    confirmButtonColor: '#0058a2',
                                })

                                $('#button-submit').prop('disabled', false)
                            },
                            statusCode: {
                                422: function(response, data) {
                                    var responseJSON = response.responseJSON
                                    var errors = responseJSON.errors

                                    $.each(errors, function(index, value) {
                                        $('#error-' + index).text(value)
                                    })

                                    $('#button-submit').prop('disabled', false)
                                },
                            }
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {

                })
        })
    </script>
@endpush
