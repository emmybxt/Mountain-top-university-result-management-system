<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Result_template_model extends CI_Model
{

    /**
    ** Get Info
    **/
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('result_template');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    /**
    ** Insert Query
    **/
    function addNew($data)
    {
        $this->db->trans_start();
        $this->db->insert('result_template', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    /**
    ** Update Query
    **/
    function edit($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('result_template', $data);
        return TRUE;
    }


    /**
    ** Delete Query
    **/
    function delete($Id)
    {
        $this->db->where('id', $Id);
        $this->db->delete('result_template');
        return TRUE;
    }


    /**
    ** Listing Count
    **/
    function getListingCount()
    {
        $this->db->select('*');
        $this->db->from('result_template');
        $query = $this->db->get();
        return $query->num_rows();
    }


    /**
    ** List Query
    **/ 
    function getListing($page, $segment)
    {
        $this->db->select('*');
        $this->db->from('result_template');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }


}

  