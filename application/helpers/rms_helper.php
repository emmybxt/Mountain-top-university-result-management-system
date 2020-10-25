<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    
/**
** This function for field builder
**/
function fieldBuilder($type, $field_name, $field_value, $field_label, $required, $v = 0){

    if(empty($required)){
        $required = '';
    }else{
        $required = 'required';
    }
    
    if(!empty($v)){
       $label_class = '';
       $hdiv = '';
       $hdiv_close = '';
    }else{
       $label_class = 'col-sm-4';
       $hdiv = '<div class="col-sm-8">';
       $hdiv_close = '</div>';
    }

    switch ($type) {
        case 'input':
            $output ='<div class="form-group">';
            $output .='<label for="field_id_'.$field_name.'" class=" '.$label_class.' control-label">'.$field_label.'</label>';
            $output .=$hdiv;
            $output .='<input type="text" class="form-control '.$required.'" value="'.$field_value.'" id="field_id_'.$field_name.'" name="'.$field_name.'" >';
            $output .=$hdiv_close;
            $output .='</div>';
        break;

        case 'number':
            $output ='<div class="form-group">';
            $output .='<label for="field_id_'.$field_name.'" class=" '.$label_class.' control-label">'.$field_label.'</label>';
            $output .=$hdiv;
            $output .='<input type="number" class="form-control '.$required.'"  value="'.$field_value.'" id="field_id_'.$field_name.'" name="'.$field_name.'" >';
            $output .=$hdiv_close;
            $output .='</div>';
        break;

        case 'textarea':
            $output ='<div class="form-group">';
            $output .='<label for="field_id_'.$field_name.'" class="col-sm-4 control-label">'.$field_label.'</label>';
            $output .='<div class="col-sm-8">';
            $output .='<textarea class="form-control '.$required.'" rows="3" id="field_id_'.$field_name.'" name="'.$field_name.'">'.$field_value.'</textarea>';
            //$output .='<input type="text" class="form-control '.$required.'" value="'.set_value($field_name, $field_value).'" id="field_id_'.$field_name.'" name="'.$field_name.'" >';
            $output .='</div>';
            $output .='</div>';
        break;

        case 'select':
            $output ='<div class="form-group">';
            $output .='<label for="field_id_'.$field_name.'" class="col-sm-4 control-label">'.$field_label.'</label>';
            $output .='<div class="col-sm-8">';
            $output .= $field_value;
            $output .='</div>';
            $output .='</div>';
        break;

        case 'checkbox':
            $output ='<div class="form-group">';
            $output .='<label for="field_id_'.$field_name.'" class="col-sm-2 control-label">'.$field_label.'</label>';
            $output .='<div class="col-sm-10">';
            $output .='<input type="text" class="form-control '.$required.'" value="'.set_value($field_name, $field_value).'" id="field_id_'.$field_name.'" name="'.$field_name.'" >';
            $output .='</div>';
            $output .='</div>';
        break;

        case 'radio':
            $output ='<div class="form-group">';
            $output .='<label for="field_id_'.$field_name.'" class="col-sm-2 control-label">'.$field_label.'</label>';
            $output .='<div class="col-sm-10">';
            $output .='<input type="text" class="form-control '.$required.'" value="'.set_value($field_name, $field_value).'" id="field_id_'.$field_name.'" name="'.$field_name.'" >';
            $output .='</div>';
            $output .='</div>';
        break;
        
       
    }
    
    return $output;
}


/**
    ** Get System Message
    **/
    function getSystemMessage(){

        $CI =& get_instance();
        $CI->load->helper('form'); 

        $output = '';

        // validation error
        $output .= '<div class="row">';
        $output .= '<div class="col-md-12">';
        $output .= validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); 
        $output .= '</div>';
        $output .= '</div>';
            
        // Error 
        $error = $CI->session->flashdata('error');
        if($error){ 
            $output .= '<div class="alert alert-danger alert-dismissable">';
            $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $output .= $error;                    
            $output .= '</div>';
        }

        // Success
        $success = $CI->session->flashdata('success');
        if($success){ 
            $output .= '<div class="alert alert-success alert-dismissable">';
            $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $output .= $success;                    
            $output .= '</div>';
        } 
        
        // Send
        $send = $CI->session->flashdata('send');
        if($send){
            $output .= '<div class="alert alert-success alert-dismissable">';
            $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $output .= $send;                   
            $output .= '</div>';
        }

        // not send
        $notsend = $CI->session->flashdata('notsend');
        if($notsend){
            $output .= '<div class="alert alert-danger alert-dismissable">';
            $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $output .= $notsend;                     
            $output .= '</div>';
        }

        // unable
        $unable = $CI->session->flashdata('unable');
        if($unable){
            $output .= '<div class="alert alert-danger alert-dismissable">';
            $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $output .= $unable;                     
            $output .= '</div>';
        }

        // invalid
        $invalid = $CI->session->flashdata('invalid');
        if($invalid){
            $output .= '<div class="alert alert-warning alert-dismissable">';
            $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $output .= $invalid;                   
            $output .= '</div>';
        }

        return $output;
    }


/**
** Make PDF Header
**/
function pdfHeader(){

    $style ='

    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/sumoselect.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/custom.css" rel="stylesheet" type="text/css" />
    

    ';

    return $style;
    
}


