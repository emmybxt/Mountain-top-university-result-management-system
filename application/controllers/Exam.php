<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Exam extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('exam_model');
        $this->isLoggedIn();  
    }
    
    
    /**
    ** Add/ Edit Function
    **/
    function add($Id = NULL)
    {

        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            if(empty($Id)){
                $Id = $this->input->post('id'); 
            }
            
            $this->form_validation->set_rules('name','Exam Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('status');
            $this->form_validation->set_rules('exam_date');

            if($this->form_validation->run() == FALSE)
            {    

                $addnew_exam_title = getlang('addnew_exam_title');
                $edit_exam_title = getlang('edit_exam_title');
 
                if(!empty($Id)){
                    $data['exam_data'] = $this->exam_model->getInfo($Id);
                    $this->global['pageTitle'] =  $addnew_exam_title;
                    $this->loadViews("/exam/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = $edit_exam_title;
                    $this->loadViews("/exam/add", $this->global, NULL, NULL);
                }
            }else{

                $name        = $this->security->xss_clean($this->input->post('name'));
                $status      = $this->input->post('status');
                $date_field  = $this->input->post('exam_date');

                $class       = $this->input->post('class');
                $class_value = implode(",",$class);

                $params = $this->input->post('exam_params');
                $params_data = json_encode($params);

                $exam_info = array(
                    'name'=> $name,
                    'class'=> $class_value,
                    'param'=> $params_data,
                    'status'=> $status,
                    'exam_date' => $date_field
                );
                
                if(!empty($Id)){
                    $result = $this->exam_model->edit($exam_info, $Id);
                    $message_success = getlang('update_success');
                    $message_error = getlang('update_failed');
                }else{
                	$result = $this->exam_model->addNew($exam_info);
                	$message_success = getlang('create_success');
                	$message_error = getlang('create_failed');
                }
                
                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }

                redirect('exam');

            }
        }
    }


    /**
    ** save here
    **/
    function savehere($Id = NULL)
    {

        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            if(empty($Id)){
                $Id = $this->input->post('id'); 
            }
            
            $this->form_validation->set_rules('name','Exam Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('status');
            $this->form_validation->set_rules('exam_date');

            if($this->form_validation->run() == FALSE)
            {    

                $addnew_exam_title = getlang('addnew_exam_title');
                $edit_exam_title = getlang('edit_exam_title');
 
                if(!empty($Id)){
                    $data['exam_data'] = $this->exam_model->getInfo($Id);
                    $this->global['pageTitle'] =  $addnew_exam_title;
                    $this->loadViews("/exam/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = $edit_exam_title;
                    $this->loadViews("/exam/add", $this->global, NULL, NULL);
                }
            }else{

                $name        = $this->security->xss_clean($this->input->post('name'));
                $status      = $this->input->post('status');
                $date_field  = $this->input->post('exam_date');

                $class       = $this->input->post('class');
                $class_value = implode(",",$class);

                $params = $this->input->post('exam_params');
                $params_data = json_encode($params);

                $exam_info = array(
                    'name'=> $name,
                    'class'=> $class_value,
                    'param'=> $params_data,
                    'status'=> $status,
                    'exam_date' => $date_field
                );
                
                if(!empty($Id)){
                    $result = $this->exam_model->edit($exam_info, $Id);
                    $message_success = getlang('update_success');
                    $message_error = getlang('update_failed');
                }else{
                    $result = $this->exam_model->addNew($exam_info);
                    $message_success = getlang('create_success');
                    $message_error = getlang('create_failed');
                }
                
                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }

                redirect('exam/savehere/'.$Id);

            }
        }
    }


    /**
    ** This function is used to load the  list
    **/

    function examlist()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{  

            $exam_list_title = getlang('exam_list_title');

            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');
            $count = $this->exam_model->ListingCount($searchText);
            $returns = $this->paginationCompress ( "exam/", $count, 20 );
            
            $data['examRecords'] = $this->exam_model->Listing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = $exam_list_title;
            $this->loadViews("/exam/list",  $this->global, $data , NULL);
        }
    }


    

    /**
    * This function is used to delete the using id
    * @return boolean $result : TRUE / FALSE
    */
    function delete($Id = NULL)
    {
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );

        $no_permission = getlang('no_permission');
        if (empty($Id)) {
            $Id = $this->input->post('Id');

        }
        
        if($this->isAdmin() == TRUE){
           $this->session->set_flashdata('error', $no_permission );
           redirect('exam');
        }else{
            
            $result = $this->exam_model->delete($Id);
            if ($result > 0){ 
                $reponse['status'] = true;
            }else{ 
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }


    
}

?>