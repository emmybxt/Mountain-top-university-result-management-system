<?php

$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash()
);

$id = '';
$name = '';
$email = '';
$phone = '';
$website = '';
$address = '';
$favicon_icon = '';
$logo = '';
$logo_2 = '';
$language = '';

$result_logo = '';
$result_name = '';
$result_email = '';
$result_phone = '';
$result_address = '';
$result_website = '';


$year_start = '';
$year_end = '';
$theme = '';

$email_form = '';
$email_bcc = '';
$from_name = '';
$email_pass = '';
$protocol = '';
$smtp_host = '';
$smtp_port = '';
$smtp_user = '';
$smtp_pass = '';
$mail_path = '';

$certificate_signature = '';
$certificate_signature_of = '';
$certificate_signature_designation = '';
$certificate_title = '';
$certificate_pattan = '';
$certificate_template = '';
$certificate_style = '.certificate-student-image{position: absolute; top: 175px; right: 200px; width: 150px; height: 160px;}';

$front_end_result = '';

$pdf_orientation = '';
$pdf_paper_size = '';
$pdf_font = '';

$student_account = '';
$student_choose_subject = '';

if(!empty($con_data))
{
    foreach ($con_data as $item)
    {
        $id = $item->id;
        $name = $item->name;
        $email = $item->email;
        $phone = $item->phone;
        $website = $item->website;
        $address = $item->address;
        $favicon_icon = $item->favicon_icon;
        $logo = $item->logo;
        $logo_2 = $item->logo_2;
        $language = $item->language;

        $result_logo = $item->result_logo;
        $result_name = $item->result_name;
        $result_email = $item->result_email;
        $result_phone = $item->result_phone;
        $result_address = $item->result_address;
        $result_website = $item->result_website;
       

        $year_start = $item->year_start;
        $year_end = $item->year_end;
        $theme = $item->theme;

        $email_form = $item->email_form;
        $email_bcc = $item->email_bcc;
        $from_name = $item->from_name;
        $email_pass = $item->email_pass;
        $protocol = $item->protocol;
        $smtp_host = $item->smtp_host;
        $smtp_port = $item->smtp_port;
        $smtp_user = $item->smtp_user;
        $smtp_pass = $item->smtp_pass;
        $mail_path = $item->mail_path;

        $certificate_signature = $item->certificate_signature;
        $certificate_signature_of = $item->certificate_signature_of;
        $certificate_signature_designation = $item->certificate_signature_designation;
        $certificate_title = $item->certificate_title;
        $certificate_pattan = $item->certificate_pattan;
        $certificate_template = $item->certificate_template;
        $certificate_style = $item->certificate_style;
        if(empty($certificate_style)){
            $certificate_style = '.certificate-student-image{position: absolute; top: 175px; right: 200px; width: 150px; height: 160px;}';
        }

        

        $front_end_result = $item->front_end_result;

        $pdf_orientation = $item->pdf_orientation;
        $pdf_paper_size = $item->pdf_paper_size;
        $pdf_font = $item->pdf_font;

        $student_account = $item->student_account;
        $student_choose_subject = $item->student_choose_subject;
    }
}

$language_list = getLanguageList($language);


// Get language
$school_name = getlang('institute_name');
$school_website = getlang('website');
$school_logo = getlang('logo');
$default_lang = getlang('default_lang');
$school_address = getlang('address');
$s_email = getlang('email');
$s_phone = getlang('phone');
$start_year = getlang('start_year');
$end_year = getlang('end_year');
$default_theme = getlang('default_theme');

$s_institute_logo = getlang('show_logo');
$s_institute_name = getlang('show_institute_name');
$s_email_address = getlang('show_email');
$s_mobile = getlang('show_phone');
$s_address = getlang('show_address');
$s_website = getlang('show_website');



$from_email = getlang('from_email');
$from_bcc = getlang('from_bcc');
$from_client = getlang('from_name');
$email_password = getlang('email_password');
$protocols = getlang('protocol');
$host_smtp = getlang('smtp_host');
$port_smtp = getlang('smtp_port');
$smtp_username = getlang('smtp_username');
$smtp_password = getlang('smtp_password');
$email_path = getlang('mail_path');


$signature = getlang('certificate_signature');
$signature_of = getlang('signature_of');
$signature_designation = getlang('signature_designation');
$text_template = getlang('text_template');
$certificate_background = getlang('certificate_background');


