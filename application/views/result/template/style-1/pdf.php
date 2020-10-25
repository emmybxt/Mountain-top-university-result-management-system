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

    $pdf_body ='<style>table tr th, table tr td {border: 1px solid #ccc;padding:10px;} .text-center{text-align:center;}</style>';
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

    $pdf_body .= '<h4 style="font-size: 15px;text-align: center;line-height: 10px;" > '.getlang('class').' - '.$class_name.' </h4>';
    $pdf_body .= '</div>';

    $pdf_body .= '<table  width="100%" style="border: 0px solid #fff;" cellpadding="0" cellspacing="0" >';
    $pdf_body .='<tr>';
    $pdf_body .='<td style="text-align: left;border: 0px solid #fff;" width="50%" ><span >'.getlang('students').':'.$student_name.' </span></td>';
    $pdf_body .='<td style="text-align: right;border: 0px solid #fff;" width="50%" ><span> '.getlang('roll').':'.$roll.'</span></td>';
    $pdf_body .='</tr>';   
    $pdf_body .='</table> <br>';


    $pdf_body .= '<table  width="100%" style="border: 0px solid #fff;"  >';
    $pdf_body .= '<caption><p style="text-align:center;"><b> '.$exam_name.'</b></p></caption>';
            //Head 
            $pdf_body .= '<tr>'; 
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
                        $pdf_body .= '<td class="text-center">'.$grade['comment'].'</td>';
                    }
                    $pdf_body .= '</tr>'; 

                } // End Subject foreach

      
        $pdf_body .= '</table><br/>';  

        //Resultsheet Footer
        $exam_total_mark = array_sum($exam_total_mark);
        $pdf_body .= '<div></div><table  width="100%"  style="" >';
        $pdf_body .= '<tr>'; 
        $pdf_body .= '<td width="50%" style="border: 0px solid #fff;text-align:left;"><b>'.getlang('total_marks').' : '.$exam_total_mark.'</b></td>';
        
        // get calculate exam gp
        $exam_total_gp = array_sum($exam_total_gp);
        $exam_gp = round(($exam_total_gp / $total_subject), 2);
        
        $pdf_body .= '<td width="50%" style="border: 0px solid #fff;text-align:right;"><b> '.getlang("gpa").' : '.$exam_gp.'</b></td>';
        $pdf_body .= '</tr>'; 
        $pdf_body .= '</table>';  

        

    return $pdf_body;
}
?>
