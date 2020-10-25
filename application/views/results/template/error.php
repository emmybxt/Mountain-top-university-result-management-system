<?php

    $institude_name    = getParam('name');
    $institute_email   = getParam('email');
    $institute_phone   = getParam('phone');
    $institute_website = getParam('website');
    $institute_address = getParam('address');
    $institute_logo    = getParam('logo_2');

    $student_choose_subject = getParam('student_choose_subject');

    if(empty($institute_logo)){
        $institute_logo_path = site_url('/uploads/logo/').'/rms_logo.png';
    }else{
        $institute_logo_path = site_url('/uploads/logo/').'/'.$institute_logo;
    }
    $institude_show_name    = getParam('result_name');
    $institute_show_email   = getParam('result_email');
    $institute_show_phone   = getParam('result_phone');
    $institute_show_website = getParam('result_website');
    $institute_show_address = getParam('result_address');
    $institute_show_logo    = getParam('result_logo');
  

	
 
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title><?php echo getlang('result_title'); ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
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
      p{margin: 0;}
      .header-table tr td {border: 0px solid #fff;padding-top: 20px;padding-bottom: 20px;}
      .footer-table tr td{padding-top: 20px; padding-bottom: 50px;}
      #grade-chart td{text-align: center; border: 1px solid #000;padding: 1px 2px; font-size: 11px;line-height: 15px;}
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
    <body>

    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <p style="text-align: center;color: red;margin-top: 100px;"><?php echo $error_msg; ?></p>
            </div>
        </div>
    </section>
</div>


    </body>
</html>