<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Gradecat extends BaseController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('gradecat_model');
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
            
            $this->form_validation->set_rules('name','Category Title','trim|required|max_length[128]');
            $this->form_validation->set_rules('mark','Mark','');

            if($this->form_validation->run() == FALSE)
            {
                if(!empty($Id)){
                    $data['dp_data'] = $this->gradecat_model->getInfo($Id);
                    $this->global['pageTitle'] = getlang('edit_grade_cat_title');
                    $this->loadViews("/gradecat/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = getlang('add_grade_cat_title');
                    $this->loadViews("/gradecat/add", $this->global, NULL, NULL);
                }
            }else{

                // Collect data from post
                $name = $this->security->xss_clean($this->input->post('name'));
                $mark = $this->security->xss_clean($this->input->post('mark'));

                $info = array(
                    'name'=> $name,
                    'mark'=> $mark
                );
               
                if(!empty($Id)){
                    // Get update query
                    $result          = $this->gradecat_model->edit($info, $Id);
                    $message_success = getlang('update_success');
                    $message_error   = getlang('update_failed');
                }else{
                    // Get insert query
                	$result          = $this->gradecat_model->addNew($info);
                	$message_success = getlang('create_success');
                	$message_error   = getlang('create_failed');
                }
                
                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }

                redirect('gradecat');
            }
        }
    }


    /**
    ** This function is used to load the  list
    **/
    function gradecatlist()
    {

        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{  

            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');
            $count = $this->gradecat_model->ListingCount($searchText);
            $returns = $this->paginationCompress ( "gradecat/", $count, 20 );
            $data['records'] = $this->gradecat_model->Listing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = getlang('grade_cat_list_title');
            $this->loadViews("/gradecat/list",  $this->global, $data , NULL);
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
            redirect('gradecat');
        }else{
            
            $result = $this->gradecat_model->delete($Id);
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