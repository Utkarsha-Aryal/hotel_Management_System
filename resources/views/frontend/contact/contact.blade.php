
@extends('frontend.layouts.main')

@section('title')
Contact us
@endsection 
  @section('main-content')
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
                  <div id="customNotification" class="custom-notification"></div>
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
                     <iframe src= "{{$siteSetting->link_map}}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Footer -->
  
   <!-- Javascript Files -->
   <script src="{{ asset('frontpanel/assets/js/jquery.min.js') }}"></script>
   <script src="{{ asset('frontpanel/assets/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('frontpanel/assets/js/jquery-3.0.0.min.js') }}"></script>
   <script src="{{ asset('frontpanel/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
   <script src="{{ asset('frontpanel/assets/js/custom.js') }}"></script>
   <script>
   function showNotification(message, type) {
      var notification = document.getElementById('customNotification');
      notification.innerHTML = message.replace(/\n/g, '<br>');
      notification.style.backgroundColor = type === 'success' ? '#28a745' : '#dc3545';
      notification.style.display = 'block';
      setTimeout(function () {
         notification.style.display = 'none';
      }, 3000);
   }

   $(document).ready(function () {
      // Intercept form submission
      $('#contactus').on('submit', function (e) {
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
                  $('#contactus')[0].reset();
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
   });
</script>
@endsection

