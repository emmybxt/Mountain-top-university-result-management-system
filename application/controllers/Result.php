<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Result extends BaseController
{
    /**
    ** This is default constructor of the class
    **/
    public function __construct()
    {
        parent::__construct();
        $this->load->model('result_model');
        $this->isLoggedIn();   
    }
    
    /**
    ** This function is used to load the  list
    **/
    function form()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{   
            $result_title = getlang('result_title');
            $this->global['pageTitle'] =  $result_title;
            $this->loadViews("/result/form",  $this->global, '' , NULL);
        }
    }

    /**
    ** This function is used to download PDF
    **/
    function download_pdf(){

        $roll          = $this->input->post('roll');
        $class_id      = $this->input->post('class');
        $department_id = $this->input->post('department');
        $exam_ids      = $this->input->post('exam');
        $year          = $this->input->post('year');

        $exam_param      = getSingledata('exam', 'param', 'id', $exam_ids);
        $exam_param_data = json_decode($exam_param,true);   

        // Get result template id
        if(isset($exam_param_data['class_id'][$class_id]['result_template'][0])){
            $result_template_id = $exam_param_data['class_id'][$class_id]['result_template'][0];
        }else{
            $result_template_id = '';
        }

        $result_template_alias = getSingledata('result_template', 'alias', 'id', $result_template_id);
        
        $style = $result_template_alias.'/pdf.php';
        
        require_once('./application/views/result/template/'.$style);

        $html = getPDF($roll, $class_id, $department_id, $exam_ids, $year);

        $this->load->library('pdf');
        //$this->loadViews("/result/template/".$style,  $this->global, $data , NULL);
        $filename = "report-".$year;
        
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle($filename);
        $pdf->SetHeaderMargin(0);
        $pdf->SetTopMargin(0);
        $pdf->setFooterMargin(0);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetDisplayMode('real', 'default');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins('10', '10', '10');
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('font', '', 12);
        $pdf->SetFont('brazili', '', 12);
        $pdf->SetFont('traditionalarabic', '', 12);
        $pdf->SetFont('krutidev010', '', 12);
        $pdf->SetFont('solaimanlipi', '', 12);
        $pdf->SetFont('times', '', 12);
        $pdf->SetFont('freeserif', '', 12);

        $pdf->AddPage('P', 'A4');
        ob_start();
        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdf->Output($filename.'.pdf', 'D');
        
    }

    
    /**
    ** This function is used to display result
    **/
    function show_result()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{   

            $roll = $this->input->post('roll');
            $class_id = $this->input->post('class_name');
            $department_id = $this->input->post('department');
            $exam_ids = $this->input->post('exam_name');
            $year = $this->input->post('year');

            $data['roll'] = $roll;
            $data['class_id'] = $class_id;
            $data['department'] = $department_id;
            $data['exam_ids'] = $exam_ids;
            $data['year'] = $year; 

            $exam_param      = getSingledata('exam', 'param', 'id', $exam_ids);
            $exam_param_data = json_decode($exam_param,true);   

            $result_title = getlang('result_title');
            $this->global['pageTitle'] =  $result_title;

            // Get result template id
            if(isset($exam_param_data['class_id'][$class_id]['result_template'][0])){
                $result_template_id = $exam_param_data['class_id'][$class_id]['result_template'][0];
                $result_template_alias = getSingledata('result_template', 'alias', 'id', $result_template_id);

                $student_id    = getStudentID($roll, $class_id, $year, $department_id);
                if(!empty($student_id)){
                    $style = $result_template_alias.'/'.$result_template_alias;
                    $this->loadViews("/result/template/".$style,  $this->global, $data , NULL);
                }else{
                    $data['error_msg'] = "Student not found !";
                    $this->loadViews("/result/template/error",  $this->global, $data , NULL);
                }
                
            }else{
                $result_template_id = '';
                $data['error_msg'] = "Result template not set !";
                $this->loadViews("/result/template/error",  $this->global, $data , NULL);
            }

            
        }
    }

   
 
}




