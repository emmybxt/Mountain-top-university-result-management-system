<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Fields_model extends CI_Model
{


    /**
     * This function used to get information by id
     * @param number $id : This is id
     * @return array $result : This is information
     */
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('fields');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    /**
     * This function is used to get the class listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function ListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('fields');
        if(!empty($searchText)) {
            $likeCriteria = "(field_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the class listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function Listing($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('fields');
        if(!empty($searchText)) {
            $likeCriteria = "(field_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
   
    
   
    
    /**
     * This function is used to add new field to system
     * @return number $insert_id : This is last inserted id
     */
    function addNew($field_info)
    {
        $this->db->trans_start();
        $this->db->insert('fields', $field_info);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }


    /**
     * This function is used to update the field information
     * @param array $userInfo : This is field updated information
     * @param number $userId : This is field id
     */
    function edit($class_info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('fields', $class_info);
        return TRUE;
    }



    /**
     * This function is used to delete the field information
     * @param number $userId : This is field id
     * @return boolean $result : TRUE / FALSE
     */
    function delete($Id)
    {
        $this->db->where('id', $Id);
        $this->db->delete('fields');
        return TRUE;
    }
    


}

  