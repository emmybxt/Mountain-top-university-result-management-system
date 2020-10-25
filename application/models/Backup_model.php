<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Backup_model extends CI_Model
{
   
    /**
    ** Student List
    **/
    function students_list()
    {
        $this->db->select('*');
        $this->db->from('students');
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
    ** Upload New Students
    **/
    function upload_students_new($studentsInfo)
    {
        $this->db->trans_start();
        $this->db->insert('students', $studentsInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Upload Edit Students
    **/
    function upload_students_edit($studentInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('students', $studentInfo);
        return TRUE;
    }


    /**
    ** Teacher List
    **/
    function teacher_list()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by("userId", "asc");
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
    ** Upload New Teacher's
    **/
    function upload_teachers_new($teachersInfo)
    {
        $this->db->trans_start();
        $this->db->insert('users', $teachersInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Upload Edit Teacher's
    **/
    function upload_teacher_edit($teachersInfo, $id)
    {
        $this->db->where('userId', $id);
        $this->db->update('users', $teachersInfo);
        return TRUE;
    }


    /**
    ** Class List
    **/
    function class_list()
    {
        $this->db->select('*');
        $this->db->from('class');
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
    ** Upload New class
    **/
    function upload_class_new($Info)
    {
        $this->db->trans_start();
        $this->db->insert('class', $Info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Upload Edit class
    **/
    function upload_class_edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('class', $Info);
        return TRUE;
    }

    /**
    ** Subject List
    **/
    function subjects_list()
    {
        $this->db->select('*');
        $this->db->from('subjects');
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
    ** Upload New Subjects
    **/
    function upload_subjects_new($Info)
    {
        $this->db->trans_start();
        $this->db->insert('subjects', $Info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Upload Edit Subjects
    **/
    function upload_subjects_edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('subjects', $Info);
        return TRUE;
    }

    /**
    ** Exam List
    **/
    function exam_list()
    {
        $this->db->select('*');
        $this->db->from('exam');
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
    ** Field List
    **/
    function field_list()
    {
        $this->db->select('*');
        $this->db->from('fields');
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
    ** Upload New Exam
    **/
    function upload_exam_new($Info)
    {
        $this->db->trans_start();
        $this->db->insert('exam', $Info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Upload Edit Exam
    **/
    function upload_exam_edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('exam', $Info);
        return TRUE;
    }

    /**
    ** Upload New Field
    **/
    function upload_field_new($Info)
    {
        $this->db->trans_start();
        $this->db->insert('fields', $Info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Upload Edit Field
    **/
    function upload_field_edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('fields', $Info);
        return TRUE;
    }

    /**
    ** Marks List
    **/
    function mark_list()
    {
        $this->db->select('*');
        $this->db->from('exam_marks');
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
    ** Upload New Mark
    **/
    function upload_mark_new($Info)
    {
        $this->db->trans_start();
        $this->db->insert('exam_marks', $Info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Upload Edit Mark
    **/
    function upload_mark_edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('exam_marks', $Info);
        return TRUE;
    }

    /**
    ** Configuration List
    **/
    function config_list()
    {
        $this->db->select('*');
        $this->db->from('config');
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }


    /**
    ** Upload Edit Configuration
    **/
    function upload_con_edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('config', $Info);
        return TRUE;
    }


    /**
    ** Grade List
    **/
    function grade_list()
    {
        $this->db->select('*');
        $this->db->from('exams_grade');
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    /**
    ** Upload New Grade
    **/
    function upload_grade_new($Info)
    {
        $this->db->trans_start();
        $this->db->insert('exams_grade', $Info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
    ** Upload Edit Mark
    **/
    function upload_grade_edit($Info, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('exams_grade', $Info);
        return TRUE;
    }
   
    

}

  