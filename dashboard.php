<?php
ini_set('display_errors', false);
error_reporting(0);
session_start();
require 'Database.php';

if (isset($_SESSION['user_data']['id']) and !empty($_SESSION['user_data']['id'])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>LTZ | Dashboard</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
        <script src="js/jquery-3.1.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/dashboard.js" type="text/javascript"></script>
        <link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina" rel="stylesheet" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Roboto|Ubuntu" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/dropzone.css" />
        <link rel="stylesheet" href="css/table.css"/>
        <link rel="stylesheet" href="css/animate.css"/>
        <script type="text/javascript" src="js/dropzone.js"></script>
        <script type="text/javascript">
            (function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);
        </script>
    </head>
    <body>

    <!-- Navigation Bar Start -->
    <div class="nav">
        <!-- Logo Start -->
        <a href="index.php">
            <div class="logo">
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
        </a>
        <!-- Logo End -->

        <!-- Search Start -->
        <div class="search">
            <input type="text" id="search" class="search-bar" spellcheck="false">
            <label for="search" class="search-label">Search</label>
        </div>
        <!-- Search End -->

        <!-- User Section Start -->
        <div class="person dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
               aria-expanded="false">
                <div class="person-image"><img src="images/avt.png"/></div>
                <div class="person-refer">
                    <div class="person-hello">Hello,</div>
                    <div class="person-name"><?php echo $_SESSION['user_data']['first_name'].' '.$_SESSION['user_data']['last_name']; ?></div>
                </div>
            </a>
            <ul class="dropdown-menu">
                <li><a href="#" data-toggle="modal" data-target="#uploadModal">
                        <span class="glyphicon glyphicon-cloud"></span> &nbsp; Upload</a>
                </li>
                <li class="nav-profile"><a href="javascript:toggleView('.profile-setup');"><span class="glyphicon glyphicon-user"></span> &nbsp; Profile</a>
                </li>
                <li class="nav-password"><a href="javascript:toggleView('.password-setup');"><span class="glyphicon glyphicon-lock"></span> &nbsp;
                        Change Password</a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> &nbsp; Logout</a></li>
            </ul>
        </div>
        <!-- User Section End -->
    </div>
    <!-- Navigation Bar End -->

    <!--------------------------- Search Table Start -------------------------------->
    <!-- Search Table Data Start -->
    <div class="table-container" style="display: none">
        <table class="table text-center">
            <thead>
            <tr>
                <td>File Name</td>
                <td>Uploaded on</td>
                <td>Downloaded</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <!-- Search Table Data End -->

    <!-- Search Table Close Button Start -->
    <div class="table-close-button" style="display: none;"><i class="fa fa-compress fa-lg"></i></div>
    <!-- Search Table Close Button End -->
    <!--------------------------- Search Table End ---------------------------------->

    <!-- Upload Modal Start -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document" style="width: 80%">
            <div class="modal-content" style="height: 60vh">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="myModalLabel"><b>Upload your files</b></h2>
                </div>
                <div class="modal-body" style="max-height: 60vh; overflow-y: scroll; height: 50vh">
                    <div class="image_upload_div" style="height: 50vh">
                        <form action="upload.php" class="dropzone" style="height: 48vh">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Upload Modal End -->

    <br />

    <!-- Password Setup Start -->
    <div class="custom-container password-setup" style="display: none;">
        <h1 class="text-center">Change Password</h1>
        <hr/>
        <div class="form-container">
            <form>
                <input type="password" id="old_psw" class="inp-text" spellcheck="false">
                <label for="old_psw" class="inp-label">Old Password</label>
                <input type="password" id="new_psw" class="inp-text" spellcheck="false">
                <label for="new_psw" class="inp-label">New Password</label>
                <input type="password" id="cnf_new_psw" class="inp-text" spellcheck="false">
                <label for="cnf_new_psw" class="inp-label">Confirm New Password</label><br/>
                <input type="button" id="changepwd-btn" class="btn btn-primary frm" value="Change Password">
            </form>
        </div>
    </div>
    <!-- Password Setup End -->

    <!-- Profile Setup Start -->
    <div class="custom-container profile-setup" style="display: none;">
        <h1 class="text-center">Profile Setting</h1>
        <hr/>
        <div class="form-container">
            <form>
                <input type="text" id="first_name" name="first_name" class="inp-text" spellcheck="false" value="<?php echo $_SESSION['user_data']['first_name'];?>">
                <label for="first_name" class="inp-label has-values">First Name</label>
                <input type="text" id="last_name" name="last_name" class="inp-text" spellcheck="false" value="<?php echo $_SESSION['user_data']['last_name'];?>">
                <label for="last_name" class="inp-label has-values">Last Name</label><br/><br/>
                <!--<label for="avatar" class="inp-label">Change Avatar</label>
                <label class="custom-file text-center"><input type="file" name="avatar_file" id="avatar">Upload
                    File Here</label>
                <div class="filename"></div>
                --><br/>
                <input type="button" id="profile-btn" class="btn btn-primary frm" value="Make Changes">
            </form>
        </div>
    </div>
    <!-- Profile Setup End -->

    <!-- Dashboard Main Start -->
    <div class="section dashboard-main" style="display: block;">
        <div class="container card-container">
            <!-- Advanced Options -->
            <!--<div class="row" style="text-align: left">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="card-lg">
                        <div class="card-left">
                            <i class="fa fa-star-o fa-lg"></i>
                        </div>
                        <div class="card-right">
                            <div class="card-right-title">Popular Downloads</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="card-lg">
                        <div class="card-left">
                            <i class="fa fa-cloud-download fa-lg"></i>
                        </div>
                        <div class="card-right">
                            <div class="card-right-title">Latest Updates</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 hidden-sm col-xs-12">
                    <div class="card-lg">
                        <div class="card-left">
                            <i class="fa fa-tasks fa-lg"></i>
                        </div>
                        <div class="card-right">
                            <div class="card-right-title">Featured Downloads</div>
                        </div>
                    </div>
                </div>
            </div>-->
            <br /><br />
            <!-- First Row Content Start -->
            <div class="row">
                <a href="uploads/softwares">
                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                        <div class="card">
                            <div class="card-main">
                                <image class="card-main-image" src="images/adobe.jpg" />
                                <div class="card-main-text">
                                    <span class="bordered-content">Softwares</span>
                                    <div class="image-hover">
                                        <i class="fa fa-windows"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-info">
                                <div class="card-title">Windows, Linux, Mac</div>
                                <div class="card-text">1535 downloads</div>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="uploads/study">
                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                        <div class="card">
                            <div class="card-main">
                                <image class="card-main-image" src="images/library.jpg" />
                                <div class="card-main-text">
                                    <span class="bordered-content">Studies</span>
                                    <div class="image-hover">
                                        <i class="fa fa-book "></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-info">
                                <div class="card-title">eBook, notes</div>
                                <div class="card-text">1535 downloads</div>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="uploads/tutorials">
                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                        <div class="card">
                            <div class="card-main">
                                <image class="card-main-image" alt="Not found" src="images/picture-6.png" />
                                <div class="card-main-text">
                                    <span class="bordered-content">Tutorials</span>
                                    <div class="image-hover">
                                        <span class="glyphicon glyphicon-blackboard"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-info">
                                <div class="card-title">Lecture Videos, References</div>
                                <div class="card-text">1535 downloads</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><br /><br />
            <!-- First Row Content End -->

            <!-- Second Row Content Start -->
            <div class="row">
                <a href="uploads/movies">
                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                        <div class="card">
                            <div class="card-main">
                                <image class="card-main-image" src="images/01.jpg" />
                                <div class="card-main-text">
                                    <span class="bordered-content">Movies</span>
                                    <div class="image-hover">
                                        <i class="fa fa-video-camera "></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-info">
                                <div class="card-title">Movies Downloads</div>
                                <div class="card-text">1535 downloads</div>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="uploads/music">
                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                        <div class="card">
                            <div class="card-main">
                                <image class="card-main-image" src="images/songs.jpg" />
                                <div class="card-main-text">
                                    <span class="bordered-content">Music</span>
                                    <div class="image-hover">
                                        <span class="glyphicon glyphicon-music"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-info">
                                <div class="card-title">Genres, Artists, Albums</div>
                                <div class="card-text">1535 downloads</div>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="uploads/series">
                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                        <div class="card">
                            <div class="card-main">
                                <image class="card-main-image" src="images/flash.png" />
                                <div class="card-main-text">
                                    <span class="bordered-content">Seasons</span>
                                    <div class="image-hover">
                                        <i class="fa fa-television "></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-info">
                                <div class="card-title">Download Popular T.V. Series</div>
                                <div class="card-text">1535 downloads</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div><br /><br />
            <!-- Second Row Content End-->
        </div>
    </div>
    <!-- Dashboard Main End -->

    <!-- Dashboard Toast Start -->
    <div class="toast">Notifications goes here...</div>
    <!-- Dashboard Toast End -->

    <!-- Footer Content Start -->
    <div class="footer" style="margin-bottom: 0px; margin-top: 20px;">
        <div class="container">
            <p>&copy; 2016 Lovely Torrentz, Inc.</p>
            <ul>
                <li><a href="#">About</li>
                <li><a href="#">Terms</a></li>
                <li><a href="#">Privacy</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </div>
    <!-- Footer Content End -->

    <script src="js/upload.js" type="text/javascript"></script>
    <script>
        function toggleView(viewName) {
            var visibleItem = $('.dashboard-main').css('display')=='block' ? '.dashboard-main' : ($('.profile-setup').css('display')=='block' ? '.profile-setup' : '.password-setup');
            $(visibleItem).addClass('animated fadeOut');
            window.setTimeout(function () {
                $(visibleItem).css('display','none').removeClass('animated fadeOut');
                $(viewName).css('display','block').addClass('animated fadeInUp');
                window.setTimeout(function () {
                    $(viewName).removeClass('animated fadeInUp');
                }, 500);
            }, 500);
        }
    </script>
    </body>
    </html>

    <?php
} else {
    echo "Please login to continue... Redirecting in 2 second...";
    header('Refresh:2,url=index.php');
}
?>
