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
<div class="content-wrapper mark-page">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body" >
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
				        $class_name      = getSingledata('class', 'name', 'id', $class_id);
				        $department_name = getSingledata('departments', 'department_name', 'id', $department_id);

				        $total_marks = array();

				        $onclick_link ="'printableArea'";
				        $header_con ='<input type="button" id="print" onclick="printDiv('.$onclick_link.')" class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" value="'.getlang('print').'" />';
				        $header_con .='<a href="'.base_url().'result" id="more-result" class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" >'.getlang('more_result').'</a> ';

				        // Download PDF
				        $header_con .='<form action="'.base_url().'result/download_pdf" method="post" style="display: inline-block;" >';
				        $header_con .='<input type="hidden" name="roll" value="'.$roll.'">';
				        $header_con .='<input type="hidden" name="class" value="'.$class_id.'">';
				        $header_con .='<input type="hidden" name="department" value="'.$department_id.'">';
				        $header_con .='<input type="hidden" name="exam" value="'.$exam_ids.'">';
				        $header_con .='<input type="hidden" name="year" value="'.$year.'">';
				        $header_con .='<input type="submit" id="export-pdf"  class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" value="'.getlang('pdf').'" /> ';
				        $header_con .='</form>';
       

				        //Result Display 
				        $result_display = '';
				        $result_display .= '<div id="printableArea" >';
				        $result_display .= '<div class="row">';
				        $result_display .= '<div class="col-md-12 result-header text-center">';
				        if(!empty($institute_show_logo)){$result_display .= '<img src="'.$institute_logo_path.'"  alt="institute logo"  >';}
				        if(!empty($institude_show_name)){$result_display .= '<h3>'.$institude_name.'</h3>';}
				        if(!empty($institute_show_address)){$result_display .= '<p>'.$institute_address.'</p>';}
				        if(!empty($institute_show_phone)){$result_display .= '<p> <b>'.getlang('phone').': </b>'.$institute_phone.'</p>';}
				        if(!empty($institute_show_email)){$result_display .= '<p> <b>'.getlang('email').': </b>'.$institute_email.'</p>';}
				        if(!empty($institute_show_website)){$result_display .= '<p> <b>'.getlang('website').': </b>'.$institute_website.'</p>';}
				        $result_display .= $header_con;
				        $result_display .= '<h4>'.$result_caption.'</h4>';
				        $result_display .= '</div>';
				        $result_display .= '</div>';

				        $result_display .= '<table  width="100%" class="header_table"  style="border: 0px;margin: 0px 0;" >'; 
				        $result_display .='<tr>';
				        $result_display .='<td style="text-align: center;border: 0px;padding-left:0; > </td>';
				        $result_display .='<td style="text-align: center;border: 0px;padding-left:0; >
				        <h4> '.getlang('class').' - '.$class_name.' </h4> 
				        <h4> '.getlang('department').' - '.$department_name.' </h4>
				        </td>';
				        
				        $result_display .='</tr>';   
				        $result_display .='</table>';

				        $result_display .= '<table  width="100%" class="student_info_table" id="admin-table" style="border: 0px;margin: 0px 0;" >';
				        $result_display .='<tr>';
				        $result_display .='<td style="text-align: left;border: 0px;padding-left:0;" width="20%" ><b> '.getlang('students').' : </b>'.$student_name.' </td>';
				        $result_display .='<td style="text-align: right;border: 0px;" width="20%" ><b> '.getlang('roll').' :</b> '.$roll.'</td>';
				        $result_display .='</tr>';   
				        $result_display .='</table>';



			            $result_display .= '<table  width="100%" class="mark-table" id="result-table"  >';
			            $result_display .= '<caption><p style="text-align:center;"><b> '.$exam_name.'</b></p></caption>';
			            $result_display .= '<tr>'; 
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
				        $result_display .= '<table  width="100%" class=" none-border-table"  style="border: 0px;margin: 0px 0;" >';
				        $result_display .= '<tr>'; 
				        $result_display .= '<td class="text-left" style="padding-left:0;padding-top: 15px;"><b>'.getlang('total_marks').' : '.$exam_total_mark.'</b></td>';
				        
				        // get calculate exam gp
				        $exam_total_gp = array_sum($exam_total_gp);
				        $exam_gp = round(($exam_total_gp / $total_subject), 2);
				        
				        $result_display .= '<td class="text-center" style="padding-top: 15px;text-align:right;"><b> '.getlang("gpa").' : '.$exam_gp.'</b></td>';
				        $result_display .= '</tr>'; 
				        $result_display .= '</table>';  

				        $result_display .= '</div>';  
        
                        echo $result_display;
                    }
                    ?>
                    </div>
                </div>
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
		document.getElementById("export-pdf").style.visibility = "hidden";
		window.print();
		document.body.innerHTML = originalContents;
		//document.location.reload();
	}
</script>
