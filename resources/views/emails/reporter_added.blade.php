<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Trackify Media Team</title>
</head>
<body style='border-top: 10px solid #3fa3df ;text-align: center; color:#000 !important;'>
        <div style='text-align: center;padding: 10px; background-color:white;'>
            <img src='https://pressbro.com/News/assets/img/mediaLogo.png' style='width: 20%;vertical-align:middle'>
        </div>
        <div style='background-color: #fff; color:#000 !important; padding: 0% 10%; text-align: center;'>
                            <h3 align='center'> <span style="font-size:18px;"> Reset Password</span> <br>
                            Hello, {{ $reporterName }}</h3>
                            <p style='color: #757272; text-align:center:' >To reset your password please click on the below button.
                                <a href="{{ route('reporter.resetPassword', [$userId, $token]) }}"> Reset Password</button></a>  
                                </p>
                        </div>
                    <p>Thank you for joining our Team.</p>
                    <p>Thank you</p>
</body>
</html>