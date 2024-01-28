<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ env('APP_NAME') ?? config('app.name') }} - Login</title>

    @include('layouts.meta')

    @include('layouts.css')
</head>

<body>
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="loader-pendulums"></div>
    </div>
    <!-- /Preloader -->

    <!-- HK Wrapper -->
    <div class="hk-wrapper">

        <!-- Main Content -->
        <div class="hk-pg-wrapper hk-auth-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 pa-0">
                        <div class="auth-form-wrap pt-xl-0 pt-70">
                            <div class="auth-form w-xl-30 w-lg-55 w-sm-75 w-100">
                                <a class="auth-brand text-center d-block mb-20" href="#">
                                    <img class="brand-img" src="{{ asset('assets/img/logo.jpg') }}"
                                        style="width: 100px; height: 100px;" alt="brand" />
                                </a>
                                <form id="form-login">
                                    <h1 class="display-4 text-center mb-10">Login</h1>
                                    <p class="text-center mb-30">Silahkan login terlebih dahulu.</p>
                                    <div id="error-top"></div>
                                    <div id="waiting_time"></div>
                                    <div class="form-group">
                                        <input class="form-control" name="username"
                                            id="username"
                                            minlength="3"
                                            maxlength="50"
                                            placeholder="Username"
                                            type="text" required>
                                        <span class="text-danger" id="error-username"></span>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="password"
                                            id="password"
                                            minlength="3"
                                            maxlength="50"
                                            placeholder="Password"
                                            type="password" required>
                                        <span class="text-danger" id="error-password"></span>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="submit" id="button-login">Login</button>
                                    <p class="text-center mt-30">Created by : Bernand Dayamuntari Hermawan</p>
                                    <p class="text-center mb-30 mt-10">*Untuk technical test d PT. SAMB</p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- JavaScript -->

    <!-- jQuery -->
    <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('assets/vendors/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Slimscroll JavaScript -->
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ asset('assets/js/dropdown-bootstrap-extended.js') }}"></script>

    <!-- FeatherIcons JavaScript -->
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <!-- Init JavaScript -->
    <script src="{{ asset('assets/js/init.js') }}"></script>

    <!-- Moment js -->
    <script src="{{ asset('assets/js/moment.js') }}"></script>

    <script text="type/javascript">
        let myInterval;
        var i = 0
        
        function myStopFunction() {
            clearInterval(myInterval);
        }

        $(document).ready(function() {
            $.ajax({
                method: 'GET',
                url: "{{ route('check-login-block') }}",
                type: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var { code, success, message, data } = response;
                    var chance = data.chance ?? ''

                    if(data.last_login_date != 0) {
                        if(chance) {
                            $('#error-top').html('<div class="alert alert-warning text-center">'+message+' <br> Kesempatan anda : '+chance+' lagi</div>')
                        } else {
                            $('#error-top').html('<div class="alert alert-warning text-center">'+message+'</div>')
                        }

                        var lastLoginDate = moment(data.last_login_date.date).unix()
                        var currentDate = moment().unix()
                        var interval = 1000
                        var diffTime = lastLoginDate - currentDate
                        var duration = moment.duration(diffTime*1000, 'milliseconds');

                        myInterval = setInterval(function(){
                            duration = moment.duration(duration - interval, 'milliseconds');

                            if(duration > 0) {
                                $('#waiting_time').html(`<div class="alert alert-info text-center"> Silahkan menunggu : <b> ${duration.minutes() + ":" + duration.seconds()} </b> <br> untuk melakukan login kembali </div>`)
                                $('#button-login').prop('disabled', true)

                            } else {
                                $('#waiting_time').html('')
                                $('#button-login').prop('disabled', false)
                                myStopFunction()
                            }
                        }, interval);
                    }
                }
            })
        });

        $('#form-login').submit(function(e) {
            e.preventDefault();

            var username = $('#username').val();
            var password = $('#password').val();

            $.ajax({
                method: 'POST',
                url: "{{ route('login-action') }}",
                type: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    username,
                    password
                },
                beforeSend: function() {
                    $('#button-login').prop('disabled', true)
                    $('#error-top').html('')
                    $('#waiting_time').html('')
                },
                success: function(response) {
                    var { code, success, message, data } = response;
                    var chance = data.chance ?? ''

                    if(success) {
                        window.location.replace("{{ route('home') }}")
                    } else {
                        if(chance) {
                            $('#error-top').html('<div class="alert alert-warning text-center">'+message+' <br> Kesempatan anda : '+chance+' lagi</div>')
                        } else {
                            $('#error-top').html('<div class="alert alert-warning text-center">'+message+'</div>')
                        }

                        if(data.last_login_date != 0) {
                            var lastLoginDate = moment(data.last_login_date.date).unix()
                            var currentDate = moment().unix()
                            var interval = 1000
                            var diffTime = lastLoginDate - currentDate
                            var duration = moment.duration(diffTime*1000, 'milliseconds');

                            myInterval = setInterval(function(){
                                duration = moment.duration(duration - interval, 'milliseconds');

                                if(duration > 0) {
                                    $('#waiting_time').html(`<div class="alert alert-info text-center"> Silahkan menunggu : <b> ${duration.minutes() + ":" + duration.seconds()} </b> <br> untuk melakukan login kembali </div>`)
                                    $('#button-login').prop('disabled', true)

                                } else {
                                    $('#waiting_time').html('')
                                    $('#button-login').prop('disabled', false)
                                    myStopFunction()
                                }
                            }, interval);
                        }

                    }

                    $('#button-login').prop('disabled', false)
                },
                statusCode: {
                    422: function(response, data) {
                        var responseJSON = response.responseJSON
                        var errors = responseJSON.errors

                        $.each(errors, function(index, value) {
                            $('#error-'+index).text(value)
                        })

                        $('#button-login').prop('disabled', false)
                    },
                    500: function() {
                        $('#button-login').prop('disabled', false)
                        $('#error-top').html('<div class="alert alert-warning text-center">Terjadi Kesalahan</div>')
                        $('waiting_time').html('')
                    }
                }
            })
        });
    </script>
</body>

</html>
