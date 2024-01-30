@extends('layouts.main')

@section('title', 'Pengeluaran Barang Masuk')

@section('breadcrumb_1', 'Data')

@section('href_breadcrumb_1', route('pengeluaran-barang.index'))

@section('breadcrumb_2', 'Pengeluaran Barang Masuk')

@push('styles')
    <!-- Bootstrap Dropzone CSS -->
    <link href="{{ asset('assets/vendors/dropify/dist/css/dropify.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                            data-feather="plus-square"></i></span></span>Pengeluaran Barang</h4>
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
                                    <p class="">Nomor Transaksi Penerimaan Barang</p>
                                    <select id="TrxinNo" name="TrxinNo" class="form-control"
                                        aria-placeholder="Pilih Nomor Transaksi Penerimaan Barang"
                                        placeholder="Pilih Nomor Transaksi Penerimaan Barang"
                                        onchange="getPenerimaanHeaderDetail(this)"
                                        required>
                                        <option value="">- Pilih Nomor Transaksi Penerimaan Barang -</option>
                                        @foreach ($penerimaanBarangs as $penerimaanBarang)
                                            <option value="{{ $penerimaanBarang->TrxInPK }}">{{ $penerimaanBarang->TrxInNo }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="error-TrxOutNo"></span>
                                </div>

                                <div id="header" style="display: none;"></div>
                                <div id="detail" style="display: none;"></div>

                                <button class="btn btn-primary" type="submit" id="button-submit" disabled>Simpan</button>
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
        $('#button-tambah-produk').click(function(e) {
            $('#product_list').clone().appendTo('#new_product_list')
        })

        function checkQty(el) {
            const value = parseInt($(el).val())
            const max = parseInt($(el).attr('max'))

            if(value > max) $(el).val(max)
        }

        function getPenerimaanHeaderDetail(el) {
            const id = $(el).val()

            if(id) {
                $.ajax({
                    method: 'GET',
                    url: "{{ route('penerimaan-barang.header-detail', '') }}/"+id,
                    type: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('#button-submit').prop('disabled', true)
                        $('#header').html('').hide()
                        $('#detail').html('').hide()
                    },
                    success: function(response) {
                        const { data } = response
                        const { htmlHeader, htmlDetail } = data

                        // Set Header and Detail
                        $('#header').show().html(htmlHeader)
                        $('#detail').show().html(htmlDetail)

                        $('#button-submit').prop('disabled', false)
                    }
                })
            }
        }

        function onlyNumberKey(evt) {
            // Only ASCII character in that range allowed
            let ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        $('#form').submit(function(e) {
            e.preventDefault();

            let details = []
            const products = $(".TrxOutDProductIdf");

            for(let i = 0; i <= products.length - 1; i++) {
                const array = {
                    'TrxOutDProductIdf': $(".TrxOutDProductIdf")[i].value,
                    'TrxOutDQtyDus': $(".TrxOutDQtyDus")[i].value,
                    'TrxOutDQtyPcs': $(".TrxOutDQtyPcs")[i].value,
                }

                details.push(array)
            }

            const header = {
                'TrxOutNo': $('#TrxOutNo').val(),
                'WhsIdf':$('#WhsIdf').val(),
                'TrxOutSuppIdf': $('#TrxOutSuppIdf').val(),
                'TrxOutNotes': $('#TrxOutNotes').val()
            }

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
                        url: "{{ route('pengeluaran-barang.store') }}",
                        type: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            header,
                            details
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
                                    window.location = "{{ route('pengeluaran-barang.index') }}";
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
                            500: function(response, data) {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: 'Terjadi Kesalahan',
                                    icon: 'warning',
                                    showCancelButton: false,
                                    confirmButtonText: 'Tutup',
                                    confirmButtonColor: '#0058a2',
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
