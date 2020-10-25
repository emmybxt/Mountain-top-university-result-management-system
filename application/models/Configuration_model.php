<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Configuration_model extends CI_Model
{
   /**
     * This function used to get information by id
     * @param number $id : This is id
     * @return array $result : This is information
     */
    function getInfo($id)
    {
        $this->db->select('*');
        $this->db->from('config');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }
   
    
    /**
     * This function is used to update the information
     * @param array $info : This is updated information
     * @param number $Id : This is id
     */
    function edit($Info, $id)
    {
        $this->db->where('id', 1);
        $this->db->update('config', $Info);
        return TRUE;
    }



}

  