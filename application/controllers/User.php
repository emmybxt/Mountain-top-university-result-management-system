<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class User extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->isLoggedIn();   
        
    }
    
    /**
    ** This function used to load the first screen of the user
    **/
    public function index()
    {
        $dashboard_title = getlang('dashboard_title');
        $this->global['pageTitle'] = $dashboard_title;
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
    ** This function is used to load the user list
    **/
    function userlist()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{   
            $teacher_list_title = getlang('teacher_list_title');
            $searchText         = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            $count   = $this->user_model->userListingCount($searchText);
			$returns = $this->paginationCompress ( "user/", $count, 10 );
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] =$teacher_list_title;
            $this->loadViews("/user/list", $this->global, $data, NULL);
        }
    }


    /**
    ** This function is used to check whether email already exist or not
    **/
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email  = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
    ** This function is used to add new user to the system
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

            if(empty($Id)){
                $this->form_validation->set_rules('password','Password','required|max_length[8]');
                $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[8]');
            }

            $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[11]');
            
            if($this->form_validation->run() == FALSE)
            {
                $addnew_teacher_title = getlang('addnew_teacher_title');
                $edit_teacher_title   = getlang('edit_teacher_title');
                
                if(!empty($Id)){
                    $data['roles']             = $this->user_model->getUserRoles();
                    $data['user_data']         = $this->user_model->getUserInfo($Id);
                    $this->global['pageTitle'] = $edit_teacher_title;
                    $this->loadViews("/user/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = $addnew_teacher_title;
                    $data['roles']             = $this->user_model->getUserRoles();
                    $this->loadViews("/user/add", $this->global, $data, NULL);
                }
            }else{

                $name     = $this->security->xss_clean($this->input->post('name'));
                $email    = $this->security->xss_clean($this->input->post('email'));
                $password = $this->input->post('password');
                $roleId   = $this->input->post('role');
                $mobile   = $this->security->xss_clean($this->input->post('mobile'));

                // User avatar upload
                $old_avatar = $this->input->post('old_avatar');
                $new_avatar = $_FILES['avatar']['name'];
                $avatar     = '';

                if(!empty($new_avatar)){

                    if(!empty($old_avatar)){
                        // delete query
                        $old_file = './uploads/users/'.$old_avatar;
                        unlink($old_file);
                    }

                    $config['upload_path']          = './uploads/users/';
                    $config['allowed_types']        = 'gif|jpg|png';
                    //$config['max_size']             = 100;
                    //$config['max_width']            = 1024;
                    //$config['max_height']           = 768;


                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload('avatar')){
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        $this->global['pageTitle'] = getlang('new_student');
                        $this->loadViews("users/addNew", $this->global, NULL, NULL);
                    }else{
                        $file_data = $this->upload->data();
                        $avatar = $file_data['file_name'];
                    }
                }else{
                    $avatar = $old_avatar;
                }

                if(empty($password)){
                    $userInfo = array(
                    'email'      => $email,
                    'roleId'     => $roleId, 
                    'name'       => $name,
                    'avatar'     => $avatar,
                    'mobile'     => $mobile, 
                    'createdBy'  => $this->vendorId, 
                    'createdDtm' => date('Y-m-d H:i:s')
                    );
                }else{
                    $userInfo = array(
                    'email'      => $email,
                    'password'   => getHashedPassword($password), 
                    'roleId'     => $roleId, 
                    'name'       => $name,
                    'avatar'     => $avatar,
                    'mobile'     => $mobile, 
                    'createdBy'  => $this->vendorId, 
                    'createdDtm' => date('Y-m-d H:i:s')
                    );
                }

                if(!empty($Id)){
                    $result          = $this->user_model->edit($userInfo, $Id);
                    $message_success = getlang('update_success');
                    $message_error   = getlang('update_failed');
                }else{
                    $result          = $this->user_model->addNew($userInfo);
                    $message_success = getlang('create_success');
                    $message_error   = getlang('create_failed');
                }
                
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Teacher created successfully');
                }else{
                    $this->session->set_flashdata('error', 'Teacher creation failed');
                }
                
                redirect('user');
            }
        }
    }

    /**
     * This function is used to delete the user using userId
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
           $this->session->set_flashdata('error'.$no_permission);
           redirect('user');
        }else{

            // Delete Avatar
            $exit_avatar = getSingledata('users', 'avatar', 'userId', $Id);
            if(!empty($exit_avatar)){
                $old_file = './uploads/users/'.$exit_avatar;
                unlink($old_file);
            }

            $result = $this->user_model->delete($Id);
            if ($result > 0){ 
                $reponse['status'] = true;
            }else{ 
                $reponse['status'] = false;
            }
        }

        echo json_encode($reponse);
    }
    
    /**
     * This function is used to load the change password screen
     */
    function changepass()
    {
        $change_password           = getlang('change_password');
        $this->global['pageTitle'] = $change_password;
        $this->loadViews("user/changepassword", $this->global, NULL, NULL);
    }
    
    
    /**
     * This function is used to change the password of the user
     */
    function updatepassword()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE){
            $this->loadChangePass();
        }else{
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            $resultPas   = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas)){
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('loadChangePass');
            }else{
                $usersData = array(
                    'password'   => getHashedPassword($newPassword), 
                    'updatedBy'  => $this->vendorId,
                    'updatedDtm' => date('Y-m-d H:i:s')
                );
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { 
                    $this->session->set_flashdata('success', 'Password update successful'); 
                }else{ 
                    $this->session->set_flashdata('error', 'Password update failed'); 
                }
                redirect('user/changepass');
            }
        }
    }


    /**
     * This function is used to load the change password screen
     */
    function changeavatar()
    {
        $change_avatar             = getlang('change_avatar');
        $userId                    = $this->vendorId;
        $data['userInfo']          = $this->user_model->getadmininfo($userId);
        $this->global['pageTitle'] = $change_avatar;
        $this->loadViews("user/changeavatar", $this->global, $data, NULL);
    }
    
    
    /**
     * This function is used to change the Avatar of the user
     */
    function updateavatar()
    {
        $userId = $this->vendorId;

        // User avatar upload
        $old_avatar = $this->input->post('old_avatar');
        $new_avatar = $_FILES['avatar']['name'];
        $avatar = '';
        if(!empty($new_avatar)){
            if(!empty($old_avatar)){
                // delete query
                $old_file = './uploads/users/'.$old_avatar;
                unlink($old_file);
            }

            $config['upload_path']          = './uploads/users/';
            $config['allowed_types']        = 'gif|jpg|png';

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('avatar'))
            {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                $this->global['pageTitle'] = 'Add New User';
                $this->loadViews("users/editOld", $this->global, NULL, NULL);
            }else{
                $file_data = $this->upload->data();
                $avatar = $file_data['file_name'];
            }
        }else{
            $avatar = $old_avatar;
        }

        $userInfo = array(
            'avatar'=>$avatar
        );

        $result = $this->user_model->edit($userInfo, $userId);
        
        if($result == true){
            $this->session->set_flashdata('success', 'Avatar updated successfully');
        }else{
            $this->session->set_flashdata('error', 'Avatar update failed');
        }
                
        redirect('user/changeavatar');
                
    }


}

?>