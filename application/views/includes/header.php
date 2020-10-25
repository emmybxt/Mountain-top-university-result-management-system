<?php 
$theme = getParam('theme');
$lang_id = getParam('language');
$lang_direction = getSingledata('languages', 'direction', 'id', $lang_id);
$lang_code = getSingledata('languages', 'lang_code', 'id', $lang_id);

$front_end_result = getParam('front_end_result');

$icon = getParam('favicon_icon');

  if(empty($icon)){
      $icon_path = site_url('/uploads/logo/').'/rms_icon.png';
  }else{
      $icon_path = site_url('/uploads/logo/').'/'.$icon;
  }

?>

<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>" dir="<?php echo $lang_direction; ?>">
  <head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="shortcut icon" href="<?php echo $icon_path; ?>">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/sumoselect.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/custom.css" rel="stylesheet" type="text/css" />

    

    <style>
    	.error{
    		color:red;
    		font-weight: normal;
    	}
    </style>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/common.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="<?php echo $theme; ?> sidebar-mini">

    <?php 
    $userid = $userid;
    $avator = getSingledata('users', 'avatar', 'userId', $userid);
    if(empty($avator)){
        $img_path = site_url('/uploads/users/').'/avator.png';
    }else{
        $img_path = site_url('/uploads/users/').'/'.$avator;
    }

    $institude_name = getParam('name');
    $logo = getParam('logo');

    if(empty($logo)){
        $logo_path = site_url('/uploads/logo/').'/rms_logo_light.png';
    }else{
        $logo_path = site_url('/uploads/logo/').'/'.$logo;
    }
    ?>
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">
            <img src="<?php echo $logo_path; ?>" style="max-width: 80%;"  alt="<?php echo $institude_name; ?>"  >
          </span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
            <img src="<?php echo $logo_path; ?>" style="max-width: 80%;"  alt="<?php echo $institude_name; ?>"  >
          </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span> 
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown tasks-menu">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fa fa-history"></i>
                </a>
                <ul class="dropdown-menu">
                  <li class="header"><?php echo getlang('last_login'); ?> :<i class="fa fa-clock-o"></i> <?= empty($last_login) ? "First Time Login" : $last_login; ?></li>
                </ul>
              </li>


              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img style="width: 20px; height: 20px;" src="<?php echo $img_path; ?>" class="img-circle" alt="User Image" />
                  <span class="hidden-xs"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">

                    <img src="<?php echo $img_path; ?>" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $name; ?>
                      <small><?php echo $role_text; ?></small>
                    </p>

                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="">
                      <a style="width: 100%;margin-bottom: 10px;" href="<?php echo base_url(); ?>changeavatar" class="btn btn-default btn-flat"><i class="fa fa-user"></i> <?php echo getlang('change_avatar'); ?></a>
                      <a style="width: 100%;margin-bottom: 10px;" href="<?php echo base_url(); ?>changepass" class="btn btn-default btn-flat"><i class="fa fa-key"></i> <?php echo getlang('change_password'); ?></a>
                    </div>
                    <div class="">
                      <a style="width: 100%;margin-bottom: 10px;" href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> <?php echo getlang('log_out'); ?></a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <!-- <li class="header text-center"><?php echo $institude_name; ?></li> -->
            <?php echo getMenu($role); ?>
            <?php if(empty($front_end_result)): ?>
            <li class=" bg-green">
              <a href="<?php echo base_url(); ?>results"  target="_blank" ><i class="fa fa-trophy"></i><span>Front end result</span></a>
            </li>
            <?php endif; ?>

          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>