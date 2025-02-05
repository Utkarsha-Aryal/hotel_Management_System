
@extends('frontend.layouts.main')

@section('title')
Home
@endsection 
  @section('main-content')
  <style>
     
.datepickss{
    position: relative;
}
    input#nepali-datepicker {
        width: 100% !important;
        height: 50% !important;
        border-radius: 0.2rem !important;
        border: 0.1px solid rgb(236, 231, 231);
        padding-left: 0.5rem !important;
    }
    input#nepali-datepicker {
        width: 100% !important;
        height: 50% !important;
        border-radius: 0.2rem !important;
        border: 0.1px solid rgb(236, 231, 231);
        padding-left: 0.5rem !important;
    }
    #ndp-nepali-box {
        top: 50px !important;
        left: 10px !important;
    }
  </style>
      <!-- end header inner -->
      <!-- end header -->
      <!-- banner -->
      <section class="banner_main">
         <div id="myCarousel" class="carousel slide banner" data-ride="carousel">
            <ol class="carousel-indicators">
               <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
               <li data-target="#myCarousel" data-slide-to="1"></li>
               <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
               <div class="carousel-item active">
                <!-- {{ asset('frontpanel/assets/images/loading.gif') }} -->
                  <img class="first-slide" src="{{ asset('frontpanel/assets/images/banner1.jpg')}}" alt="First slide">
                  <div class="container">
                  </div>
               </div>
               <div class="carousel-item">
                  <img class="second-slide" src="{{ asset('frontpanel/assets/images/banner2.jpg')}}" alt="Second slide">
               </div>
               <div class="carousel-item">
                  <img class="third-slide" src="{{ asset('frontpanel/assets/images/banner3.jpg')}}" alt="Third slide">
               </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
         </div>
         <div class="booking_ocline">
            <div class="container">
               <div class="row">
                  <div class="col-md-5">
                     <div class="book_room">
                        <h1>Book a Room Online</h1>
                        <form id="book_now" action = "{{route('booknow')}}" method = "POST"  enctype="multipart/form-data" >
                           @csrf
                           <div class="row">
                              <div class="col-md-12 datepick">
                                 <span>Arrival</span>
                                 <!-- <img class="date_cua" src="{{ asset('frontpanel/assets/images/date.png')}}"> -->
                                 <input type="text" id="nepali-datepicker-work-order" name="start_date" class="form-control" placeholder="Select start date">
                                 </div>
                              <div class="col-md-12 datepickss">
                                 <span>Departure</span>
                                 <!-- <img class="date_cua" src="{{ asset('frontpanel/assets/images/date.png')}}"> -->
                                 <input type="text" id="nepali-datepicker-work-completion" name="end_date" class="form-control nepali-datepicker" placeholder="Select end date">
                                 </div>
                              <div class="col-md-12">
                                 <button class="book_btn" type="submit">Book Now</button>
                              </div>
                              <!--   <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 datepick">
                                <label for="maximum occupancy" class="form-label">Start Date <span class="required-field">*</span></label>
                                <input type="text" id="nepali-datepicker-work-order" name="start_date" class="form-control" placeholder="Select start date">
                            </div>
                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 datepickss">
                                <label for="maximum occupancy" class="form-label">End Date <span class="required-field">*</span></label>
                                <input type="text" id="nepali-datepicker-work-completion" name="end_date" class="form-control nepali-datepicker" placeholder="Select end date">
                            </div> -->
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- end banner -->
      <!-- about -->
      <div class="about">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-5">
                  <div class="titlepage">
                     <h2>About Us</h2>
                     <p>The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software. Today it's seen all around the web; on templates, websites, and stock designs. Use our generator to get your own, or read on for the authoritative history of lorem ipsum. </p>
                     <a class="read_more" href="Javascript:void(0)"> Read More</a>
                  </div>
               </div>
               <div class="col-md-7">
                  <div class="about_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/about.png')}}" alt="#"/></figure>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end about -->
      <!-- our_room -->
      <div  class="our_room">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Our Room</h2>
                     <p>Lorem Ipsum available, but the majority have suffered </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4 col-sm-6">
                  <div id="serv_hover"  class="room">
                     <div class="room_img">
                        <figure><img src="{{ asset('frontpanel/assets/images/room1.jpg')}}" alt="#"/></figure>
                     </div>
                     <div class="bed_room">
                        <h3>Bed Room</h3>
                        <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div id="serv_hover"  class="room">
                     <div class="room_img">
                        <figure><img src="{{ asset('frontpanel/assets/images/room2.jpg')}}" alt="#"/></figure>
                     </div>
                     <div class="bed_room">
                        <h3>Bed Room</h3>
                        <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div id="serv_hover"  class="room">
                     <div class="room_img">
                        <figure><img src="{{ asset('frontpanel/assets/images/room3.jpg')}}" alt="#"/></figure>
                     </div>
                     <div class="bed_room">
                        <h3>Bed Room</h3>
                        <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div id="serv_hover"  class="room">
                     <div class="room_img">
                        <figure><img src="{{ asset('frontpanel/assets/images/room4.jpg')}}" alt="#"/></figure>
                     </div>
                     <div class="bed_room">
                        <h3>Bed Room</h3>
                        <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div id="serv_hover"  class="room">
                     <div class="room_img">
                        <figure><img src="{{ asset('frontpanel/assets/images/room5.jpg')}}" alt="#"/></figure>
                     </div>
                     <div class="bed_room">
                        <h3>Bed Room</h3>
                        <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6">
                  <div id="serv_hover"  class="room">
                     <div class="room_img">
                        <figure><img src="{{ asset('frontpanel/assets/images/room6.jpg')}}" alt="#"/></figure>
                     </div>
                     <div class="bed_room">
                        <h3>Bed Room</h3>
                        <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end our_room -->
      <!-- gallery -->
      <div  class="gallery">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>gallery</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery1.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery2.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery3.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery4.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery5.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery6.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery7.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery8.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end gallery -->
      <!-- blog -->
      <div  class="blog">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Blog</h2>
                     <p>Lorem Ipsum available, but the majority have suffered </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="blog_box">
                     <div class="blog_img">
                        <figure><img src="{{ asset('frontpanel/assets/images/blog1.jpg')}}" alt="#"/></figure>
                     </div>
                     <div class="blog_room">
                        <h3>Bed Room</h3>
                        <span>The standard chunk </span>
                        <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generatorsIf you are   </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="blog_box">
                     <div class="blog_img">
                        <figure><img src="{{ asset('frontpanel/assets/images/blog2.jpg')}}" alt="#"/></figure>
                     </div>
                     <div class="blog_room">
                        <h3>Bed Room</h3>
                        <span>The standard chunk </span>
                        <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generatorsIf you are   </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="blog_box">
                     <div class="blog_img">
                        <figure><img src="{{ asset('frontpanel/assets/images/blog3.jpg')}}" alt="#"/></figure>
                     </div>
                     <div class="blog_room">
                        <h3>Bed Room</h3>
                        <span>The standard chunk </span>
                        <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generatorsIf you are   </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script>
         $(document).ready(function(){
        $("#nepali-datepicker-work-order").nepaliDatePicker({
            container: ".datepick"
        });

        $("#nepali-datepicker-work-completion").nepaliDatePicker({
            container: ".datepickss"
        });

        $('#book_btn').on('submit', function (e) {
         e.preventDefault(); // Prevent default form submission

         // Use AJAX to send the form data
         $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: new FormData(this), // Form data
            contentType: false,       // Required for file uploads
            processData: false,       // Prevent jQuery from processing the data
            success: function (response) {
               if (response.type === 'success') {
                  showNotification(response.message, 'success');
                  $('#book_now')[0].reset();
               } else {
                  showNotification(response.message, 'error');
               }
            },
            error: function (xhr) {
               if (xhr.responseJSON && xhr.responseJSON.errors) {
                  let errorMessages = '';
                  $.each(xhr.responseJSON.errors, function (key, value) {
                     errorMessages += value[0] + '\n'; // Collect validation errors
                  });
                  showNotification(errorMessages, 'error');
               } else {
                  showNotification('An unexpected error occurred.', 'error');
               }
            }
         });
      });


      })

      </script>
  @endsection