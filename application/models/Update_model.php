<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Update_model extends CI_Model
{


    /**
     * This function is used to add new class to system
     * @return number $insert_id : This is last inserted id
     */
    function addNew($data)
    {
        $this->db->trans_start();
        $this->db->insert('update', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    /**
     * This function is used to update the class information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is class id
     */
    function edit($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('update', $data);
        return TRUE;
    }




}

  