<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Students_model extends CI_Model
{
    /**
    ** Get Student Info
    **/
    function getStudentInfo($id)
    {
        $this->db->select('*');
        $this->db->from('students');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }




    /**
    ** Get Listing Count
    **/
    function studentsListingCount($searchText = '', $class_value, $department_value, $year_value)
    {
        $this->db->select('*');
        $this->db->from('students');
        if(!empty($searchText)) {
            $likeCriteria = "(roll  LIKE '%".$searchText."%'
                            OR  name  LIKE '%".$searchText."%'
                            OR  phone  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        // Filter by class 
        if(!empty($class_value)){
            $this->db->where('class', $class_value);
        }

        // Filter by department 
        if(!empty($department_value)){
            $this->db->where('department', $department_value);
        }

        // Filter by year 
        if(!empty($year_value)){
            $this->db->where('year', $year_value);
        }

        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
    ** Get listing
    **/
    function studentsListing($searchText = '', $class_value, $department_value, $year_value, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('students');
        if(!empty($searchText)) {
            $likeCriteria = "(roll  LIKE '%".$searchText."%'
                            OR  name  LIKE '%".$searchText."%'
                            OR  phone  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        // Filter by class 
        if(!empty($class_value)){
            $this->db->where('class', $class_value);
        }

        // Filter by department 
        if(!empty($department_value)){
            $this->db->where('department', $department_value);
        }

        // Filter by year 
        if(!empty($year_value)){
            $this->db->where('year', $year_value);
        }


        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
   
    
    /**
    ** Get Insert Query
    **/
    function addNewStudents($studentsInfo)
    {
        // get student query
        $this->db->insert('students', $studentsInfo);
        $student_id = $this->db->insert_id();

        //Setting Custom Field Data
        $sid = getFieldSectionID('student');
        
        $fields = getFieldList($sid);
        $total_field = count($fields);

        foreach($fields as $field){
            $fid = $field->id;
            $sid = $sid;
            $field_input_name ='field_'.$fid;
            $field_data = $this->input->post($field_input_name);
            $student_id = $student_id;
            $type = $field->type;
            saveFields($fid, $type, $sid, $field_data, $student_id,'');
        }

        return TRUE;
    }


    /**
    ** Get Update Query
    **/
    function editStudent($studentInfo, $id)
    {

        $this->db->where('id', $id);
        $this->db->update('students', $studentInfo);

        //Setting Custom Field Data
        $sid = getFieldSectionID('student');
        
        $fields = getFieldList($sid);
        $total_field = count($fields);

        foreach($fields as $field){
            $fid = $field->id;
            $sid = $sid;
            $field_input_name ='field_'.$fid;
            $field_data = $this->input->post($field_input_name);
            $student_id = $id;
            $type = $field->type;

            $this->db->FROM('fields_data');
            $this->db->SELECT('id');
            $this->db->where('fid',$fid);
            $this->db->where('sid',$sid);
            $this->db->where('panel_id',$student_id);
            $query_result=$this->db->get();
            $exit_ids = $query_result->row();
            $old_id = $exit_ids->id;

            saveFields($fid, $type, $sid, $field_data, $student_id,$old_id);
        }

        return TRUE;
    }

    /**
    ** Get Delete Query
    **/
    function deleteStudent($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('students');
        return TRUE;
    }

    /**
    ** Get View info
    **/
    function viewStudent($id)
    {
        $this->db->SELECT('*');
        $this->db->FROM('students');
        $this->db->where('id',$id);
        $query_result=$this->db->get();
        $query=$query_result->row();
        return $query;
    }
    

}

  