/**
** Get Menu
**/
function getMenu($role){
    
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('menus');
    $CI->db->order_by("menu_order", "asc");
    $query = $CI->db->get();
    $results = $query->result();

    

    $output = '';
    foreach ($results as $key => $item) {
        $id = $item->id;

        if(!empty(getlang('menu_'.$id, 'menus'))){
            $title =  getlang('menu_'.$id, 'menus');
        }else{
            $title = $item->title;
        }
        
        $link = $item->link;
        $menu_icon = $item->menu_icon;
        $parent = $item->parent;
        $child = $item->child;
        $access = $item->access;
        $access_ids = explode(",",$access);
        $child_ids = explode(",",$child);
        if (in_array($role, $access_ids) && $parent == 0) {
            $output .='<li class="treeview">';
            $output .='<a href="'.base_url().$link.'">';
            $output .='<i class="fa '.$menu_icon.'"></i>';
            $output .='<span>'.$title.'</span>';

            // child item right icon for each main item
            if (!empty($child)) {
                $output .='<i class="fa fa-angle-left pull-right"></i>';
            }

            $output .='</a>';

            // start child item checker
            if (!empty($child)) {
                $output .='<ul class="treeview-menu">';

                foreach ($child_ids as $c => $value) {

                    if(!empty(getlang('menu_'.$value, 'menus'))){
                        $sub_title =  getlang('menu_'.$value, 'menus');
                    }else{
                        $sub_title = getSingledata('menus', 'title', 'id', $value);
                    }

                    
                    $sub_link = getSingledata('menus', 'link', 'id', $value);
                    $sub_menu_icon = getSingledata('menus', 'menu_icon', 'id', $value);

                        $output .='<li>';
                            $output .='<a  href="'.base_url().$sub_link.'">';
                                $output .='<i class="fa '.$sub_menu_icon.'"></i>';
                                $output .='<span>'.$sub_title.'</span>';
                            $output .='</a>';
                        $output .='</li>';
                    
                } // end submenu loop
                $output .='</ul>';
            }// end child checker

            $output .='</li>';
        }else{
            
        }

        
        
    } // end main menu loop


    
    return $output;
}



/**
** Published/ Unpublished
**/
function getStatus($name, $id){
	$list = array(
		'0' => 'Unpublished', 
		'1' => 'Published'
	);

    $output = '<select name="'.$name.'" id="s_'.$name.'" class="form-control" >';
    foreach ($list as $key => $item) {
        if ($key == $id ) {
            $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
        }else{
            $output .= '<option value="'.$key.'">'.$item.'</option>';
        }
    }
    $output .= '</select>';
    return $output;
}





/**
** Published/ Unpublished
**/
function getDirection($name, $id){
    $list = array(
        'ltl' => 'ltl', 
        'rtl' => 'rtl'
    );

    $output = '<select name="'.$name.'" id="s_'.$name.'" class="form-control" >';
    foreach ($list as $key => $item) {
        if ($key == $id ) {
            $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
        }else{
            $output .= '<option value="'.$key.'">'.$item.'</option>';
        }
    }
    $output .= '</select>';
    return $output;
}


/**
** Yes/ No
**/
function getYesNo($name, $id){
    $list = array(
        '0' => 'No', 
        '1' => 'Yes'
    );

    $output = '<select name="'.$name.'" id="s_'.$name.'" class="form-control" >';
    foreach ($list as $key => $item) {
        if ($key == $id ) {
            $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
        }else{
            $output .= '<option value="'.$key.'">'.$item.'</option>';
        }
    }
    $output .= '</select>';
    return $output;
}


/**
** Function for section header
**/
function sectionHeader($title, $sub_title, $icon){
    $output = '<section class="content-header">';
    $output .= '<h1><i class="fa '.$icon.'"></i> '.$title.' <small> '.$sub_title.' </small></h1>';
    $output .= '</section>';
    return $output;
}

/**
** Select single data
**/
function getSingledata($table, $select_field, $where_field, $where_data){
    $CI =& get_instance();
    $CI->db->select($select_field);
    $CI->db->from($table);
    $CI->db->where($where_field, $where_data);
    $query = $CI->db->get();
    $results = $query->row();
    if($results){
        $output = $results->$select_field;
    }else{
        $output = '';
    }
    
    return $output;
}

/**
** Get Student ID by Roll, Class & year
**/
function getStudentID($roll, $class, $year, $department){
    $CI =& get_instance();
    $CI->db->select('id');
    $CI->db->from('students');
    $CI->db->where('roll', $roll);
    $CI->db->where('class', $class);
    $CI->db->where('department', $department);
    $CI->db->where('year', $year);
    $query = $CI->db->get();
    $results = $query->row();
    if($results){
        $output = $results->id;
    }else{
        $output = 0;
    }
    
    return $output;
}

/**
** Get Student Object
**/
function getStudentObject($class, $year, $department){
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('students');
    $CI->db->where('class', $class);
    $CI->db->where('department', $department);
    $CI->db->where('year', $year);
    $query = $CI->db->get();
    $results = $query->result();
    return $results;
}

/**
** Select all data
**/
function getMultipaledata($table, $select_field)
    {
        $CI =& get_instance();
        $CI->db->select($select_field);
        $CI->db->from($table);
        $query = $CI->db->get();
         return $query->result();
    }
/**
** Select all data from fields
** $whereData use for show row.
**/

function getfieldsdata($table, $select_field, $whereData)
{
    $CI =& get_instance();
    $CI->db->select($select_field);
    $CI->db->from($table);
    $CI->db->where($whereData, 1);
    $query = $CI->db->get();
     return $query->result();
}

/**
** Select Configuration
**/
function getParam($select_field){
    $CI =& get_instance();
    $CI->db->select($select_field);
    $CI->db->from('config');
    $CI->db->where('id', 1);
    $query = $CI->db->get();
    $results = $query->row();
    $output = $results->$select_field;
    return $output;
}

/**
** Get Subject List
**/
function getSubjects($ids){

    $subject_ids = explode(",",$ids);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('subjects');
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="subject_name[]" id="s_name" multiple="multiple" class="form-control required subjectfield" >';
    foreach ($results as $key => $item) {
        $id = $item->id;
        
        if (in_array($id, $subject_ids)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }
        
    }
    $output .= '</select>';
    return $output;
}

/**
** Get Option Subject List
**/
function getOptionSubjects($ids){

    $subject_ids = explode(",",$ids);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('subjects');
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="option_subject[]" id="option_subject" multiple="multiple" class="form-control required subjectfield" >';
    foreach ($results as $key => $item) {
        $id = $item->id;
        
        if (in_array($id, $subject_ids)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }
        
    }
    $output .= '</select>';
    return $output;
}

