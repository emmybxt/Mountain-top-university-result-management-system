<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }

    /**
    ** Index
    **/
    public function index()
    {
        $this->isLoggedIn();
    }
    
    /**
    ** This function used to check the user is logged in or not
    **/
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE){
            $this->load->view('user/login');
        }else{
            redirect('/dashboard');
        }
    }
    
    
    /**
    ** This function used to logged in user
    **/
    public function loginMe()
    {
        // Get form validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');

        if($this->form_validation->run() == FALSE){
            $this->index();
        }else{
            // Get collection form data
            $email    = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');
            $result   = $this->login_model->loginMe($email, $password);
            
            if(!empty($result))
            {
                $lastLogin = $this->login_model->lastLoginInfo($result->userId);

                // Set session data
                $sessionArray = array(
                    'userId'     => $result->userId,                    
                    'role'       => $result->roleId,
                    'roleText'   => $result->role,
                    'name'       => $result->name,
                    'lastLogin'  => $lastLogin->createdDtm,
                    'isLoggedIn' => TRUE
                );

                $this->session->set_userdata($sessionArray);
                unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
                
                // Set login info
                $loginInfo = array(
                    "userId"       => $result->userId, 
                    "sessionData"  => json_encode($sessionArray), 
                    "machineIp"    => $_SERVER['REMOTE_ADDR'], 
                    "userAgent"    => getBrowserAgent(), 
                    "agentString"  => $this->agent->agent_string(), 
                    "platform"     => $this->agent->platform()
                );

                $this->login_model->lastLogin($loginInfo);
                redirect('/dashboard');
            }else{
                $email_pass_mismatch = getlang('email_pass_mismatch');
                $this->session->set_flashdata('error', $email_pass_mismatch);
                redirect('login');
            }
        }
    }

    /**
    ** This function used to load forgot password view
    **/
    public function forgotpassword()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE){
            $this->load->view('user/forgotpassword');
        }else{
            redirect('/dashboard');
        }
    }
    
    /**
    ** This function used to generate reset password request link
    **/
    function resetPasswordUser()
    {
        $status = '';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
        if($this->form_validation->run() == FALSE){
            $this->forgotPassword();
        }else{
            $email = $this->security->xss_clean($this->input->post('login_email'));
            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                $this->load->helper('string');
                $data['email']         = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm']    = date('Y-m-d H:i:s');
                $data['agent']         = getBrowserAgent();
                $data['client_ip']     = $this->input->ip_address();
                $save = $this->login_model->resetPasswordUser($data);                
                
                if($save){
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $reset_pass = getlang('reset_pass');
                        $data1["name"] = $userInfo[0]->name;
                        $data1["email"] = $userInfo[0]->email;
                        $data1["message"] = $reset_pass;
                    }

                    $sendStatus = resetPasswordEmail($data1);

                    if($sendStatus){
                        $pass_link_sent = getlang('pass_link_sent');
                        $status = "send";
                        setFlashData($status, $pass_link_sent);
                    } else {
                        $email_failed = getlang('email_failed');
                        $status = "notsend";
                        setFlashData($status,  $email_failed);
                    }
                }else{
                    $sent_details_error = getlang('sent_details_error');
                    $status = 'unable';
                    setFlashData($status, $sent_details_error);
                }
            }else{
                $email_registered = getlang('email_registered');
                $status = 'invalid';
                setFlashData($status, $email_registered);
            }
            redirect('forgotpassword');
        }
    }

    /**
    ** This function used to reset the password 
    ** @param string $activation_id : This is unique id
    ** @param string $email : This is user email
    **/
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);
        
        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
        
        $data['email']           = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1){
            $this->load->view('user/newPassword', $data);
        }else{
            redirect('login');
        }
    }
    
    /**
    ** This function used to create new password for user
    **/
    function createPasswordUser()
    {
        $status        = '';
        $message       = '';
        $email         = $this->input->post("email");
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE){
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }else{
            $password  = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
            
            if($is_correct == 1)
            {               
                $this->login_model->createPasswordUser($email, $password);
                $status  = 'success';
                $message = getlang('pass_success');
            }else{
                $status  = 'error';
                $message = getlang('pass_error');
            }
            
            setFlashData($status, $message);
            redirect("login");
        }
    }
}

?>