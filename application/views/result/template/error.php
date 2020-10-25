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
<style>
      
      p{margin: 0;}
      .header-table tr td {border: 0px solid #fff;padding-top: 20px;padding-bottom: 20px;}
      .footer-table tr td{padding-top: 20px; padding-bottom: 50px;}
      #grade-chart td{text-align: center; border: 1px solid #000;padding: 1px 2px; font-size: 11px;line-height: 15px;}
</style>
<div class="content-wrapper mark-page">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body" >
                    <p style="text-align: center;color: red;margin-top: 20px;"><?php echo $error_msg; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


