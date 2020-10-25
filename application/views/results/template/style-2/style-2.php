<?php

    $institude_name    = getParam('name');
    $institute_email   = getParam('email');
    $institute_phone   = getParam('phone');
    $institute_website = getParam('website');
    $institute_address = getParam('address');
    $institute_logo    = getParam('logo_2');

    $student_choose_subject = getParam('student_choose_subject');

    if(empty($institute_logo)){
        $institute_logo_path = site_url('/uploads/logo/').'/rms_logo.png';
    }else{
        $institute_logo_path = site_url('/uploads/logo/').'/'.$institute_logo;
    }
    $institude_show_name    = getParam('result_name');
    $institute_show_email   = getParam('result_email');
    $institute_show_phone   = getParam('result_phone');
    $institute_show_website = getParam('result_website');
    $institute_show_address = getParam('result_address');
    $institute_show_logo    = getParam('result_logo');
  
	$roll          = $roll;
	$class_id      = $class_id;
	$department_id = $department;
	$exam_id       = $exam_ids;
	$year          = $year;
	$student_id    = getStudentID($roll, $class_id, $year, $department_id);
 
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title><?php echo getlang('result_title'); ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/sumoselect.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/custom.css" rel="stylesheet" type="text/css" />

    <style>
      .error{
        color:red;
        font-weight: normal;
      }
      p{margin: 0;}
      .header-table tr td {border: 0px solid #fff;padding-top: 20px;padding-bottom: 20px;}
      .footer-table tr td{padding-top: 20px; padding-bottom: 50px;}
      #grade-chart td{text-align: center; border: 1px solid #000;padding: 1px 2px; font-size: 11px;line-height: 15px;}
    </style>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/common.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    <body>

    <section class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php 
                if(!empty($roll) && !empty($class_id) && !empty($exam_ids) && !empty($department_id) && !empty($student_id)){

		            // Get mark distribution by class id
		            $mark_distribution_string = getSingledata('class', 'mark_distribution', 'id', $class_id);
		            $mark_distribution_object = explode(",", $mark_distribution_string);

		            // Get exam data
		            $exam_name       = getSingledata('exam', 'name', 'id', $exam_id);
		            $exam_param      = getSingledata('exam', 'param', 'id', $exam_id);
		            $exam_param_data = json_decode($exam_param,true);

		            if(!empty($student_choose_subject)){
		            	// Get subject
			            $main_subject = getSingledata('students', 'main_subjects', 'id', $student_id);
			            if(!empty($main_subject)){
			                $main_subject_array = explode(",", $main_subject);
			            }else{
			                $main_subject_array = array();
			            }

			            // Get optional subject
			            $optional_subject = getSingledata('students', 'optional_subject', 'id', $student_id);
			            if(!empty($optional_subject)){
			                $optional_subject_array = explode(",", $optional_subject);
			            }else{
			                $optional_subject_array = array();
			            }
			            
			            $subject_array = array_merge($main_subject_array, $optional_subject_array);

			            $total_subject = count($subject_array);

		            }else{
		            	// Get subject
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

			            $total_subject = count($subject_array);
		            }

		            

		            // Get result template id
		            if(isset($exam_param_data['class_id'][$class_id]['result_template'][0])){
		                $result_template_id = $exam_param_data['class_id'][$class_id]['result_template'][0];
		            }else{
		                $result_template_id = '';
		            }
		            $result_template_param      = getSingledata('result_template', 'param', 'id', $result_template_id);
		            $result_template_param_data = json_decode($result_template_param,true);

		            // result_caption
		            if(isset($result_template_param_data['result_caption'][0])){
		                $result_caption = $result_template_param_data['result_caption'][0];
		            }else{
		                $result_caption = '';
		            }

		            // show show_grade_chart
		            if(isset($result_template_param_data['show_grade_chart'][0])){
		                $show_grade_chart = $result_template_param_data['show_grade_chart'][0];
		            }else{
		                $show_grade_chart = '';
		            }

		            // show avatar
		            if(isset($result_template_param_data['show_avatar'][0])){
		                $show_avatar = $result_template_param_data['show_avatar'][0];
		            }else{
		                $show_avatar = '';
		            }

		            // show letter grade
		            if(isset($result_template_param_data['show_letter_grade'][0])){
		                $show_letter_grade = $result_template_param_data['show_letter_grade'][0];
		            }else{
		                $show_letter_grade = '';
		            }

		            // show merit list
		            if(isset($result_template_param_data['show_merit_list'][0])){
		                $show_merit_list = $result_template_param_data['show_merit_list'][0];
		            }else{
		                $show_merit_list = '';
		            }

		            // show class position
		            if(isset($result_template_param_data['show_class_position'][0])){
		                $show_class_position = $result_template_param_data['show_class_position'][0];
		            }else{
		                $show_class_position = '';
		            }

		            // show department position
		            if(isset($result_template_param_data['show_department_position'][0])){
		                $show_department_position = $result_template_param_data['show_department_position'][0];
		            }else{
		                $show_department_position = '';
		            }

		            // show exam position
		            if(isset($result_template_param_data['show_exam_position'][0])){
		                $show_exam_position = $result_template_param_data['show_exam_position'][0];
		            }else{
		                $show_exam_position = '';
		            }

		            // show highest mark
		            if(isset($result_template_param_data['show_highest_mark'][0])){
		                $show_highest_mark = $result_template_param_data['show_highest_mark'][0];
		            }else{
		                $show_highest_mark = '';
		            }

		            // show gp
		            if(isset($result_template_param_data['show_gp'][0])){
		                $show_gp = $result_template_param_data['show_gp'][0];
		            }else{
		                $show_gp = '';
		            }

		            // show grade
		            if(isset($result_template_param_data['show_grade'][0])){
		                $show_grade = $result_template_param_data['show_grade'][0];
		            }else{
		                $show_grade = '';
		            }

		            // show gp comment
		            if(isset($result_template_param_data['show_gp_comment'][0])){
		                $show_gp_comment = $result_template_param_data['show_gp_comment'][0];
		            }else{
		                $show_gp_comment = '';
		            }

			        $student_name    = getSingledata('students', 'name', 'id', $student_id);
			        $student_year    = getSingledata('students', 'year', 'id', $student_id);
			        $class_name      = getSingledata('class', 'name', 'id', $class_id);
			        $department_name = getSingledata('departments', 'department_name', 'id', $department_id);

                    // Get students photo
                    $student_avatar    = getSingledata('students', 'avatar', 'id', $student_id);
			        if(empty($student_avatar)){
                        $img_path = site_url('/uploads/students/').'avator.png';
                  	}else{
                        $img_path = site_url('/uploads/students/').$student_avatar;
                  	}

			        $total_marks = array();

			        $onclick_link ="'printableArea'";
			        $header_con ='<input type="button" id="print" onclick="printDiv('.$onclick_link.')" class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" value="'.getlang('print').'" />';
			        $header_con .='<a href="'.base_url().'results" id="more-result" class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" >'.getlang('more_result').'</a> ';

			       

			        //Result Display 
			        $result_display = '';
			        $result_display .= '<div id="printableArea" >';
			        $result_display .= '<div class="row">';
			        $result_display .= '<div class="col-md-12 result-header text-center">';
			        if(!empty($institute_show_logo)){$result_display .= '<img src="'.$institute_logo_path.'" width="300px"  alt="institute logo"  >';}
			        if(!empty($institude_show_name)){$result_display .= '<h3 style="margin: 2px;">'.$institude_name.'</h3>';}
			        if(!empty($institute_show_address)){$result_display .= '<p style="margin: 0px;">'.$institute_address.'</p>';}
			        if(!empty($institute_show_phone)){$result_display .= '<p style="margin: 0px;"><b>'.getlang('phone').': </b>'.$institute_phone.'</p>';}
			        if(!empty($institute_show_email)){$result_display .= '<p style="margin: 0px;"><b>'.getlang('email').': </b>'.$institute_email.'</p>';}
			        if(!empty($institute_show_website)){$result_display .= '<p style="margin: 0px;"><b>'.getlang('website').': </b>'.$institute_website.'</p>';}
			        $result_display .= $header_con;
			        
			        $result_display .= '<h4>'.$result_caption.'</h4>';
			        $result_display .= '</div>';
			        $result_display .= '</div>';

			        
			        $result_display .= '<table  width="100%" class="header-table">';
                    $result_display .= '<tr>'; 
			        $result_display .= '<td  style="padding-right:10px;vertical-align: top;">';
			            $result_display .= '<p><b>'.getlang('student_information').'</b></p>';
			            $result_display .= '<table  width="100%" id="result-table" class="mark-table" >';
			            $result_display .= '<tr>
			                                <td width="50%">'.getlang('students').'</td>
			                                <td width="50%">'.$student_name.'</td>
			                                </tr>'; 
			            $result_display .= '<tr>
			                                <td width="50%">'.getlang("roll").'</td>
			                                <td width="50%">'.$roll.'</td>
			                                </tr>'; 
			            $result_display .= '<tr>
			                                <td width="50%">'.getlang('class').'</td>
			                                <td width="50%">'.$class_name.'</td>
			                                </tr>'; 
			            $result_display .= '<tr>
			                                <td width="50%">'.getlang('department').'</td>
			                                <td width="50%">'.$department_name.'</td>
			                                </tr>'; 
			            $result_display .= '<tr>
			                                <td width="50%">'.getlang('year').'</td>
			                                <td width="50%">'.$student_year.'</td>
			                                </tr>'; 
			            $result_display .= '</table>'; 
			        $result_display .= '</td>';
			        $result_display .= '<td width="250px" style="padding-left:10px;text-align:center; vertical-align: top;" >';
			            if(!empty($show_grade_chart)){
			        	$result_display .= '<p><b>'.getlang('grade_point_chart').'</b></p>';
			        	$result_display .= '<table  width="100%" id="grade-chart" class="mark-table" >';
			            $result_display .= '<tr>
			                                <td>'.getlang('letter_grade').'</td>
			                                <td>'.getlang('mark_interval').'</td>
			                                <td>'.getlang('grade_point').'</td>
			                                </tr>'; 
			                $grade_chart_object = getGradeList(1);
			                foreach ($grade_chart_object as $key => $grade) {
			                	$result_display .= '<tr>
			                                <td>'.$grade->name.'</td>
			                                <td>'.$grade->mark_from.' - '.$grade->mark_upto.'</td>
			                                <td>'.number_format($grade->grade_point, 1).'</td>
			                                </tr>'; 
			                }
			            $result_display .= '</table>'; 
			            }
			        $result_display .= '</td>';
			        $result_display .= '<td width="200px" style="padding-left:10px;text-align:right;vertical-align: top;" >';
			        if(!empty($show_avatar)){
			        	$result_display .= '<p style="padding:10px;"></p>';
			        	$result_display .= '<img src="'.$img_path.'" alt="'.$student_name.'" width="160px" >';
			        }
			        $result_display .= '</td>';
			        $result_display .='</tr>';   
			        $result_display .='</table>';

			       
		            $result_display .= '<table  width="100%" class="mark-table" id="result-table"  >';
		            $result_display .= '<p>'.getlang('examination').': <b>'.$exam_name.'</b></p>';
		            $result_display .= '<tr>'; 
		            $result_display .= '<th class="center" >'.getlang('sl').'</th>';
		            $result_display .= '<th class="center" > '.getlang('subjects').' </th>';
			            if(!empty($show_highest_mark)){
			                $result_display .= '<th class="center" >'.getlang('highest_mark').'</th>';
			            }
            
			            foreach ($mark_distribution_object as $key => $md) {
			                $md_title = getSingledata('mark_distribution', 'title', 'id', $md);
			                $result_display .= '<th class="center">'.$md_title.'</th>';
			            }
			            $result_display .= '<th class="center" >'.getlang('total').'</th>';
			            if(!empty($show_gp)){
			            	$result_display .= '<th class="center" >'.getlang('gp').'</th>';
			            }
			            
			            if(!empty($show_grade)){
			            	$result_display .= '<th class="center" >'.getlang('grade').'</th>';
			            }
			            
			            if(!empty($show_gp_comment)){
			                $result_display .= '<th class="center" > '.getlang('comment').' </th>';
			            }
		            $result_display .= '</tr>'; 

       
	                $exam_total_mark = array();
	                $exam_total_gp = array();
	                foreach ($subject_array as $j=>$subject_id) {

	                    // Get exam param by subject
	                    if(isset($exam_param_data['class_id'][$class_id]['subject_id'][$subject_id]['grade_system'][0])){
	                        $grade_category_id = $exam_param_data['class_id'][$class_id]['subject_id'][$subject_id]['grade_system'][0];
	                    }else{
	                        $grade_category_id = '';
	                    }
                
	                    // Get Subject Name
	                    $subject_name = getSingledata('subjects', 'name', 'id', $subject_id);

	                    // Get Highest mark
	                    $highest_marks = getHighestMark('MAX(total_mark)', $exam_id, $class_id, $department_id, $subject_id, $year);

	                                               
	                    $result_display .= '<tr>'; 
	                    $result_display .= '<td class="text-center">'.($j+1).'</td>';
	                    $result_display .= '<td class="text-left">'.$subject_name.'</td>';
	                    if(!empty($show_highest_mark)){
	                        $result_display .= '<td class="text-center">'.$highest_marks.'</td>';
	                    }

	                    $subject_total_mark = array();
	                    foreach ($mark_distribution_object as $md_key => $md) {
	                        $mark_id    = getExitMark($student_id, $subject_id, $class_id, $exam_id, $year, $department_id);
	                        $mark_value = getExitData('mark', $class_id,  $subject_id, $department_id, $student_id, $exam_id, $mark_id, $md, $year);
	                        if(empty($mark_value)){
	                            $mark_value = '';
	                            $subject_total_mark[] = 0;
	                        }else{
	                            $subject_total_mark[] = $mark_value;
	                        }
	                        $result_display .= '<td class="text-center">'.$mark_value.'</td>';
	                    }

	                    $subject_total_mark = array_sum($subject_total_mark);
	                    $exam_total_mark[] = $subject_total_mark;

	                    // Get calculation grade & comment
	                    $grade = getGradeValue($grade_category_id, $subject_total_mark);

	                    $gp = $grade['gp'];
	                    $exam_total_gp[] = $gp;
	                     
	                    $result_display .= '<td class="text-center">'.$subject_total_mark.'</td>';

	                    if(!empty($show_gp)){
		                    $result_display .= '<td class="text-center">'.$gp.'</td>';
	                    }

	                    if(!empty($show_grade)){
		                    $result_display .= '<td class="text-center">'.$grade['gpa'].'</td>';
		                }

	                    if(!empty($show_gp_comment)){
	                        $result_display .= '<td class="text-center">'.$grade['comment'].'</td>';
	                    }
	                    $result_display .= '</tr>'; 

                    } // End Subject foreach
                    $result_display .= '</table>';  

			        //Resultsheet Footer
			        $exam_total_mark = array_sum($exam_total_mark);
			        // get calculate exam gp
			        $exam_total_gp = array_sum($exam_total_gp);
			        $exam_gp = round(($exam_total_gp / $total_subject), 2);

			        $merit_in_department = getExitRank('department_position', $exam_id, $class_id, $department_id, $year, $student_id);
                    $student_in_department = getStudentInDepartment($exam_id, $class_id, $department_id, $year);

                    $merit_in_class = getExitRank('class_position', $exam_id, $class_id, $department_id, $year, $student_id);
                    $student_in_class = getStudentInclass($exam_id, $class_id, $year);

                    $merit_in_exam = getExitRank('exam_position', $exam_id, $class_id, $department_id, $year, $student_id);
                    $student_in_exam = getStudentInexam($exam_id, $year);

                    $letter_grade = getGradeLetter(1, $exam_gp);


			        $result_display .= '<table  width="100%" class="footer-table" >';
			        $result_display .= '<tr>'; 
			        $result_display .= '<td width="50%" style="padding-right:10px;">';
			            // Left table
			            $result_display .= '<p><b>'.getlang('total_marks_gpa').'</b></p>';
			            $result_display .= '<table  width="100%" id="result-table" class="mark-table" >';
			            $result_display .= '<tr>
			                                <td width="50%">'.getlang('total_marks').'</td>
			                                <td width="50%">'.$exam_total_mark.'</td>
			                                </tr>'; 
			            $result_display .= '<tr>
			                                <td width="50%">'.getlang("gpa").'</td>
			                                <td width="50%">'.$exam_gp.'</td>
			                                </tr>';
			            if(!empty($show_letter_grade)){
			            $result_display .= '<tr>
			                                <td width="50%">'.getlang('letter_grade').'</td>
			                                <td width="50%">'.$letter_grade.'</td>
			                                </tr>'; 
			            }
			            $result_display .= '</table>';  
			            

			        $result_display .= '</td>';
			        $result_display .= '<td width="50%" style="padding-left:10px;" >';
	                    // Right table
			            if(!empty($show_merit_list)){
			            $result_display .= '<p><b>'.getlang('position_merit_list').'</b></p>';
			            $result_display .= '<table  width="100%" id="result-table" class="mark-table" >';
			            if(!empty($show_class_position)){
			                $result_display .= '<tr>
			                                <td width="50%">'.getlang('class').'</td>
			                                <td width="50%">'.$merit_in_class.' Out of '.$student_in_class.'</td>
			                                </tr>'; 
			            }
			            if(!empty($show_department_position)){
			                $result_display .= '<tr>
			                                <td width="50%">'.getlang('department').'</td>
			                                <td width="50%">'.$merit_in_department.' Out of '.$student_in_department.'</td>
			                                </tr>'; 
			            }
			            if(!empty($show_exam_position)){
			                $result_display .= '<tr>
			                                <td width="50%">'.getlang('exam').'</td>
			                                <td width="50%">'.$merit_in_exam.' Out of '.$student_in_exam.'</td>
			                                </tr>'; 
			            }
			            $result_display .= '</table>';  
			            }
			        $result_display .= '</td>';
			        $result_display .= '</tr>'; 
			        $result_display .= '</table>';  

			        $result_display .= '</div>';  

                    
    
                    echo $result_display;
                }
                ?>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
	function printDiv(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		document.getElementById("print").style.visibility = "hidden";
		document.getElementById("more-result").style.visibility = "hidden";
		window.print();
		document.body.innerHTML = originalContents;
		//document.location.reload();
	}
</script>


    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/app.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
    
    </body>
</html>