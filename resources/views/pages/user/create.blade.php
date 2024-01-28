@extends('layouts.main')

@section('title', 'Tambah Data Pengguna')

@section('breadcrumb_1', 'Pengguna')

@section('href_breadcrumb_1', route('user.index'))

@section('breadcrumb_2', 'Tambah Data Pengguna')

@push('styles')
    <!-- Bootstrap Dropzone CSS -->
    <link href="{{ asset('assets/vendors/dropify/dist/css/dropify.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                            data-feather="plus"></i></span></span>Tambah Data Pengguna</h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <form id="form" enctype="multipart/form-data">
                                <div class="form-group">
                                    <p class="">Username</p>
                                    <input type="text" class="form-control"
                                        id="username" name="username"
                                        autocomplete="off"
                                        placeholder="Contoh : Username"
                                        minlength="3" maxlength="50"
                                        onkeypress="return noSpace()"
                                        required>
                                    <span class="text-danger" id="error-username"></span>
                                </div>
                                <div class="form-group">
                                    <p class="">Nama</p>
                                    <input type="text" class="form-control"
                                        id="name" nam="name"
                                        placeholder="Contoh : Nama"
                                        autocomplete="off"
                                        minlength="3" maxlength="100"
                                        required>
                                    <span class="text-danger" id="error-name"></span>
                                </div>
                                <div class="form-group">
                                    <p class="">Password</p>
                                    <input type="password" class="form-control"
                                        id="password" name="password"
                                        placeholder="Contoh : Password"
                                        autocomplete="off"
                                        minlength="6" maxlength="100"
                                        onkeypress="return noSpace()"
                                        required>
                                    <span class="text-danger" id="error-password"></span>
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

        function noSpace() {
            if (event.keyCode == 32) {
                return false;
            }
        }

        $('#form').submit(function(e) {
            e.preventDefault();

            var username = $('#username').val()
            var name = $('#name').val()
            var password = $('#password').val()

            if(username.trim() == '') {
                $('#error-username').text('Isi Username')
            } else {
                $('#error-username').text('')
            }

            if(name.trim() == '') {
                $('#error-file').text('Isi Nama')
            } else {
                $('#error-file').text('')
            }

            if(password.trim() == '') {
                $('#error-body').text('Isi Password')
            } else {
                $('#error-body').text('')
            }

            if(username.trim() != '' && name.trim() != '' && password.trim() != '') {
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
                            url: "{{ route('user.store') }}",
                            type: 'JSON',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                username,
                                name,
                                password
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
                                        window.location = "{{ route('user.index') }}";
                                    }
                                });

                                $('#button-submit').prop('disabled', false)
                            },
                            error: function (err) {
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

                                    $('#button-submit').prop('disabled', false)
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

                                    $('#button-submit').prop('disabled', false)
                                }
                            }
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {

                })
            }
        })
    </script>
@endpush
