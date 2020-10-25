<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Departments extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('department_model');
        $this->isLoggedIn();  
    }
    
    
    /**
    ** Add/ Edit Function
    **/
    function add($Id = NULL)
    {
        $update_success = getlang('update_success');
        $update_failed  = getlang('update_failed');
        $create_success = getlang('create_success');
        $create_failed  = getlang('create_failed');

        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            if(empty($Id)){
                $Id = $this->input->post('id');
            }
            
            $this->form_validation->set_rules('department_name','Department Name','trim|required|max_length[128]');

            if($this->form_validation->run() == FALSE)
            {
                if(!empty($Id)){
                    $data['dp_data'] = $this->department_model->getInfo($Id);
                    $this->global['pageTitle'] = getlang('edit_department_title');
                    $this->loadViews("/department/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = getlang('add_department_title');
                    $this->loadViews("/department/add", $this->global, NULL, NULL);
                }
            }else{
                $department_name = ucwords(strtolower($this->security->xss_clean($this->input->post('department_name'))));
                $department_info = array('department_name'=> $department_name);
               
                if(!empty($Id)){
                    $result          = $this->department_model->edit($department_info, $Id);
                    $message_success = getlang('update_success');
                    $message_error   = getlang('update_failed');
                }else{
                	$result          = $this->department_model->addNew($department_info);
                	$message_success = getlang('create_success');
                	$message_error   = getlang('create_failed');
                }
                
                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }
                redirect('departments');
            }
        }
    }


    /**
    ** This function is used to load the  list
    **/
    function departmentslist()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{ 
            $class_list_title   = getlang('department_list_title');
            $searchText         = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');
            $count                     = $this->department_model->ListingCount($searchText);
            $returns                   = $this->paginationCompress ( "departments/", $count, 20 );
            $data['departmentRecords'] = $this->department_model->Listing($searchText, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = $class_list_title;
            $this->loadViews("/department/list",  $this->global, $data , NULL);
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
            $this->session->set_flashdata('error', $no_permission );
            redirect('departments');
        }else{
            $result = $this->department_model->delete($Id);
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