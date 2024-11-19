@extends('backend.layouts.external')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>

<body>
  <div class="container">
    <div class="inner-background">
      <div class="another">
          <div class="secondbox">
              <h1>Hotel</h1>
              @section('form')
              <form action="{{ route('updatepassword') }}" id="resetPasswordForm" method="POST">
                @csrf
                <div class="form">
                  <div class="mail">
                    <input type="hidden" name='id' id="id" value="{{ session('id') }}">
                    <label for="password">New Password</label>
                    <div class="passcode">
                      <div class="inputbox">
                    <input type="password" id="passcode" name="password" style="width: 84%" required>
                    <img src="{{ asset('images/eye-close.png') }}" alt="Closed Eye Icon" id="eyeicon" style="width:20px;
                    cursor: pointer;">
                    </div>
                    </div>
                    @error('password')
                      <div class="error">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="passcode">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="inputbox">
                    <input type="password" id="confirm_password" name="confirm_password" style="width: 84%" required>
                    <img src="{{ asset('images/eye-close.png') }}" alt="Closed Eye Icon" id="eyeicon2" style="width:20px;
                    cursor: pointer;">
                    @error('confirm_password')
                      <div class="error">{{ $message }}</div>
                    @enderror
                  </div>
                  </div>
                </div>

                <div class="pass">
                  <p><a href="{{route('login')}}">Back to login</a></p>
                </div>

                <button type="submit" class="resetPassword">Submit</button>
              </form>
              @show

              @section('condition')
              <div class="nt-5">
                  @if($errors->any())
                      <div class="col-12">
                          @foreach($errors->all() as $error)
                              <div class="alert alert-danger">{{ $error }}</div>
                          @endforeach
                      </div>
                  @endif

                  @if(session()->has('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                  @endif

                  @if(session()->has('success'))
                      <div class="alert alert-success">{{ session('success') }}</div>
                  @endif
              </div>
              @show
          </div>
      </div>  
    </div>

    <div class="footer">
      <div class="footerone">
        2024 &copy; Utkarsha Aryal
      </div>
    </div>
  </div>
</body>

<script>
  $(document).ready(function() {
    $('#resetPasswordForm').validate({
      rules: {
        passcode: {
          required: true,
        },
        confirm_password: {
          required: true,
          equalTo: "#passcode"
        }
      },
      messages: {
        password: {
          required: "Please enter a new password",
        },
        confirm_password: {
          required: "Please confirm your password",
          equalTo: "Passwords do not match"
        }
      }
    });

    function showNotification(message, type) {
      $('#customNotification').text(message).addClass(`alert alert-${type}`);
      setTimeout(() => {
        $('#customNotification').text('').removeClass(`alert alert-${type}`);
      }, 3000);
    }

    $('.resetPassword').off('click').on('click', function(e) {
      e.preventDefault();
      if ($('#resetPasswordForm').valid()) {
        $('.resetPassword').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading...');

        $('#resetPasswordForm').ajaxSubmit({
          success: function(response) {
            const result = typeof response === "string" ? JSON.parse(response) : response;
            showNotification(result.message, result.type);
            $('#resetPasswordForm')[0].reset();
            window.location.href = result.route;
            $('.resetPassword').prop('disabled', false).html('Submit');
          },
          error: function() {
            $('.resetPassword').prop('disabled', false).html('Submit');
            showNotification('An error occurred. Please try again.', 'error');
          }
        });
      }
    });
  });
</script>

<script>
    let eyeicon = document.getElementById("eyeicon"); 
    let password = document.getElementById("passcode"); 
    let eyeicon2 = document.getElementById("eyeicon2");
    let confirmPassword = document.getElementById("confirm_password"); 

    eyeicon.onclick = function() {
        if (password.type === "password") {
            password.type = "text"; 
            eyeicon.src = "{{ asset('images/eye-open.png') }}"; 
        } else {
            password.type = "password"; 
            eyeicon.src = "{{ asset('images/eye-close.png') }}";
        }
    }

    eyeicon2.onclick = function() {
        if (confirmPassword.type === "password") {
            confirmPassword.type = "text"; 
            eyeicon2.src = "{{ asset('images/eye-open.png') }}"; 
        } else {
            confirmPassword.type = "password"; 
            eyeicon2.src = "{{ asset('images/eye-close.png') }}";
        }
    }
</script>
@endsection
