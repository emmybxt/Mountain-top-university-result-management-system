<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
    ** Index Page for this controller.
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
            $this->load->view('login');
        }else{
            redirect('pageNotFound');
        }
    }
}

?>