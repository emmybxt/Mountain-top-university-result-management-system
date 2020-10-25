<?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

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
  
    $class_id       = $class_id;
    $department_id  = $department;
    $exam_id        = $exam_ids;
    $year           = $year;
    $student_object = getStudentObject($class_id, $year, $department_id);
 
?>
<div class="content-wrapper mark-page">
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body" >
      <?php 
        

        

        if(!empty($class_id) && !empty($exam_id) && !empty($department_id)){

            $onclick_link ="'printableArea'";
            $header_con ='<input type="button" id="print" onclick="printDiv('.$onclick_link.')" class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" value="'.getlang('print').'" />';
            $header_con .='<a href="'.base_url().'tabulation" id="more-result" class="btn btn-small btn-primary"  style="border: none;margin-left: 10px;" >More Sheet</a> ';

           //Result Display 
            $result_display = '';
            $result_display .= '<div id="printableArea" >';
            $result_display .= '<div class="row">';
            $result_display .= '<div class="col-md-12 result-header text-center">';
            if(!empty($institute_show_logo)){$result_display .= '<img src="'.$institute_logo_path.'"  alt="institute logo" width="300px">';}
            if(!empty($institude_show_name)){$result_display .= '<h3>'.$institude_name.'</h3>';}
            if(!empty($institute_show_address)){$result_display .= '<p>'.$institute_address.'</p>';}
            if(!empty($institute_show_phone)){$result_display .= '<p> <b>'.getlang('phone').': </b>'.$institute_phone.'</p>';}
            if(!empty($institute_show_email)){$result_display .= '<p> <b>'.getlang('email').': </b>'.$institute_email.'</p>';}
            if(!empty($institute_show_website)){$result_display .= '<p> <b>'.getlang('website').': </b>'.$institute_website.'</p>';}
            $result_display .= $header_con;
            $result_display .= '<h4> '.getlang('table_tabulation_sheet').'</h4>';
            
            $result_display .= '</div>';
            $result_display .= '</div>';

            // Get exam data
            $exam_name       = getSingledata('exam', 'name', 'id', $exam_id);
            $exam_param      = getSingledata('exam', 'param', 'id', $exam_id);
            $exam_param_data = json_decode($exam_param,true);

            $result_display .= '<table  width="100%" class="mark-table" id="result-table"  >';
            $result_display .= '<caption><p style="text-align:center;"><b> '.$exam_name.'</b></p></caption>';
            //Head
            $result_display .= '<tr>'; 
            $result_display .= '<th class="center" width="100px" >'.getlang('table_student_roll').'</th>';
            $result_display .= '<th class="center" >'.getlang('table_student_name').'</th>';
            $result_display .= '<th class="center" >'.getlang('table_total_mark').'</th>';
            $result_display .= '<th class="center" >'.getlang('table_gpa').'</th>';
            $result_display .= '<th class="center" width="100px" >'.getlang('letter_grade').'</th>';
            $result_display .= '</tr>'; 

           foreach ($student_object as $key => $student) {
                $student_id = $student->id;

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

                $exam_total_mark = array();
                $exam_total_gp = array();
                foreach ($subject_array as $j=>$subject_id) {

                    // Get mark
                    $marks = getMark('total_mark', $exam_id, $class_id, $subject_id, $student->id, $department_id, $year);
                    $gp = getMark('gp', $exam_id, $class_id, $subject_id, $student->id, $department_id, $year);

                    if(!empty($marks)){
                        $exam_total_mark[] = $marks;
                    }
                    
                    if(!empty($gp)){
                        $exam_total_gp[] = $gp;
                    }

                } // End Subject foreach

                $exam_total_mark_value = array_sum($exam_total_mark);
                $exam_total_gp_value = array_sum($exam_total_gp);

                //calculate Tearm GPA
                $tearm_gp = round(($exam_total_gp_value / $total_subject), 2);

                $letter_grade = getGradeLetter(1, $tearm_gp);

                $result_display .= '<tr>'; 
                $result_display .= '<td class="text-center" >'.$student->roll.'</td>';
                $result_display .= '<td class="text-left" >'.$student->name.'</td>';
                $result_display .= '<td class="text-center" >'.$exam_total_mark_value.'</td>';
                $result_display .= '<td class="text-center" >'.$tearm_gp.'</td>';
                $result_display .= '<td class="text-center" >'.$letter_grade.'</td>';
                $result_display .= '</tr>'; 
           }

           $result_display .= '</table>';  

           $result_display .= '</div>';  
           echo $result_display;
        }else{
                
            if (empty($class_id)) { echo '<p style="color:red;">'.getlang('select_class_result').' </p>';
            }elseif (empty($exam_id)) { echo '<p style="color:red;">'.getlang('select_exam_result').' </p>';
            }elseif (empty($department_id)) { echo '<p style="color:red;">'.getlang('select_department_result').' </p>';
            }else{ echo '<p style="color:red;">'.getlang('roll_class_exam').' </p>';}

        }
      ?>
    </div>
    </div>
      </div>
    </div>
  </section>
</div>

<form action="<?php echo base_url() ?>tabulation/details" method="post" >
    <input type="hidden" name="class_name" value="<?php echo $class_id; ?>" />
    <input type="hidden" name="department" value="<?php echo $department_id; ?>" />
    <input type="hidden" name="exam_name" value="<?php echo $exam_id; ?>" />
    <input type="hidden" name="year" value="<?php echo $year; ?>" />
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
    
</form>

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
