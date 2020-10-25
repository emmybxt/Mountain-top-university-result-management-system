
<?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $id = '';
    $title = '';
    $title_native = '';
    $lang_code = '';
    $image = '';
    $published = '';
    $direction = '';
    $data = '';
    $menus = '';
    $param = '';
    $menu_param = '';
    if(!empty($language_data))
    {
        foreach ($language_data as $item)
        {
            $id = $item->id;
            $title = $item->title;
            $title_native = $item->title_native;
            $lang_code = $item->lang_code;
            $image = $item->image;
            $published = $item->published;
            $direction = $item->direction;
            $data = $item->data;
            $param = json_decode($data,true);

            $menus = $item->menus;
            $menu_param = json_decode($menus,true);
        }
    }

    $direction_list = getDirection('direction', $direction);
    $status_list =  getStatus('published', $published);
    $flag_list = getFlags('image', $image);


    if(empty($image)){
        $flug_path = site_url('/uploads/lang/').'/flag.gif';
    }else{
        $flug_path = site_url('/uploads/lang/').'/'.$image.'.gif';
    }

?>


<div class="content-wrapper">
    <?php echo sectionHeader('Language Form', 'Add / Edit language', 'fa-language'); ?>
    
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addlanguage" class="" action="<?php echo base_url() ?>languages/add" method="post" role="form">
                        <div class="box-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#general">General</a></li>
                                <li><a data-toggle="tab" href="#data">Language Data</a></li>
                                <li><a data-toggle="tab" href="#menu">Menu Items</a></li>
                                <li><a data-toggle="tab" href="#quick_menu">Quick Menu Items</a></li>
                                <li><a data-toggle="tab" href="#system_masg">System message</a></li>
                                <li><a data-toggle="tab" href="#button">Button</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="general" class="tab-pane fade in active">
                                    <p></p>

                                    <fieldset class="form-horizontal">
                                    <div class="row">
                                        <div class="col-md-6"><?php echo fieldBuilder('input', 'title', $title, 'Title', 'required'); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"><?php echo fieldBuilder('input', 'title_native', $title_native, 'Native Title', 'required'); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"><?php echo fieldBuilder('input', 'lang_code', $lang_code, 'Lang Code', 'required'); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="s_image" class="col-sm-4 control-label">Flag image</label>
                                                <div class="col-sm-7"><?php echo $flag_list; ?></div>
                                                <div class="col-sm-1"><img src="<?php echo $flug_path; ?>" id="flag_icon" alt="<?php echo $image; ?>" ></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"><?php echo fieldBuilder('select', 'direction', $direction_list, 'Direction', 'required'); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6"><?php echo fieldBuilder('select', 'published', $status_list, 'Published', 'required'); ?></div>
                                    </div>
                                    </fieldset>
                                </div>

                                <div id="data" class="tab-pane fade ">
                                    <p></p>
                                    <fieldset class="form-vertical language-fielset"> 
                                    <div class="row">
                                        <?php 
                                        echo langField($param, 'action', 'Action');
                                        echo langField($param, 'academic', 'Academic info');
                                        echo langField($param, 'address', 'Address');
                                        echo langField($param, 'avatar', 'Avatar');

                                        echo langField($param, 'blood_group', 'Blood group');
                                        echo langField($param, 'comment', 'Comment');
                                        
                                        echo langField($param, 'cirtificate', 'Certificate menu');
                                        echo langField($param, 'certificate_signature', 'Certificate signature');
                                        echo langField($param, 'certificate_background', 'Certificate background');

                                        echo langField($param, 'class_form', 'Class Form');
                                        echo langField($param, 'class', 'Class');
                                        echo langField($param, 'class_list', 'Class list');
                                        echo langField($param, 'class_name', 'Class Title');

                                        
                                        echo langField($param, 'department_manage', 'Department management');
                                        echo langField($param, 'department', 'Department');
                                        echo langField($param, 'department_list', 'Department list');
                                        echo langField($param, 'department_name', 'Department name');
                                        echo langField($param, 'select_department', 'Select Department');


                                        echo langField($param, 'change_password', 'Change password');
                                        echo langField($param, 'confirm_password', 'Confirm password');
                                        echo langField($param, 'change_avatar', 'Change avatar');
                                        echo langField($param, 'control_panel', 'Control panel');

                                        echo langField($param, 'dashboard', 'Dashboard');
                                        echo langField($param, 'default_lang', 'Default language');
                                        echo langField($param, 'default_theme', 'Default theme');

                                        echo langField($param, 'exam', 'Exam');
                                        echo langField($param, 'examination', 'Examination');
                                        echo langField($param, 'email_password', 'Email password');
                                        echo langField($param, 'enter_ditails', 'Enter Class Details');
                                        echo langField($param, 'enter_sub_details', 'Enter subject details');
                                        echo langField($param, 'exam_manage', 'Exam management');
                                        echo langField($param, 'exam_name', 'Exam name');
                                        echo langField($param, 'exam_list', 'Exam list');
                                        echo langField($param, 'exam_date', 'Exam date');
                                        echo langField($param, 'enter_exam_details', 'Enter exam details');
                                        echo langField($param, 'email', 'Email');
                                        echo langField($param, 'enter_details', 'Enter details');
                                        echo langField($param, 'enter_teacher_details', 'Enter teachers details');
                                        echo langField($param, 'grade_details', 'Enter grade details');

                                        echo langField($param, 'full_name', 'Full name');
                                        echo langField($param, 'father_name', 'Father name');
                                        echo langField($param, 'from_email', 'From email');
                                        echo langField($param, 'from_bcc', 'From bcc');
                                        echo langField($param, 'from_name', 'From name');
                                        echo langField($param, 'forget_password', 'Forget password');
                                        echo langField($param, 'front_end_result', 'Front end result');


                                        echo langField($param, 'field_manage', 'Field management');
                                        echo langField($param, 'field', 'Field');
                                        echo langField($param, 'field_list', 'Field list');
                                        echo langField($param, 'field_name', 'Field name');

                                        echo langField($param, 'grade_cat_list', 'Grade Category List');
                                        echo langField($param, 'grade_cat', 'Grade Category');
                                        echo langField($param, 'grade_cat_title', 'Grade Category Title');
                                        echo langField($param, 'grade_cat_mark', 'Mark');

                                        echo langField($param, 'grade_management', 'Grade management');
                                        echo langField($param, 'grade_list', 'Grade list');
                                        echo langField($param, 'grade_name', 'Grade name');
                                        echo langField($param, 'grade_point', 'Grade point');
                                        echo langField($param, 'grade_form', 'Grade form');
                                        echo langField($param, 'grade', 'Grade');
                                        echo langField($param, 'gpa', 'G.P.A');
                                        echo langField($param, 'gp', 'G.P');
                                        echo langField($param, 'general', 'General');
                                        echo langField($param, 'sl', 'SL');

                                        echo langField($param, 'highest_mark', 'Highest mark');

                                        echo langField($param, 'institute_name', 'Institute name');

                                        echo langField($param, 'loading', 'Loading...');
                                        echo langField($param, 'last_login', 'Last login');
                                        echo langField($param, 'logo', 'Logo');
                            
                                        
                                        echo langField($param, 'mail_configuration', 'Mail configuration');
                                        echo langField($param, 'mark', 'Mark');
                                        echo langField($param, 'mail_path', 'Mail path');
                                        echo langField($param, 'mother_name', 'Mother name');
                                        echo langField($param, 'mark_from', 'Mark from');
                                        echo langField($param, 'mark_upto', 'Mark upto');
                                        echo langField($param, 'mark_manage', 'Mark management');

                                        echo langField($param, 'new_password', 'New password');

                                        echo langField($param, 'old_password', 'Old password');
                                        echo langField($param, 'obtain_mark', 'Obtain mark');
                                        
                                        echo langField($param, 'photo', 'Photo');
                                        echo langField($param, 'protocol', 'Protocol');
                                        echo langField($param, 'phone', 'Phone');
                                        echo langField($param, 'password', 'Password');

                                        echo langField($param, 'result', 'Result menu for configuration');
                                        echo langField($param, 'role', 'Role');
                                        echo langField($param, 'result_from', 'Result form');
                                        echo langField($param, 'remembar_me', 'Remember me');
                                        echo langField($param, 'reset_pass', 'Reset password');

                                        echo langField($param, 'subjects', 'Subjects');
                                        echo langField($param, 'optional_subjects', 'Optional Subjects');
                                        echo langField($param, 'students', 'Student name');
                                        echo langField($param, 'smtp_host', 'SMTP host');
                                        echo langField($param, 'smtp_port', 'SMTP port');
                                        echo langField($param, 'smtp_username', 'SMTP username');
                                        echo langField($param, 'smtp_password', 'SMTP password');
                                        echo langField($param, 'status', 'Status');
                                        echo langField($param, 'select_exam', 'Select exam');
                                        echo langField($param, 'select_class', 'Select class');
                                        echo langField($param, 'select_subject', 'Select subject');
                                        echo langField($param, 'save_success', 'Saved successfully');
                                        echo langField($param, 'save_error', 'Save error');
                                        echo langField($param, 'saving', 'Saving...');
                                        echo langField($param, 'signature_of', 'Signature of');
                                        echo langField($param, 'signature_designation', 'Signature designation');
                                        echo langField($param, 'select_year', 'Select year');
                                        echo langField($param, 'subject_manage', 'Subjects management');
                                        echo langField($param, 'subject_list', 'Subjects list');
                                        echo langField($param, 'subject_from', 'Subjects from');
                                        echo langField($param, 'subject_name', 'Subject name');
                                        echo langField($param, 'set_new_password', 'Set your new password');
                                        echo langField($param, 'student_manage', 'Student management');
                                        echo langField($param, 'search', 'Search');
                                        echo langField($param, 'student_list', 'Student list');
                                        echo langField($param, 'student_form', 'Student Form');
                                        echo langField($param, 'show_logo', 'Show logo');
                                        echo langField($param, 'show_institute_name', 'Show institute name');
                                        echo langField($param, 'show_email', 'Show email');
                                        echo langField($param, 'show_website', 'Show website');
                                        echo langField($param, 'show_phone', 'Show phone');
                                        echo langField($param, 'show_address', 'Show address');
                                        echo langField($param, 'show_highest_mark', 'Show highest mark');
                                        echo langField($param, 'show_comment', 'Show comment');
                                        echo langField($param, 'set_new_avatar', 'Set new avatar for your account');
                                        echo langField($param, 'student_profile', 'Student profile');
                                        echo langField($param, 'roll', 'Student roll');

                                        echo langField($param, 'text_template', 'Text template');
                                        echo langField($param, 'teachers_manage', 'Teachers management');
                                        echo langField($param, 'teachers_list', 'Teachers list');
                                        echo langField($param, 'teachers_name', 'Teachers name');
                                        echo langField($param, 'total_students', 'Total students');
                                        echo langField($param, 'total_subjects', 'Total subjects');
                                        echo langField($param, 'total_class', 'Total class');
                                        echo langField($param, 'total_exam', 'Total exam');
                                        echo langField($param, 'total_marks', 'Total mark');
                                        echo langField($param, 'total', 'Total');
                                        echo langField($param, 'total_marks_gpa', 'Total Mark & GPA');
                                        echo langField($param, 'letter_grade', 'Letter Grade');
                                        echo langField($param, 'position_merit_list', 'Position in Merit List');

                                        echo langField($param, 'mark_interval', 'Marks Interval');
                                        echo langField($param, 'grade_point_chart', 'Grade point chart');
                                        echo langField($param, 'student_information', 'Student Information');

                                        echo langField($param, 'type', 'Type');
                                        echo langField($param, 'section', 'Section');
                                        echo langField($param, 'field_order', 'Field Order');
                                        echo langField($param, 'publishe', 'Status');
                                        
                                        echo langField($param, 'website', 'Website');
                                        
                                        echo langField($param, 'year', 'Year');
                                        echo langField($param, 'start_year', 'Year start');
                                        echo langField($param, 'end_year', 'Year end');
                                        echo langField($param, 'year_limit', 'Year limit');

                                        echo getlabel('Tabulation Sheet');
                                        echo langField($param, 'table_tabulation_sheet', 'Tabulation Sheet');
                                        echo langField($param, 'table_student_roll', 'Student Roll');
                                        echo langField($param, 'table_student_name', 'Student Name');
                                        echo langField($param, 'table_total_mark', 'Total Mark');
                                        echo langField($param, 'table_gpa', 'GPA');


                                        echo getlabel('Mark Distribution');
                                        echo langField($param, 'mark_distribution', 'Mark distribution');
                                        echo langField($param, 'mark_distribution_list', 'Mark distribution list');
                                        echo langField($param, 'markdistribution_title', 'Title');
                                        echo langField($param, 'markdistribution_from', 'Mark distribution from');
                                        echo langField($param, 'addnew_markdistributiontitle', 'New Mark Distribution');
                                        echo langField($param, 'edit_markdistributiontitle', 'Edit Mark Distribution');
                                        echo langField($param, 'assigning_mark_distribution', 'Assigning Mark Distribution');
                                       
                                        
                                        echo getlabel('Browser Title');

                                        echo langField($param, 'addnew_subjecttitle', 'Add new subject');
                                        echo langField($param, 'addnew_exam_title', 'Add new exam');
                                        echo langField($param, 'add_new_students_title', 'Add new student');
                                        echo langField($param, 'add_grade_title', 'Add new grade');
                                        echo langField($param, 'addnew_teacher_title', 'Add new teacher');
                                        echo langField($param, 'addnew_class_subject_title', 'Add class and subject');

                                        echo langField($param, 'certificate_title', 'Certificate title');
                                        echo langField($param, 'configuration_title', 'Configuration');
                                        echo langField($param, 'class_list_title', 'Class list');
                                        echo langField($param, 'department_list_title', 'Departments list');
                                        echo langField($param, 'department', 'Department');
                                        echo langField($param, 'edit_department_title', 'Edit Department ');
                                        echo langField($param, 'add_department_title', 'Add Department ');

                                        echo langField($param, 'dashboard_title', 'Dashboard title');

                                        echo langField($param, 'edit_subjecttitle', 'Edit subject');
                                        echo langField($param, 'edit_students_title', 'Edit student information');
                                        echo langField($param, 'edit_class_subject_title', 'Edit class and subject ');
                                        echo langField($param, 'exam_list_title', 'Exam list');
                                        echo langField($param, 'edit_exam_title', 'Edit new exam');
                                        echo langField($param, 'edit_grade_title', 'Edit grade');
                                        echo langField($param, 'edit_teacher_title', 'Edit teacher information');

                                        echo langField($param, 'field_list_title', 'Field list');
                                        echo langField($param, 'addnew_field_title', 'Add new field');
                                        echo langField($param, 'edit_field_title', 'Edit field ');

                                        echo langField($param, 'grade_list_title', 'Grade list');
                                        echo langField($param, 'grade_cat_list_title', 'Grade Category');
                                        echo langField($param, 'edit_grade_cat_title', 'Edit Grade Category');
                                        echo langField($param, 'add_grade_cat_title', 'Add Grade Category');

                                        echo langField($param, 'mark_title', 'Manage mark');

                                        echo langField($param, 'result_title', 'Students result');

                                        echo langField($param, 'subjects_list_title', 'Subjects list');
                                        echo langField($param, 'students_list_title', 'Students list');
                                        echo langField($param, 'teacher_list_title', 'Teachers list');
                                        ?>
                                    </div>
                                    </fieldset>

                                </div>


                                <div id="menu" class="tab-pane fade ">
                                    <p></p>
                                    <fieldset class="form-vertical language-fielset"> 
                                    <div class="row">
                                        <?php 
                                        $CI =& get_instance();
                                        $CI->db->select('*');
                                        $CI->db->from('menus');
                                        $CI->db->order_by("menu_order", "asc");
                                        $query = $CI->db->get();
                                        $results = $query->result();
                                        foreach ($results as $key => $menu_item) {
                                            $menu_id = $menu_item->id;
                                            $menu_title = $menu_item->title;
                                            $field_name= 'menu_'.$menu_id;
                                            echo langField($menu_param, $field_name, $menu_title,'menu');
                                        }
                                        ?>
                                    </div>
                                    </fieldset>

                                </div>

                                <div id="quick_menu" class="tab-pane fade ">
                                    <p></p>
                                    <fieldset class="form-vertical language-fielset"> 
	                                    <div class="row">
	                                    	<?php 
                                            echo langField($param, 'backup_restore', 'Backup and restore');
	                                        echo langField($param, 'list_class', 'Class list');
                                            echo langField($param, 'configuration', 'Configuration');
                                            echo langField($param, 'certificate_quick', 'Certificate');

                                            echo langField($param, 'list_exam', 'Exam list');
                                            echo langField($param, 'list_grade', 'Grade list');
	                                        
	                                        echo langField($param, 'manage_language', 'Manage language');
                                            echo langField($param, 'get_mark', 'Mark');

                                            echo langField($param, 'new_class', 'New class');
                                            echo langField($param, 'new_subject', 'New subject');
                                            echo langField($param, 'new_teacher', 'New teacher');
	                                        echo langField($param, 'new_exam', 'New exam');
	                                        echo langField($param, 'new_grade', 'New grade');
                                            echo langField($param, 'new_student', 'New student');

                                            echo langField($param, 'result_quick', 'Result');                                            
	                                        echo langField($param, 'list_student', 'Student list');
                                            echo langField($param, 'list_subject', 'Subject list');
                                            echo langField($param, 'list_teacher', 'Teacher list');
	                                        ?>
	                                     </div>
                                    </fieldset>
                                </div>

                                <div id="system_masg" class="tab-pane fade ">
                                    <p></p>
                                    <fieldset class="form-vertical language-fielset"> 
	                                    <div class="row">
	                                    	<?php 
	                                        echo langField($param, 'email_failed', 'Email has been failed, try again.');
                                            echo langField($param, 'email_pass_mismatch', 'Email or password mismatch'); 
                                            echo langField($param, 'restored_failed', 'Error: Please choose CSV file !');
                                            echo langField($param, 'update_failed', 'Information update failed');
                                            echo langField($param, 'update_success', 'Information update successfully');
                                            echo langField($param, 'create_failed', 'Information create failed !');
                                            echo langField($param, 'create_success', 'Information create successfully !'); 
                                            echo langField($param, 'sent_details_error', 'Error while sending your details, try again.'); 
                                            echo langField($param, 'enter_roll', 'Please enter roll !');
                                            echo langField($param, 'select_department_result', 'Please select department !');
                                            echo langField($param, 'select_class_result', 'Please select class !');
                                            echo langField($param, 'select_exam_result', 'Please select exam !');
                                            echo langField($param, 'pass_error', 'Password changed failed');
                                            echo langField($param, 'class_exam_subject', 'Please select exam, class, subject ! '); 
                                            echo langField($param, 'pass_success', 'Password changed successfully'); 
                                            echo langField($param, 'roll_class_exam', 'Please fill roll, class, exam !');
                                            echo langField($param, 'select_class', 'Please select class !');
                                            echo langField($param, 'select_exam', 'Please select exam !');
                                            echo langField($param, 'select_roll', 'Please select roll !');
                                            echo langField($param, 'pass_link_sent', 'Reset password link sent successfully, please check mails.'); 
                                            echo langField($param, 'result_no_found', 'Result not found !'); 
                                            echo langField($param, 'somthing_worng', 'Somthing worng');
                                            echo langField($param, 'restored_success', 'Successfully restored');
                                            echo langField($param, 'email_registered', 'This email is not registered with us.'); 
                                            echo langField($param, 'no_permission', 'You have no permission');

	                                        ?>
	                                     </div>
                                    </fieldset>
                                </div>

                                <div id="button" class="tab-pane fade ">
                                    <p></p>
                                    <fieldset class="form-vertical language-fielset"> 
                                        <div class="row">
                                            <?php 

                                            echo langField($param, 'add', 'Add');
                                            echo langField($param, 'add_new', 'Add new');
                                            echo langField($param, 'cancel', 'Cancel');
                                            echo langField($param, 'delete', 'Delete');
                                            echo langField($param, 'edit', 'Edit');
                                            echo langField($param, 'export_csv', 'Export CSV');
                                            echo langField($param, 'pdf', 'Export PDF');
                                            echo langField($param, 'login', 'Login');
                                            echo langField($param, 'log_out', 'Log out');
                                            echo langField($param, 'more_result', 'More result');
                                            echo langField($param, 'print', 'Print');
                                            echo langField($param, 'reset', 'Reset');
                                            echo langField($param, 'submit', 'Submit');
                                            echo langField($param, 'save', 'Save');
                                            echo langField($param, 'save_here', 'Save & Here');
                                            echo langField($param, 'view_result', 'View result');
                                            
                                            ?>
                                         </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

    
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input type="hidden" value="<?php echo $id; ?>" name="id">
                                            <input type="submit" class="btn btn-primary" value="Save" /> 
                                            <a class="btn  btn-default" href="<?php echo base_url().'languages'; ?>" title="Cancel"> Cancel </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    </form>
                    <!-- form end -->

                </div>
            </div>
        </div> 
           
    </section>
    
</div>

<script type="text/javascript">
    jQuery( "#s_image" ).change(function() { 
        var image = jQuery("#s_image").val();
        jQuery('#flag_icon').attr('src', '<?php echo site_url('/uploads/lang/'); ?>'+image+'.gif');
    });
</script>
