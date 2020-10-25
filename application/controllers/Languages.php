<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Languages extends BaseController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('languages_model');
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
            
            $this->form_validation->set_rules('title','Title','trim|required|max_length[128]');
            if($this->form_validation->run() == FALSE)
            {

                if(!empty($Id)){
                    $data['language_data'] = $this->languages_model->getInfo($Id);
                    $this->global['pageTitle'] = 'Edit Language';
                    $this->loadViews("/languages/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = 'Add New Lanuage';
                    $this->loadViews("/languages/add", $this->global, NULL, NULL);
                }
            }else{
                $title        = $this->input->post('title');
                $title_native = $this->input->post('title_native');
                $lang_code    = $this->input->post('lang_code');
                $image        = $this->input->post('image');
                $published    = $this->input->post('published');
                $direction    = $this->input->post('direction');

                $params       = $this->input->post('params');
                $params_data  = json_encode($params);

                $menu_params  = $this->input->post('menu');
                $menu_data    = json_encode($menu_params);

                $data = array(
                    'title'        => $title,
                    'title_native' => $title_native,
                    'lang_code'    => $lang_code,
                    'image'        => $image,
                    'published'    => $published,
                    'data'         => $params_data,
                    'menus'        => $menu_data,
                    'direction'    => $direction
                );
                
                if(!empty($Id)){
                    $result = $this->languages_model->edit($data, $Id);
                    $message_success = 'data successfully update !';
                    $message_error = 'information update failed !';
                }else{
                	$result = $this->languages_model->addNew($data);
                	$message_success = 'language created successfully';
                	$message_error = 'language added failed !';
                }
                
                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }
                redirect('languages');
            }
        }
    }


    /**
    ** This function is used to load the  list
    **/
    function languagelist()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{      
            $searchText         = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');
            $count    = $this->languages_model->ListingCount($searchText);
            $returns  = $this->paginationCompress ( "subjects/", $count, 20 );
            
            $data['languageRecords'] = $this->languages_model->Listing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Language List';
            $this->loadViews("/languages/list",  $this->global, $data , NULL);
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
           $this->session->set_flashdata('error', 'You have no permission !');
           redirect('languages');
        }else{
            
            $result = $this->languages_model->delete($Id);
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