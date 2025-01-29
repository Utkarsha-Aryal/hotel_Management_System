<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>@yield('title')</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="{{ asset('frontpanel/assets/css/bootstrap.min.css') }}">
   <!-- Custom CSS -->
   <link rel="stylesheet" href="{{ asset('frontpanel/assets/css/style.css') }}">
   <!-- Responsive CSS -->
   <link rel="stylesheet" href="{{ asset('frontpanel/assets/css/responsive.css') }}">
   <!-- Favicon -->
   <link rel="icon" href="{{ asset('frontpanel/assets/images/fevicon.png') }}" type="image/gif">
   <!-- Scrollbar Custom CSS -->
   <link rel="stylesheet" href="{{ asset('frontpanel/assets/css/jquery.mCustomScrollbar.min.css') }}">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

   <!-- Fancybox -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      <!-- <div class="loader_bg">
      <div class="loader"><img src="{{ asset('frontpanel/assets/images/loading.gif') }}" alt="Loading"></div>
      </div> -->

      @include('frontend.layouts.header')
      <div class="main-content app-content">
            <div class="container-fluid">
                @yield('main-content')
            </div>
        </div>
      @include('frontend.layouts.footer')
      
   <script src="{{ asset('frontpanel/assets/js/jquery.min.js') }}"></script>
   <script src="{{ asset('frontpanel/assets/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('frontpanel/assets/js/jquery-3.0.0.min.js') }}"></script>
   <script src="{{ asset('frontpanel/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
   <script src="{{ asset('frontpanel/assets/js/custom.js') }}"></script>
   </body>
</html>