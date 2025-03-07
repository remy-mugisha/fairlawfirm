
<!DOCTYPE html>
<?php
session_start();

if(!isset($_SESSION["email"])){
   header("location: index");
}
?>
<html lang="en">
<!-- Mirrored from themewagon.github.io/pluto/index by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jan 2025 09:06:51 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Fair Law Firm | Admin</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icon -->
      <link rel="icon" href="images/fevicon.html" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css" />
      <!-- site css -->
      <link rel="stylesheet" href="style.css" />
      <!-- responsive css -->
      <link rel="stylesheet" href="css/responsive.css" />
      <!-- color css -->
      <link rel="stylesheet" href="css/colors.html" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="css/bootstrap-select.css" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="css/perfect-scrollbar.css" />
      <!-- custom css -->
      <link rel="stylesheet" href="css/custom.css" />
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="dashboard dashboard_1">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  -->
            <nav id="sidebar">
               <div class="sidebar_blog_1">
                  <!-- <div class="sidebar-header">
                     <div class="logo_section">
                        <a href="index-2.html"><img class="logo_icon img-responsive" src="images/logo/logo_icon.png" alt="#" /></a>
                     </div>
                  </div> -->
                  <!-- <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                        <div class="user_img"><img class="img-responsive" src="images/layout_img/user_img.jpg" alt="#" /></div>
                        <div class="user_info">
                           <h6>John David</h6>
                           <p><span class="online_animation"></span> Online</p>
                        </div>
                     </div>
                  </div> -->
               </div>
               <div class="sidebar_blog_2">
                  <h4>Fair Law Firm LTD</h4>
                  <ul class="user_profile_dd">
    <li>
    <a class="dropdown-toggle" data-toggle="dropdown">
    <?php if (!empty($_SESSION['profile_image'])): ?>
        <img class="img-responsive rounded-circle profile-image" src="<?php echo htmlspecialchars($_SESSION['profile_image']); ?>" alt="Profile Image" />
    <?php else: ?>
        <img class="img-responsive rounded-circle profile-image" src="images/default-avatar.png" alt="Default Avatar" />
    <?php endif; ?>
    <span class="name_user"><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></span>
</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="profile.php">My Profile</a>
            <a class="dropdown-item" href="logout.php"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
        </div>
    </li>
</ul>
                  <ul class="list-unstyled components">
                     <li class="active">
                        <a href="dashboard"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a>
                     </li>
                     <!-- <li>
                        <a href="manage_users">
                        <i class="fa fa-briefcase blue1_color"></i> <span>Manage Users</span></a>
                     </li> -->
                     
                     <li>
                        <a href="display_properties">
                        <i class="fa fa-briefcase blue1_color"></i> <span>Add Manage Properties</span></a>
                     </li>
                     <li>
                        <a href="display_rental">
                        <i class="fa fa-plus blue1_color"></i> <span>Add Rental House</span></a>
                     </li>
                     <!-- <li><a href="#"><i class="fa fa-newspaper-o blue1_color"></i> <span>Add Blog</span></a></li> -->
                     <li class="active">
                        <a href="#additional_page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-table purple_color2"></i> <span>Show Tables</span></a>
                        <ul class="collapse list-unstyled" id="additional_page">
                           <li>
                              <a href="display_properties">> <span>Manage Properties</span></a>
                           </li>
                           <li>
                              <a href="display_rental">> <span>Rental House</span></a>
                           </li>
                           <!-- <li>
                              <a href="#">> <span>Blog</span></a>
                           </li> -->
                        </ul>
                     </li>
                     <?php if ($_SESSION['user_type'] == 'admin'): ?>
                            <li><a href="manage_users.php"><i class="fa fa-users yellow_color"></i> <span>Manage Users</span></a></li>
                     <?php endif; ?>
                     <li><a href="#"><i class="fa fa-cog yellow_color"></i> <span>Settings</span></a></li>
                     <!-- <li><a href="logout.php"><i class=""></i> <span>Logout</span></a></li> -->
                  </ul>
               </div>
            </nav>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
               <div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <!-- <div class="logo_section">
                           <a href="index-2.html"><img class="img-responsive" src="images/logo/logo.png" alt="#" /></a>
                        </div> -->
                        <div class="right_topbar">
                           <div class="icon_info">
                              <ul>
                                 <li><a href="#"><i class="fa fa-bell-o"></i><span class="badge">2</span></a></li>
                                 <li><a href="#"><i class="fa fa-question-circle"></i></a></li>
                                 <li><a href="#"><i class="fa fa-envelope-o"></i><span class="badge">3</span></a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
               </div>
               <!-- end topbar -->

               <style>
                  .profile-image {
                     width: 70px; 
                     height: 70px; 
                     object-fit: cover; 
                     border-radius: 50%; 
                     }
               </style>   