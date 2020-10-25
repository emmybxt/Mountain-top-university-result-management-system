<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Result_template extends BaseController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('result_template_model');
        $this->load->library('session');
        $this->isLoggedIn();   
    }
    
    /**
    ** This function is used to load the  list
    **/
    function index()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{      
            $this->load->library('pagination');
            $count           = $this->result_template_model->getListingCount();
            $returns         = $this->paginationCompress ( "result_template/", $count, 20 );
            $data['records'] = $this->result_template_model->getListing($returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'Result Template Install';
            $this->loadViews("result_template/default", $this->global, $data, NULL);
        } 
    }

    /**
    ** Configuration
    **/
    function configuration($Id = NULL)
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $data['records'] = $this->result_template_model->getInfo($Id);
            $this->global['pageTitle'] = 'Configuration';
            $this->loadViews("/result_template/configuration", $this->global, $data, NULL);
        }
    }

    /**
    ** Configuration Save
    **/
    function configuration_save()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            
            $Id = $this->input->post('id');
            $params = $this->input->post('conf');
            $params_data = json_encode($params);

            $Info = array(
                'param'         => $params_data
            );
           
            $result          = $this->result_template_model->edit($Info, $Id);
            $message_success = getlang('update_success');
            $message_error   = getlang('update_failed');
           
            if($result > 0){
                $this->session->set_flashdata('success', $message_success);
            }else{
                $this->session->set_flashdata('error', $message_error);
            }

            redirect('result_template');

        }
    }

    /**
    ** Get Install
    **/
    function getinstall()
    {
        
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{      

            if ($_FILES) {
                $fileName = $_FILES['install_file']['tmp_name'];
                $zip = new my_ZipArchive();
                if ($zip->open($fileName)) {

                    // Get Addon XML
                    $xmlFile        =  $zip->getFromName('template.xml');
                    $setting_data   = simplexml_load_string($xmlFile);
                    
                    $title          = $setting_data->title;
                    $description    = $setting_data->description;
                    $alias          = $setting_data->alias;
                    $thumbo         = $setting_data->thumbo;
                    $status         = $setting_data->status;
                    $fields         = $setting_data->fields;
                    $param          = $setting_data->param;
                    if(!empty($alias) ){

                        $exit_id = getSingledata('result_template', 'id', 'alias', $alias);

                        $Info = array(
                            'title'         => $title,
                            'description'   => $description,
                            'alias'         => $alias,
                            'thumbo'        => $thumbo,
                            'status'        => $status,
                            'fields'        => $fields,
                            'param'         => $param
                        );

                        if(empty($exit_id)){
                            $result  = $this->result_template_model->addNew($Info);
                        }else{
                            $result  = $this->result_template_model->edit($Info, $exit_id);
                        }
                        
                        if($result > 0){
                            $id = 1;
                        }else{
                            $id = 0;
                        }
                        
                    }else{
                       $id = 0;
                    }
                    

                    if (!empty($id)) {

                        for ($i = 0; $i < $zip->numFiles; $i++) {
                            $filename = $zip->getNameIndex($i);
                            $fileinfo = pathinfo($filename);

                            // Views Files
                            if($fileinfo['dirname']=='views'){
                                $views_path = './application/views/';
                                $zip->extractSubdirTo($views_path, "views/");
                            }

                        }
                        
                        $msg .= 'Result template successfully installed ! ';
                    }else {
                        $msg .= 'Result template installed error !';
                    }

                }
                $zip->close();
            }

            $this->session->set_flashdata('success', $msg);
            redirect('result_template');
        }

    }


    /**
    ** Get Delete
    **/
    function getdelete($Id = NULL)
    {

        $reponse = array('status' => true);
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );

        if (empty($Id)) {
            $Id = $this->input->post('Id');
        }

        if($this->isAdmin() == TRUE){
            $no_permission = getlang('no_permission');
            $this->session->set_flashdata('error', $no_permission );
            redirect('result_template');
        }else{

            // Delete Template file and folder
            $exit_alias = getSingledata('result_template', 'alias', 'id', $Id);
            if(!empty($exit_alias)){
                $dir_name = './application/views/result/template/'.$exit_alias;
                $this->load->helper("file"); // load the helper
                if(delete_files($dir_name, true)){
                    if(rmdir($dir_name)){
                        // Get delete data
                        $result = $this->result_template_model->delete($Id);
                        if ($result > 0){ 
                            $reponse['status'] = true;
                        }else{ 
                            $reponse['status'] = false;
                        }
                    }else{
                        $reponse['status'] = false;
                    }
                }else{
                    $reponse['status'] = false;
                }
                
            }else{
                $reponse['status'] = false;
            }
            
            
        }

        echo json_encode($reponse);
    }

    
}














class my_ZipArchive extends ZipArchive
  {
    public function extractSubdirTo($destination, $subdir)
    {
      $errors = array();

      // Prepare dirs
      $destination = str_replace(array("/", "\\"), DIRECTORY_SEPARATOR, $destination);
      $subdir = str_replace(array("/", "\\"), "/", $subdir);

      if (substr($destination, mb_strlen(DIRECTORY_SEPARATOR, "UTF-8") * -1) != DIRECTORY_SEPARATOR)
        $destination .= DIRECTORY_SEPARATOR;

      if (substr($subdir, -1) != "/")
        $subdir .= "/";

      // Extract files
      for ($i = 0; $i < $this->numFiles; $i++)
      {
        $filename = $this->getNameIndex($i);

        if (substr($filename, 0, mb_strlen($subdir, "UTF-8")) == $subdir)
        {
          $relativePath = substr($filename, mb_strlen($subdir, "UTF-8"));
          $relativePath = str_replace(array("/", "\\"), DIRECTORY_SEPARATOR, $relativePath);

          if (mb_strlen($relativePath, "UTF-8") > 0)
          {
            if (substr($filename, -1) == "/")  // Directory
            {
              // New dir
              if (!is_dir($destination . $relativePath))
                if (!@mkdir($destination . $relativePath, 0755, true))
                  $errors[$i] = $filename;
            }
            else
            {
              if (dirname($relativePath) != ".")
              {
                if (!is_dir($destination . dirname($relativePath)))
                {
                  // New dir (for file)
                  @mkdir($destination . dirname($relativePath), 0755, true);
                }
              }

              // New file
              if (@file_put_contents($destination . $relativePath, $this->getFromIndex($i)) === false)
                $errors[$i] = $filename;
            }
          }
        }
      }

      return $errors;
    }
  }
