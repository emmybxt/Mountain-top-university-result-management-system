<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mark_model extends CI_Model
{


    /**
     * This function used to get information by id
     * @param number $id : This is id
     * @return array $result : This is information
     */
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('class');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    function getStudents($class, $department)
    {
        $this->db->select('*');
        $this->db->from('students');
        $this->db->where('class', $class);
        $this->db->where('department', $department);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
   
    
   
    
    /**
    ** Insert Exam Mark
    **/
    function addNew($data)
    {
        $this->db->trans_start();
        $this->db->insert('exam_marks', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    /**
    ** Update Exam Mark
    **/
    function edit($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('exam_marks', $data);
        return TRUE;
    }



    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function delete($Id)
    {
        $this->db->where('id', $Id);
        $this->db->delete('class');
        return TRUE;
    }


    /**
    ** Insert Mark Distribution
    **/
    function addNewMDvalue($data)
    {
        $this->db->trans_start();
        $this->db->insert('mark_distribution_values', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Update Mark Distribution
    **/
    function updateMDvalue($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('mark_distribution_values', $data);
        return TRUE;
    }
    


}

  