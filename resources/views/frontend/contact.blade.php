<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Basic Meta -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- Mobile Meta -->
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <!-- Site Meta -->
   <title>Keto</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
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
   <!-- Fancybox -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
   <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->


</head>
<body class="main-layout">
   <!-- Loader -->
   <div class="loader_bg">
      <div class="loader"><img src="{{ asset('frontpanel/assets/images/loading.gif') }}" alt="Loading"></div>
   </div>
   <!-- Header -->
   <header>
      <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 logo_section">
                  <div class="full">
                     <div class="center-desk">
                        <div class="logo">
                           <a href="index.html"><img src="{{ asset('frontpanel/assets/images/logo.png') }}" alt="Logo"></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                  <nav class="navigation navbar navbar-expand-md navbar-dark">
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                     </button>
                     <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav mr-auto">
                           <li class="nav-item">
                              <a class="nav-link" href="index.html">Home</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" href="about.html">About</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" href="room.html">Our Room</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" href="gallery.html">Gallery</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" href="blog.html">Blog</a>
                           </li>
                           <li class="nav-item active">
                              <a class="nav-link" href="contact.html">Contact Us</a>
                           </li>
                        </ul>
                     </div>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </header>
   <!-- Banner Section -->
   <div class="back_re">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="title">
                  <h2>Contact Us</h2>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Contact Section -->
   <div class="contact">
      <div class="container">
         <div class="row">
            <div class="col-md-6">
               <form id="contactus" action="{{route('contact.save')}}" method="POST" enctype="multipart/form-data" class="main_form">
                  @csrf
                  <div class="row">
                     <div class="col-md-12">
                        <input class="contactus" placeholder="Name" type="text" name="name">
                     </div>
                     <div class="col-md-12">
                        <input class="contactus" placeholder="Email" type="email" name="email">
                     </div>
                     <div class="col-md-12">
                        <input class="contactus" placeholder="Phone Number" type="text" name="phone_number">
                     </div>
                     <div class="col-md-12">
                        <textarea class="textarea" placeholder="Message" name="message"></textarea>
                     </div>
                     <div class="col-md-12">
                        <button class="send_btn" type="submit">Send</button>
                     </div>
                  </div>
               </form>
            </div>
            <div class="col-md-6">
               <div class="map_main">
                  <div class="map-responsive">
                     <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d2777.017648781283!2d85.33038864228291!3d27.683763288955074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2snp!4v1735206315710!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Footer -->
   <footer>
      <div class="footer">
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                  <h3>Contact Us</h3>
                  <ul class="conta">
                     <li><i class="fa fa-map-marker"></i> Address</li>
                     <li><i class="fa fa-mobile"></i> +01 1234569540</li>
                     <li><i class="fa fa-envelope"></i><a href="#"> demo@gmail.com</a></li>
                  </ul>
               </div>
               <div class="col-md-4">
                  <h3>Menu Link</h3>
                  <ul class="link_menu">
                     <li><a href="#">Home</a></li>
                     <li><a href="about.html">About</a></li>
                     <li><a href="room.html">Our Room</a></li>
                     <li><a href="gallery.html">Gallery</a></li>
                     <li><a href="blog.html">Blog</a></li>
                     <li><a href="contact.html">Contact Us</a></li>
                  </ul>
               </div>
               <div class="col-md-4">
                  <h3>Newsletter</h3>
                  <form class="bottom_form">
                     <input class="enter" placeholder="Enter your email" type="email" name="email">
                     <button class="sub_btn" type="submit">Subscribe</button>
                  </form>
                  <ul class="social_icon">
                     <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                     <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                     <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                     <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="copyright">
            <div class="container">
               <div class="row">
                  <div class="col-md-10 offset-md-1">
                     <p>© 2019 All Rights Reserved. Design by <a href="https://html.design/">Free Html Templates</a><br><br>
                        Distributed by <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </footer>
   <!-- Javascript Files -->
   <script src="{{ asset('frontpanel/assets/js/jquery.min.js') }}"></script>
   <script src="{{ asset('frontpanel/assets/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('frontpanel/assets/js/jquery-3.0.0.min.js') }}"></script>
   <script src="{{ asset('frontpanel/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
   <script src="{{ asset('frontpanel/assets/js/custom.js') }}"></script>
   <script>
      $(document).ready(function(){
         // send data from contact us
         $('.send_btn').off('click')
         $('.send_btn').on('click',function(){
            console.log('clicked')
            $('#contactus').ajaxSubmit({

            })
         })
      })

</script>
</body>
</html>
