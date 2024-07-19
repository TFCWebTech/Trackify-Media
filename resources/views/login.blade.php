<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>News Report System</title>

    <!-- Custom fonts for this template-->
    <!-- <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css"> -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
<style>
    .mt-4, .my-4 {
    margin-top: 1.5rem !important;
    margin-left: -0.5rem !important;
}
dl, ol, ul {
    margin-top: 0;
    margin-bottom: 0rem !important;
}
</style>

<!-- Include the necessary CSS and JS libraries for DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<body class="bg-gradient-primary">

    <div class="container"> 

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"> -->
                            <div class="col-lg-6 border-right" id="mo_display_none">
                                <img src="{{ asset('assets/img/images/Mobile login-pana.png') }}" style="width:100%;" alt="">
                            </div>
                            <div class="col-lg-6 mt-4">
                                <div id="error-messages" class="alert alert-danger" style="display: none;">
                                    <ul></ul>
                                </div>
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form id="login-form" action="{{ route('login.user') }}" method="POST" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="userId" class="form-control form-control-user" placeholder="Enter User Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="user_password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Enter Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" type="button" class="btn btn-primary" data-toggle="modal" data-target="#forgotModal">Forgot Password?</a>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="forgotModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Forget Password</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post">
                
                        <div class="mb-1 mt-0">
                            <p class="pb-1">Please enter your email address. You will receive a link to create a new password via email.</p>
                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="send_email" onchange="checkEmail()" required >
                            <p class="text-danger" id="display-error">This email does not exist.</p>
                        </div>
                        <div class="float-right pt-1">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- <script>
    function checkEmail() {
        var searchEmail = $('#email').val();

        $.ajax({
            type: 'POST',
             url: "{{route('check.userMail')}} ",
             dataType: "html",
            data: {
                searchEmail: searchEmail,
                _token: '{{ csrf_token() }}', // Include CSRF token
            },
            success: function(data) {
                if (data === 'false') {
                    $('#display-error').show();
                    $('#email').val('');

                    setTimeout(function() {
                        $('#display-error').hide();
                    }, 5000);
                }
            }
        });
    }
    </script> -->

    <script>
    $(document).ready(function() {
        $('#login-form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    if (errors) {
                        $.each(errors, function(key, value) {
                            errorMessages += '<li>' + value[0] + '</li>';
                        });
                    } else {
                        errorMessages += '<li>' + xhr.responseJSON.error + '</li>';
                    }
                    $('#error-messages ul').html(errorMessages);
                    $('#error-messages').show();
                }
            });
        });
    });
</script>


  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('assets/vendor/jquery/jquery.min.js');}}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js');}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js');}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js');}}"></script>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript">



