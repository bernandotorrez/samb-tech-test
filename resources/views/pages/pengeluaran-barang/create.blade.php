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
                            data-feather="plus-square"></i></span></span>Pengeluaran Barang Masuk</h4>
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

                                <div id="header_detail" style="display: none;">
                                    <div class="form-group">
                                        <h4 class="mb-30 mt-30 text-center">Header</h4>
                                        <p class="">Nomor Transaksi Pengeluaran Barang</p>
                                        <input type="text" class="form-control"
                                            id="TrxOutNo" name="TrxOutNo"
                                            autocomplete="off"
                                            placeholder="Contoh : TRX/OUT/001"
                                            minlength="3" maxlength="100"
                                            required>
                                        <span class="text-danger" id="error-TrxOutNo"></span>
                                    </div>

                                    <div class="form-group">
                                        <p class="">Tanggal Transaksi</p>
                                        <input type="text" class="form-control bg-grey-light-1"
                                            id="TrxOutDate" name="TrxOutDate"
                                            autocomplete="off"
                                            minlength="3" maxlength="25"
                                            value="{{ date('d-m-Y') }}"
                                            readonly
                                            required>
                                        <span class="text-danger" id="error-TrxOutDate"></span>
                                    </div>

                                    <div class="form-group">
                                        <p class="">Warehouse</p>
                                        <select id="WhsIdf" name="WhsIdf" class="form-control"
                                            aria-placeholder="Pilih Warehouse"
                                            placeholder="Pilih Warehouse"
                                            required>
                                            <option value="">- Pilih Warehouse -</option>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->WhsPK }}">{{ $warehouse->WhsName }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="error-WhsIdf"></span>
                                    </div>

                                    <div class="form-group">
                                        <p class="">Supplier</p>
                                        <select id="TrxOutSuppIdf" name="TrxOutSuppIdf" class="form-control"
                                            aria-placeholder="Pilih Supplier"
                                            placeholder="Pilih Supplier"
                                            required>
                                            <option value="">- Pilih Supplier -</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->SupplierPK }}">{{ $supplier->SupplierName }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="error-TrxOutSuppIdf"></span>
                                    </div>

                                    <div class="form-group">
                                        <p class="">Catatan Transaksi</p>
                                        <textarea type="text" class="form-control"
                                            id="TrxOutNotes" name="TrxOutNotes"
                                            autocomplete="off"
                                            placeholder="Contoh : Catatan"
                                            minlength="3" maxlength="250"
                                            required></textarea>
                                        <span class="text-danger" id="error-TrxOutNotes"></span>
                                    </div>
                                </div>

                                <button class="btn btn-success" type="button" id="button-tambah-produk">Tambah Produk</button>
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
        $('#button-tambah-produk').click(function(e) {
            $('#product_list').clone().appendTo('#new_product_list')
        })

        function getPenerimaanHeaderDetail(el) {
            const id = $(el).val()

            $.ajax({
                method: 'GET',
                url: "{{ route('penerimaan-barang.header-detail', '') }}/"+id,
                type: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#button-submit').prop('disabled', true)
                    $('#header_detail').hide()
                },
                success: function(response) {
                    const { data } = response
                    const { headers, details } = data
                    const {
                        TrxInDate,
                        TrxInNo,
                        TrxInNotes,
                        TrxInPK,
                        TrxInSuppIdf,
                        WhsIdf
                    } = headers;

                    // Set Value
                    $('#TrxOutDate').val(TrxInDate);
                    $('#WhsIdf').val(WhsIdf);
                    $('#TrxOutSuppIdf').val(TrxInSuppIdf);
                    $('#TrxOutNotes').val(TrxInNotes);

                    $('#button-submit').prop('disabled', false)

                    $('#header_detail').show()
                    console.log(response)
                }
            })
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
