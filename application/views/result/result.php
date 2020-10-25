<?php
  // Get language
  $roll = $roll;
  
  $class_id = $class_id;
  $department_id = $department;
  $exam_ids = $exam_ids;
  $year = $year;
  $student_id = getStudentID($roll, $class_id, $year, $department_id);
 
?>
<div class="content-wrapper mark-page">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body" >
      <?php 
      $institude_name = getParam('name');
        $institute_email = getParam('email');
        $institute_phone = getParam('phone');
        $institute_website = getParam('website');
        $institute_address = getParam('address');
        $institute_logo = getParam('logo_2');

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

        $institute_show_highest = getParam('result_highest');
        $institute_show_comment = getParam('result_comment');

        

        if(!empty($roll) && !empty($class_id) && !empty($exam_ids) && !empty($department_id) && !empty($student_id)){

        
        $student_name = getSingledata('students', 'name', 'roll', $roll);
        $class_name = getSingledata('class', 'name', 'id', $class_id);
        $department_name = getSingledata('departments', 'department_name', 'id', $department_id);

        $grade_rows = getGradeList();

        $total_marks = array();

        $onclick_link ="'printableArea'";
        $header_con ='<input type="button" id="print" onclick="printDiv('.$onclick_link.')" class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" value="'.getlang('print').'" />';
        $header_con .='<a href="'.base_url().'result" id="more-result" class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" >'.getlang('more_result').'</a> ';

        // Download PDF
        $header_con .='<form action="'.base_url().'result/download_pdf" method="post" style="display: inline-block;" >';
        $header_con .='<input type="hidden" name="roll" value="'.$roll.'">';
        $header_con .='<input type="hidden" name="class" value="'.$class_id.'">';
        $header_con .='<input type="hidden" name="department" value="'.$department_id.'">';
        $exam = implode(",",$exam_ids);
        $header_con .='<input type="hidden" name="exam" value="'.$exam.'">';
        $header_con .='<input type="hidden" name="year" value="'.$year.'">';
        $header_con .='<input type="submit" id="export-pdf"  class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" value="'.getlang('pdf').'" /> ';
        $header_con .='</form>';


        // Download CSV
        $header_con .='<form action="'.base_url().'result/download_csv" method="post" style="display: inline-block;" >';
        $header_con .='<input type="hidden" name="roll" value="'.$roll.'">';
        $header_con .='<input type="hidden" name="class" value="'.$class_id.'">';
        $header_con .='<input type="hidden" name="department" value="'.$department_id.'">';
        $exam = implode(",",$exam_ids);
        $header_con .='<input type="hidden" name="exam" value="'.$exam.'">';
        $header_con .='<input type="hidden" name="year" value="'.$year.'">';
        $header_con .='<input type="submit" id="export-csv"  class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" value="'.getlang('export_csv').'" /> ';
        $header_con .='</form>';


        //$header_con .='<a href="'.base_url().'result/my_pdf" id="more-resultd" class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" >download</a> ';
        //$header_con .='<input type="button" id="export-pdf" onclick="moreresult()" class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" value="Export PDF" /> ';
        //$header_con .='<input type="button" id="export-csv" onclick="moreresult()" class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" value="Export CSV" /> ';
       

        //Result Display 
        $result_display = '';
        $result_display .= '<div id="printableArea" >';
        $result_display .= '<div class="row">';
        $result_display .= '<div class="col-md-12 result-header text-center">';
        if(empty($institute_show_logo)){$result_display .= '<img src="'.$institute_logo_path.'"  alt="institute logo"  >';}
        if(empty($institude_show_name)){$result_display .= '<h3>'.$institude_name.'</h3>';}
        if(empty($institute_show_email)){$result_display .= '<p> <b>'.getlang('email').': </b>'.$institute_email.'</p>';}
        if(empty($institute_show_phone)){$result_display .= '<p> <b>'.getlang('phone').': </b>'.$institute_phone.'</p>';}
        if(empty($institute_show_address)){$result_display .= '<p>'.$institute_address.'</p>';}
        if(empty($institute_show_website)){$result_display .= '<p> <b>'.getlang('website').': </b>'.$institute_website.'</p>';}
        $result_display .= $header_con;
        
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


        $result_display .= '<table  width="100%" class="mark-table "  style="border: 0px;" >';
        $result_display .= '<tr>'; 
        $result_display .= '<td style="border: 0px;padding-bottom: 2px; padding:0;">'; 

        foreach ($exam_ids as $key => $exam_id) {
            
            $exam_name = getSingledata('exam', 'name', 'id', $exam_id);
                    
            
            $result_display .= '<table  width="100%" class="mark-table" id="result-table"  >';
            $result_display .= '<caption><p style="text-align:center;"><b> '.$exam_name.'</b></p></caption>';
            //Head
            $result_display .= '<tr>'; 
            $result_display .= '<th class="center" > '.getlang('subjects').' </th>';
            if(empty($institute_show_highest)){
                $result_display .= '<th class="center" >'.getlang('highest_mark').'</th>';
            }
            
            $result_display .= '<th class="center" >'.getlang('obtain_mark').'</th>';
            $result_display .= '<th class="center" >'.getlang('grade').'</th>';
            if(empty($institute_show_comment)){
                $result_display .= '<th class="center" > '.getlang('comment').' </th>';
            }
            
            $result_display .= '</tr>'; 
            

            //GET SUBJECT LIST
            $subjects = getSingledata('class', 'subjects', 'id', $class_id);
            $subject_list = explode(",", $subjects);
            $total_subject = count($subject_list);

                $tearm_total_mark=0;
                $tearm_total_gp =0;
                foreach ($subject_list as $j=>$subject_id) {

                    // Get Subject Name
                    $subject_name = getSingledata('subjects', 'name', 'id', $subject_id);

                    // Get mark
                    $marks = getMark('mark', $exam_id, $class_id, $subject_id, $student_id, $roll, $year);

                    // Get Comment
                    $comment = getMark('comment', $exam_id, $class_id, $subject_id, $student_id, $roll, $year);

                    // Get Highest mark
                    $highest_marks = getHighestMark('MAX(mark)', $exam_id, $class_id, $subject_id, $year);

                    if(!empty($marks)){
                        $tearm_total_mark += $marks;
                    }
                    
                    //grade system
                    $gp =0;
                    $gpa =0;
                    foreach ($grade_rows as $grade_row) {
                        if ($marks >= $grade_row->mark_from && $marks <= $grade_row->mark_upto){
                            $gp = $grade_row->grade_point;
                            $gpa = $grade_row->name;
                        }
                    }

                    //total tearm gp
                    $tearm_total_gp += $gp;

                    //ignore empty comment
                    if(!empty($comment)){$gp_comment = $comment;}else{$gp_comment ='';}

                    //ignore empty GPA
                    if(!empty($gpa)){$gpa_ok = $gpa;}else{$gpa_ok ='';}
                                                            
                    $result_display .= '<tr>'; 
                    $result_display .= '<td class="text-left">'.$subject_name.'</td>';
                    if(empty($institute_show_highest)){
                        $result_display .= '<td class="text-center">'.$highest_marks.'</td>';
                    }
                    $result_display .= '<td class="text-center">'.$marks.'</td>';
                    $result_display .= '<td class="text-center">'.$gpa_ok.'</td>';
                    if(empty($institute_show_comment)){
                        $result_display .= '<td class="text-center">'.$gp_comment.'</td>';
                    }
                    $result_display .= '</tr>'; 

        } // End Subject foreach

        $total_marks[] = $tearm_total_mark;
        $result_display .= '</table>';  

        //Resultsheet Footer
        $result_display .= '<table  width="100%" class=" none-border-table"  style="border: 0px;margin: 0px 0;" >';
        $result_display .= '<tr>'; 
        $result_display .= '<td class="text-left" style="padding-left:0;padding-top: 15px;"><b>'.getlang('total_marks').' : '.$tearm_total_mark.'</b></td>';
        
        //calculate Tearm GPA
        $tearm_gp = round($tearm_total_gp / $total_subject);
        
        $result_display .= '<td class="text-center" style="padding-top: 15px;text-align:right;"><b> '.getlang("gpa").' : '.$tearm_gp.'</b></td>';
        $result_display .= '</tr>'; 
        $result_display .= '</table>';  

        } // End Exam foreach

        $result_display .= '</td>';
        $result_display .= '</tr>'; 
        $result_display .= '</table>';  
        $result_display .= '</div>';  
        
        echo $result_display;


        }else{
                
            if (empty($roll)) { echo '<p style="color:red;">'.getlang('enter_roll').' </p>';
            }elseif (empty($class_id)) { echo '<p style="color:red;">'.getlang('select_class_result').' </p>';
            }elseif (empty($exam_ids)) { echo '<p style="color:red;">'.getlang('select_exam_result').' </p>';
            }elseif (empty($department_id)) { echo '<p style="color:red;">'.getlang('select_department_result').' </p>';
        }elseif (empty($student_id)) { echo '<p style="color:red;">'.getlang('result_no_found').' </p>';
            }else{ echo '<p style="color:red;">'.getlang('roll_class_exam').' </p>';}

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
     document.getElementById("export-csv").style.visibility = "hidden";
     window.print();
     document.body.innerHTML = originalContents;
     //document.location.reload();
}
 </script>
