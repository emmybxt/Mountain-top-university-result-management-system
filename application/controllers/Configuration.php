<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Configuration extends BaseController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('configuration_model');
        $this->isLoggedIn();   
    }
    
    
    /**
    ** Edit Function
    **/
    function edit()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{

            $Id = 1;
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $website = $this->input->post('website');
            $address = $this->input->post('address');

            $result_logo = $this->input->post('result_logo');
            $result_name = $this->input->post('result_name');
            $result_email = $this->input->post('result_email');
            $result_phone = $this->input->post('result_phone');
            $result_address = $this->input->post('result_address');
            $result_website = $this->input->post('result_website');

            
            $year_start = $this->input->post('year_start');
            $year_end = $this->input->post('year_end');
            $theme = $this->input->post('theme');

            $email_form = $this->input->post('email_form');
            $email_bcc = $this->input->post('email_bcc');
            $from_name = $this->input->post('from_name');
            $email_pass = $this->input->post('email_pass');
            $protocol = $this->input->post('protocol');
            $smtp_host = $this->input->post('smtp_host');
            $smtp_port = $this->input->post('smtp_port');
            $smtp_user = $this->input->post('smtp_user');
            $smtp_pass = $this->input->post('smtp_pass');
            $mail_path = $this->input->post('mail_path');

            $certificate_title = $this->input->post('certificate_title');
            $certificate_signature_of = $this->input->post('certificate_signature_of');
            $certificate_signature_designation = $this->input->post('certificate_signature_designation');
            $certificate_template = $this->input->post('certificate_template');
            $certificate_address = $this->input->post('certificate_address');

            $certificate_style = $this->input->post('certificate_style');

            

            $pdf_orientation = $this->input->post('pdf_orientation');
            $pdf_paper_size = $this->input->post('pdf_paper_size');
            $pdf_font = $this->input->post('pdf_font');

            $student_account = $this->input->post('student_account');
            $student_choose_subject = $this->input->post('student_choose_subject');

            $front_end_result = $this->input->post('front_end_result');

            $language = $this->input->post('language');

            // icon upload
            $old_favicon_icon = $this->input->post('old_favicon_icon');
            $new_favicon_icon = $_FILES['favicon_icon']['name'];
            $favicon_icon = '';

            // logo upload
            $old_logo = $this->input->post('old_logo');
            $new_logo = $_FILES['logo']['name'];
            $logo = '';

            $old_logo_2 = $this->input->post('old_logo_2');
            $new_logo_2 = $_FILES['logo_2']['name'];
            $logo_2 = '';

            // certificate_signature
            $old_certificate_signature = $this->input->post('old_certificate_signature');
            $new_certificate_signature = $_FILES['certificate_signature']['name'];
            $certificate_signature = '';

            // certificate_pattan
            $old_certificate_pattan = $this->input->post('old_certificate_pattan');
            $new_certificate_pattan = $_FILES['certificate_pattan']['name'];
            $certificate_pattan = '';

            $config['upload_path']          = './uploads/logo/';
                $config['allowed_types']        = 'gif|jpg|png';
                //$config['max_size']             = 100;
                //$config['max_width']            = 1024;
                //$config['max_height']           = 768;

            $this->load->library('upload', $config);

            // Icon
            if(!empty($new_favicon_icon)){
                if(!empty($old_favicon_icon)){
                    $old_icon = './uploads/logo/'.$old_favicon_icon;
                    unlink($old_icon);
                }
                if ( ! $this->upload->do_upload('favicon_icon')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                }else{
                    $file_data = $this->upload->data();
                    $favicon_icon = $file_data['file_name'];
                }
            }else{
                $favicon_icon = $old_favicon_icon;
            }

            // Logo 1
            if(!empty($new_logo)){
                if(!empty($old_logo)){
                    $old_file = './uploads/logo/'.$old_logo;
                    unlink($old_file);
                }
                if ( ! $this->upload->do_upload('logo')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                }else{
                    $file_data = $this->upload->data();
                    $logo = $file_data['file_name'];
                }
            }else{
                $logo = $old_logo;
            }


            // Logo 2
            if(!empty($new_logo_2)){
                if(!empty($old_logo_2)){
                    $old_file_2 = './uploads/logo/'.$old_logo_2;
                    unlink($old_file_2);
                }
                if ( ! $this->upload->do_upload('logo_2')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                }else{
                    $file_data_2 = $this->upload->data();
                    $logo_2 = $file_data_2['file_name'];
                }
            }else{
                $logo_2 = $old_logo_2;
            }

            // certificate_signature
            if(!empty($new_certificate_signature)){
                if(!empty($old_certificate_signature)){
                    $old_certificate_signature = './uploads/logo/'.$old_certificate_signature;
                    unlink($old_certificate_signature);
                }
                if ( ! $this->upload->do_upload('certificate_signature')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                }else{
                    $file_certificate_signature = $this->upload->data();
                    $certificate_signature = $file_certificate_signature['file_name'];
                }
            }else{
                $certificate_signature = $old_certificate_signature;
            }

            // certificate_pattan
            if(!empty($new_certificate_pattan)){
                if(!empty($old_certificate_pattan)){
                    $old_certificate_pattan = './uploads/logo/'.$old_certificate_pattan;
                    unlink($old_certificate_pattan);
                }
                if ( ! $this->upload->do_upload('certificate_pattan')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                }else{
                    $file_certificate_pattan = $this->upload->data();
                    $certificate_pattan = $file_certificate_pattan['file_name'];
                }
            }else{
                $certificate_pattan = $old_certificate_pattan;
            }



            $data = array(
            	'name'=> $name,
            	'email'=> $email, 
                'phone'=>$phone, 
                'website'=> $website, 
                'address'=>$address, 
                'favicon_icon'=>$favicon_icon,
                'logo'=>$logo,
                'logo_2'=>$logo_2,
                'result_logo'=>$result_logo,
                'result_name'=> $result_name, 
                'result_email'=>$result_email, 
                'result_phone'=>$result_phone,
                'result_address'=>$result_address,
                'result_website'=>$result_website,
                'language'=>$language,
                'year_start'=>$year_start,
                'year_end'=>$year_end,
                'theme'=>$theme,
                'email_form'=>$email_form, 
                'email_bcc'=>$email_bcc,
                'from_name'=>$from_name,
                'email_pass'=>$email_pass,
                'protocol'=>$protocol,
                'smtp_host'=>$smtp_host,
                'smtp_port'=>$smtp_port,
                'smtp_user'=>$smtp_user,
                'smtp_pass'=>$smtp_pass,
                'mail_path'=>$mail_path,
                'front_end_result'=>$front_end_result, 

                'certificate_signature'=>$certificate_signature, 
                'certificate_signature_of'=>$certificate_signature_of, 
                'certificate_signature_designation'=>$certificate_signature_designation, 
                'certificate_title'=>$certificate_title,
                'certificate_pattan'=>$certificate_pattan,
                'certificate_template'=>$certificate_template,
                'certificate_style'=>$certificate_style,
                'pdf_orientation'=>$pdf_orientation,
                'pdf_paper_size'=>$pdf_paper_size,
                'pdf_font'=>$pdf_font,
                'student_account'=>$student_account,
                'student_choose_subject'=>$student_choose_subject                  
            );

            if(!empty($Id)){
                $result = $this->configuration_model->edit($data, $Id);
                $message_success = 'data successfully update !';
                $message_error = 'information update failed !';
            }
            
            if($result > 0){
                $this->session->set_flashdata('success', $message_success);
            }else{
                $this->session->set_flashdata('error', $message_error);
            }
            redirect('configuration');
        }
    }


    /**
    ** This function is used to load the  list
    **/

    function index()
    {
    	$Id = 1;
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{   
            $configuratoin_title = getlang('configuration_title');  
            
            if(!empty($Id)){
                $data['con_data'] = $this->configuration_model->getInfo($Id);
            }else{
                $data['con_data'] = '';    
            }
            
            $this->global['pageTitle'] = $configuratoin_title;
            $this->loadViews("/configuration/default",  $this->global, $data , NULL);
        }
    }

}

?>