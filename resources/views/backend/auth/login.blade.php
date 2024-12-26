@extends('backend.layouts.external')

@section('content')  {{-- Define a main section in your layout --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
 
    <div class="inner-background">
      <div class="another">
          <div class="secondbox">
              <h1 style="margin-left: 86px;">Hotel</h1>
              @section('form')  {{-- Start form section --}}
              <form action="{{ route('login.post') }}" id="login-form" method="POST">
                @csrf
                <div class="form">
                  <div class="mail">
                    <label for="mail">Email address</label>
                    <input type="email" id="mail" name="email" style="width: 84%" required>
                  </div>
                  <div class="passcode">
                   <label for="passcode">Password</label>
                  <div class ="inputbox">
                    <input type="password" id="passcode" name="password" style="width: 84%" required>
                    <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" height="16" style="width: 20px; cursor: pointer; position: absolute; margin-left: 217px; display: block;" viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"/></svg>
                    <svg id= "eye-close" xmlns="http://www.w3.org/2000/svg" height="16" style="width: 20px; cursor: pointer; position: absolute; margin-left: 217px; display: none;" viewBox="0 0 576 512"><path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/></svg>
                  </div>
                  </div>
                </div>

                <div class="pass">
                  <p><a href="{{route('forgetpassword')}}" style="margin-right: 34px">Forgot Password?</a></p>
                </div>

                <button type="submit" id="signin-btn">LOGIN</button>
              </form>
              <div id="customNotification" class="custom-notification"></div>

              <div class="container">

@section('condition')  {{-- Start condition section --}}
<div class="nt-5">
    @if($errors->any())
    <div class="col-12">
        @foreach($errors->all() as $error)
        <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    </div>
    @endif

    @if(session()->has('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
    @endif

    @if(session()->has('success'))
    <div class="alert alert-success">{{session('success')}}</div>
    @endif
</div>
@show  {{-- End condition section --}}
</div>
              @show  {{-- End form section --}}
          </div>
      </div>  
    </div>

    <div class="footer">
      <div class="footerone">
      ©2024 Code Logic Technologies Pvt. Ltd.   All rights reserved
      </div>
    </div>
  </div>
</body>


<script>
    const eyeOpen = document.getElementById("eye-open"); 
    const eyeClose = document.getElementById("eye-close"); 
    const password = document.getElementById("passcode"); 

    eyeOpen.onclick = function() {
        password.type = "text"; 
        eyeOpen.style.display = "none";
        eyeClose.style.display = "block";
    }

    eyeClose.onclick = function() {
        password.type = "password"; 
        eyeClose.style.display = "none";
        eyeOpen.style.display = "block";
    }
</script>

<script>
  $(document).ready(function(){
    $('#login-form').validate({
      rules: {
        email: {
          required: true,
          email: true
        },
        password: {
          required: true
        },
    },
    messages:{
      email: {
        required: "Please enter your email",
        email: " Please enter a valid email address"
      },
      password: {
        required: "Please enter your password"
      },

    },
    highlight: function(element) {
                $(element).addClass('border-danger');
            },
     unhighlight: function(element) {
         $(element).removeClass('border-danger');
        
        },

    });

    $('#signin-btn').off('click');
        $('#signin-btn').on('click', function() {
            if ($('#login-form').valid()) {
                $('#signin-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading...');

                $('#login-form').ajaxSubmit({
                    success: function(response) {
                        var result = typeof response === "string" ? JSON.parse(response) : response;
                        showNotification(result.message, result.type);

                        if (result.type === 'success') {
                            $('#login-form')[0].reset();
                            window.location.href = result.route;
                            $('#signin-btn').prop('disabled', false).html('Sign In');
                        } else if (result.type === 'warning') {
                            window.location.href = result.route;
                            $('#login-form')[0].reset();
                            $('#signin-btn').prop('disabled', false).html('Sign In');
                        } else {
                            window.location.href = result.route;
                            $('#signin-btn').prop('disabled', false).html('Sign In');
                        }
                    },
                    error: function() {
                        $('#signin-btn').prop('disabled', false).html('Sign In');
                        showNotification('An error occurred. Please try again.', 'error');
                    }
                });
            }
        });

  })

</script>


@endsection
