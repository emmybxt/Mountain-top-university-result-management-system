<?php 
function getPDF($roll, $class_id, $department_id, $exam_id, $year){

    $institude_name = getParam('name');
    $institute_email = getParam('email');
    $institute_phone = getParam('phone');
    $institute_website = getParam('website');
    $institute_address = getParam('address');
    $institute_logo = getParam('logo_2');

    $student_choose_subject = getParam('student_choose_subject');

    if(empty($institute_logo)){
        $institute_logo_path = site_url('/uploads/logo/').'/rms_logo.png';
    }else{
        $institute_logo_path = site_url('/uploads/logo/').'/'.$institute_logo;
    }
    $institude_show_name = getParam('result_name');
    $institute_show_email = getParam('result_email');
    $institute_show_phone = getParam('result_phone');
    $institute_show_website = getParam('result_website');
    $institute_show_address = getParam('result_address');
    $institute_show_logo = getParam('result_logo');

    $student_id    = getStudentID($roll, $class_id, $year, $department_id);

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

    $pdf_body ='
    <style>
       table tr th, 
       table tr td {border: 1px solid #000;} 
       .body-table{padding:2px 6px;}
       .body-table th{font-size: 12px;}
       .body-table td{font-size: 12px;}
       p{margin: 0;}
      .header-table tr td {border: 0px solid #fff;padding-top: 20px;padding-bottom: 20px;}
      .header-table-info,
      .footer-table-info {padding:3px 6px;}
      .footer-table tr td{border: 0px solid #fff;} 
      #grade-chart tr td{text-align: center; border: 1px solid #000;padding: 1px 2px; font-size: 9px;line-height: 15px;}
      .text-center{text-align:center;}
    </style>';
    $pdf_body .= '<div style="text-align: center;line-height: 5px;">';
    if(!empty($institute_show_logo)){$pdf_body .= '<img src="'.$institute_logo_path.'"  alt="" width="180px"  >';}
    if(!empty($institude_show_name)){$pdf_body .= '<h3 style="font-size: 20px;line-height: 10px;margin-top: 50px;">'.$institude_name.'</h3>';}
    $pdf_body .= '<p style="font-size: 13px;line-height: 15px;">';
    if(!empty($institute_show_address)){$pdf_body .= ''.$institute_address.'<br/>';}
    if(!empty($institute_show_phone)){$pdf_body .= '<b>'.getlang('phone').': </b>'.$institute_phone.'<br/>';}
    if(!empty($institute_show_email)){$pdf_body .= ' <b>'.getlang('email').': </b>'.$institute_email.'<br/>';}
    if(!empty($institute_show_website)){$pdf_body .= '<b>'.getlang('website').': </b>'.$institute_website.'';}
    $pdf_body .= '</p>';

    $pdf_body .= '<h4>'.$result_caption.'</h4>';
    $pdf_body .= '</div>';

    $pdf_body .= '<table  width="100%" class="header-table">';
    $pdf_body .= '<tr>'; 
    $pdf_body .= '<td width="30%" style="padding-right:10px;vertical-align: top;">';
        $pdf_body .= '<p><b>'.getlang('student_information').'</b></p>';
        $pdf_body .= '<table  width="100%" class="header-table-info" >';
        $pdf_body .= '<tr>
                            <td width="50%">'.getlang('students').'</td>
                            <td width="50%">'.$student_name.'</td>
                            </tr>'; 
        $pdf_body .= '<tr>
                            <td width="50%">'.getlang("roll").'</td>
                            <td width="50%">'.$roll.'</td>
                            </tr>'; 
        $pdf_body .= '<tr>
                            <td width="50%">'.getlang('class').'</td>
                            <td width="50%">'.$class_name.'</td>
                            </tr>'; 
        $pdf_body .= '<tr>
                            <td width="50%">'.getlang('department').'</td>
                            <td width="50%">'.$department_name.'</td>
                            </tr>'; 
        $pdf_body .= '<tr>
                            <td width="50%">'.getlang('year').'</td>
                            <td width="50%">'.$student_year.'</td>
                            </tr>'; 
        $pdf_body .= '</table>'; 
    $pdf_body .= '</td>';
    $pdf_body .= '<td width="50%" style="padding-left:10px;text-align:center; vertical-align: top;" >';
        if(!empty($show_grade_chart)){
        $pdf_body .= '<p><b>'.getlang('grade_point_chart').'</b></p>';
        $pdf_body .= '<table  width="100%" id="grade-chart" class="mark-table" >';
        $pdf_body .= '<tr>
                            <td>'.getlang('letter_grade').'</td>
                            <td>'.getlang('mark_interval').'</td>
                            <td>'.getlang('grade_point').'</td>
                            </tr>'; 
            $grade_chart_object = getGradeList(1);
            foreach ($grade_chart_object as $key => $grade) {
                $pdf_body .= '<tr>
                            <td>'.$grade->name.'</td>
                            <td>'.$grade->mark_from.' - '.$grade->mark_upto.'</td>
                            <td>'.number_format($grade->grade_point, 1).'</td>
                            </tr>'; 
            }
        $pdf_body .= '</table>'; 
        }
    $pdf_body .= '</td>';
    $pdf_body .= '<td width="20%" style="padding-left:10px;text-align:right;vertical-align: top;" >';
    if(!empty($show_avatar)){
        $pdf_body .= '<p style="padding:10px;"></p>';
        $pdf_body .= '<img src="'.$img_path.'" alt="'.$student_name.'" width="80px" >';
    }
    $pdf_body .= '</td>';
    $pdf_body .='</tr>';   
    $pdf_body .='</table><br>';

    $pdf_body .= '<p>'.getlang('examination').': <b>'.$exam_name.'</b></p>';
    $pdf_body .= '<table  width="100%" class="body-table"  >';
            //Head 
            $pdf_body .= '<tr>'; 
            $pdf_body .= '<th class="text-center" >'.getlang('sl').'</th>';
            $pdf_body .= '<th class="text-center" > '.getlang('subjects').' </th>';
            if(!empty($show_highest_mark)){
                $pdf_body .= '<th class="text-center" >'.getlang('highest_mark').'</th>';
            }
            
            foreach ($mark_distribution_object as $key => $md) {
                $md_title = getSingledata('mark_distribution', 'title', 'id', $md);
                $pdf_body .= '<th class="text-center">'.$md_title.'</th>';
            }
            $pdf_body .= '<th class="text-center" >'.getlang('total').'</th>';
            if(!empty($show_gp)){
                $pdf_body .= '<th class="text-center" >'.getlang('gp').'</th>';
            }
            
            if(!empty($show_grade)){
                $pdf_body .= '<th class="text-center" >'.getlang('grade').'</th>';
            }
            
            if(!empty($show_gp_comment)){
                $pdf_body .= '<th class="text-center" > '.getlang('comment').' </th>';
            }
            
            $pdf_body .= '</tr>'; 

            

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

                                                       
                    $pdf_body .= '<tr>'; 
                    $pdf_body .= '<td class="text-center">'.($j+1).'</td>';
                    $pdf_body .= '<td class="text-left">'.$subject_name.'</td>';
                    if(!empty($show_highest_mark)){
                        $pdf_body .= '<td class="text-center">'.$highest_marks.'</td>';
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
                        $pdf_body .= '<td class="text-center">'.$mark_value.'</td>';
                    }

                    $subject_total_mark = array_sum($subject_total_mark);
                    $exam_total_mark[] = $subject_total_mark;

                    // Get calculation grade & comment
                    $grade = getGradeValue($grade_category_id, $subject_total_mark);

                    $gp = $grade['gp'];
                    $exam_total_gp[] = $gp;
                     
                    $pdf_body .= '<td class="text-center">'.$subject_total_mark.'</td>';

                    if(!empty($show_gp)){
                        $pdf_body .= '<td class="text-center">'.$gp.'</td>';
                    }

                    if(!empty($show_grade)){
                        $pdf_body .= '<td class="text-center">'.$grade['gpa'].'</td>';
                    }

                    if(!empty($show_gp_comment)){
                        $pdf_body .= '<td class="text-center" style="font-size:12px;">'.$grade['comment'].'</td>';
                    }
                    $pdf_body .= '</tr>'; 

                } // End Subject foreach

      
        $pdf_body .= '</table>';
        $pdf_body .= '<div></div>';  


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

        $pdf_body .= '<table  width="100%" class="footer-table" >';
        $pdf_body .= '<tr>'; 
        $pdf_body .= '<td width="50%" >';
            // Left table
            $pdf_body .= '<b>'.getlang('total_marks_gpa').'</b><br>';
            $pdf_body .= '<table  width="100%" class="footer-table-info" >';
            $pdf_body .= '<tr>
                                <td width="50%">'.getlang('total_marks').'</td>
                                <td width="50%">'.$exam_total_mark.'</td>
                                </tr>'; 
            $pdf_body .= '<tr>
                                <td width="50%">'.getlang("gpa").'</td>
                                <td width="50%">'.$exam_gp.'</td>
                                </tr>';
            if(!empty($show_letter_grade)){
            $pdf_body .= '<tr>
                                <td width="50%">'.getlang('letter_grade').'</td>
                                <td width="50%">'.$letter_grade.'</td>
                                </tr>'; 
            }
            $pdf_body .= '</table>';  
            

        $pdf_body .= '</td>';
        $pdf_body .= '<td width="50%" >';
            // Right table
            if(!empty($show_merit_list)){
            $pdf_body .= '<b>'.getlang('position_merit_list').'</b><br>';
            $pdf_body .= '<table  width="100%" class="footer-table-info" >';
            if(!empty($show_class_position)){
                $pdf_body .= '<tr>
                                <td width="50%">'.getlang('class').'</td>
                                <td width="50%">'.$merit_in_class.' Out of '.$student_in_class.'</td>
                                </tr>'; 
            }
            if(!empty($show_department_position)){
                $pdf_body .= '<tr>
                                <td width="50%">'.getlang('department').'</td>
                                <td width="50%">'.$merit_in_department.' Out of '.$student_in_department.'</td>
                                </tr>'; 
            }
            if(!empty($show_exam_position)){
                $pdf_body .= '<tr>
                                <td width="50%">'.getlang('exam').'</td>
                                <td width="50%">'.$merit_in_exam.' Out of '.$student_in_exam.'</td>
                                </tr>'; 
            }
            $pdf_body .= '</table>';  
            }
        $pdf_body .= '</td>';
        $pdf_body .= '</tr>'; 
        $pdf_body .= '</table>';  

        

    return $pdf_body;
}
?>
