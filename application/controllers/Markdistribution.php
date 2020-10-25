<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Markdistribution extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('markdistribution_model');
        $this->isLoggedIn();  
    }
    
    
    /**
    ** Add/Edit Function
    **/
    function add($Id = NULL)
    {
        $addnew_markdistribution_title = getlang('addnew_markdistributiontitle');
        $edit_markdistribution_title = getlang('edit_markdistributiontitle');

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
                    $data['data'] = $this->markdistribution_model->getInfo($Id);
                    $this->global['pageTitle'] = $edit_markdistribution_title;
                    $this->loadViews("/markdistribution/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = $addnew_markdistribution_title;
                    $this->loadViews("/markdistribution/add", $this->global, NULL, NULL);
                }
            }else{
                $title = $this->security->xss_clean($this->input->post('title'));
                $info = array('title'=> $title);
                
                if(!empty($Id)){
                    $result = $this->markdistribution_model->edit($info, $Id);
                    $message_success = getlang('update_success');
                    $message_error = getlang('update_failed');
                }else{
                	$result = $this->markdistribution_model->addNew($info);
                	$message_success = getlang('create_success');
                	$message_error = getlang('create_failed');
                }
                
                
                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }

                redirect('markdistribution');

            }
        }
    }


    /**
    ** This function is used to load the  list
    **/

    function mlist()
    {
        $markdistribution_list = getlang('mark_distribution_list');

        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{      
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');
            $count = $this->markdistribution_model->ListingCount($searchText);
            $returns = $this->paginationCompress ( "subjects/", $count, 20 );
            
            $data['records'] = $this->markdistribution_model->Listing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = $markdistribution_list;
            $this->loadViews("/markdistribution/list",  $this->global, $data , NULL);
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
            
            $result = $this->markdistribution_model->delete($Id);
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