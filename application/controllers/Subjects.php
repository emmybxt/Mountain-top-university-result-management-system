<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Subjects extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('subjects_model');
        $this->isLoggedIn();  
    }
    
    /**
    ** Add/ Edit Function
    **/
    function add($Id = NULL)
    {
        $addnew_subject_title = getlang('addnew_subjecttitle');
        $edit_subjecttitle    = getlang('edit_subjecttitle');

        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            if(empty($Id)){
                $Id = $this->input->post('id');
            }
            
            $this->form_validation->set_rules('name','Subject Name','trim|required|max_length[128]');
            if($this->form_validation->run() == FALSE)
            {

                if(!empty($Id)){
                    $data['subject_data'] = $this->subjects_model->getInfo($Id);
                    $this->global['pageTitle'] = $edit_subjecttitle;
                    $this->loadViews("/subjects/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = $addnew_subject_title;
                    $this->loadViews("/subjects/add", $this->global, NULL, NULL);
                }
            }else{
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('name'))));
                $subject = array('name'=> $name);
                
                if(!empty($Id)){
                    $result = $this->subjects_model->edit($subject, $Id);
                    $message_success = getlang('update_success');
                    $message_error = getlang('update_failed');
                }else{
                	$result = $this->subjects_model->addNew($subject);
                	$message_success = getlang('create_success');
                	$message_error = getlang('create_failed');
                }
                
                
                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }
                redirect('subjects');

            }
        }
    }


    /**
    ** This function is used to load the  list
    **/
    function subjectlist()
    {
        $subjects_list = getlang('subjects_list_title');

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{      
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');
            $count = $this->subjects_model->ListingCount($searchText);
            $returns = $this->paginationCompress ( "subjects/", $count, 20 );
            
            $data['subjectsRecords'] = $this->subjects_model->Listing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = $subjects_list;
            $this->loadViews("/subjects/list",  $this->global, $data , NULL);
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

        if (empty($Id)) {
            $Id = $this->input->post('Id');
        }
        
        if($this->isAdmin() == TRUE){
            $no_permission = getlang('no_permission');
           $this->session->set_flashdata('error', $no_permission);
           redirect('subjects');
        }else{
            
            $result = $this->subjects_model->delete($Id);
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