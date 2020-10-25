<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Students extends BaseController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('students_model');
        $this->isLoggedIn();  
    }

    /**
    ** Add Function
    **/
    function add()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{

            $student_choose_subject = getParam('student_choose_subject');
            $add_new_students       = getlang('add_new_students_title');
            $this->load->library('form_validation');
            $Id = $this->input->post('id');

            $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('mobile','Mobile Number','required');
            $this->form_validation->set_rules('class_name','Class');
            $this->form_validation->set_rules('roll','Roll No','required|max_length[20]');
            if(!empty($student_choose_subject)):
                $this->form_validation->set_rules('subject_name[]','Subject','required');
                $this->form_validation->set_rules('option_subject[]','Optional Subject','required');
            endif;
            if($this->form_validation->run() == FALSE)
            {
                $this->global['pageTitle'] = $add_new_students;
                $this->loadViews("/students/add", $this->global, NULL, NULL);
            }else{

                // Get student name from post data
                $name = $this->security->xss_clean($this->input->post('name'));

                // Get class from post data
                $class = $this->input->post('class_name');

                // Get department from post data
                $department = $this->input->post('department');

                // Get roll number from post data
                $roll = $this->input->post('roll');

                // Get year from post data
                $year = $this->input->post('year');

                // Get mobile/phone from post data
                $mobile = $this->security->xss_clean($this->input->post('mobile'));

                
                if(!empty($student_choose_subject)):

                // Get subject from post data
                $main_subject = $this->input->post('subject_name');
                $main_subject = implode(",",$main_subject);

                // Get option subject from post data
                $option_subject = $this->input->post('option_subject');
                $option_subject = implode(",",$option_subject);
                endif;

                // Get student avatar upload
                $old_avatar = $this->input->post('old_avatar');
                $new_avatar = $_FILES['avatar']['name'];
                $avatar = '';

                if(!empty($new_avatar)){

                    $config['upload_path']          = './uploads/students/';
                    $config['allowed_types']        = 'gif|jpg|png';

                    $this->load->library('upload', $config);
                   
                    if(!empty($old_avatar)){
                        // delete query
                        $old_file = './uploads/students/'.$old_avatar;
                        unlink($old_file);
                    }

                    if ( ! $this->upload->do_upload('avatar'))
                    {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        
                    }else{
                        $file_data = $this->upload->data();
                        $avatar = $file_data['file_name'];
                    }

                }else{
                    $avatar = $old_avatar;
                }

                // Set info 
                $studentsInfo = array(
                    'roll'             => $roll, 
                    'year'             => $year, 
                    'name'             => $name, 
                    'class'            => $class,
                    'department'       => $department, 
                    'phone'            => $mobile,
                    'avatar'           => $avatar 
                );

                if(!empty($student_choose_subject)):
                    $studentsInfo['main_subjects']    = $main_subject;
                    $studentsInfo['optional_subject'] = $option_subject;
                endif;
                
                if(!empty($Id)){
                    $result          = $this->students_model->editStudent($studentsInfo, $Id);
                    $message_success = getlang('update_success');
                    $message_error   = getlang('update_failed');
                }else{
                	$result          = $this->students_model->addNewStudents($studentsInfo);
                	$message_success = getlang('create_success');
                	$message_error   = getlang('create_failed');
                }

                if($result > 0){
                    $this->session->set_flashdata('success', $message_success);
                }else{
                    $this->session->set_flashdata('error', $message_error);
                }

                redirect('students');

            }
        }
    }

    /**
    ** Edit Function
    **/
    function edit($Id = NULL)
    {
        $create_success = getlang('create_success');
    	$create_failed  = getlang('create_failed');
        $edit_students  = getlang('edit_students_title');

        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            
            $student_choose_subject = getParam('student_choose_subject');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[11]');
            $this->form_validation->set_rules('class_name','Class');
            $this->form_validation->set_rules('roll','Roll No','required|max_length[20]');
            if(!empty($student_choose_subject)):
                $this->form_validation->set_rules('subject_name[]','Subject','required');
                $this->form_validation->set_rules('option_subject[]','Optional Subject','required');
            endif;
            
            if($this->form_validation->run() == FALSE)
            {
                if(!empty($Id)){
                    $data['studentInfo'] = $this->students_model->getStudentInfo($Id);
                    $this->global['pageTitle'] = $edit_students;
                    $this->loadViews("/students/add", $this->global, $data, NULL);
                }else{
                    $this->global['pageTitle'] = $add_new_students;
                    $this->loadViews("/students/add", $this->global, NULL, NULL);
                }  
            }else{

                // Get student name from post data
                $name = $this->security->xss_clean($this->input->post('name'));

                // Get class from post data
                $class = $this->input->post('class_name');

                // Get department from post data
                $department = $this->input->post('department');

                // Get roll number from post data
                $roll = $this->input->post('roll');

                // Get year from post data
                $year = $this->input->post('year');

                // Get mobile/phone from post data
                $mobile = $this->security->xss_clean($this->input->post('mobile'));

                if(!empty($student_choose_subject)):

                // Get subject from post data
                $main_subject = $this->input->post('subject_name');
                $main_subject = implode(",",$main_subject);

                // Get option subject from post data
                $option_subject = $this->input->post('option_subject');
                $option_subject = implode(",",$option_subject);
                endif;
                
                // Set info 
                $studentsInfo = array(
                    'roll'             => $roll, 
                    'year'             => $year, 
                    'name'             => $name, 
                    'class'            => $class,
                    'department'       => $department, 
                    'phone'            => $mobile,
                    'avatar'           => $avatar 
                );

                if(!empty($student_choose_subject)):
                    $studentsInfo['main_subjects']    = $main_subject;
                    $studentsInfo['optional_subject'] = $option_subject;
                endif;

                $result = $this->students_model->addNewStudents($studentsInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', $update_success );
                }else{
                    $this->session->set_flashdata('error', $update_failed );
                }

                redirect('students');

            }
        }
    }

    /**
    ** List 
    **/
    function studentlist()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{      

            $students_list_title = getlang('students_list_title');

            $searchText                = $this->security->xss_clean($this->input->post('searchText'));
            $class_value               = $this->security->xss_clean($this->input->post('class_value'));
            $department_value          = $this->security->xss_clean($this->input->post('department_value'));
            $year_value                = $this->security->xss_clean($this->input->post('year_value'));
            $data['searchText']        = $searchText;
            $data['class_value']       = $class_value;
            $data['department_value']  = $department_value;
            $data['year_value']        = $year_value;
            
            $this->load->library('pagination');
            
            $count = $this->students_model->studentsListingCount($searchText, $class_value, $department_value, $year_value);

            $returns = $this->paginationCompress ( "students/", $count, 20 );
            
            $data['studentsRecords'] = $this->students_model->studentsListing($searchText, $class_value, $department_value, $year_value, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = $students_list_title;
            $this->loadViews("/students/list",  $this->global, $data , NULL);
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

        $no_permission = getlang('no_permission');
        if (empty($Id)) {
            $Id = $this->input->post('Id');
        }

        if($this->isAdmin() == TRUE){
           $this->session->set_flashdata('error', $no_permission );
           redirect('students');
        }else{

            // Delete Avatar
            $exit_avatar = getSingledata('students', 'avatar', 'id', $Id);
            if(!empty($exit_avatar)){
                $old_file = './uploads/students/'.$exit_avatar;
                unlink($old_file);
            }
            $result = $this->students_model->deleteStudent($Id);
            if ($result > 0){ 
                $reponse['status'] = true;
            }else{ 
                $reponse['status'] = false;
            }
        }
        echo json_encode($reponse);
    }

    /**
    ** View
    **/
    function view($id = NULL)
    {
        $no_permission   = getlang('no_permission');
        $somthing_worng  = getlang('somthing_worng');
        $student_profile = getlang('student_profile');

        if($this->isAdmin() == TRUE){
            $this->session->set_flashdata('error', $no_permission );
            redirect('students');
        }else{
            
            if (!empty($id)) {
                $result['studentInfo'] = $this->students_model->viewStudent($id);
                $this->global['pageTitle'] = $student_profile;
                $this->loadViews("/students/view",  $this->global, $result , NULL);
            }else{
                $this->session->set_flashdata('error', $somthing_worng );
                redirect('students');
            }
        }
    }

    
}

?>