/**
** pdf orientation
**/
function pdf_orientation($id){
    $list = array(
        'portrait' => 'Portrait', 
        'landscape' => 'Landscape'
    );

    $output = '<select name="pdf_orientation"  class="form-control" >';
    foreach ($list as $key => $item) {
        if ($key == $id ) {
            $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
        }else{
            $output .= '<option value="'.$key.'">'.$item.'</option>';
        }
    }
    $output .= '</select>';
    return $output;
}

/**
** pdf paper size
**/
function pdf_paper_size($id){
    $list = array(
        'A4' => 'A4', 
        'A5' => 'A5'
    );

    $output = '<select name="pdf_paper_size"  class="form-control" >';
    foreach ($list as $key => $item) {
        if ($key == $id ) {
            $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
        }else{
            $output .= '<option value="'.$key.'">'.$item.'</option>';
        }
    }
    $output .= '</select>';
    return $output;
}

/**
** pdf font
**/
function pdf_font($id){
    $list = array(
        'Courier' => 'Courier', 
        'Helvetica' => 'Helvetica',
        'Times' => 'Times',
        'DejaVuSans' => 'DejaVu Sans',
        'Firefly' => 'Firefly (Unicode)',
        'unifont' => 'Unifont (Unicode)'
    );

    $output = '<select name="pdf_font"  class="form-control" >';
    foreach ($list as $key => $item) {
        if ($key == $id ) {
            $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
        }else{
            $output .= '<option value="'.$key.'">'.$item.'</option>';
        }
    }
    $output .= '</select>';
    return $output;
}



