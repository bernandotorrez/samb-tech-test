@extends('layouts.main')

@section('title', 'Ubah Data Pengguna')

@section('breadcrumb_1', 'Pengguna')

@section('href_breadcrumb_1', route('user.index'))

@section('breadcrumb_2', 'Ubah Data Pengguna')

@push('styles')
    <!-- Bootstrap Dropzone CSS -->
    <link href="{{ asset('assets/vendors/dropify/dist/css/dropify.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                            data-feather="edit"></i></span></span>Ubah Data Pengguna</h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <form id="form" enctype="multipart/form-data">
                                <input type="hidden" id="uuid_user" name="uuid_user" value="{{ $data->uuid_user }}">
                                <div class="form-group">
                                    <p class="">Username</p>
                                    <input type="readonly" class="form-control bg-grey-light-3"
                                        id="username" name="username"
                                        placeholder="Contoh : Username"
                                        autocomplete="off"
                                        minlength="3" maxlength="50"
                                        value="{{ $data->username }}"
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
                                        value="{{ $data->name }}"
                                        required>
                                    <span class="text-danger" id="error-name"></span>
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

            var uuid_user = $('#uuid_user').val()
            var name = $('#name').val()

            if(name.trim() == '') {
                $('#error-name').text('Isi Nama')
            } else {
                $('#error-name').text('')
            }

            if(name.trim() != '') {
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
                            url: "{{ route('user.update') }}/"+uuid_user,
                            type: 'JSON',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                name,
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
