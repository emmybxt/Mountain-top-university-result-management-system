<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Mark extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mark_model');
        $this->isLoggedIn();   
    }
    
    
    /**
    ** This function is used to load the mark form
    **/
    function add()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{   
            $mark_title = getlang('mark_title');
            $this->global['pageTitle'] = $mark_title;
            $this->loadViews("/mark/add",  $this->global,'' , NULL);
        }

    }


    /**
    ** Import Excel File
    **/
    function importcsv(){
        $exam_id       = $this->input->post('exam_id');
        $class_id      = $this->input->post('class_id');
        $department_id = $this->input->post('department_id');
        $subject_id    = $this->input->post('subject_id');

        //jimport('phpexcel.library.PHPExcel');
        //Check valid spreadsheet has been uploaded
        if(isset($_FILES['spreadsheet'])){

            if($_FILES['spreadsheet']['tmp_name']){
                if(!$_FILES['spreadsheet']['error'])
                {
                    $filename=$_FILES["spreadsheet"]["tmp_name"];   
                    if($_FILES["spreadsheet"]["size"] > 0){

                        $file = fopen($filename, "r");

                        // read the first line and ignore it
                        fgets($file); 
                        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){

                            $roll          = $getData['0'];
                            $student_name  = $getData['1'];
                            
                            //get student id
                            $student_id = getSingledata('students', 'id', 'roll', $roll);
                            //get student year
                            $student_year = getSingledata('students', 'year', 'roll', $roll);
                                
                            if(!empty($student_id) && !empty($student_year)){
                                        
						        // Get mark data
						        $exam_mark_data = array(
						            'student_id'     => $student_id, 
						            'exam_id'        => $exam_id, 
						            'class_id'       => $class_id, 
						            'subject_id'     => $subject_id, 
						            'year'           => $student_year,
						            'department_id'  => $department_id, 
						            'add_by'         => $this->vendorId
						        );

						        // Get check exit data
                                $exam_mark_id = getMark('id', $exam_id, $class_id, $subject_id, $student_id, $department_id, $student_year);

						        // Get save exam data
						        if(!empty($exam_mark_id)){
						            $id = $this->mark_model->edit($exam_mark_data, $exam_mark_id);
						            $mark_id = $exam_mark_id;
						        }else{
						            $id = $this->mark_model->addNew($exam_mark_data);
						            $mark_id = $id;
						        }

						        // Get mark distribution by class id
						        $mark_distribution_string = getSingledata('class', 'mark_distribution', 'id', $class_id);
						        $mark_distribution_object = explode(",", $mark_distribution_string);
						        
                                $total_mark = array();
								foreach ($mark_distribution_object as $key => $md) {
									$csv_key = $key+2;
					                $mark = $getData[$csv_key];
                                    if(!empty($mark)){
                                       $total_mark[] = $mark;
                                    }else{
                                       $total_mark[] = 0;
                                    }
						            
							        $mark_distribution_data = array(
							            'mark'                 => $mark, 
							            'mark_distribution_id' => $md, 
							            'class_id'             => $class_id, 
							            'department_id'        => $department_id, 
							            'student_id'           => $student_id,
							            'exam_id'              => $exam_id, 
							            'mark_id'              => $mark_id, 
							            'year'                 => $student_year,
							            'subject_id'           => $subject_id
							        );
						            $exit_id = getExitData('id', $class_id, $subject_id, $department_id, $student_id, $exam_id, $mark_id, $md, $student_year);

						            if(!empty($exit_id)){
						            	$md_id = $this->mark_model->updateMDvalue($mark_distribution_data, $exit_id);
						            }else{
						                $md_id = $this->mark_model->addNewMDvalue($mark_distribution_data);
						            }
								}

                                $total_mark = array_sum($total_mark);

                                // Get calculation grade & comment
                                $exam_param      = getSingledata('exam', 'param', 'id', $exam_id);
                                $exam_param_data = json_decode($exam_param,true);
                                if(isset($exam_param_data['class_id'][$class_id]['subject_id'][$subject_id]['grade_system'][0])){
                                    $grade_category_id = $exam_param_data['class_id'][$class_id]['subject_id'][$subject_id]['grade_system'][0];
                                }else{
                                    $grade_category_id = '';
                                }
                                $grade = getGradeValue($grade_category_id, $total_mark);
                                $gp = $grade['gp'];
                                $total_mark_data = array(
                                    'total_mark'      => $total_mark,
                                    'gp'              => $gp
                                );
                                $this->mark_model->edit($total_mark_data, $mark_id);

                                // Get update rank by student, exam, class, department, year
                                getUpdateRank($exam_id, $class_id, $department_id, $student_year, $student_id);
                                                                                               
                            }

                        }

                        fclose($file);
                        $msg ="Excel File successfully upload & mark stored  ! ";
                    }
                }else{
                    $msg = $_FILES['spreadsheet']['error'];
                }
            }// End spreadsheet file tmp_name
        }else{
            $msg = 'Please select CSV file !';
        }

        redirect('mark?exam='.$exam_id.'&class='.$class_id.'&department='.$department_id.'&subjects='. $subject_id);
    }


    /**
    ** Get Student List by exam_id, class_id & Subject_id
    **/
    function student_list()
    {
        // Use for get language
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );

        $html    = '';
        
        $roll    = getlang('roll');
        $name    = getlang('students');
        $mark    = getlang('mark');
        $comment = getlang('comment');
        $saving  = getlang('saving');
        $save    = getlang('save');

        // Reacive data from add form
        $exam_id    = $this->input->post('exam_id');
        $class_id   = $this->input->post('class_id');
        $department = $this->input->post('department_id');
        $subject_id = $this->input->post('subject_id');
        $uid        = $this->input->post('uid');

        // Get mark distribution by class id
        $mark_distribution_string = getSingledata('class', 'mark_distribution', 'id', $class_id);
        $mark_distribution_object = explode(",", $mark_distribution_string);

        if(!empty($exam_id) && !empty($class_id) && !empty($subject_id)){
            $students = $this->mark_model->getStudents($class_id, $department);
            //upload xcxl file
            $mark_student = '<table class="admin-table" id="admin-table" style="width: 100%;margin-top: 50px;background: #f5f5f5;" align="center">';
            $mark_student .= '<tr>';
            $mark_student .= '<td>';

            $mark_student .= '<form action="'.base_url().'mark/importcsv" method="post" name="user-form" enctype="multipart/form-data" style="padding:10px;">';
            $mark_student .= '<input type="file" style="display: inline-block;" name="spreadsheet"/>';
            $mark_student .= '<input type="submit" value="Upload" id="upload" class="btn btn-default" style="display: inline-block;" />';
            $mark_student .= '<input type="hidden" name="task" value="importcsv"  />';
            $mark_student .= '<input type="hidden" name="controller" value="marks" />';
            $mark_student .= '<input type="hidden" name="exam_id" value="'.$exam_id.'" />';
            $mark_student .= '<input type="hidden" name="class_id" value="'.$class_id.'" />';
            $mark_student .= '<input type="hidden" name="subject_id" value="'.$subject_id.'" />';
            $mark_student .= '<input type="hidden" name="department_id" value="'.$department.'" />';
            $mark_student .= '<input type="hidden" name="'.$reponse['csrfName'].'" value="'.$reponse['csrfHash'].'" />';
            $mark_student .= '</form>';
            $mark_student .= ' <p class="help-block" style="margin-top: 10px;padding:10px;">Only Excel File <b style="color: red;">{CSV} </b> format Import. Excel file Must have headers as follows:<b style="color: red;"> Roll, Student Name, ';
            $total_mark_distribution = count($mark_distribution_object);
            foreach ($mark_distribution_object as $key => $md) {
                $md_title = getSingledata('mark_distribution', 'title', 'id', $md);
                if (($key + 1) == $total_mark_distribution) {
                    $mark_student .= $md_title;
                }else{
                    $mark_student .= $md_title.', ';
                }
            }
            $mark_student .= '</b> </p></td>';
            $mark_student .= '</tr>';
            $mark_student .= '</table>';

            $mark_student .= '<table class="table-bordered result-table" id="admin-table" style="margin-top: 50px;" align="center">';
            $mark_student .= '<tr>';
            $mark_student .= '<th style="width: 3%;">'.$roll.'</th>';
            $mark_student .= '<th>'.$name.'</th>';
            foreach ($mark_distribution_object as $key => $md) {
                $md_title = getSingledata('mark_distribution', 'title', 'id', $md);
                $mark_student .= '<th style="width: 15%;">'.$md_title.'</th>';
            }
            $mark_student .= '<th style="text-align: left;">'.getlang('action').'</th>';
            $mark_student .= '</tr>';

            $mark_student .= '<input type="hidden" id="exam_id"  value="'.$exam_id.'" />';
            $mark_student .= '<input type="hidden" id="class_id"  value="'.$class_id.'" />';
            $mark_student .= '<input type="hidden" id="department_id"  value="'.$department.'" />';
            $mark_student .= '<input type="hidden" id="subject_id"  value="'.$subject_id.'" />';
            $mark_student .= '<input type="hidden" id="uid"  value="'.$uid.'" />';

            // Script for save mark
            $mark_student .= '<script type="text/javascript">';
                
                $mark_student .= 'var exam_id        = jQuery("#exam_id").val();';
                $mark_student .= 'var class_id       = jQuery("#class_id").val();';
                $mark_student .= 'var department_id  = jQuery("#department_id").val();';
                $mark_student .= 'var subject_id     = jQuery("#subject_id").val();';
                $mark_student .= 'var addby          = jQuery("#uid").val();';
                     
                // function make
                $mark_student .= 'function markSaving(
                                exam_id,
                                class_id,
                                department_id,
                                subject_id,
                                sid,
                                addby,
                                year,';
                                foreach ($mark_distribution_object as $key => $md) {
                                    $mark_student .= 'mark_'.$key.',';
                                }
                $mark_student .= 'order){';
                $url = base_url()."mark/savemark";
                $mark_student .= 'jQuery("#saving_"+ order).html("'.$saving.'");';
                 
                $mark_student .= 'jQuery.post( "'.$url.'",{';
                        foreach ($mark_distribution_object as $key => $md) {
                            $mark_student .= 'mark_'.$key.':mark_'.$key.',';
                        }
                        $mark_student .= 'exam_id:exam_id,
                                class_id:class_id,
                                department_id:department_id,
                                subject_id:subject_id,
                                sid:sid,
                                addby:addby,
                                year:year
                             }, function(data){';
                $mark_student .= 'if(data){ jQuery("#saving_"+ order).html(data); }';
                $mark_student .= '});';
                $mark_student .= '}';
            
                //function call
                foreach ($students as $s => $items) {
                    $mark_student .= 'jQuery( "#button_'.$s.'" ).click(function() {';
                    $mark_student .= 'markSaving(
                                      exam_id,
                                      class_id,
                                      department_id,
                                      subject_id,
                                      jQuery("#sid_'.$s.'").val(),
                                      addby,
                                      jQuery("#year_'.$s.'").val(),';
                                      foreach ($mark_distribution_object as $key => $md) {
								     	$mark_student .= 'jQuery("#mark_'.$s.'_'.$key.'").val(),';
								    }
                    $mark_student .= $s.')';
                    $mark_student .= '});';
                }
                     

            $mark_student .= '</script>';

            foreach ($students as $key => $student) {

                //Hidden Value
                $mark_student .= '<input type="hidden" id="sid_'.$key.'"  value="'.$student->id.'" />';
                $mark_student .= '<input type="hidden" id="year_'.$key.'"  value="'.$student->year.'" />';

                $mark_student .= '<tr>';
                $mark_student .= '<td style="width: 3%;text-align: center;">'.$student->roll.'</td>';
                $mark_student .= '<td style="width: 15%;text-align: left;">'.$student->name.'</td>';

                // Mark Field
                foreach ($mark_distribution_object as $md_key => $md) {
                    $mark_id    = getExitMark($student->id, $subject_id, $class_id, $exam_id, $student->year, $department);
                    $mark_value = getExitData('mark', $class_id,  $subject_id, $department, $student->id, $exam_id, $mark_id, $md, $student->year);
                    if(empty($mark_value)){
                    	$mark_value = '';
                    }

                    $mark_student .= '<td style="width: 15%;text-align: center;" >';
                    $mark_student .= '<input type="text" class="mark-input" id="mark_'.$key.'_'.$md_key.'" name="marks" value="'.$mark_value.'"  />';
                    $mark_student .= '<input type="hidden" id="md_id_'.$key.'_'.$md_key.'" value="'.$md.'" />';
                    $mark_student .= '</td>';
                }
               
                $mark_student .= '<td style="text-align: left;">';
                $mark_student .= '<div id="saving_'.$key.'"></div>';
                $mark_student .= '<input type="button" class="btn btn-primary"  name="save" id="button_'.$key.'" value="'.$save.'" />';
                $mark_student .= '</td>';
                $mark_student .= '</tr>';
            }
            $mark_student .= '</table>';

            $html = $mark_student;
        }else{
            $select_exam        = getlang('select_exam');
            $select_subject     = getlang('select_subject');
            $select_class       = getlang('select_class');
            $class_exam_subject = getlang('class_exam_subject');
            if(empty($exam_id)) { $html .= '<p style="color:red;">'.$select_exam.'</p>';
            }elseif (empty($class_id)) { $html .= '<p style="color:red;">'.$select_class.'</p>';
            }elseif (empty($subject_id)) { $html .= '<p style="color:red;">'.$select_subject.'</p>';
            }else{ $html .= '<p style="color:red;">'.$class_exam_subject.'</p>';}
        }

        $reponse['html'] = $html;
        echo json_encode($reponse);
    }


    /**
    ** Get Subject List
    **/
    function getsubject(){
        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );

        $class_id = $this->input->post('class_id');
        
        // Get main subject
        $main_subject = getSingledata('class', 'subjects', 'id', $class_id);
        if(!empty($main_subject)){
            $main_subject_array = explode(",", $main_subject);
        }else{
            $main_subject_array = array();
        }
        
        // Get optional subject
        $optional_subject = getSingledata('class', 'optional_subject', 'id', $class_id);
        if(!empty($optional_subject)){
            $optional_subject_array = explode(",", $optional_subject);
        }else{
            $optional_subject_array = array();
        }
        
        $subject_array = array_merge($main_subject_array, $optional_subject_array);

        $html = '';
        if(!empty($class_id)){
            // Set subject list
            $output = '<script type="text/javascript">jQuery( "#subject" ).change(function() { desplyStudentList(); });</script>';
            $output .='<select name="subject" id="subject" class="form-control " >';
            $output .='<option value="0" > Select Subject </option>';
            foreach ($subject_array as $key => $item) {
                $subject_name = getSingledata('subjects', 'name', 'id', $item);
                $output .='<option value="'.$item.'">'.$subject_name.'</option>';
            }
            $output .='</select>';
            $html .= $output;
        }else{
            if(empty($class_id)){
                $html .='<p style="text-align: center;color: red;">Please select class.</p>';
            }
        }

        $reponse['html'] = $html;
        echo json_encode($reponse);
    }


    /**
    ** Get Save mark 
    **/
    function savemark()
    {
        $save_success = getlang('save_success');
        $save_error   = getlang('save_error');

        $exam_id       = $this->input->post('exam_id');
        $class_id      = $this->input->post('class_id');
        $department_id = $this->input->post('department_id');
        $subject_id    = $this->input->post('subject_id');
        $student_id    = $this->input->post('sid');
        $year          = $this->input->post('year');
        $uid           = $this->input->post('addby');


        // Get mark data
        $exam_mark_data = array(
            'student_id'     => $student_id, 
            'exam_id'        => $exam_id, 
            'class_id'       => $class_id, 
            'subject_id'     => $subject_id, 
            'year'           => $year,
            'department_id'  => $department_id, 
            'add_by'         => $uid
        );

        // Get check exit data
        $exam_mark_id = getMark('id', $exam_id, $class_id, $subject_id, $student_id, $department_id, $year);

        // Get save exam data
        if(!empty($exam_mark_id)){
            $id = $this->mark_model->edit($exam_mark_data, $exam_mark_id);
            $mark_id = $exam_mark_id;
        }else{
            $id = $this->mark_model->addNew($exam_mark_data);
            $mark_id = $id;
        }

        // Get mark distribution by class id
        $mark_distribution_string = getSingledata('class', 'mark_distribution', 'id', $class_id);
        $mark_distribution_object = explode(",", $mark_distribution_string);
        
        $total_mark = array();
		foreach ($mark_distribution_object as $key => $md) {
            $mark = $this->input->post('mark_'.$key);
            if(!empty($mark)){
               $total_mark[] = $mark;
            }else{
               $total_mark[] = 0;
            }
            
            
	        $mark_distribution_data = array(
	            'mark'                 => $mark, 
	            'mark_distribution_id' => $md, 
	            'class_id'             => $class_id, 
	            'department_id'        => $department_id, 
	            'student_id'           => $student_id,
	            'exam_id'              => $exam_id, 
	            'mark_id'              => $mark_id, 
	            'year'                 => $year,
	            'subject_id'           => $subject_id
	        );
            $exit_id = getExitData('id', $class_id, $subject_id, $department_id, $student_id, $exam_id, $mark_id, $md, $year);

            if(!empty($exit_id)){
            	$md_id = $this->mark_model->updateMDvalue($mark_distribution_data, $exit_id);
            }else{
                $md_id = $this->mark_model->addNewMDvalue($mark_distribution_data);
            }
		}

        $total_mark = array_sum($total_mark);
        // Get calculation grade & comment
        $exam_param      = getSingledata('exam', 'param', 'id', $exam_id);
        $exam_param_data = json_decode($exam_param,true);
        if(isset($exam_param_data['class_id'][$class_id]['subject_id'][$subject_id]['grade_system'][0])){
            $grade_category_id = $exam_param_data['class_id'][$class_id]['subject_id'][$subject_id]['grade_system'][0];
        }else{
            $grade_category_id = '';
        }
        $grade = getGradeValue($grade_category_id, $total_mark);
        $gp = $grade['gp'];
		$total_mark_data = array(
            'total_mark'      => $total_mark,
            'gp'              => $gp
        );
        $this->mark_model->edit($total_mark_data, $mark_id);

        // Get update rank by student, exam, class, department, year
        getUpdateRank($exam_id, $class_id, $department_id, $year, $student_id);

        if ($id) {
            echo '<b style="color:green;">'.$save_success.'</b>';
        }else{
            echo '<b style="color:red;">'.$save_error.'</b>';
        }
    }

    
    
}

?>
