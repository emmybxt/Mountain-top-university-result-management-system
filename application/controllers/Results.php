<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Results extends BaseController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('results_model'); 
    }
    
    /**
    ** This function is used to load the  list
    **/
    function index()
    {  
        $result_title = getlang('result_title');
        $this->global['pageTitle'] = $result_title;
        $this->load->view("/results/default",  $this->global, '' , NULL);
    }


    /**
    ** This function is used to display result
    **/
    function details()
    {
        $roll          = $this->input->post('roll');
        $class_id      = $this->input->post('class_name');
        $department_id = $this->input->post('department');
        $exam_ids      = $this->input->post('exam_name');
        $year          = $this->input->post('year');

        $data['roll']       = $roll;
        $data['class_id']   = $class_id;
        $data['department'] = $department_id;
        $data['exam_ids']   = $exam_ids;
        $data['year']       = $year; 



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
                $this->load->view("/results/template/".$style, $data , NULL);
            }else{
                $data['error_msg'] = "Student not found !";
                $this->load->view("/results/template/error", $data , NULL);
            }

            
        }else{
            $result_template_id = '';
            $data['error_msg'] = "Result template not set !";
            $this->load->view("/results/template/error", $data , NULL);
        }

        

        
        
    }


    
}


?>

