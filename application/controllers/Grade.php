<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Grade extends BaseController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('grade_model');
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
            
            $this->form_validation->set_rules('name','Grade Name','trim|required|max_length[128]');
            if($this->form_validation->run() == FALSE)
            {
                if(!empty($Id)){
                    $edit_grade_title = getlang('edit_grade_title');
                    $data['grade_data'] = $this->grade_model->getInfo($Id);
                    $this->global['pageTitle'] = $edit_grade_title;
                    $this->loadViews("/grade/add", $this->global, $data, NULL);
                }else{
                    $add_new_grade = getlang('add_grade_title');
                    $this->global['pageTitle'] = $add_new_grade;
                    $this->loadViews("/grade/add", $this->global, NULL, NULL);
                }
            }else{
                $name         = $this->security->xss_clean($this->input->post('name'));
                $grade_point  = $this->input->post('grade_point');
                $point_from   = $this->input->post('point_from');
                $point_to     = $this->input->post('point_to');
                $mark_from    = $this->input->post('mark_from');
                $mark_upto    = $this->input->post('mark_upto');
                $comment      = $this->input->post('comment');
                $category      = $this->input->post('category');
                $grade_data = array(
                    'name'        => $name,
                    'grade_point' => $grade_point,
                    'point_from'  => $point_from,
                    'point_to'    => $point_to,
                    'mark_from'   => $mark_from,
                    'mark_upto'   => $mark_upto,
                    'comment'     => $comment,
                    'category'    => $category
                );
                
                if(!empty($Id)){
                    $result = $this->grade_model->edit($grade_data, $Id);
                    $message_success = $update_success;
                    $message_error = $update_failed;
                }else{
                	$result = $this->grade_model->addNew($grade_data);
                	$message_success = $create_success;
                	$message_error = $create_failed;
                }
                
                
                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }
                redirect('grade');
            }
        }
    }


    /**
    ** This function is used to load the  list
    **/
    function gradelist()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{    
            $grade_list_title = getlang('grade_list_title');  

            $searchText         = $this->security->xss_clean($this->input->post('searchText'));
            $cat_value          = $this->security->xss_clean($this->input->post('cat_value'));
            $data['searchText'] = $searchText;
            $data['cat_value']  = $cat_value;

            $this->load->library('pagination');
            $count   = $this->grade_model->ListingCount($searchText, $cat_value);
            $returns = $this->paginationCompress ( "grade/", $count, 20 );
            
            $data['subjectsRecords'] = $this->grade_model->Listing($searchText, $cat_value, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = $grade_list_title;
            $this->loadViews("/grade/list",  $this->global, $data , NULL);
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
           $this->session->set_flashdata('error', $no_permission);
           redirect('grade');
        }else{
            $result = $this->grade_model->delete($Id);
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