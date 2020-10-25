<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Markdistribution_model extends CI_Model
{
    /**
    ** Get Info
    **/
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('mark_distribution');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    /**
    ** Listing Count
    **/
    function ListingCount($searchText = '')
    {
        $this->db->select('id, title');
        $this->db->from('mark_distribution');
        if(!empty($searchText)) {
            $likeCriteria = "(title  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /**
    ** Listing
    **/
    function Listing($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('mark_distribution');
        if(!empty($searchText)) {
            $likeCriteria = "(title  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
   
    /**
    ** Insert 
    **/
    function addNew($Info)
    {
        $this->db->trans_start();
        $this->db->insert('mark_distribution', $Info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    /**
    ** Update
    **/ 
    function edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('mark_distribution', $Info);
        return TRUE;
    }


    /**
    ** Delete
    **/
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mark_distribution');
        return TRUE;
    }
    

}

  