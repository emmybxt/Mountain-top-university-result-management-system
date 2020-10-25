<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class Tabulation extends BaseController
{
    
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
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{   
            $result_title = 'Tabulation Sheet';
            $this->global['pageTitle'] =  $result_title;
            $this->loadViews("/tabulation/form",  $this->global, '' , NULL);
        }
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

            
            $class_id = $this->input->post('class_name');
            $department_id = $this->input->post('department');
            $exam_ids = $this->input->post('exam_name');
            $year = $this->input->post('year');

            
            $data['class_id'] = $class_id;
            $data['department'] = $department_id;
            $data['exam_ids'] = $exam_ids;
            $data['year'] = $year;    

           
            $result_title = 'Tabulation Sheet';
            $this->global['pageTitle'] =  $result_title;
            $this->loadViews("/tabulation/result",  $this->global, $data , NULL);
        }
    }

    
 
}




