@extends('backend.layouts.external')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="inner-background">
        <div class="another">
            <div class="secondbox">
                <h1>Hotel</h1>
                @section('form')
                <form action="{{ route('validotp') }}" id="otpForm" method="POST" autocomplete="off">
                    @csrf
                    <div class="form">
                        <div class="mail">
                            <label for="otp">Check your mail and enter OTP</label>
                            <input type="hidden" name="id" id="id" value="{{ session('id') }}">
                            <input type="text" id="otp" name="otp" maxlength="4" placeholder="Enter your OTP">
                            @error("otp")
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="submitOtp">Send OTP</button>
                </form>
                @show
                <div class="container">
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
                    <div id="customNotification" class="custom-notification"></div>

                    @show
                </div>
            </div>
        </div>  
    </div>

    <div class="footer">
        <div class="footerone">
            2024 &copy; Utkarsha Aryal
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        $('#otpForm').validate({
            rules: {
                otp: {
                    required: true,
                    minlength: 4,
                    maxlength: 4,
                    
                }
            },
            messages: {
                otp: {
                    required: "Please enter OTP",
                    minlength: "OTP must be exactly 4 digits",
                    maxlength: "OTP must be exactly 4 digits",
                
                }
            }
        });

        $('.submitOtp').off('click').on('click', function(e) {
            e.preventDefault();
            if ($('#otpForm').valid()) {
                $('.submitOtp').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                
                $('#otpForm').ajaxSubmit({
                    success: function(response) {
                        $('#otpForm')[0].reset();
                        $('.submitOtp').prop('disabled', false).html('Submit OTP');
                        window.location.href = response.route; // Redirect to the specified route
                    },
                    error: function() {
                        $('.submitOtp').prop('disabled', false).html('Submit OTP');
                        showNotification('An error occurred. Please try again.', 'error');
                    }
                });
            }
        });

        function showNotification(message, type) {
            $('#customNotification').text(message).addClass(`alert alert-${type}`);
            setTimeout(() => {
                $('#customNotification').text('').removeClass(`alert alert-${type}`);
            }, 3000);
        }
    });
</script>

@endsection
