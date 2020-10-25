<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Gradecat_model extends CI_Model
{


    /**
    ** Get Info
    **/
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('grade_category');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    /**
    ** Get Listing Count
    **/
    function ListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('grade_category');
        if(!empty($searchText)) {
            $likeCriteria = "(name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
    ** Get Listing
    **/
    function Listing($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('grade_category');
        if(!empty($searchText)) {
            $likeCriteria = "(name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
   
    /**
    ** Get Insert Query
    **/
    function addNew($info)
    {
        $this->db->trans_start();
        $this->db->insert('grade_category', $info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    /**
    ** Get Update Query
    **/
    function edit($info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('grade_category', $info);
        return TRUE;
    }

    /**
    ** Get Delete Query
    **/
    function delete($Id)
    {
        $this->db->where('id', $Id);
        $this->db->delete('grade_category');
        return TRUE;
    }
    


}

  