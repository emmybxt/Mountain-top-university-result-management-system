<?php

// Get data

$student_roll = $roll;
$student_class = $class_id;
$student_year = $year;
$exam_ids = $exam_ids;

$institude_name = getParam('name');
$institute_email = getParam('email');
$institute_phone = getParam('phone');
$institute_website = getParam('website');
$institute_address = getParam('address');
$institute_logo = getParam('logo_2');

if(empty($institute_logo)){
    $institute_logo_path = 'uploads/logo/avator.png';

}else{
    $institute_logo_path = 'uploads/logo/'.$institute_logo;
}

$student_name = getSingledata('students', 'name', 'roll', $student_roll);
$class_name = getSingledata('class', 'name', 'id', $student_class);

$student_id = getStudentID($roll, $class_id, $year);
$grade_rows = getGradeList();


$total_marks = array();
$total_gp = array();
foreach ($exam_ids as $key => $exam_id) {
            
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

    } // End Subject foreach

    $total_marks[] = $tearm_total_mark;
    $total_gp[] = round($tearm_total_gp / $total_subject);
    
} // End Exam foreach

 

?>

<div class="content-wrapper">
	<section class="content">
        <div class="row">
            <div class="col-md-12">
            	<div class="box">
            		<div class="box-body ">
                        <h1>cirtificate page</h1>
                        <?php var_dump($exam_ids); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>