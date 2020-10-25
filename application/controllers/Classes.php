<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Classes extends BaseController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('class_model');
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
            
            $this->form_validation->set_rules('name','Class Name','trim|required|max_length[128]');

            if($this->form_validation->run() == FALSE)
            {
                if(!empty($Id)){
                    $data['class_data'] = $this->class_model->getInfo($Id);
                    $this->global['pageTitle'] = getlang('edit_class_subject_title');
                    $this->loadViews("/class/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = getlang('addnew_class_subject_title');
                    $this->loadViews("/class/add", $this->global, NULL, NULL);
                }
            }else{
                
                // Get name from post data
                $name = $this->security->xss_clean($this->input->post('name'));

                // Get subject from post data
                $subject_name = $this->input->post('subject_name');
                $subject_name = implode(",",$subject_name);

                // Get option subject from post data
                $option_subject = $this->input->post('option_subject');
                $option_subject = implode(",",$option_subject);

                // Get mark distribution from post data
                $mark_distribution = $this->input->post('mark_distribution');
                $mark_distribution = implode(",",$mark_distribution);

                // Set class insert data
                $class_info = array(
                                'name'              => $name,
                                'subjects'          => $subject_name,
                                'optional_subject'  => $option_subject,
                                'mark_distribution' => $mark_distribution
                            );

                if(!empty($Id)){
                    $result = $this->class_model->edit($class_info, $Id);
                    $message_success = getlang('update_success');
                    $message_error = getlang('update_failed');
                }else{

                	$result = $this->class_model->addNew($class_info);
                	$message_success = getlang('create_success');
                	$message_error = getlang('create_failed');
                }
                
                
                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }

                redirect('classes');

            }
        }
    }


    /**
    ** This function is used to load the  list
    **/
    function classlist()
    {

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{  
    
            $class_list_title = getlang('class_list_title');

            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');
            $count = $this->class_model->ListingCount($searchText);
            $returns = $this->paginationCompress ( "classes/", $count, 20 );
            
            $data['classRecords'] = $this->class_model->Listing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = $class_list_title;
            $this->loadViews("/class/list",  $this->global, $data , NULL);
        }
    }


    /**
    ** Delete
    **/
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
           redirect('classes');
        }else{
            
            $result = $this->class_model->delete($Id);
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