<!DOCTYPE html>
<html lang="en">
    
<script src="{{ asset('backpanel/assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('backpanel/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Defaultmenu JS -->
    <script src="{{ asset('backpanel/assets/js/defaultmenu.min.js') }}"></script>

    <!-- Node Waves JS-->
    <script src="{{ asset('backpanel/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Sticky JS -->
    <script src="{{ asset('backpanel/assets/js/sticky.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('backpanel/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backpanel/assets/js/simplebar.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('backpanel/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>


    <!-- Apex Charts JS -->
    <script src="{{ asset('backpanel/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- JSVector Maps JS -->
    <script src="{{ asset('backpanel/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>

    <!-- JSVector Maps MapsJS -->
    <script src="{{ asset('backpanel/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('backpanel/assets/js/us-merc-en.js') }}"></script>

    <!-- Chartjs Chart JS -->
    <script src="{{ asset('backpanel/assets/js/index.js') }}"></script>


    <!-- Custom-Switcher JS -->
    <script src="{{ asset('backpanel/assets/js/custom-switcher.min.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('backpanel/assets/js/custom.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.1.min.js" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script type="text/javascript" src="{{ asset('backpanel/assets/js/fontawesome-iconpicker.min.js') }}"></script>

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('backpanel/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('backpanel/assets/js/date&time_pickers.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <script src="{{ asset('backpanel/assets/js/jquery-validate.js') }}"></script>

    <!-- cropper js-->
    <script src="{{ asset('backpanel/assets/js/cropper/cropper.common.js') }}"></script>
    <script src="{{ asset('backpanel/assets/js/cropper/cropper.esm.js') }}"></script>
    <script src="{{ asset('backpanel/assets/js/cropper/cropper.js') }}"></script>
    <script src="{{ asset('backpanel/assets/js/cropper/cropper.min.js') }}"></script>

    <!-- Sweetalerts JS -->
    <script src="{{ asset('backpanel/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('backpanel/assets/js/sweet-alerts.js') }}"></script>
  <style>
    body {
    background-image: url("/images/wallpaperflare.com_wallpaper.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    margin: 0;
    height: 100%;
    width: 100%;
    position: relative;
}

.inner-background {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    gap: 20rem;
    top:0;
    left:0;
    position: fixed;
     background-color: rgba(29, 122, 215, 0.6);
    
     

}


    


h4 {
    color: rgb(29, 103, 215);

}

.secondbox {

    background-color: rgba(255, 255, 255, 0.6);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: -1px 1px 10px 6px rgba(0, 0, 0, 0.6);
    width: 16rem;
    height: 20rem;
    padding: 20px;
    margin: 0;


}
.img {
    width: 10rem;
}


.footer {

    text-align: left;
    margin: 0;
    padding: 0;
    width: 100%;
    background-color: rgb(66, 88, 161);
    box-shadow: -1px 1px 10px 6px rgba(0, 0, 0, 0.6);
    border-collapse: collapse;
    height: 31px;



}

button {
    height: 28px;
    width: 13rem;
    font-weight: 400;
    background-color: rgb(12, 12, 113);
    color: white;
    border-radius: 4px;
    border: none;
    margin: left 20px;
    padding: .375rem .75rem;

}
button:hover{
    background-color: rgb(90, 90, 241);

}
h3{
    font-weight: bolder;
    font-size: 30px;
}
h4{
    font-weight: bolder;
    font-size: 23px;
}
.pass{
    text-align: right;
    font-size: 15px;
    font-size: small;
    font-weight: bold;
    margin-top: 0;
    
   
    
}

#mail, #passcode{
margin: 0;
justify-content: space-evenly;

}
.footer{
    display:flex;
    gap: 45rem;
    justify-content: space-around;
    justify-content: center;
    
    
   
} 
.form{
    margin-top: 40px;
   
}
.mail{
    margin-top: 15px;
}

.passcode{
    margin-top: 10px;
   
}
.inputbox{
    display: flex;
    align-items:center;
}
.blue-text {
    color: blue;
}

.red-text {
    color: red;
}
.another{
    display: flex;
    gap:20rem;
    margin-top: 8rem;
}
.footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #658291;
    color: white;
    text-align: center;
    
}
.footerone, .footertwo{
    color:black;
}
.footertwo{
    display: flex;
   
}
#red{
    color: red;
    margin-left: 5px;
}
#blue{
    color: blue;
    margin-left: 5px;
}
input{
   border-radius: 5px;
   height:20px;
   width:170px;
   border-color: gray;
   padding: .375rem .75rem

}
.form{
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    
}
</style>
<script>
        $('.alert').delay(3000).fadeOut();
    </script>
    <script>
        var baseurl = '{{ url(' / ') }}';
        var token = "<?= csrf_token() ?>";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        function showLoader() {
            $('#loadingOverlay').show();
        }

        function hideLoader() {
            $('#loadingOverlay').hide();
        }

        function showNotification(message, type) {
            var notification = document.getElementById('customNotification');
            notification.textContent = message;

            if (type === 'success') {
                notification.style.backgroundColor = '#28a745'; // Green for success
            } else if (type === 'error') {
                notification.style.backgroundColor = '#dc3545'; // Red for error
            }

            // Show the notification
            notification.style.display = 'block';

            // Hide the notification after 3 seconds (adjust as needed)
            setTimeout(function() {
                notification.style.display = 'none';
            }, 3000);
        }
    </script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    {{-- <div class="authincation h-100">
        <div class="container h-100"> --}}


    <!-- Loader with Background Overlay -->
    <div id="loadingOverlay" style="display: none; position: fixed;top: 0px;left: 0px;width: 100%;height: 100%;background: rgb(10 10 10 / 64%);z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border spinner-border-lg  text-danger" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>


@yield('content')

  <!-- <div class="container">
    @yield('condition')
    <div class="inner-background">
      <div class="another">
        <div class="secondbox">
          <h1>Hotel</h1>
          @yield('form')
        </div>
      </div>
    </div>

    <div class="footer">
      <div class="footerone">
        2024 &copy Utkarsha Aryal
      </div>
    </div>
  </div> -->
</body>

</html>