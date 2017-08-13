<?php
error_reporting(0);
session_start();
if (isset($_SESSION['user_data']['id']) and !empty($_SESSION['user_data']['id'])) {
    header('Location: dashboard.php');
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>LTZ</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/index.css" rel="stylesheet">
        <script src="js/jquery-3.1.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/index.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina" rel="stylesheet">
    </head>
    <body>
    <div class="container">
        <div class="row wrapper">
            <div class="col-lg-7">
                <div class="logo-dots">
                    <div class="circle-container">
                        <div class="dots" style="background-color: yellow"></div>
                        <div class="dots" style="background-color: crimson"></div>
                    </div>
                    <div class="circle-container">
                        <div class="dots" style="background-color: darkgreen"></div>
                        <div class="dots"></div>
                    </div>
                </div>
                <div class="logo-text"><span>LTZ</span></div>
            </div>

            <div class="col-lg-5">
                <div class="border"></div>
                <form method="post" action="#" class="login-field-form" autocomplete="off" spellcheck="false">
                    <div class="error"></div>
                    <input type="email" id="username" name="username" placeholder="Email Address"
                           class="form-control inp-field"
                           autocomplete="off" spellcheck="false"><br/>
                    <input type="password" id="password" name="password" placeholder="Password"
                           class="form-control inp-field" required><br/>
                    <a href="#" style="position: relative; top: 5px">Forgot Password?</a>&nbsp;&nbsp;
                    <input type="button" class="btn login-btn" value="Login">
                    <input type="button" class="btn signup-btn" value="Signup">
                </form>
            </div>
        </div>
    </div>
    <script src="js/index.js"></script>
    </body>
    </html>
<?php } ?>
