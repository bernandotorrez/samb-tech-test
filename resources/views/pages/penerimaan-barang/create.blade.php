@extends('layouts.main')

@section('title', 'Penerimaan Barang Masuk')

@section('breadcrumb_1', 'Data')

@section('href_breadcrumb_1', route('penerimaan-barang.index'))

@section('breadcrumb_2', 'Penerimaan Barang Masuk')

@push('styles')
    <!-- Bootstrap Dropzone CSS -->
    <link href="{{ asset('assets/vendors/dropify/dist/css/dropify.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                            data-feather="plus-square"></i></span></span>Penerimaan Barang Masuk</h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <form id="form-header">
                                <div class="form-group">
                                    <h4 class="mb-30 text-center">Header</h4>
                                    <p class="">Nomor Transaksi</p>
                                    <input type="text" class="form-control"
                                        id="TrxInNo" name="TrxInNo"
                                        autocomplete="off"
                                        placeholder="Contoh : TRX/IN/001"
                                        minlength="3" maxlength="100"
                                        required>
                                    <span class="text-danger" id="error-TrxInNo"></span>
                                </div>

                                <div class="form-group">
                                    <p class="">Tanggal Transaksi</p>
                                    <input type="text" class="form-control bg-grey-light-1"
                                        id="TrxInDate" name="TrxInDate"
                                        autocomplete="off"
                                        minlength="3" maxlength="25"
                                        value="{{ date('d-m-Y') }}"
                                        readonly
                                        required>
                                    <span class="text-danger" id="error-TrxInDate"></span>
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
                                    <select id="TrxInSuppIdf" name="TrxInSuppIdf" class="form-control" 
                                        aria-placeholder="Pilih Supplier"
                                        placeholder="Pilih Supplier"
                                        required>
                                        <option value="">- Pilih Supplier -</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->SupplierPK }}">{{ $supplier->SupplierName }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="error-TrxInSuppIdf"></span>
                                </div>

                                <div class="form-group">
                                    <p class="">Catatan Transaksi</p>
                                    <textarea type="text" class="form-control"
                                        id="TrxInNotes" name="TrxInNotes"
                                        autocomplete="off"
                                        placeholder="Contoh : Catatan"
                                        minlength="3" maxlength="250"
                                        required></textarea>
                                    <span class="text-danger" id="error-TrxInNotes"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <form id="form-detail">
                                <div id="product_list">
                                    <div class="form-group">
                                        <h4 class="mb-30 text-center">Detail</h4>
                                        <p class="">Produk</p>
                                        <select id="TrxInDProductIdf" name="TrxInDProductIdf[]" class="form-control" 
                                            aria-placeholder="Pilih Supplier"
                                            placeholder="Pilih Supplier"
                                            required>
                                            <option value="">- Pilih Produk -</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->ProductPK }}">{{ $product->ProductName }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="error-TrxInDProductIdf"></span>
                                    </div>  

                                    <div class="form-group">
                                        <p class="">Dus</p>
                                        <input type="text" class="form-control"
                                            id="TrxInDQtyDus" name="TrxInDQtyDus[]"
                                            autocomplete="off"
                                            minlength="1" maxlength="4"
                                            onkeypress="return onlyNumberKey(event)"
                                            required>
                                        <span class="text-danger" id="error-TrxInDQtyDus"></span>
                                    </div> 

                                    <div class="form-group">
                                        <p class="">Pieces</p>
                                        <input type="text" class="form-control"
                                            id="TrxInDQtyPcs" name="TrxInDQtyPcs[]"
                                            autocomplete="off"
                                            minlength="1" maxlength="4"
                                            onkeypress="return onlyNumberKey(event)"
                                            required>
                                        <span class="text-danger" id="error-TrxInDQtyPcs"></span>
                                    </div> 
                                </div>

                                <div id="new_product_list"></div>

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

        function onlyNumberKey(evt) {  
            // Only ASCII character in that range allowed
            let ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        $('#button-submit').click(function(e) {
            e.preventDefault();
            
            const formHeader = $('#form-header').serialize()
            const formDetail = $('#form-detail').serializeArray()

            const formHeaderData = {
                'TrxInNo': $('#TrxInNo').val(),
                'WhsIdf':$('#WhsIdf').val(),
                'TrxInSuppIdf': $('#TrxInSuppIdf').val(),
                'TrxInNotes': $('#TrxInNotes').val()
            }

            console.log(formHeader)
            console.log(formDetail)

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
                        url: "{{ route('penerimaan-barang.store') }}",
                        type: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            formHeaderData,
                            formDetail
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
                                    window.location = "{{ route('master-warehouse.index') }}";
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

        $('#form').submit(function(e) {
            e.preventDefault();

            var WhsName = $('#WhsName').val()

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
                        url: "{{ route('master-warehouse.store') }}",
                        type: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            WhsName
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
                                    window.location = "{{ route('master-warehouse.index') }}";
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