?>
<div class="content-wrapper">

    <section class="content-header">
        <h1><i class="fa fa-cog"></i> <?php echo getlang('configuration_title'); ?> </h1>
    </section>

    <section class="content">
        <div class="row">
             <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" class="form-horizontal"  action="<?php echo base_url() ?>configuration/edit" method="post" role="form" enctype="multipart/form-data">
                    <div class="box-body">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#general"><?php echo getlang('general'); ?></a></li>
                            <li><a data-toggle="tab" href="#student">Student</a></li>
                            <li><a data-toggle="tab" href="#logo">Logo & icon</a></li>
                            <li><a data-toggle="tab" href="#result">Result</a></li>
                            <li><a data-toggle="tab" href="#mail">Mail Configuration</a></li>
                            <li><a data-toggle="tab" href="#certificate">Certificate</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="general" class="tab-pane fade in active">

                                <p></p>

                                <div class="row">
                                    <div class="col-md-8">                                
                                        <?php  echo fieldBuilder('input', 'name', $name, $school_name, 'required'); ?>
                                        <input type="hidden" value="<?php echo $id; ?>" name="id" id="id" /> 
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php  echo fieldBuilder('textarea', 'address', $address, $school_address, 'required'); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'email', $email, $s_email, 'required');?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'phone', $phone, $s_phone, 'required');?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'website', $website, $school_website, 'required');?></div>
                                </div>


                                

                                    <div class="row">
                                        <div class="col-md-8">                              
                                            <?php  echo fieldBuilder('select', '', $language_list, $default_lang, 'required'); ?>
                                        </div>
                                    </div>

                                    <h4><?php echo getlang('year_limit'); ?></h4>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <?php $startyear = yearListsystem('year_start', $year_start, '2001', '2099'); ?>                              
                                            <?php  echo fieldBuilder('select', 'year_start', $startyear, $start_year, ''); ?>  
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <?php $endyear = yearListsystem('year_end', $year_end, '2001', '2099'); ?>                              
                                            <?php  echo fieldBuilder('select', 'year_end', $endyear, $end_year, ''); ?>  
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <?php $themelist = gettheme('theme', $theme); ?>                              
                                            <?php  echo fieldBuilder('select', 'theme', $themelist, $default_theme, ''); ?>  
                                        </div>
                                    </div>

                            </div>

                            <div id="logo" class="tab-pane fade">
                                <p></p>

                                <div class="row">
                                    <div class="col-md-8 rms-profile-image">
                                        <?php 
                                        if(empty($favicon_icon)){
                                            $favicon_icon_path = site_url('/uploads/logo/').'/rms_icon.png';
                                        }else{
                                            $favicon_icon_path = site_url('/uploads/logo/').'/'.$favicon_icon;
                                        }
                                        $favicon_icon_field = '<input type="file" name="favicon_icon" onchange="readURL(this, 1);" />';
                                        echo fieldBuilder('select', 'logo', $favicon_icon_field, 'Favicon', '');
                                        ?>
                                        <div class="form-group">
                                            <div class="col-sm-4 control-label"></div>
                                            <div class="col-sm-8" style="background: #f5f5f5;">
                                              <img src="<?php echo $favicon_icon_path; ?>" id="preview_1" alt="favicon icon"  >
                                              <input type="hidden" value="<?php echo $favicon_icon; ?>" name="old_favicon_icon">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="row">
                                    <div class="col-md-8 rms-profile-image">
                                        <?php 
                                        if(empty($logo)){
                                            $img_path = site_url('/uploads/logo/').'/rms_logo_light.png';
                                        }else{
                                            $img_path = site_url('/uploads/logo/').'/'.$logo;
                                        }
                                        $logo_field = '<input type="file" name="logo" onchange="readURL(this, 2);" />';
                                        echo fieldBuilder('select', 'logo', $logo_field, $school_logo, '');
                                        ?>
                                        <div class="form-group">
                                            <div class="col-sm-4 control-label"></div>
                                            <div class="col-sm-8" style="background: #f5f5f5;">
                                              <img src="<?php echo $img_path; ?>" id="preview_2" alt="avator"  >
                                              <input type="hidden" value="<?php echo $logo; ?>" name="old_logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-8 rms-profile-image">
                                        <?php 
                                        if(empty($logo_2)){
                                            $img_path_2 = site_url('/uploads/logo/').'/rms_logo.png';
                                        }else{
                                            $img_path_2 = site_url('/uploads/logo/').'/'.$logo_2;
                                        }
                                        $logo_field_2 = '<input type="file" name="logo_2" onchange="readURL(this, 3);" />';
                                        echo fieldBuilder('select', 'logo_2', $logo_field_2, 'Logo 2', '');

                                        ?>

                                        <div class="form-group">
                                            <div class="col-sm-4 control-label"></div>
                                            <div class="col-sm-8" style="background: #f5f5f5;">
                                              <img src="<?php echo $img_path_2; ?>" id="preview_3"  alt="logo 2"  >
                                              <input type="hidden" value="<?php echo $logo_2; ?>" name="old_logo_2">
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>

                            </div>

                            <div id="student" class="tab-pane fade">
                                <p></p>

                                

                                <div class="row">
                                    <div class="col-md-8">  
                                        <?php $student_choose_subject_field = getYesNo('student_choose_subject', $student_choose_subject); ?>
                                        <?php  echo fieldBuilder('select', '', $student_choose_subject_field, 'Student choose own subject ?', ''); ?>
                                    </div>
                                </div>

                            </div>

                            <div id="result" class="tab-pane fade">
                                <p></p>

                                <div class="row">
                                    <div class="col-md-8">  
                                        <?php $show_front_end_result = getYesNo('front_end_result', $front_end_result); ?>                              
                                        <?php  echo fieldBuilder('select', '', $show_front_end_result, 'Disable Front-end Result ?', 'required'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">  
                                        <?php $show_logo = getYesNo('result_logo', $result_logo); ?>                              
                                        <?php  echo fieldBuilder('select', '', $show_logo, $s_institute_logo, 'required'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">  
                                        <?php $show_name = getYesNo('result_name', $result_name); ?>                              
                                        <?php  echo fieldBuilder('select', '', $show_name, $s_institute_name, 'required'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">  
                                        <?php $show_email = getYesNo('result_email', $result_email); ?>                              
                                        <?php  echo fieldBuilder('select', '', $show_email, $s_email_address, 'required'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">  
                                        <?php $show_phone = getYesNo('result_phone', $result_phone); ?>                              
                                        <?php  echo fieldBuilder('select', '', $show_phone, $s_mobile, 'required'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">  
                                        <?php $show_address = getYesNo('result_address', $result_address); ?>                              
                                        <?php  echo fieldBuilder('select', '', $show_address, $s_address, 'required'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">  
                                        <?php $show_website = getYesNo('result_website', $result_website); ?>                              
                                        <?php  echo fieldBuilder('select', '', $show_website, $s_website, 'required'); ?>
                                    </div>
                                </div>

                                
                            </div>

                            <div id="mail" class="tab-pane fade">
                                <p></p>
                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'email_form', $email_form, $from_email, 'required');?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'email_bcc', $email_bcc, $from_bcc, 'required');?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'from_name', $from_name, $from_client, 'required');?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'email_pass', $email_pass, $email_password, 'required');?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'protocol', $protocol, $protocols, 'required');?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'smtp_host', $smtp_host, $host_smtp, 'required');?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'smtp_port', $smtp_port, $port_smtp, 'required');?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'smtp_user', $smtp_user, $smtp_username, 'required');?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'smtp_pass', $smtp_pass, $smtp_password, 'required');?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8"><?php echo fieldBuilder('input', 'mail_path', $mail_path, $email_path, 'required');?></div>
                                </div>

                            </div>


                            <div id="certificate" class="tab-pane fade">
                                <p></p>

                                <div class="row">
                                        <div class="col-md-8 rms-profile-image">
                                            <?php 
                                            if(empty($certificate_signature)){
                                                $certificate_signature_path = site_url('/uploads/logo/').'/signature.png';
                                            }else{
                                                $certificate_signature_path = site_url('/uploads/logo/').'/'.$certificate_signature;
                                            }
                                            $certificate_signature_field = '<input type="file" name="certificate_signature" onchange="readURL(this, 4);" />';
                                            echo fieldBuilder('select', 'certificate_signature', $certificate_signature_field, $signature, '');

                                            ?>

                                            <div class="form-group">
                                                <div class="col-sm-4 control-label"></div>
                                                <div class="col-sm-8">
                                                  <img src="<?php echo $certificate_signature_path; ?>" id="preview_4" alt="avator" width="70px"  >
                                                  <input type="hidden" value="<?php echo $certificate_signature; ?>" name="old_certificate_signature">
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                </div>

                                

                                <div class="row">
                                    <div class="col-md-8">  
                                        <?php  echo fieldBuilder('input', 'certificate_signature_of', $certificate_signature_of, $signature_of, 'required'); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">  
                                        <?php  echo fieldBuilder('input', 'certificate_signature_designation', $certificate_signature_designation, $signature_designation, 'required'); ?>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-8">  
                                        <?php  echo fieldBuilder('input', 'certificate_title', $certificate_title, 'Certificate Title', 'required'); ?>
                                    </div>
                                </div>
                                

                                <div class="row">
                                    <div class="col-md-8"><?php  echo fieldBuilder('textarea', 'certificate_template', $certificate_template, $text_template, 'required'); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="col-sm-4 control-label"></div>
                                            <div class="col-sm-8">
                                            <p>Please used tags <b>[STUDENT_NAME]</b>, <b>[STUDENT_IMAGE]</b>, <b>[YEAR]</b>, <b>[MARK]</b>, <b>[GP]</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-8"><?php  echo fieldBuilder('textarea', 'certificate_style', $certificate_style, 'CSS Code', ''); ?></div>
                                </div>

                                <div class="row">
                                        <div class="col-md-8 rms-profile-image">
                                            <?php 
                                            if(empty($certificate_pattan)){
                                                $certificate_pattan_path = site_url('/uploads/logo/').'/certificate.jpg';
                                            }else{
                                                $certificate_pattan_path = site_url('/uploads/logo/').'/'.$certificate_pattan;
                                            }
                                            $certificate_pattan_field = '<input type="file" name="certificate_pattan" onchange="readURL(this, 5);" />';
                                            echo fieldBuilder('select', 'certificate_pattan', $certificate_pattan_field, $certificate_background, '');

                                            ?>

                                            <div class="form-group">
                                                <div class="col-sm-4 control-label"></div>
                                                <div class="col-sm-8">
                                                  <img src="<?php echo $certificate_pattan_path; ?>" id="preview_5" alt="avator" width="70px"   >
                                                  <input type="hidden" value="<?php echo $certificate_pattan; ?>" name="old_certificate_pattan">
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                </div>


                            </div>

                            
                            
                        </div>

                    
                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-8 ">
                                <div class="form-group">
                                    <div class="col-sm-4 control-label"></div>
                                    <div class="col-sm-8">
                                        <input type="hidden" value="<?php echo $id; ?>" name="id">
                                        <input type="submit" class="btn btn-primary" value="<?php echo getlang('submit'); ?>" /> 
                                        <a class="btn  btn-default" href="<?php echo base_url().'students'; ?>" title="Cancel"> <?php echo getlang('cancel'); ?> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>







