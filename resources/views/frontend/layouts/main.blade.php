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
      @if (!empty($siteSetting->img_favicon) && Storage::disk('public')->exists('setting/' .$siteSetting->img_favicon))
    <link rel="icon" href="{{ asset('storage/setting/'. $siteSetting->img_favicon ) }}" type="image/png">
    @else
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    @endif
      <!-- Bootstrap CSS -->
   <link id="style" href="{{ asset('backpanel/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
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

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
   <!-- Nepali date picker -->
   <link href="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/css/nepali.datepicker.v4.0.1.min.css"
   rel="stylesheet" type="text/css" />   <script src="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.1.min.js"
   type="text/javascript"></script>
   <link rel="stylesheet" href="{{ asset('backpanel/assets/css/fontawesome-iconpicker.min.css') }}">

   <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css" integrity="sha512-d0olNN35C6VLiulAobxYHZiXJmq+vl+BGIgAxQtD5+kqudro/xNMvv2yIHAciGHpExsIbKX3iLg+0B6d0k4+ZA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <!-- Fancybox -->
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen"> -->
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
      <link
      href="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/css/nepali.datepicker.v4.0.5.min.css"
      rel="stylesheet" type="text/css"/>
   <script src="{{ asset('frontpanel/assets/js/bootstrap.bundle.min.js') }}"></script>
   <!-- <script src="{{ asset('frontpanel/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script> -->
   <script src="{{ asset('frontpanel/assets/js/custom.js') }}"></script>
   <script
      src="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.5.min.js"
      type="text/javascript"></script>
   <script>
        function showDatePicker() {
            window.onload = function() {
                var mainInput = document.getElementById("nepali-datepicker");
                mainInput.nepaliDatePicker();
            };

            $("#nepali-datepicker").nepaliDatePicker({
                container: ".datepick",
            });
            // $("#nepali-datepicker1").nepaliDatePicker({
            //     container: ".datepick1",
            // });
        }
     

 

   </script>
   </body>
</html>