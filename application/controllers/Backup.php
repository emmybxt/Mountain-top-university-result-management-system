<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Backup extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('backup_model');
        $this->isLoggedIn();
        
        $restored_success = getlang('restored_success');   
        $restored_failed = getlang('restored_failed');   
    }
    
    /**
    ** Backup index page
    **/
    function index()
    {
        $this->global['pageTitle'] = 'Backup';
        $this->loadViews("backup/default", $this->global, NULL, NULL);
    }


    /**
    ** Download Student's Avatar
    **/
    function download_students_avatar()
    {
        $this->load->library('zip');
        $file_name='backup_students_avatar.zip';
        $path = 'uploads/students';
        $this->zip->read_dir($path, FALSE);
        $this->zip->download($file_name);
    }


    /**
    ** Download Students CSV 
    **/
    function download_students_csv()
    {
        $students = $this->backup_model->students_list();
        
        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'ID');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Avatar');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Name');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Class');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Department');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Roll');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Phone');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Year');

        // Set custom field
        $alphabet = range('A', 'Z');
        $sid         = getFieldSectionID('student');
        $fields      = getFieldList($sid);
        $total_field = count($fields);
        foreach ($fields as $key => $field_item) {
        	$field_name  = $field_item->field_name;
        	$field_index = $alphabet[$key+8].'1';
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($field_index, $field_name);
        }

        // Start students Loop
        foreach ($students as $key => $item) {
            $sr = $key +2;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sr.'', $item->id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$sr.'', $item->avatar);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$sr.'', $item->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$sr.'', $item->class);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$sr.'', $item->department);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$sr.'', $item->roll);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$sr.'', $item->phone);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$sr.'', $item->year);

            foreach ($fields as $f => $field_item) {

                $ci =& get_instance();
            	$ci->db->FROM('fields_data');
	            $ci->db->SELECT('*');
	            $ci->db->where('fid',$field_item->id);
	            $ci->db->where('sid',$sid);
	            $ci->db->where('panel_id',$item->id);
	            $query_result   = $ci->db->get();
	            $field_data_row = $query_result->row();
	            $field_data     = $field_data_row->data;
                $field_index    = $alphabet[$f+8].$sr;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($field_index, $field_data);
            }
        } 


        // set file name
        $filename = "backup_students";

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.csv"');

        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        exit;
        
    }

    /**
    ** Upload Student's Avatars
    **/
    function upload_students_avatar()
    {
        $restored_success = getlang('restored_success');   
        $restored_failed = getlang('restored_failed'); 

        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );

        if(isset($_FILES['file'])){
            $zip = new ZipArchive;
            $file = $_FILES['file']['tmp_name'];
            chmod($file,0777);
            if ($zip->open($file) === TRUE) {
                $zip->extractTo('./uploads');
                $zip->close();
                $msg = '<p style="color: green;"><span class="fa fa-check" ></span> '.$restored_success.'</p>';
            } else {
               $msg = '<p style="color: red;"><span class="fa fa-exclamation-triangle"></span> '.$restored_failed.'</p>';
            }
        }else{
            $msg = '<p style="color: red;"><span class="fa fa-exclamation-triangle"></span> '.$restored_failed.'</p>';
        }

        $reponse['html'] = $msg;
        echo json_encode($reponse);

    }


    /**
    ** Upload Student's CSV
    **/
    function upload_students_csv()
    {

        $restored_success = getlang('restored_success');   
        $restored_failed = getlang('restored_failed'); 

        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );

        if(isset($_FILES['csv'])){

            if($_FILES['csv']['tmp_name']){
                if(!$_FILES['csv']['error'])
                {

                    $filename=$_FILES["csv"]["tmp_name"];   
                    if($_FILES["csv"]["size"] > 0){

                        $file = fopen($filename, "r");

                        // read the first line and ignore it
                        fgets($file); 
                        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){

                            $id           = $getData['0'];
                            $avatar       = $getData['1'];
                            $name         = $getData['2'];
                            $class        = $getData['3'];
                            $department   = $getData['4'];
                            $roll         = $getData['5'];
                            $phone        = $getData['6'];
                            $year         = $getData['7'];

                            // Set custom field
					        $sid         = getFieldSectionID('student');
					        $fields      = getFieldList($sid);
					        foreach ($fields as $key => $field_item) {
					        	$fid = $field_item->id;
					        	$type = $field_item->type;
					        	$student_id = $id;
					        	$field_data = $getData[$key+8];

                                $ci =& get_instance();
					        	$ci->db->FROM('fields_data');
					            $ci->db->SELECT('id');
					            $ci->db->where('fid',$fid);
					            $ci->db->where('sid',$sid);
					            $ci->db->where('panel_id',$student_id);
					            $query_result = $ci->db->get();
					            $exit_ids     = $query_result->row();
					            $old_id       = $exit_ids->id;

					        	saveFields($fid, $type, $sid, $field_data, $student_id, $old_id);
					        }


                            $studentsInfo = array(
                                'id'         => $id, 
                                'avatar'     => $avatar, 
                                'name'       => $name, 
                                'class'      => $class, 
                                'department' => $department,
                                'roll'       => $roll, 
                                'phone'      => $phone, 
                                'year'       => $year
                            );

                            $exit_id = getSingledata('students', 'id', 'id', $id);
                            if(!empty($exit_id)){
                                $result = $this->backup_model->upload_students_edit($studentsInfo, $exit_id);
                            }else{
                                $result = $this->backup_model->upload_students_new($studentsInfo);
                            }
                                
                        }

                        fclose($file);
                        $msg ='<p style="color: green;"><span class="fa fa-check" ></span> '.$restored_success.'</p>';
                        
                    }


                }else{
                    $msg = $_FILES['csv']['error'];
                }
            }// End spreadsheet file tmp_name
        }else{
            $msg = '<p style="color: red;"><span class="fa fa-exclamation-triangle"></span> '.$restored_failed.'</p>';
        }

        $reponse['html'] = $msg;
        echo json_encode($reponse);

    }


    /**
    ** Download Teacher's Avatar
    **/
    function download_teachers_avatar()
    {
        $this->load->library('zip');
        $file_name='backup_teachers_avatar.zip';
        $path = 'uploads/users';
        $this->zip->read_dir($path, FALSE);
        $this->zip->download($file_name);
    }


    /**
    ** Download Teacher CSV 
    **/
    function download_teachers_csv()
    {
        $teachers = $this->backup_model->teacher_list();
        
        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'userId');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'email');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'password');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'name');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'avatar');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'mobile');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'roleId');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'isDeleted');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'createdBy');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'createdDtm');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'updatedBy');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'updatedDtm');

        // Start students Loop
        foreach ($teachers as $key => $item) {
            $sr = $key +2;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sr.'', $item->userId);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$sr.'', $item->email);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$sr.'', $item->password);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$sr.'', $item->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$sr.'', $item->avatar);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$sr.'', $item->mobile);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$sr.'', $item->roleId);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$sr.'', $item->isDeleted);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$sr.'', $item->createdBy);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$sr.'', $item->createdDtm);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$sr.'', $item->updatedBy);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$sr.'', $item->updatedDtm);
        } 


        // set file name
        $filename = "backup_teachers";

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.csv"');

        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        exit;
        
    }
    

    /**
    ** Upload Teacher's CSV
    **/
    function upload_teachers_csv()
    {


        $restored_success = getlang('restored_success');   
        $restored_failed = getlang('restored_failed');

        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );

        if(isset($_FILES['tcsv'])){

            if($_FILES['tcsv']['tmp_name']){
                if(!$_FILES['tcsv']['error'])
                {

                    $filename=$_FILES["tcsv"]["tmp_name"];   
                    if($_FILES["tcsv"]["size"] > 0){

                        $file = fopen($filename, "r");

                        // read the first line and ignore it
                        fgets($file); 
                        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){

                            $userId           = $getData['0'];
                            $email            = $getData['1'];
                            $password         = $getData['2'];
                            $name             = $getData['3'];
                            $avatar           = $getData['4'];
                            $mobile           = $getData['5'];
                            $roleId           = $getData['6'];
                            $isDeleted        = $getData['7'];
                            $createdBy        = $getData['8'];
                            $createdDtm       = $getData['9'];
                            $updatedBy        = $getData['10'];
                            $updatedDtm       = $getData['11'];


                            $teacherInfo = array(
                                'userId'     => $userId, 
                                'email'      => $email, 
                                'password'   => $password, 
                                'name'       => $name, 
                                'avatar'     => $avatar, 
                                'mobile'     => $mobile, 
                                'roleId'     => $roleId,
                                'isDeleted'  => $isDeleted, 
                                'createdBy'  => $createdBy, 
                                'createdDtm' => $createdDtm,
                                'updatedBy'  => $updatedBy,
                                'updatedDtm' => $updatedDtm  
                            );

                            $exit_id = getSingledata('users', 'userId', 'userId', $userId);
                            if(!empty($exit_id)){
                                $result = $this->backup_model->upload_teacher_edit($teacherInfo, $exit_id);
                            }else{
                                $result = $this->backup_model->upload_teachers_new($teacherInfo);
                            }
                                
                        }

                        fclose($file);
                        $msg ='<p style="color: green;"><span class="fa fa-check" ></span> '.$restored_success.'</p>';
                        
                    }


                }else{
                    $msg = $_FILES['tcsv']['error'];
                }
            }// End spreadsheet file tmp_name
        }else{
            $msg = '<p style="color: red;"><span class="fa fa-exclamation-triangle"></span> '.$restored_failed.'</p>';
        }

        $reponse['html'] = $msg;
        echo json_encode($reponse);

    }

    /**
    ** Upload Teacher's Avatars
    **/
    function upload_teachers_avatar()
    {
        $restored_success = getlang('restored_success');   
        $restored_failed = getlang('restored_failed');

        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );

        if(isset($_FILES['file'])){
            $zip = new ZipArchive;
            $file = $_FILES['file']['tmp_name'];
            chmod($file,0777);
            if ($zip->open($file) === TRUE) {
                $zip->extractTo('./uploads');
                $zip->close();
                $msg = '<p style="color: green;"><span class="fa fa-check" ></span> '.$restored_success.'</p>';
            } else {
               $msg = '<p style="color: red;"><span class="fa fa-exclamation-triangle"></span> '.$restored_failed.'</p>';
            }
        }else{
            $msg = '<p style="color: red;"><span class="fa fa-exclamation-triangle"></span> '.$restored_failed.'</p>';
        }

        $reponse['html'] = $msg;
        echo json_encode($reponse);

    }

    /**
    ** Download Class CSV 
    **/
    function download_class_csv()
    {
        $class = $this->backup_model->class_list();
        
        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'ID');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Class Name');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Subjects');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Optional subject');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Mark Distribution');

        // Start Class Loop
        foreach ($class as $key => $item) {
            $sr = $key +2;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sr.'', $item->id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$sr.'', $item->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$sr.'', $item->subjects);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$sr.'', $item->optional_subject);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$sr.'', $item->mark_distribution);
        } 

        // set file name
        $filename = "backup_class";
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.csv"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        $objWriter->save('php://output');
        exit;
    }

    /**
    ** Download Subjects CSV 
    **/
    function download_subjects_csv()
    {
        $subjects = $this->backup_model->subjects_list();
        
        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'ID');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Subject Name');

        // Start Subjects Loop
        foreach ($subjects as $key => $item) {
            $sr = $key +2;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sr.'', $item->id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$sr.'', $item->name);
        } 

        // set file name
        $filename = "backup_subjects";
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.csv"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        $objWriter->save('php://output');
        exit;
    }

    /**
    ** Download Exams CSV 
    **/
    function download_exams_csv()
    {
        $exams = $this->backup_model->exam_list();
        
        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'ID');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Exam Name');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Exam Date');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Class ID');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Param');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Status');

        // Start Exams Loop
        foreach ($exams as $key => $item) {
            $sr = $key +2;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sr.'', $item->id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$sr.'', $item->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$sr.'', $item->exam_date);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$sr.'', $item->class);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$sr.'', $item->param);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$sr.'', $item->status);
        } 

        // set file name
        $filename = "backup_exams";
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.csv"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        $objWriter->save('php://output');
        exit;
    }

    /**
    ** Download Field CSV 
    **/
    function download_field_csv()
    {
        $field = $this->backup_model->field_list();
        
        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'ID');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Field Name');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Published');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Type');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Required');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Section');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Option Param');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'field order');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'profile');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'list');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'biodata');

        // Start Exams Loop
        foreach ($field as $key => $item) {
            $sr = $key +2;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sr.'', $item->id);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$sr.'', $item->field_name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$sr.'', $item->published);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$sr.'', $item->type);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$sr.'', $item->required);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$sr.'', $item->section);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$sr.'', $item->option_param);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$sr.'', $item->field_order);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$sr.'', $item->profile);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$sr.'', $item->list);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$sr.'', $item->biodata);
        } 

        // set file name
        $filename = "backup_field";
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.csv"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        $objWriter->save('php://output');
        exit;
    }


    /**
    ** Upload Class CSV
    **/
    function upload_class_csv()
    {
        $restored_success = getlang('restored_success');   
        $restored_failed = getlang('restored_failed');

        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );


        if(isset($_FILES['csv'])){

            if($_FILES['csv']['tmp_name']){
                if(!$_FILES['csv']['error'])
                {

                    $filename=$_FILES["csv"]["tmp_name"];   
                    if($_FILES["csv"]["size"] > 0){

                        $file = fopen($filename, "r");

                        // read the first line and ignore it
                        fgets($file); 
                        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){

                            $id                  = $getData['0'];
                            $name                = $getData['1'];
                            $subjects            = $getData['2'];
                            $optional_subject    = $getData['3'];
                            $mark_distribution   = $getData['4'];

                            $Info = array(
                                'id'                 => $id, 
                                'name'               => $name, 
                                'subjects'           => $subjects,
                                'optional_subject'   => $optional_subject,
                                'mark_distribution'  => $mark_distribution 
                            );

                            $exit_id = getSingledata('class', 'id', 'id', $id);
                            if(!empty($exit_id)){
                                $result = $this->backup_model->upload_class_edit($Info, $exit_id);
                            }else{
                                $result = $this->backup_model->upload_class_new($Info);
                            }
                                
                        }

                        fclose($file);
                        $msg ='<p style="color: green;"><span class="fa fa-check" ></span> '.$restored_success.'</p>';
                        
                    }


                }else{
                    $msg = $_FILES['csv']['error'];
                }
            }// End spreadsheet file tmp_name
        }else{
            $msg = '<p style="color: red;"><span class="fa fa-exclamation-triangle"></span> '.$restored_failed.'</p>';
        }

        $reponse['html'] = $msg;
        echo json_encode($reponse);

    }

    /**
    ** Upload Subjects CSV
    **/
    function upload_subjects_csv()
    {

        $restored_success = getlang('restored_success');   
        $restored_failed = getlang('restored_failed');

        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );

        if(isset($_FILES['csv'])){

            if($_FILES['csv']['tmp_name']){
                if(!$_FILES['csv']['error'])
                {

                    $filename=$_FILES["csv"]["tmp_name"];   
                    if($_FILES["csv"]["size"] > 0){

                        $file = fopen($filename, "r");

                        // read the first line and ignore it
                        fgets($file); 
                        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){

                            $id           = $getData['0'];
                            $name            = $getData['1'];

                            $Info = array(
                                'id'     => $id, 
                                'name'      => $name
                            );

                            $exit_id = getSingledata('subjects', 'id', 'id', $id);
                            if(!empty($exit_id)){
                                $result = $this->backup_model->upload_subjects_edit($Info, $exit_id);
                            }else{
                                $result = $this->backup_model->upload_subjects_new($Info);
                            }
                                
                        }

                        fclose($file);
                        $msg ='<p style="color: green;"><span class="fa fa-check" ></span> '.$restored_success.'</p>';
                        
                    }


                }else{
                    $msg = $_FILES['csv']['error'];
                }
            }// End spreadsheet file tmp_name
        }else{
            $msg = '<p style="color: red;"><span class="fa fa-exclamation-triangle"></span> '.$restored_failed.'</p>';
        }

        $reponse['html'] = $msg;
        echo json_encode($reponse);

    }


    /**
    ** Upload field CSV
    **/
    function upload_field_csv()
    {

        $restored_success = getlang('restored_success');   
        $restored_failed = getlang('restored_failed');

        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );

        if(isset($_FILES['csv'])){

            if($_FILES['csv']['tmp_name']){
                if(!$_FILES['csv']['error'])
                {

                    $filename=$_FILES["csv"]["tmp_name"];   
                    if($_FILES["csv"]["size"] > 0){

                        $file = fopen($filename, "r");

                        // read the first line and ignore it
                        fgets($file); 
                        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){

                            $id             = $getData['0'];
                            $field_name     = $getData['1'];
                            $published      = $getData['2'];
                            $type           = $getData['3'];
                            $required       = $getData['4'];
                            $section        = $getData['5'];
                            $option_param   = $getData['6'];
                            $field_order    = $getData['7'];
                            $profile        = $getData['8'];
                            $list           = $getData['9'];
                            $biodata        = $getData['10'];

                            $Info = array(
                                'id'              => $id, 
                                'field_name'      => $field_name,
                                'published'       => $published,
                                'type'            => $type,
                                'required'        => $required,
                                'section'         => $section,
                                'option_param'    => $option_param,
                                'field_order'     => $field_order,
                                'profile'         => $profile,
                                'list'            => $list,
                                'biodata'         => $biodata
                            );

                            $exit_id = getSingledata('fields', 'id', 'id', $id);
                            if(!empty($exit_id)){
                                $result = $this->backup_model->upload_field_edit($Info, $exit_id);
                            }else{
                                $result = $this->backup_model->upload_field_new($Info);
                            }
                                
                        }

                        fclose($file);
                        $msg ='<p style="color: green;"><span class="fa fa-check" ></span> '.$restored_success.'</p>';
                        
                    }


                }else{
                    $msg = $_FILES['csv']['error'];
                }
            }// End spreadsheet file tmp_name
        }else{
            $msg = '<p style="color: red;"><span class="fa fa-exclamation-triangle"></span> '.$restored_failed.'</p>';
        }

        $reponse['html'] = $msg;
        echo json_encode($reponse);

    }


    /**
    ** Upload exam CSV
    **/
    function upload_exam_csv()
    {

        $restored_success = getlang('restored_success');   
        $restored_failed = getlang('restored_failed');

        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );

        if(isset($_FILES['csv'])){

            if($_FILES['csv']['tmp_name']){
                if(!$_FILES['csv']['error'])
                {

                    $filename=$_FILES["csv"]["tmp_name"];   
                    if($_FILES["csv"]["size"] > 0){

                        $file = fopen($filename, "r");

                        // read the first line and ignore it
                        fgets($file); 
                        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){

                            $id           = $getData['0'];
                            $name         = $getData['1'];
                            $exam_date    = $getData['2'];
                            $status       = $getData['3'];

                            $Info = array(
                                'id'        => $id, 
                                'name'      => $name,
                                'exam_date' => $exam_date,
                                'status'    => $status
                            );

                            $exit_id = getSingledata('exam', 'id', 'id', $id);
                            if(!empty($exit_id)){
                                $result = $this->backup_model->upload_exam_edit($Info, $exit_id);
                            }else{
                                $result = $this->backup_model->upload_exam_new($Info);
                            }
                                
                        }

                        fclose($file);
                        $msg ='<p style="color: green;"><span class="fa fa-check" ></span> '.$restored_success.'</p>';
                        
                    }


                }else{
                    $msg = $_FILES['csv']['error'];
                }
            }// End spreadsheet file tmp_name
        }else{
            $msg = '<p style="color: red;"><span class="fa fa-exclamation-triangle"></span> '.$restored_failed.'</p>';
        }

        $reponse['html'] = $msg;
        echo json_encode($reponse);

    }


    
}

?>