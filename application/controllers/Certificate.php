<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Certificate extends BaseController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();   
    }
    

    function index()
    {
        $cirtificate_title = getlang('certificate_title');
        $this->global['pageTitle'] = $cirtificate_title;
        $this->loadViews("certificate/form", $this->global, NULL, NULL);
    }

    /**
    ** This function is used to download PDF
    **/
    function download_pdf(){
        $roll            = $this->input->post('roll');
        $class_id        = $this->input->post('class');
        $department_id   = $this->input->post('department');
        $exam_id         = $this->input->post('exam');
        $year            = $this->input->post('year');
        $student_id      = getStudentID($roll, $class_id, $year, $department_id);
        $student_name    = getSingledata('students', 'name', 'id', $student_id);

        if(!empty($roll) && !empty($class_id) && !empty($exam_id) && !empty($student_id)){
            $html = $this->crtificatePDFhtml($roll, $class_id, $exam_id, $year, $department_id);
        }else{
            $html = '';
        }

        // certificate pattan
        $certificate_pattan = getParam('certificate_pattan');
        if(empty($certificate_pattan)){
            $certificate_pattan_path = 'uploads/logo/certificate.jpg';
        }else{
            $certificate_pattan_path = 'uploads/logo/'.$certificate_pattan;
        }
       
        $this->load->library('pdf');
        $file_name = $student_name.'-certificate';
        
        $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle($file_name);
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetDisplayMode('real', 'default');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set auto page breaks
        $pdf->SetAutoPageBreak(false, 0);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('25', PDF_MARGIN_TOP, '25');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('unifrakturcookb', '', 12);
        $pdf->SetFont('pinyonscripti', '', 12);
        $pdf->SetFont('times', '', 12);

        $pdf->AddPage('L', 'A4');

        // set bacground image
        $img_file = $certificate_pattan_path;
        $pdf->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);

        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->Output($file_name.'.pdf', 'D');
        
    }

    /**
    ** Display Certificate PDF HTML Format
    **/
    function crtificatePDFhtml($roll, $class_id, $exam_id, $year, $department_id)
    {
        $student_id            = getStudentID($roll, $class_id, $year, $department_id);

        $institude_name        = getParam('name');
        $institute_email       = getParam('email');
        $institute_phone       = getParam('phone');
        $institute_website     = getParam('website');
        $institute_address     = getParam('address');
        $institute_logo        = getParam('logo_2');

        $certificate_signature             = getParam('certificate_signature');
        $certificate_title                 = getParam('certificate_title');
        $certificate_pattan                = getParam('certificate_pattan');
        $certificate_template              = getParam('certificate_template');
        $certificate_style                 = getParam('certificate_style');
        $certificate_signature_of          = getParam('certificate_signature_of');
        $certificate_signature_designation = getParam('certificate_signature_designation');

        // Logo
        if(empty($institute_logo)){
            $institute_logo_path = 'uploads/logo/rms_logo.png';
        }else{
            $institute_logo_path = 'uploads/logo/'.$institute_logo;
        }

        // certificate signature
        if(empty($certificate_signature)){
            $certificate_signature_path = 'uploads/logo/signature.png';
        }else{
            $certificate_signature_path = 'uploads/logo/'.$certificate_signature;
        }

        // certificate pattan
        if(empty($certificate_pattan)){
            $certificate_pattan_path = 'uploads/logo/certificate.jpg';
        }else{
            $certificate_pattan_path = 'uploads/logo/'.$certificate_pattan;
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

        // Get final mark
        $final_mark = getCertificateMark('total_mark', $exam_id, $class_id, $department_id, $year, $student_id);
        
        // Get final gp
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
            '<span>'.$student_name.'</span>',
            '<b><img src="'.$img_path.'" class="certificate-student-image" alt="avator"  ></b>',
            '<span>'.$year.'</span>',
            '<span>'.$final_mark.'</span>',
            '<span>'.$final_gp.'</span>',
        ];
        $rendered = str_replace($placeHolders, $values, $templateContent);

        $lang_id       = getParam('language');
        $pdf_font      = getSingledata('languages', 'lang_code', 'id', $lang_id);
        $background_cr = "'".$certificate_pattan_path."'";

        // #### PDF BODY ####
        $pdf_body ='
            <style>
            '.$certificate_style.'
            .certificate-area{text-align: center;}

            .certificate-area .logo img {width: 300px;}
            .certificate-area .info {
                font-family: unifrakturcookb;
                font-size: 350%;
                line-height: 30px;
            }
            
            .certificate-area .text{
                font-family: pinyonscripti;
                font-size: 180%;
                line-height: 30px;

            }
            .certificate-area .text span{
                font-family: pinyonscripti;
                font-size: 150%;
            }
            

            </style>
            ';
        $pdf_body .='<div class="certificate-area">';  
        
            // ### LOGO ### 
            $pdf_body .='<div class="logo" ><br />';
                 if(empty($certificate_logo)): 
                $pdf_body .='<img src="'.$institute_logo_path.'"  alt="logo"  >';
                endif; 
            $pdf_body .='</div>';
            
            // ### CERTIFICATE TITLE ### 
            $pdf_body .='<div class="info">'.$certificate_title.'</div><br />';

            // ### CERTIFICATE TEMPLATE ### 
            $pdf_body .='<div class="text" >'.$rendered.'</div>';

            ### CERTIFICATE SIGNATURE ###
            $pdf_body .='<div class="signature" >';
                //if(!empty($certificate_signature)): 
                $pdf_body .='<img src="'.$certificate_signature_path.'"  alt="signature" width="100px"  >';
                //endif; 
                $pdf_body .='<div class="author">'.$certificate_signature_of.'<br /> '.$certificate_signature_designation.'</div>';
            $pdf_body .='</div>';

        $pdf_body .='</div>';

        
        return $pdf_body;
    }


    /**
    ** This function is used to certificate details
    **/
    function details()
    {
        $cirtificate_title = getlang('certificate_title');
        $roll              = $this->input->post('roll');
        $class_id          = $this->input->post('class_name');
        $department        = $this->input->post('department');
        $exam_ids          = $this->input->post('exam_name');
        $year              = $this->input->post('year');

        $data['roll']       = $roll;
        $data['class_id']   = $class_id;
        $data['department'] = $department;
        $data['exam_ids']   = $exam_ids;
        $data['year']       = $year;    

        $student_name              = getSingledata('students', 'name', 'roll', $roll);
        $this->global['pageTitle'] =  $cirtificate_title.'|'.$student_name;
        $this->loadViews("certificate/details", $this->global, $data, NULL);
    }


    
}

