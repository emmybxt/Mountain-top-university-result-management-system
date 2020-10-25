<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Grade_model extends CI_Model
{
    /**
    ** Get Info
    **/
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('exams_grade');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    /**
    ** Get Listing Count
    **/
    function ListingCount($searchText = '', $cat_value)
    {
        $this->db->select('*');
        $this->db->from('exams_grade');
        if(!empty($searchText)) {
            $likeCriteria = "(name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        // Filter by category 
        if(!empty($cat_value)){
            $this->db->where('category', $cat_value);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
    ** Get Listing
    **/
    function Listing($searchText = '', $cat_value, $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('exams_grade');
        if(!empty($searchText)) {
            $likeCriteria = "(name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        // Filter by category 
        if(!empty($cat_value)){
            $this->db->where('category', $cat_value);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
   
    
    /**
    ** Get Insert
    **/
    function addNew($Info)
    {
        $this->db->trans_start();
        $this->db->insert('exams_grade', $Info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Get Update
    **/
    function edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('exams_grade', $Info);
        return TRUE;
    }

    /**
    ** Get Delete
    **/
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('exams_grade');
        return TRUE;
    }
    

}

  