/**
** Get Mark Distribution List
**/
function getMarkDistributionList($ids){

    $mark_distribution_ids = explode(",",$ids);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('mark_distribution');
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="mark_distribution[]" id="mark_distribution" multiple="multiple" class="form-control required mark_distributionfield" >';
    foreach ($results as $key => $item) {
        $id = $item->id;
        
        if (in_array($id, $mark_distribution_ids)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->title.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->title.'</option>';
        }
        
    }
    $output .= '</select>';
    return $output;
}


/**
** Get Class List
**/
function getClassList($ids){

    $class_ids = explode(",",$ids);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('class');
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="class[]" id="class" multiple="multiple" class="form-control required class_field" >';
    foreach ($results as $key => $item) {
        $id = $item->id;
        
        if (in_array($id, $class_ids)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }
        
    }
    $output .= '</select>';
    return $output;
}

/**
** Get getGradeSystem List
**/
function getGradeSystem($ids, $name){

    $cat_ids = explode(",",$ids);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('grade_category');
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="'.$name.'"  class="form-control required " >';
    foreach ($results as $key => $item) {
        $id = $item->id;
        
        if (in_array($id, $cat_ids)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }
        
    }
    $output .= '</select>';
    return $output;
}

/**
** Get result template List
**/
function getResultTemplateList($ids, $name){

    $cat_ids = explode(",",$ids);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('result_template');
    $CI->db->where('status', 1);
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="'.$name.'" class="form-control required " >';
    foreach ($results as $key => $item) {
        $id = $item->id;
        
        if (in_array($id, $cat_ids)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->title.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->title.'</option>';
        }
        
    }
    $output .= '</select>';
    return $output;
}



/**
** Get Fields Type Data
**/
function getFieldType($ids, $field_name){

    $field_type = explode(",",$ids);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('fields_type');
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="'.$field_name.'" id="'.$field_name.'" class="form-control required" >';
    foreach ($results as $key => $item) {
        $id = $item->id;
        
        if (in_array($id, $field_type)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->type.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->type.'</option>';
        }
        
    }
    $output .= '</select>';
    return $output;
}


/**
** Get Fields Section Data
**/
function getFieldSection($ids, $field_name){

    $field_type = explode(",",$ids);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('fields_section');
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="'.$field_name.'" id="'.$field_name.'" class="form-control required" >';
    foreach ($results as $key => $item) {
        $id = $item->id;
        
        if (in_array($id, $field_type)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }
        
    }
    $output .= '</select>';
    return $output;
}


/**
** Get  Language List
**/
function getLanguageList($ids){
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('languages');
    $CI->db->where('published', 0);
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="language" id="language" class="form-control required" >';
    $output .='<option value="0" > Select Language </option>';
    foreach ($results as $key => $item) {
        $id = $item->id;
        if ($id == $ids) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->title.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->title.'</option>';
        }
    }
    $output .= '</select>';
    return $output;
}

/**
** Get  Class List
**/
function getClass($ids){
    $class_ids = explode(",",$ids);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('class');
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="class_name" id="class" class="form-control required" >';
    $output .='<option value="0" > Select Class </option>';
    foreach ($results as $key => $item) {
        $id = $item->id;
        if (in_array($id, $class_ids)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }
    }
    $output .= '</select>';
    return $output;
}

/**
** Get  Class List
**/
function getDepartment($field_name, $ids){
    $department_ids = explode(",",$ids);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('departments');
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="'.$field_name.'" id="department" class="form-control required" >';
    $output .='<option value="0" > Select Department </option>';
    foreach ($results as $key => $item) {
        $id = $item->id;
        if (in_array($id, $department_ids)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->department_name.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->department_name.'</option>';
        }
    }
    $output .= '</select>';
    return $output;
}

/**
* Subject
**/ 
function getSubjectsList($ids){

    $subject_ids = explode(",",$ids);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('subjects');
    $query = $CI->db->get();
    $results = $query->result();

    $output = '<select name="subject_name[]" id="subject"  class="form-control required" >';
    $output .='<option value="0"> Select Subject </option>';
    
    foreach ($results as $key => $item) {
        $id = $item->id;
        if (in_array($id, $subject_ids)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }
        
    }
    $output .= '</select>';
    return $output;
}


/**
* Subject list by class ID
**/ 
function getSubjectsListByClass($ids, $class_id){

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

    //$output = '<script type="text/javascript">jQuery( "#subject" ).change(function() { desplyStudentList(); });</script>';
    $output = '<select name="subject" id="subject"  class="form-control required" >';
    $output .='<option value="0"> Select Subject </option>';
    
    foreach ($subject_array as $key => $item) {
        $subject_name = getSingledata('subjects', 'name', 'id', $item);
        if ($item == $ids) {
            $output .= '<option selected="selected" value="'.$item.'">'.$subject_name.'</option>';
        }else{
            $output .= '<option value="'.$item.'">'.$subject_name.'</option>';
        }
        
    }
    $output .= '</select>';
    return $output;
}

/**
* Get Exam
**/
function getExam($ids, $multiple, $class){

    $exam_ids = explode(",",$ids);
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('exam');
    $query = $CI->db->get();
    $results = $query->result();

    if(!empty($multiple)){
        $multiple_att = 'multiple="multiple"';
        $name = 'name="exam_name[]"';
        $option_first_value = '';
    }else{
        $multiple_att = '';
        $name = 'name="exam_name"';
        $option_first_value ='<option value="0"> Select Exam </option>';
    }

    $output = '<select  id="exam" '.$name.' '.$multiple_att.'  class="form-control required '.$class.'" >';
    $output .= $option_first_value;
    foreach ($results as $key => $item) {
        $id = $item->id;
        if (in_array($id, $exam_ids)) {
            $output .= '<option selected="selected" value="'.$item->id.'">'.$item->name.'</option>';
        }else{
            $output .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }
        
    }
    $output .= '</select>';
    return $output;
}



