<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Meta untuk SEO -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<meta name="keywords" content="SAMT Technical Test - Bernand D H">
<meta name="description" content="SAMT Technical Test - Bernand D H">

<meta name="author" content="Bernand Dayamuntari Hermawan S.Kom, Dika Andharu S.Kom">
<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="SAMT Technical Test - Bernand D H">
<meta itemprop="description" content="SAMT Technical Test - Bernand D H">
@hasSection('meta_image')
<meta property="image" content="@yield('meta_image')">
@else
<meta property="image" content="{{ asset('assets/img/logo.jpg') }}">
@endif

<!-- Twitter Card data -->
<meta name="twitter:card" content="SAMT Technical Test - Bernand D H">
<meta name="twitter:site" content="SAMT Technical Test - Bernand D H">
<meta name="twitter:title" content="SAMT Technical Test - Bernand D H">
<meta name="twitter:description" content="SAMT Technical Test - Bernand D H">
<meta name="twitter:creator" content="Bernand Dayamuntari Hermawan S.Kom, Dika Andharu S.Kom">
@hasSection('meta_image')
<meta property="twitter:image" content="@yield('meta_image')">
@else
<meta property="twitter:image" content="{{ asset('assets/img/logo.jpg') }}">
@endif
<meta name="twitter:data1" content="SAMT Technical Test - Bernand D H">
<meta name="twitter:label1" content="SAMT Technical Test - Bernand D H">

<!-- Open Graph data -->
<meta property="og:title" content="SAMT Technical Test - Bernand D H">
<meta property="og:type" content="article">
<meta property="og:url" content="berdikari.tech">

@hasSection('meta_image')
<meta property="og:image" content="@yield('meta_image')">
@else
<meta property="og:image" content="{{ asset('assets/img/logo.jpg') }}">
@endif

<meta property="og:description" content="SAMT Technical Test - Bernand D H">
<meta property="og:site_name" content="SAMT Technical Test - Bernand D H">
