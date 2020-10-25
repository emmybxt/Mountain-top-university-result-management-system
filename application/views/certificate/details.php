<?php

    $token_name = $this->security->get_csrf_token_name();
    $token_hash = $this->security->get_csrf_hash();

    // Get language
    $roll          = $roll;
    $class_id      = $class_id;
    $department_id = $department;
    $exam_id       = $exam_ids;
    $year          = $year;
    $student_id    = getStudentID($roll, $class_id, $year, $department_id);

    if(empty($student_id)){
        // redirect form
         $this->session->set_flashdata('error', 'Not Found ! Try Again please.');
        redirect('certificate');
    }

    $institude_name = getParam('name');
    $institute_email = getParam('email');
    $institute_phone = getParam('phone');
    $institute_website = getParam('website');
    $institute_address = getParam('address');
    $institute_logo = getParam('logo_2');

    $certificate_signature = getParam('certificate_signature');
    $certificate_title = getParam('certificate_title');
    $certificate_pattan = getParam('certificate_pattan');
    $certificate_template = getParam('certificate_template');
    $certificate_style = getParam('certificate_style');
    $certificate_signature_of = getParam('certificate_signature_of');
    $certificate_signature_designation = getParam('certificate_signature_designation');

    // Logo
    if(empty($institute_logo)){
        $institute_logo_path = site_url('/uploads/logo/').'rms_logo.png';
    }else{
        $institute_logo_path = site_url('/uploads/logo/').$institute_logo;
    }

    // certificate signature
    if(empty($certificate_signature)){
        $certificate_signature_path = site_url('/uploads/logo/').'signature.png';
    }else{
        $certificate_signature_path = site_url('/uploads/logo/').$certificate_signature;
    }

    // certificate pattan
    if(empty($certificate_pattan)){
        $certificate_pattan_path = site_url('/uploads/logo/').'certificate.jpg';
    }else{
        $certificate_pattan_path = site_url('/uploads/logo/').$certificate_pattan;
    }

    $student_name    = getSingledata('students', 'name', 'id', $student_id);
    $student_year    = getSingledata('students', 'year', 'id', $student_id);
    $class_name      = getSingledata('class', 'name', 'id', $class_id);
    $department_name = getSingledata('departments', 'department_name', 'id', $department_id);
    // Get students photo
    $student_avatar    = getSingledata('students', 'avatar', 'id', $student_id);
    if(empty($student_avatar)){
        $img_path = site_url('/uploads/students/').'avator.png';
    }else{
        $img_path = site_url('/uploads/students/').$student_avatar;
    }


    // Print Button
    $onclick_link ="'printableArea'";
    $print_button ='<input type="button" id="print" onclick="printCertificate('.$onclick_link.')" class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" value="Print" />';

    // Download PDF
    $download_pdf ='<form action="'.base_url().'certificate/download_pdf" method="post" style="display: inline-block;" >';
    $download_pdf .='<input type="hidden" name="roll" value="'.$roll.'">';
    $download_pdf .='<input type="hidden" name="class" value="'.$class_id.'">';
    $download_pdf .='<input type="hidden" name="department" value="'.$department_id.'">';

    $download_pdf .='<input type="hidden" name="exam" value="'.$exam_id.'">';
    $download_pdf .='<input type="hidden" name="year" value="'.$year.'">';
    $download_pdf .='<input type="submit" id="export-pdf"  class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" value="Download PDF" /> ';
    $download_pdf .='</form>';

    $final_mark = getCertificateMark('total_mark', $exam_id, $class_id, $department_id, $year, $student_id);

    $final_gp = getCertificateMark('gp', $exam_id, $class_id, $department_id, $year, $student_id);


    // Certificate Template
    $templateContent = $certificate_template; 
    $placeHolders = [
        '[STUDENT_NAME]',
        '[STUDENT_IMAGE]',
        '[YEAR]',
        '[MARK]',
        '[GP]',
    ];

    $values = [
        '<b>'.$student_name.'</b>',
        '<b><img src="'.$img_path.'" class="certificate-student-image" alt="avator"  ></b>',
        '<b>'.$year.'</b>',
        '<b>'.$final_mark.'</b>',
        '<b>'.$final_gp.'</b>',
    ];
    $rendered = str_replace($placeHolders, $values, $templateContent);

?>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body ">


                    <!-- #### START CERTIFICATE #### -->
                    <div id="printableArea"  >

                        <link href="https://fonts.googleapis.com/css?family=UnifrakturCook:700" rel="stylesheet">
                        <link href="https://fonts.googleapis.com/css?family=Pinyon+Script" rel="stylesheet">
                        <style type="text/css">

                        <?php echo $certificate_style; ?>
                        .certificate-area{
                            display: block;
                            background: url('<?php echo $certificate_pattan_path; ?>');
                            background-repeat: no-repeat;
                            background-position: center top;
                            background-size: 100% 100%;
                            /*width: 297mm;
                            height: 210mm;
                            */
                            width: 100%;
                            min-height: 210mm;
                            
                        }
                        .certificate-area .info h3{font-family: 'UnifrakturCook', cursive;font-size: 350%;}
                        .certificate-area .text {font-family: 'Pinyon Script', cursive;font-size: 200%;}

                        @media print {
                            @page {
                                size: 100% 100% landscape; 
                                margin: 0mm;
                                padding: 0mm;
                                display: block;
                            }

                            body{
                                width: 100%;
                                height: 100%;
                                display: block;
                                margin: 0mm auto 0mm auto;
                                padding: 0mm;
                                box-shadow: 0;

                                background: url('<?php echo $certificate_pattan_path; ?>') !important;
                                background-repeat: no-repeat !important;
                                background-position: center top !important;
                                background-size: 100% 100% !important;
                                
                            }
                            <?php echo $certificate_style; ?>
                            .certificate-area{
                                
                            }
                            .certificate-area .logo{
                                text-align: center;
                                margin-top: 120px !important;
                            }
                            .certificate-area .info{}
                      
                        }
                        </style>
                        <page size="A4">
                            <div class="certificate-area">  

                                <!-- ### LOGO ### -->
                                <div class="logo">
                                    <?php if(empty($certificate_logo)): ?>
                                    <img src="<?php echo $institute_logo_path; ?>"  alt="<?php echo $institude_name; ?>"  >
                                    <?php endif; ?>
                                </div>
                                
                                <!-- ### CERTIFICATE TITLE ### -->
                                <div class="info"><h3><?php echo $certificate_title; ?></h3></div>

                                <!-- ### CERTIFICATE TEMPLATE ### -->
                                <div class="text"><?php echo $rendered; ?></div>

                                <!-- ### CERTIFICATE SIGNATURE ### -->
                                <div class="signature">
                                    <?php if(!empty($certificate_signature)): ?>
                                    
                                    <?php endif; ?>  
                                    <img src="<?php echo $certificate_signature_path; ?>"  alt="signature" width="100px"  >
                                    <p><b><?php echo $certificate_signature_of; ?></b></p>
                                    <p><?php echo $certificate_signature_designation; ?></p>
                                </div>

                            </div>
                        </page>
                    </div>
                    <!-- #### END CERTIFICATE #### -->


                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="toolsbar">
                                <?php echo $print_button; ?>
                                <?php echo $download_pdf; ?>
                            </div>
                        </div>
                    </div>
                </div>


                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

    function printCertificate(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
 </script>