/**
* Get Grade List
**/
function getGradeList($category_id){
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('exams_grade');
    $CI->db->where('category', $category_id);
    $query = $CI->db->get();
    $results = $query->result();
    return $results;
}

/**
* Get Grade Point
**/
function getGradeValue($category_id, $mark){
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('exams_grade');
    $CI->db->where('category', $category_id);
    $query = $CI->db->get();
    $grade_object = $query->result();

    $grade_point        = 0;
    $grade_point_letter = '';
    $grade_comment      = '';
    foreach ($grade_object as $grade_row) {
        if ($mark >= $grade_row->mark_from && $mark <= $grade_row->mark_upto){
            $grade_point        = $grade_row->grade_point;
            $grade_point_letter = $grade_row->name;
            $grade_comment      = $grade_row->comment;
        }
    }

    $output = array();
    $output['gp']      = $grade_point;
    $output['gpa']     = $grade_point_letter;
    $output['comment'] = $grade_comment;
    return $output;
}

/**
* Get Grade Letter
**/
function getGradeLetter($category_id, $gp){
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('exams_grade');
    $CI->db->where('category', $category_id);
    $query = $CI->db->get();
    $grade_object = $query->result();

    $grade_point_letter = '';
    foreach ($grade_object as $grade_row) {
        if ($gp >= $grade_row->point_from && $gp <= $grade_row->point_to){
            $grade_point_letter = $grade_row->name;
        }
    }
    return $grade_point_letter;
}


/**
 * This function is used to print the content of any data
 */
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * This function used to get the CI instance
 */
