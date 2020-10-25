<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Languages_model extends CI_Model
{
   /**
     * This function used to get information by id
     * @param number $id : This is id
     * @return array $result : This is information
     */
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('languages');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    /**
     * This function is used to get the listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function ListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.Id,  BaseTbl.title');
        $this->db->from('languages as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.title  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the listing 
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function Listing($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('languages as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.title  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
   
    
   
    
    /**
     * This function is used to add new to system
     * @return number $insert_id : This is last inserted id
     */
    function addNew($Info)
    {
        $this->db->trans_start();
        $this->db->insert('languages', $Info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    /**
     * This function is used to update the information
     * @param array $info : This is updated information
     * @param number $Id : This is id
     */
    function edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('languages', $Info);
        return TRUE;
    }



    /**
     * This function is used to delete the information
     * @param number $Id : This is id
     * @return boolean $result : TRUE / FALSE
     */
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('languages');
        return TRUE;
    }
    

}

  