@extends('backend.layouts.external')

@section('content')  {{-- Define a main section in your layout --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script> </script>
</head>

<body>
  <div class="container">
    
    <div class="inner-background">
      <div class="another">
          <div class="secondbox">
              <h1>Forget Password</h1>
              @section('form')  {{-- Start form section --}}
              <form action="{{route('checkuser')}}" method="POST" id="resetOtpMailForm" autocomplete="off">
                @csrf
                <div class="form">
                  <div class="mail">
                    <label for="mail">Email address</label>
                    <input type="email" id="mail" name="email" placeholder="enter your email" required>
                  </div>

                <div class="pass">
                  <p><a href="{{route('login')}}">back to login</a></p>
                </div>

                <button type="submit" id="forgetpassword">Send</button>
              </form>
              <div id="customNotification" class="custom-notification"></div>

              @show  {{-- End form section --}}

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
  $(document).ready(function(){
    $("#resetOtpMailForm").validate({
      rules:{
        email: {
          required: true,
          email: true
        },
      },
      messages: {
        email: {
          required: "Please enter your email",
          email:"Please enter a valid email address"
        },
      },
      highlight: function(element){
        $(element).addClass('border-danger');
      },
      unhighlight: function(element) {
                $(element).removeClass('border-danger');
      },
    })

    $('#forgetpassword').off('click');
        $('#forgetpassword').on('click', function() {
            if ($('#resetOtpMailForm').valid()) {
                $('#forgetpassword').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading...');

                $('#resetOtpMailForm').ajaxSubmit({
                    success: function(response) {
                        var result = typeof response === "string" ? JSON.parse(response) : response;
                        showNotification(result.message, result.type);

                        if (result.type === 'success') {
                            $('#resetOtpMailForm')[0].reset();
                            window.location.href = result.route; // Redirect to the specified route
                            $('#forgetpassword').prop('disabled', false).html('Reset Password');
                        } else {
                            window.location.href = result.route; // Redirect to the specified route
                            $('#forgetpassword').prop('disabled', false).html('Reset Password');
                        }
                    },
                    error: function() {
                        $('#forgetpassword').prop('disabled', false).html('Reset Password');
                        showNotification('An error occurred. Please try again.', 'error');
                    }
                });
            }
        });



  })
</script>

@endsection