if(!function_exists('get_instance'))
{
    function get_instance()
    {
        $CI = &get_instance();
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}

/**
 * This method used to get current browser agent
 */
if(!function_exists('getBrowserAgent'))
{
    function getBrowserAgent()
    {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser())
        {
            $agent = $CI->agent->browser().' '.$CI->agent->version();
        }
        else if ($CI->agent->is_robot())
        {
            $agent = $CI->agent->robot();
        }
        else if ($CI->agent->is_mobile())
        {
            $agent = $CI->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }
}

if(!function_exists('setProtocol'))
{
    function setProtocol()
    {
        $CI = &get_instance();
                    
        $CI->load->library('email');
        
        $config['protocol'] = getParam('protocol');
        $config['mailpath'] = getParam('mail_path');
        $config['smtp_host'] = getParam('smtp_host');
        $config['smtp_port'] = getParam('smtp_port');
        $config['smtp_user'] = getParam('smtp_user');
        $config['smtp_pass'] = getParam('smtp_pass');
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        
        $CI->email->initialize($config);
        
        return $CI;
    }
}

if(!function_exists('emailConfig'))
{
    function emailConfig()
    {
        $CI->load->library('email');
        $config['protocol'] = getParam('protocol');
        $config['smtp_host'] = getParam('smtp_host');
        $config['smtp_port'] = getParam('smtp_port');
        $config['mailpath'] = getParam('mail_path');
        $config['charset'] = 'UTF-8';
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
    }
}

if(!function_exists('resetPasswordEmail'))
{
    function resetPasswordEmail($detail)
    {
        $data["data"] = $detail;
        // pre($detail);
        // die;

        $mail_from = getParam('email_form');
        $from_name = getParam('from_name');
        
        $CI = setProtocol();    
        $CI->email->from($mail_from, $from_name);
        $CI->email->subject("Reset Password");
        $CI->email->message($CI->load->view('email/resetPassword', $data, TRUE));
        $CI->email->to($detail["email"]);
        $status = $CI->email->send();
        
        return $status;
    }
}

if(!function_exists('setFlashData'))
{
    function setFlashData($status, $flashMsg)
    {
        $CI = get_instance();
        $CI->session->set_flashdata($status, $flashMsg);
    }
}




/**
** Get Mark
**/
function getMark($select_field, $exam_id, $class_id, $subject_id, $student_id, $department_id, $year){
    $CI =& get_instance();
    $CI->db->select($select_field);
    $CI->db->from('exam_marks');
    $CI->db->where('exam_id', $exam_id);
    $CI->db->where('class_id', $class_id);
    $CI->db->where('subject_id', $subject_id);
    $CI->db->where('student_id', $student_id);
    $CI->db->where('department_id', $department_id);
    $CI->db->where('year', $year);
    $query = $CI->db->get();
    $results = $query->row();
    if ($results) {
        $output = $results->$select_field;
    }else{
        $output = '';
    }
    
    return $output;
}


/**
** Get Certificate mark
**/
function getCertificateMark($select_field, $exam_id, $class_id, $department_id, $year, $student_id){
    $CI =& get_instance();
    $CI->db->select($select_field);
    $CI->db->from('exam_rank_marks');
    $CI->db->where('exam_id', $exam_id);
    $CI->db->where('class_id', $class_id);
    $CI->db->where('department_id', $department_id);
    $CI->db->where('year', $year);
    $CI->db->where('student_id', $student_id);
    $query = $CI->db->get();
    $results = $query->row();
    if ($results) {
        $output = $results->$select_field;
    }else{
        $output = '';
    }
    
    return $output;
}


/**
** Get Highest Mark
**/
function getHighestMark($select_field, $exam_id, $class_id, $department_id, $subject_id, $year){
    $CI =& get_instance();
    $CI->db->select($select_field);
    $CI->db->from('exam_marks');
    $CI->db->where('exam_id', $exam_id);
    $CI->db->where('class_id', $class_id);
    $CI->db->where('department_id', $department_id);
    $CI->db->where('subject_id', $subject_id);
    $CI->db->where('year', $year);
    $query = $CI->db->get();
    $results = $query->row();
    if ($results) {
        $output = $results->$select_field;
    }else{
        $output = '';
    }
    
    return $output;
}


/**
** Get Year List
**/
function yearList($name, $year_id){
    $year_start = getParam('year_start');
    $year_end = getParam('year_end');
    $year_html ='<select id="id_'.$name.'" class="form-control" name="'.$name.'" required="required">';
    for($i = $year_start; $i <= $year_end; $i++) {
            if(!empty($year_id)){
                $isCurrentY = ($i == $year_id) ? 'true': 'false';
            }else{
            	$isCurrentY = ($i == $i) ? 'true': 'false';
                $isCurrentY = ($i == intVal(date("Y"))) ? 'true': 'false';
            }

        $year_html .='<option value="'.$i.'"';
        if($isCurrentY=="true"){ $year_html .='selected="selected"';}else{ } 
        $year_html .='>'.$i.'</option>';
    }
    $year_html .='</select>';
    return $year_html;
}


/**
** Get Year List for configuration
**/
function yearListsystem($name, $year_id, $start, $end){
    $year_html ='<select id="id_'.$name.'" class="form-control" name="'.$name.'" required="required">';
    for($i = $start; $i <= $end; $i++) {
            if(!empty($year_id)){ 
                $isCurrentY = ($i == $year_id) ? 'true': 'false';
            }else{
                $isCurrentY = ($i == $i) ? 'true': 'false';
                $isCurrentY = ($i == intVal(date("Y"))) ? 'true': 'false';
            }

        $year_html .='<option value="'.$i.'"';
        if($isCurrentY=="true"){ $year_html .='selected="selected"';}else{ } 
        $year_html .='>'.$i.'</option>';
    }
    $year_html .='</select>';
    return $year_html;
}



/**
** get flug list
**/
function getFlags($name, $id){
    $list = array(
        'af' => 'af','af_za' => 'af_za','al' => 'al','ar' => 'ar','ar_aa' => 'ar','at' => 'at','az' => 'az','az_az' => 'az_az','be' => 'be','be_by' => 'be_by','belg' => 'belg','bg' => 'bg','bg_bg' => 'bg_bg','bn' => 'bn','bn_bd' => 'bn_bd','br' => 'br','br_fr' => 'br_fr','bs' => 'bs','bs_ba' => 'bs_ba','ca' => 'ca','ca_es' => 'ca_es','cbk_iq' => 'cbk_iq','ch' => 'ch','cs' => 'cs','cs_cz' => 'cs_cz','cy' => 'cy','cy_gb' => 'cy_gb','cz' => 'cz','da' => 'da','da_dk' => 'da_dk','de' => 'de','de_ch' => 'de_ch','de_de' => 'de_de','de_li' => 'de_li','de_lu' => 'de_lu','dk' => 'dk','dz_bt' => 'dz_bt','el' => 'el','el_gr' => 'el_gr','en' => 'en','en_au' => 'en_au','en_ca' => 'en_ca','en_gb' => 'en_gb','en_nz' => 'en_nz','en_us' => 'en_us','eo' => 'eo','eo_xx' => 'eo_xx','es' => 'es','es_co' => 'es_co','es_es' => 'es_es','et' => 'et','et_ee' => 'et_ee','eu_es' => 'eu_es','fa' => 'fa','fi' => 'fi','fi_fi' => 'fi_fi','fr' => 'fr','fr_ca' => 'fr_ca','fr_fr' => 'fr_fr','ga_ie' => 'ga_ie','gd' => 'gd','gd_gb' => 'gd_gb','gl' => 'gl','he' => 'he','he_il' => 'he_il','hi' => 'hi','hk' => 'hk','hi_in' => 'hi_in','hk' => 'hk','hk_hk' => 'hk_hk','hr' => 'hr','hr_hr' => 'hr_hr','hu' => 'hu','hu_hu' => 'hu_hu','hy' => 'hy','hy_am' => 'hy_am','id' => 'id','id_id' => 'id_id','is' => 'is','is_is' => 'is_is','it' => 'it','it_it' => 'it_it','ja' => 'ja','ja_jp' => 'ja_jp','ka' => 'ka','ka_ge' => 'ka_ge','km' => 'km','km_kh' => 'km_kh','ko' => 'ko','ko_kr' => 'ko_kr','ku' => 'ku','lo' => 'lo','lo_la' => 'lo_la','lt' => 'lt','lt_lt' => 'lt_lt','lv' => 'lv','lv_lv' => 'lv_lv','mk' => 'mk','mk_mk' => 'mk_mk','mn' => 'mn','mn_mn' => 'mn_mn','ms_my' => 'ms_my','nb_no' => 'nb_no','nl' => 'nl','nl_be' => 'nl_be','nl_nl' => 'nl_nl','nn_no' => 'nn_no','no' => 'no','pl' => 'pl','pl_pl' => 'pl_pl','prs_af' => 'prs_af','ps' => 'ps','ps_af' => 'ps_af','pt' => 'pt','pt_br' => 'pt_br','pt_pt' => 'pt_pt','ro' => 'ro','ro_ro' => 'ro_ro','ru' => 'ru','ru_ru' => 'ru_ru','si' => 'si','sk' => 'sk','sk_sk' => 'sk_sk','sl' => 'sl','sl_si' => 'sl_si','sq_al' => 'sq_al','sr' => 'sr','sr_rs' => 'sr_rs','sr_yu' => 'sr_yu','srp_me' => 'srp_me','sv' => 'sv','sv_se' => 'sv_se','sw' => 'sw','sw_ke' => 'sw_ke','sy' => 'sy','sy_iq' => 'sy_iq','ta' => 'ta','ta_in' => 'ta_in','th' => 'th','th_th' => 'th_th','tk_tm' => 'tk_tm','tr' => 'tr','tr_tr' => 'tr_tr','tw' => 'tw','ug_cn' => 'ug_cn','uk' => 'uk','uk_ua' => 'uk_ua','ur' => 'ur','ur_pk' => 'ur_pk','us' => 'us','uz' => 'uz','uz_uz' => 'uz_uz','vi' => 'vi','vi_vn' => 'vi_vn','zh' => 'zh','zh_cn' => 'zh_cn','zh_tw' => 'zh_tw'
    );
    
    $output = '<select name="'.$name.'" id="s_'.$name.'" class="form-control" >';
    foreach ($list as $key => $item) {
        if ($key == $id ) {
            $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
        }else{
            $output .= '<option value="'.$key.'">'.$item.'</option>';
        }
    }
    $output .= '</select>';
    return $output;
}
/**
** Get Lang
**/
function getlang($name, $field_name = 'data'){
    // Get default language
        $lang_id = getParam('language');
        $lang_param = getSingledata('languages', $field_name, 'id', $lang_id);
        $param_data = json_decode($lang_param,true);

        if(!empty($param_data[$name][0])){
            $output = $param_data[$name][0];
        }else{
            $output = '';
        }
 
    
    return $output;
}

/**
** Param data preview check-up for language field
**/
function pdchecker($param_data, $field){
    if(!empty($param_data[$field][0])){
        $output = $param_data[$field][0];
    }else{
        $output = '';
    }
    return $output;
}

function langField($param, $field, $label, $field_name = 'params'){
    $output = '<div class="col-md-3">'.fieldBuilder('input',  $field_name.'['.$field.'][]', pdchecker($param, $field), $label, '', 1).'</div>';
    return $output;
}


/**
** Use for label
**/
 function getlabel($label_name){
    $output = '<div class="col-md-12 label" style=" margin:20px 0;">';
    $output .= '<p style="padding:10px; background:#ccc; color:#000;margin:0; font-size:20px;">';
    $output .= $label_name;
    $output .='</p>';
    $output .='</div>';
    return $output;
 }

/**
** get flug list
**/
function gettheme($name, $id){
    $list = array(
        'skin-blue' => 'Skin Blue',
        'skin-blue-light' => 'Skin blue light',
        'skin-yellow' => 'Skin yellow',
        'skin-yellow-light' => 'Skin yellow light',
        'skin-green' => 'Skin green',
        'skin-green-light' => 'Skin green light',
        'skin-purple' => 'Skin purple',
        'skin-purple-light' => 'Skin purple light',
        'skin-red' => 'Skin red',
        'skin-red-light' => 'Skin red light',
        'skin-black' => 'Skin black',
        'skin-black-light' => 'Skin black light'
    );
    
    $output = '<select name="'.$name.'" id="s_'.$name.'" class="form-control" >';
    foreach ($list as $key => $item) {
        if ($key == $id ) {
            $output .= '<option selected="selected" value="'.$key.'">'.$item.'</option>';
        }else{
            $output .= '<option value="'.$key.'">'.$item.'</option>';
        }
    }
    $output .= '</select>';
    return $output;
}

/**
** Get Field Section ID
**/


function getFieldSectionID($name){
    $CI =& get_instance();
    $CI->db->select('id');
    $CI->db->from('fields_section');
    $CI->db->where('name', $name);
    $query = $CI->db->get();
    $results = $query->row();
    if ($results) {
        $output = $results->id;
    }else{
        $output = '';
    }
    
    return $output;
}

/**
** Get Fields list by section id
**/

function getFieldList($sid){
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('fields');
    $CI->db->where('section', $sid);
    $CI->db->where('published', 1);
    $CI->db->order_by("field_order", "asc");
    $query = $CI->db->get();
    return $query->result();
}

function getFieldOption($fid, $sid, $type){

    $CI =& get_instance();
    $CI->db->select('option_param');
    $CI->db->from('fields');
    $CI->db->where('id', $fid);
    $CI->db->where('section', $sid);
    $CI->db->where('type', $type);
    $query = $CI->db->get();
    $results = $query->row();
    $output = $results->option_param;
    return $output;

}


/**
** Show field
**/ 

function fieldshow($fid, $sid, $panel_id, $label, $type, $required){

    if(!empty($panel_id) && !empty($fid) && !empty($sid)){
        $CI =& get_instance();
        $CI->db->select('data');
        $CI->db->from('fields_data');
        $CI->db->where('fid', $fid);
        $CI->db->where('sid', $sid);
        $CI->db->where('panel_id', $panel_id);
        $query = $CI->db->get();
        $results = $query->row();
        $field_value = $results->data;
    }else{
        $field_value ='';
    }

    if(empty($required)){
        $required = '';
    }else{
        $required = 'required';
    }

    $field_name ='field_'.$fid;
    
    
    $label_class = 'col-sm-4';
    $hdiv = '<div class="col-sm-8">';
    $hdiv_close = '</div>';


    if ($type == 1) {
        $output ='<div class="form-group">';
        $output .='<label for="field_id_'.$field_name.'" class=" '.$label_class.' control-label">'.$label.'</label>';
        $output .=$hdiv;
        $output .='<input type="text" class="form-control '.$required.'" value="'.$field_value.'" id="'.$field_name.'" name="'.$field_name.'" >';
        $output .=$hdiv_close;
        $output .='</div>';
    }

    if ($type == 2) {
        $output ='<div class="form-group">';
        $output .='<label for="field_id_'.$field_name.'" class="'.$label_class.' control-label">'.$label.'</label>';
        $output .=$hdiv;
        $output .='<textarea class="form-control '.$required.'" rows="3" id="'.$field_name.'" name="'.$field_name.'">'.$field_value.'</textarea>';
        $output .=$hdiv_close;
        $output .='</div>';
    }

    //Check Box
    if($type==3){
      //get option value

        $output ='<div class="form-group">';
        $output .='<label for="'.$field_name.'" class=" '.$label_class.' control-label">'.$label.'</label>';
        $output .=$hdiv;


        $check_box_option = getFieldOption($fid, $sid, $type);
        $check_box_option_values = explode(",",$check_box_option);
       
            $key =0;
            foreach($check_box_option_values as $option){
            $key++;
            $options = explode("=",$option);
            $option_value = $options[0];
            $option_name = $options[1];
                if (in_array($option_value, explode(",",$value))) {
                    $checked_code ='checked="checked"';
                }else{
                   $checked_code ='';
                }
                 
                $output .= '<label class="custom_checkbox" ><input type="checkbox"  class=" "  '.$checked_code.' name="'.$field_name.'[]" id="'.$fid.'_'.$key.'"  value="'.$option_value.'"> ' .$option_name. ' </label>';
            }
            $output .=$hdiv_close;
        $output .='</div>';
    }

    /**
    ** Radio Box
    **/

    if($type == 4){
      //get option value
        $radio_box_option = getFieldOption($fid, $sid, $type);
        $radio_option_values = explode(",",$radio_box_option);
        $output ='<div class="form-group">';
        $output .='<label for="'.$field_name.'" class=" '.$label_class.' control-label">'.$label.'</label>';
        $output .=$hdiv;
        
        // if($required==1){
        // $input .= '<input type="hidden" name="'.$field_input_name.'_check"  value="'.$value.'" id="jform_'.$fid.'" class="'.$required_class.' " '.$required_code.' />';
        // $onclick_radio =' onclick="changeRadio(this.value,\'jform_'.$fid.'\')"';
        // }else{
        // $onclick_radio ='';
        // }
        
        foreach($radio_option_values as $radio_option){
         $radio_options = explode("=",$radio_option);
         $roption_value = $radio_options[0];
         $roption_name = $radio_options[1];
        if (in_array($roption_value, explode(",",$value))) {
            $checked_code ='checked="checked"';
        }else{
           $checked_code ='';
         }
         
         $output .= '<label class="custom_checkbox" > <input type="radio"   class=" "  '.$checked_code.' name="'.$field_name.'"  value="'.$roption_value.'">   ' .$roption_name. ' </label>';
        }
        $output .=$hdiv_close;
        $output .='</div>';
    }

    /**
    ** Select Box
    **/

    if ($type == 5) {
        $output ='<div class="form-group">';
        $output .='<label for="'.$field_name.'" class=" '.$label_class.' control-label">'.$label.'</label>';
        $output .=$hdiv;

        $select_box_option = getFieldOption($fid, $sid, $type);
        
        $select_option_values = explode(",",$select_box_option);
        
        $output .= '<select  id="'.$field_name.'" class="form-control" name="'.$field_name.'" >';
        
        $output .='<option value="0" >'.$label.'</option>';
        foreach ($select_option_values as $row) {
            $select_options = explode("=",$row);
            $soption_value = $select_options[0];
            $soption_name = $select_options[1];

            // if ($soption_value == $id ) {
            //     $output .= '<option selected="selected" value="'.$soption_value.'">'.$soption_name.'</option>';
            // }else{
            //     $output .= '<option value="'.$soption_value.'">'.$soption_name.'</option>';
            // }


            $output .= '<option value="'.$soption_value.'">'.$soption_name.'</option>';
        }
        $output .= '</select>';
        
        $output .=$hdiv_close;
        $output .='</div>';
    }

    if ($type == 6) {
       
        $output ='<div class="form-group">';
        $output .='<label for="'.$field_name.'" class=" '.$label_class.' control-label">'.$label.'</label>';
        $output .=$hdiv;
        $output .='<input type="select" class=" form-control datepicker '.$required.'" value="" id="'.$field_name.'" name="'.$field_name.'" >';
        $output .=$hdiv_close;
        $output .='</div>';
    }



    return $output;
}



/**
** Save Custom fields data
**/

 function saveFields($fid, $type, $sid, $field_data, $student_id, $old_id){
    
    $customFieldInfo = array(
        'fid'=> $fid, 
        'sid'=> $sid, 
        'data'=> $field_data,  
        'panel_id'=>$student_id
    );

    $CI =& get_instance();
        
    // Query for new data
    if(empty($old_id)){
        $CI->db->insert('fields_data', $customFieldInfo);
        $insert_id = $CI->db->insert_id();
        
    }else{
        // Query for update 
        $CI->db->where('id', $old_id);
        $CI->db->update('fields_data', $customFieldInfo);
    }

 

 }



    /**
    ** Get Class Object
    **/
    function getClassObject(){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('class');
        $query = $CI->db->get();
        return $query->result();
    }

    /**
    ** Get Grade Category Object
    **/
    function getGradeCategoryObject(){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('grade_category');
        $query = $CI->db->get();
        return $query->result();
    }

    /**
    ** Get Department Object
    **/
    function getDepartmentObject(){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('departments');
        $query = $CI->db->get();
        return $query->result();
    }


    /**
    ** Get exit data
    **/
    function getExitData($field, $class_id, $subject_id, $department_id, $student_id, $exam_id, $mark_id, $mark_distribution_id, $year){
        $CI =& get_instance();
        $CI->db->select($field);
        $CI->db->from('mark_distribution_values');
        $CI->db->where('class_id', $class_id);
        $CI->db->where('department_id', $department_id);
        $CI->db->where('student_id', $student_id);
        $CI->db->where('subject_id', $subject_id);
        $CI->db->where('exam_id', $exam_id);
        $CI->db->where('mark_distribution_id', $mark_distribution_id);
        $CI->db->where('year', $year);
        if(!empty($mark_id)){
            $CI->db->where('mark_id', $mark_id);
        }
        $query   = $CI->db->get();
        $results = $query->row();
        if($results){
            $output = $results->$field;
        }else{
            $output = 0;
        }
        return $output;
    }

    /**
    ** Get exit mark
    **/
    function getExitMark($student_id, $subject_id, $class_id, $exam_id, $year, $department){
        $CI =& get_instance();
        $CI->db->select('id');
        $CI->db->from('exam_marks');
        $CI->db->where('student_id', $student_id);
        $CI->db->where('exam_id', $exam_id);
        $CI->db->where('class_id', $class_id);
        $CI->db->where('department_id', $department);
        $CI->db->where('year', $year);
        $CI->db->where('subject_id', $subject_id);
        $query   = $CI->db->get();
        $results = $query->row();
        if($results){
            $output = $results->id;
        }else{
            $output = 0;
        }
        return $output;
    }



    /**
    ** Get Update Rank
    **/
    function getUpdateRank($exam_id, $class_id, $department_id, $year, $student_id){
        $CI =& get_instance();

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

        $exam_mark = array();
        $exam_gp = array();
        foreach ($subject_array as $key => $subject_id) {
            $marks = getMark('total_mark', $exam_id, $class_id, $subject_id, $student_id, $department_id, $year);
            $gp    = getMark('gp', $exam_id, $class_id, $subject_id, $student_id, $department_id, $year);
            if(!empty($marks)){
                $exam_mark[] = $marks;
            }
            
            if(!empty($gp)){
                $exam_gp[] = $gp;
            }
            
        }

        // total mark
        $total_mark = array_sum($exam_mark);

        // total gp
        $total_gp = array_sum($exam_gp);
        $final_gp = round($total_gp / $total_subject);

        $rank_id = getExitRank('id', $exam_id, $class_id, $department_id, $year, $student_id);

        $exam_rank_data = array(
            'exam_id'         => $exam_id, 
            'class_id'        => $class_id, 
            'department_id'   => $department_id, 
            'year'            => $year, 
            'student_id'      => $student_id,
            'total_mark'      => $total_mark, 
            'gp'              => $final_gp
        );

        if(!empty($rank_id)){
            // get update data
            $CI->db->where('id', $rank_id);
            $CI->db->update('exam_rank_marks', $exam_rank_data);
        }else{
            // get insert data
            $CI->db->trans_start();
            $CI->db->insert('exam_rank_marks', $exam_rank_data);
            $insert_id = $CI->db->insert_id();
            $CI->db->trans_complete();
        }

        if(!empty($total_mark)){
            getFixRank_byDepartment($exam_id, $class_id, $department_id, $year);
            getFixRank_byClass($exam_id, $class_id, $year);
            getFixRank_byExam($exam_id, $year);
        }
        
        
        return true;
    }

    /**
    ** Get exit rank data
    **/
    function getExitRank($field, $exam_id, $class_id, $department_id, $year, $student_id){
        $CI =& get_instance();
        $CI->db->select($field);
        $CI->db->from('exam_rank_marks');
        $CI->db->where('exam_id', $exam_id);
        $CI->db->where('class_id', $class_id);
        $CI->db->where('department_id', $department_id);
        $CI->db->where('year', $year);
        $CI->db->where('student_id', $student_id);
        $query   = $CI->db->get();
        $results = $query->row();
        if($results){
            $output = $results->$field;
        }else{
            $output = 0;
        }
        return $output;
    }

    /**
    ** Get fix rank by department
    **/
    function getFixRank_byDepartment($exam_id, $class_id, $department_id, $year){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('exam_rank_marks');
        $CI->db->where('exam_id', $exam_id);
        $CI->db->where('class_id', $class_id);
        $CI->db->where('department_id', $department_id);
        $CI->db->where('year', $year);
        $CI->db->order_by("total_mark desc, gp desc");
        $query   = $CI->db->get();
        $results = $query->result();
        $total = count($results);
        foreach ($results as $key => $item) {
            $exam_rank_data = array(
                'department_position'         => ($key+1)
            );
            $CI->db->where('id', $item->id);
            $CI->db->update('exam_rank_marks', $exam_rank_data);
        }
        return true;
    }

    /**
    ** Get fix rank by class
    **/
    function getFixRank_byClass($exam_id, $class_id, $year){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('exam_rank_marks');
        $CI->db->where('exam_id', $exam_id);
        $CI->db->where('class_id', $class_id);
        $CI->db->where('year', $year);
        $CI->db->order_by("total_mark desc, gp desc");
        $query   = $CI->db->get();
        $results = $query->result();
        $total = count($results);
        foreach ($results as $key => $item) {
            $exam_rank_data = array(
                'class_position'         => ($key+1)
            );
            $CI->db->where('id', $item->id);
            $CI->db->update('exam_rank_marks', $exam_rank_data);
        }
        return true;
    }

    /**
    ** Get fix rank by exam
    **/
    function getFixRank_byExam($exam_id, $year){
        $CI =& get_instance();
        $CI->db->select('*');
        $CI->db->from('exam_rank_marks');
        $CI->db->where('exam_id', $exam_id);
        $CI->db->where('year', $year);
        $CI->db->order_by("total_mark desc, gp desc");
        $query   = $CI->db->get();
        $results = $query->result();
        $total = count($results);
        foreach ($results as $key => $item) {
            $exam_rank_data = array(
                'exam_position'         => ($key+1)
            );
            $CI->db->where('id', $item->id);
            $CI->db->update('exam_rank_marks', $exam_rank_data);
        }
        return true;
    }

    /**
    ** Get total student in department
    **/
    function getStudentInDepartment($exam_id, $class_id, $department_id, $year){
        $CI =& get_instance();
        $CI->db->select('id');
        $CI->db->from('exam_rank_marks');
        $CI->db->where('class_id', $class_id);
        $CI->db->where('department_id', $department_id);
        $CI->db->where('year', $year);
        $CI->db->where('exam_id', $exam_id);
        $query   = $CI->db->get();
        $results = $query->num_rows();
        return $results;
    }

    /**
    ** Get total student in class
    **/
    function getStudentInclass($exam_id, $class_id, $year){
        $CI =& get_instance();
        $CI->db->select('id');
        $CI->db->from('exam_rank_marks');
        $CI->db->where('class_id', $class_id);
        $CI->db->where('year', $year);
        $CI->db->where('exam_id', $exam_id);
        $query   = $CI->db->get();
        $results = $query->num_rows();
        return $results;
    }

    /**
    ** Get total student in exam
    **/
    function getStudentInexam($exam_id, $year){
        $CI =& get_instance();
        $CI->db->select('id');
        $CI->db->from('exam_rank_marks');
        $CI->db->where('year', $year);
        $CI->db->where('exam_id', $exam_id);
        $query   = $CI->db->get();
        $results = $query->num_rows();
        return $results;
    }

    
    

?>