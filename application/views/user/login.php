<?php 
	$csrf = array(
	    'name' => $this->security->get_csrf_token_name(),
	    'hash' => $this->security->get_csrf_hash()
	);

    $institude_name = getParam('name');
    $icon = getParam('favicon_icon');

    if(empty($icon)){
        $icon_path = site_url('/uploads/logo/').'/rms_icon.png';
    }else{
        $icon_path = site_url('/uploads/logo/').'/'.$icon;
    }
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title><?php echo getlang('dashboard_title'); ?> | <?php echo getlang('login'); ?></title>
    <link rel="shortcut icon" href="<?php echo $icon_path; ?>">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/custom.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    <body class="login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?php echo base_url(); ?>">
                <img src="<?php echo $icon_path; ?>" style="max-width: 80%;"  alt="<?php echo $institude_name; ?>"  >
                </a>
            </div>
            <div class="login-box-body">
                <h3 class="login-box-msg"><?php echo $institude_name; ?></h3>
                <?php $this->load->helper('form'); ?>

		        <div class="row">
		             <div class="col-md-12">
		                <?php echo getSystemMessage(); ?>
		            </div>
		        </div>
        
                <form action="<?php echo base_url(); ?>loginMe" method="post">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="<?php echo getlang('email'); ?>" name="email" required />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
	                    <input type="password" class="form-control" placeholder="<?php echo getlang('password'); ?>" name="password" required />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="row">
	                    <div class="col-xs-8">    
			                <div class="checkbox">
                            <label><input type="checkbox"> <?php echo getlang('remembar_me'); ?></label>
                            </div>                        
                        </div>
                        <div class="col-xs-4">
	                        <input type="submit" class="btn btn-primary btn-block btn-flat" value="<?php echo getlang('login'); ?>" />
                        </div>
                    </div>

                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                </form>

                <a href="<?php echo base_url() ?>forgotpassword"><?php echo getlang('forget_password'); ?></a><br>
            </div>
        </div>

        <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>