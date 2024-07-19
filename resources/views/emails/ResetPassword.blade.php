
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
     
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
   
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9 mt-5" >

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <?php 
                        if($reporter->token){
                        ?>
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block" >
                                <img src="{{ asset('assets/img/images/Reset password-rafiki.png') }}" style="margin-top:10px; width:100%;" alt="">
                            </div>
                            <div class="col-lg-6" style="margin-top:50px;">
                                <div class="p-5">
                                    <div class="text-center">
                                    <img src="{{ asset('assets/img/images/logo.png') }}" style="width:100%;" alt="">
                                        <h4>Reset Password</h4>
                                    </div>
                                    <form class="user" method="post" action="{{ route('reporter.updatePassword') }}" onsubmit="return checkPassword()">
                                        @csrf
                                        <div class="form-group mt-3">
                                            <input type="password" id="password1" name="password1" class="form-control input-shadow" placeholder="New Password" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" id="password2" name="password2" class="form-control input-shadow" placeholder="Confirm Password" required>
                                        </div>
                                        <input type="hidden" id="token" name="token" value="{{ $reporter->token }}">
                                        <input type="hidden" id="user_id" name="user_id" value="{{ $reporter->user_id }}">
                                        <button type="submit" class="btn btn-primary btn-block" style="background-color:#4e73df;">Submit</button>
                                    </form>
                            </div>
                        </div>
                        <?php
                        } else { 
                            ?>
                            <h5 class="text-center m-5">This link is expired</h5>
                        <?php
                        }?>
                    </div>
                </div>

            </div>

        </div>

    </div>

   
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->    
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    <script>
function checkPassword() {
    const password1 = document.getElementById('password1').value;
    const password2 = document.getElementById('password2').value;

    if (password1 !== password2) {
        alert('Passwords do not match. Please try again.');
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}
</script>

</script>
</body>

</html>
