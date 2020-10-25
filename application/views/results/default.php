<?php

    $institude_name    = getParam('name');
    $institute_email   = getParam('email');
    $institute_phone   = getParam('phone');
    $institute_website = getParam('website');
    $institute_address = getParam('address');
    $institute_logo    = getParam('logo_2');

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

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

  // Get language
  $roll_no = getlang('roll');
  $select_exam = getlang('select_exam');
  $select_class = getlang('select_class');
  $select_department = getlang('select_department');
  $select_year = getlang('select_year');

  $front_end_result = getParam('front_end_result');


  // Roll Field
  $roll_field = fieldBuilder('input', 'roll', '',  $roll_no, '');

   // Exam list
   $examList = getExam('', 0, 'examBox');
   $exam_field = fieldBuilder('select', 'exam', $examList, $select_exam, '');

   // Class list
   $classList = getClass('');
   $class_field = fieldBuilder('select', 'class', $classList, $select_class, '');

    // Department list
   $departmentList = getDepartment('department', '');
   $department_field = fieldBuilder('select', 'department', $departmentList, $select_department, '');

   // Year list
   $yearlist = yearList('year', '');
   $year_field = fieldBuilder('select', 'year', $yearlist, $select_year, '');

?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
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

    
    <?php if(empty($front_end_result)): ?>
    <section class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 text-center" style="margin-top: 50px;">
            <?php 
                if(empty($institute_show_logo)){echo '<img src="'.$institute_logo_path.'"  alt="institute logo" width="300px"  >';}
                if(empty($institude_show_name)){echo '<h3 style="margin: 2px;">'.$institude_name.'</h3>';}
                if(empty($institute_show_email)){echo '<p style="margin: 0px;"><b>'.getlang('email').': </b>'.$institute_email.'</p>';}
                if(empty($institute_show_phone)){echo '<p style="margin: 0px;"><b>'.getlang('phone').': </b>'.$institute_phone.'</p>';}
                if(empty($institute_show_address)){echo '<p style="margin: 0px;">'.$institute_address.'</p>';}
                if(empty($institute_show_website)){echo '<p style="margin: 0px;"><b>'.getlang('website').': </b>'.$institute_website.'</p>';}
            ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <form method="post" class="form-horizontal"  action="<?php echo base_url() ?>results/details" >
                    <div class="form-horizontal" id="form-area">
                        <div class="row"><div class="col-md-12"> <?php echo $roll_field; ?> </div></div>
                        <div class="row"><div class="col-md-12"> <?php echo $class_field; ?> </div></div>
                        <div class="row"><div class="col-md-12"> <?php echo $department_field; ?> </div></div>
                        <div class="row"><div class="col-md-12"> <?php echo $exam_field; ?> </div></div>
                        <div class="row"><div class="col-md-12"> <?php echo $year_field; ?> </div></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-sm-4 control-label"></div>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                        <input type="submit" class="btn btn-primary" value="<?php echo getlang('view_result');?>" >
                                    </div>
                                </div>
                            </div>
                       </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php else: ?>
    <section class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 text-center">
            	<p style="color: red; padding: 20px 0;">Page Not Found !</p>
            </div>
        </div>
    </section>

    <?php endif; ?>


    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/app.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
    
    </body>
</html>





