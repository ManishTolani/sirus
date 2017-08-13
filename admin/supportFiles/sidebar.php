<?php
echo "
<div class='col-md-3 left_col'>
    <div class='left_col scroll-view'>
        <div class='navbar nav_title' style='border: 0;'>
            <a href='index.php' class='site_title'><i class='fa fa-paw'></i> <span><b>Torrentz</b></span></a>
        </div>

        <div class='clearfix'></div>

        <!-- menu profile quick info -->
        <div class='profile clearfix'>
            <div class='profile_pic'>
                <img src='images/img.jpg' alt='...' class='img-circle profile_img'>
            </div>
            <div class='profile_info'>
                <span>Welcome,</span>
                <h2>Mr. Admin</h2>
            </div>
        </div><br />
        <div id='sidebar-menu' class='main_menu_side hidden-print main_menu'>
            <div class='menu_section'>
                <h3>General</h3>
                <ul class='nav side-menu'>
                    <li class='active'><a href='index.php'><i class='fa fa-home'></i> Home </a></li>
                    <li><a href='uploads.php'><i class='fa fa-laptop'></i> Upload Stats <span class='label label-warning pull-right'>Ongoing: 102</span></a></li>
                    <li><a href='downloads.php'><i class='fa fa-laptop'></i> Download Stats <span class='label label-success pull-right'>Ongoing: 84</span></a></li>
                    <li><a href='upload_requests.php'><i class='fa fa-laptop'></i> Upload Requests <span class='label label-info pull-right'>New: 31</span></a></li>
                    <li><a href='messages.php'><i class='fa fa-laptop'></i> Messages <span class='label label-warning pull-right'>New: 5</span></a></li>
                </ul>
            </div>
            <div class='menu_section'>
                <h3>Advanced</h3>
                <ul class='nav side-menu'>
                    <li><a href='profile_configuration.php'><i class='fa fa-laptop'></i> Configure your profile</a></li>
                    <li><a href='premium_users.php'><i class='fa fa-laptop'></i> Premium Users <span class='label label-info pull-right'>Now: 5</span></a></li>
                    <li><a href='manage_users.php'><i class='fa fa-laptop'></i> User Management </a></li>
                    <li><a href='manage_files.php'><i class='fa fa-laptop'></i> Manage Files </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>";
?>
