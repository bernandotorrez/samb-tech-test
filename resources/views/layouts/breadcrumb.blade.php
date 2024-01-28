<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        @hasSection('breadcrumb_1')
        <li class="breadcrumb-item"><a href="@yield('href_breadcrumb_1')">@yield('breadcrumb_1')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb_2')</li>
        @endif
    </ol>
</nav>
