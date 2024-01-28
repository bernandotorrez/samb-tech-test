<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ env('APP_NAME') ?? config('app.name') }} - @yield('title')</title>

    @include('layouts.meta')

    @stack('styles')

    @include('layouts.css')


</head>

<body>
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="loader-pendulums"></div>
    </div>
    <!-- /Preloader -->

	<!-- HK Wrapper -->
	<div class="hk-wrapper hk-vertical-nav">

        <!-- Top Navbar -->
        @include('layouts.topbar')
        <!-- /Top Navbar -->

        <!-- Vertical Nav -->
        @include('layouts.vertical-navbar')
        <!-- /Vertical Nav -->

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Breadcrumb -->
            @include('layouts.breadcrumb')
            <!-- /Breadcrumb -->

            <!-- Container -->
            @yield('content')
            <!-- /Container -->

            <!-- Footer -->
            @include('layouts.footer')
            <!-- /Footer -->

        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    @include('layouts.scripts')

    @stack('scripts')

</body>

</html>
