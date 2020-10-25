<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Update extends BaseController
{
   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('update_model');
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
            $this->global['pageTitle'] = 'Update';
            $this->loadViews("update/default",  $this->global,'' , NULL);
        }
    }

    /**
    ** Get Install
    **/
    function getInstall()
    {
        
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{      

            if ($_FILES) {
                $fileName = $_FILES['install_file']['tmp_name'];
                $zip = new my_ZipArchive();
                if ($zip->open($fileName)) {

                    // Get Addon XML
                    $xmlFile          =  $zip->getFromName('update.xml');
                    $setting_data     = simplexml_load_string($xmlFile);
                    
                    $version          = $setting_data->version;
                    if(!empty($version) ){

                        $Info = array(
                            'version'  => $version
                        );
                        $result  = $this->update_model->edit($Info, '1');
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

                            
                            // Controllers Files
                            if($fileinfo['dirname']=='controllers'){
                                $controllers_path = './application/controllers/';
                                $zip->extractSubdirTo($controllers_path, "controllers/");
                            }

                            // Models Files
                            if($fileinfo['dirname']=='models'){
                                $models_path = './application/models/';
                                $zip->extractSubdirTo($models_path, "models/");
                            }

                            // Views Files
                            if($fileinfo['dirname']=='views'){
                                $views_path = './application/views/';
                                $zip->extractSubdirTo($views_path, "views/");
                            }

                            // Helpers Files
                            if($fileinfo['dirname']=='helpers'){
                                $helpers_path = './application/helpers/';
                                $zip->extractSubdirTo($helpers_path, "helpers/");
                            }

                            // Libraries Files
                            if($fileinfo['dirname']=='libraries'){
                                $libraries_path = './application/libraries/';
                                $zip->extractSubdirTo($libraries_path, "libraries/");
                            }

                            // Config Files
                            if($fileinfo['dirname']=='config'){
                                $libraries_path = './application/config/';
                                $zip->extractSubdirTo($libraries_path, "config/");
                            }


                            // SQL
                            if($fileinfo['dirname']=='sql'){
                                // Get SQL file
                                $sqlFile          =  $zip->getFromName('sql/update.sql');
                                $CI =& get_instance();
                                $dbprefix = $CI->db->dbprefix;
                                $lines = str_replace('#__', $dbprefix, $sqlFile);
                                $objects = explode(';', $lines);

                                foreach ($objects as $line) {
                                     if(!empty(trim($line))){
                                        $CI->db->query("SET FOREIGN_KEY_CHECKS = 0");
                                        $CI->db->query($line);
                                        $CI->db->query("SET FOREIGN_KEY_CHECKS = 1");
                                     }
                                }
                            }
                        }
                        
                        $msg .= 'Update pack successfully installed ! ';
                    }else {
                        $msg .= 'Update pack installed error !';
                    }

                }
                $zip->close();
            }

            $this->session->set_flashdata('success', $msg);
            redirect('update');
        }

        
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
