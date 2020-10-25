<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


ini_set('max_execution_time', 0);
ini_set('memory_limit','2048M');

class Install extends CI_Controller {

    /**
    ** Install Index page
    **/
    public function index() {
	    if ($this->router->default_controller == 'install') {
	        redirect(base_url(). 'install/step0');
	    }
    }


    /**
    ** Install Step 0
    **/
    function step0() {

	    if ($this->router->default_controller != 'install') {
	        redirect(base_url(). 'login');
	    }
	    $page_data['page_name'] = 'step0';
	    $this->load->view('install/index', $page_data);
    }

    /**
    ** Install Step 1
    **/
    function step1() {
	    if ($this->router->default_controller != 'install') {
	        redirect(base_url(). 'login');
	    }
	    $page_data['page_name'] = 'step1';
	    $this->load->view('install/index', $page_data);
    }

    /**
    ** Install Step 2
    **/
    function step2($param1 = '', $param2 = '') {
	    if ($this->router->default_controller != 'install') {
	        redirect(base_url(). 'login');
	    }

	    if ($param1 == 'error') {
	        $page_data['error'] = 'Purchase code verification failed.';
	    }
	    $page_data['page_name'] = 'step2';
	    $page_data['buyer_name']          = $_SESSION['buyer_name'];
	    $page_data['purchase_code']              = $_SESSION['purchase_code'];
	    $this->load->view('install/index', $page_data);
    }


    /**
    ** Install Step 3
    **/
    function step3($param1 = '', $param2 = '') {
	    if ($this->router->default_controller != 'install') {
	        redirect(base_url(). 'login');
	    }

	   

	    if ($param1 == 'error_con_fail') {
	        $page_data['error_con_fail'] = 'Error establishing a database conenction using your provided information. Please
	      recheck hostname, username, password and try again with correct information';
	    }
	    if ($param1 == 'error_nodb') {
	        $page_data['error_con_fail'] = 'The database you are trying to use for the application does not exist. Please create
	      the database first';
	    }

	   
	    if ($param1 == 'configure_database') {
            $dbtype        = $this->input->post("dbtype");
	        $hostname      = $this->input->post('hostname');
	        $username      = $this->input->post('username');
	        $password      = $this->input->post('password');
	        $dbname        = $this->input->post('dbname');
	        $db_prefix     = $this->input->post('db_prefix');
	        // check db connection using the above credentials
	        $db_connection = $this->check_database_connection($dbtype, $hostname, $username, $password, $dbname, $db_prefix);

	        if ($db_connection == 'failed') {
	            redirect(base_url().'install/step3/error_con_fail');
	        }else if ($db_connection == 'db_not_exist') {
	            redirect(base_url().'install/step3/error_nodb');
	        } else {
		        // proceed to step 4
		        session_start();
		        $_SESSION['dbtype']   = $dbtype;
		        $_SESSION['hostname'] = $hostname;
		        $_SESSION['username'] = $username;
		        $_SESSION['password'] = $password;
		        $_SESSION['dbname']   = $dbname;
		        $_SESSION['prefix']   = $db_prefix;
		        redirect(base_url().'install/step4');
	        }
	    }
	    $page_data['page_name'] = 'step3';
	    $this->load->view('install/index', $page_data);
    }


    /**
    ** Install Step 4
    **/
    function step4($param1 = '') {
	    if ($this->router->default_controller != 'install') {
	        redirect(base_url(). 'login');
	    }

	    if ($param1 == 'confirm_install') {
	      // write database.php
	      $this->configure_database();

	      // write autoload.php
	      $this->configure_autoload();

	      // run sql
	      $this->run_blank_sql();

	      // redirect to admin creation page
	      redirect(base_url().'install/finalizing_setup');
	    }

	    $page_data['page_name'] = 'step4';
	    $this->load->view('install/index', $page_data);
    }


    /**
    ** check database connection
    **/
    function check_database_connection($dbtype, $hostname, $username, $password, $dbname, $db_prefix) {

        // MySQLi
    	if ($dbtype == 'mysqli') {
    		$link = mysqli_connect($hostname, $username, $password);
		    if (!$link) {
		        @mysqli_close($link);
		        return 'failed';
		    }

		    $db_selected = mysqli_select_db($link, $dbname);
		    if (!$db_selected) {
		        @mysqli_close($link);
		        return "db_not_exist";
		    }

		    @mysqli_close($link);
		    return 'success';
    	}

        // MySQL PDO
    	if ($dbtype == 'pdo') {
    		try {
                $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
			    // set the PDO error mode to exception
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    return 'success';
			    }
			catch(PDOException $e)
			    {
			    return 'failed';
			    }
    	}

    	
        
	}

  
    /**
    ** configure database
    **/
    function configure_database() {
	    // write database.php
	    $data_db = file_get_contents('./application/config/database.php');
	    session_start();
	    $data_db = str_replace('db_type',	$_SESSION['dbtype'],	$data_db);
	    $data_db = str_replace('db_name',	$_SESSION['dbname'],	$data_db);
	    $data_db = str_replace('db_user',	$_SESSION['username'],	$data_db);
	    $data_db = str_replace('db_pass',	$_SESSION['password'],	$data_db);
	    $data_db = str_replace('db_host',	$_SESSION['hostname'],	$data_db);
	    $data_db = str_replace('db_prefix',	$_SESSION['prefix'],	$data_db);
	    file_put_contents('./application/config/database.php', $data_db);
    }

    /**
    ** configure autoload
    **/
    function configure_autoload() {
	    // Update autoload configuration
	    $new_libraries =  '$autoload["libraries"] = array("database", "session"); ';
	    $autoload_content = file_get_contents('./application/config/autoload.php');
	    $autoload_content = str_replace('$autoload["libraries"] = array("session");', $new_libraries, $autoload_content);
	    file_put_contents('./application/config/autoload.php', $autoload_content);
    }


    /**
    ** Run Blank SQL 
    **/
    function run_blank_sql() {
	    $this->load->database();
	    // Set line to collect lines that wrap
	    $templine = '';
	    // Read in entire file
	    $lines = file('./uploads/install.sql');
	    $lines = str_replace('#__',	$_SESSION['prefix'], $lines);
	    // Loop through each line
	    foreach ($lines as $line) {
	        // Skip it if it's a comment
	        if (substr($line, 0, 2) == '--' || $line == '')
	        continue;
	        // Add this line to the current templine we are creating
	        $templine .= $line;
	        // If it has a semicolon at the end, it's the end of the query so can process this templine
	        if (substr(trim($line), -1, 1) == ';') {
		        // Perform the query
		        $this->db->query($templine);
		        // Reset temp variable to empty
		        $templine = '';
	        }
	    }
    }


    /**
    ** Finish Setup
    **/
    function finalizing_setup($param1 = '', $param2 = '') {
	    if ($this->router->default_controller != 'install') {
	        redirect(base_url(). 'login');
	    }
    
	    if ($param1 == 'setup_admin') {

	    	// Make new user
	        $this->load->database();

	    	$school_name              = $this->input->post('system_name');
	        $admin_data['name']       = $this->input->post('name');
	        $admin_data['email']      = $this->input->post('email');
	        $admin_data['password']   = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
	        $admin_data['roleId']     = '1';
            
            // insert to user
	        $this->db->trans_start();
	        $this->db->insert('users', $admin_data);
	        $insert_u_id = $this->db->insert_id();
            $this->db->trans_complete();

            // update config
            $config_data = array('name'=> $school_name);
	        $this->db->where('id', '1');
            $this->db->update('config', $config_data);

	        redirect(base_url().'install/success');
	    }

	    $page_data['page_name'] = 'finalizing_setup';
	    $this->load->view('install/index', $page_data);
    }

    /**
    ** Setup Success
    **/
    function success($param1 = '') {
	    if ($this->router->default_controller != 'install') {
	      redirect(base_url(). 'login');
	    }

	    if ($param1 == 'login') {
	      $this->configure_routes();
	      redirect(base_url().'login');
	    }

	    $this->load->database();
	    $admin_email = $this->db->get_where('users', array('userId' => 1))->row()->email;

	    $page_data['admin_email'] = $admin_email;
	    $page_data['page_name'] = 'success';
	    $this->load->view('install/index', $page_data);
    }

   
    /**
    ** configure routes
    **/
    function configure_routes() {
	    // write routes.php
	    $data_routes = file_get_contents('./application/config/routes.php');
	    $data_routes = str_replace('install',	'login',	$data_routes);
	    file_put_contents('./application/config/routes.php', $data_routes);
    }


    
    /**
    ** validate purchase code
    **/
    function validate_purchase_code() {
    	$buyer_name    = $this->input->post('buyer_name');
	    $purchase_code = $this->input->post('purchase_code');
	    $validation_response = $this->curl_request($buyer_name, $purchase_code);
	    if($validation_response == 1) {

	        //move to step 3
	        redirect(base_url().'install/step3');
	    }else{
	    	session_start();
	    	$_SESSION['buyer_name']             = $buyer_name;
	        $_SESSION['purchase_code']          = $purchase_code;
	        //remain on step 2 and show error
	        redirect(base_url().'install/step2/error');
	    }
    }

    function curl_request($buyer = '', $code = '') {

        $purchase_code = $code;

        // Query using CURL:
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$purchase_code}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTPHEADER => array(
                "Authorization: bearer wbmooMDbbMZh5Y9TZ4qzHrY0LMD5FJ9o",
                "User-Agent: Purchase code verification script"
            )
        ));

        // Execute CURL with warnings suppressed:
        $response = @curl_exec($ch);
        $purchase_data = json_decode($response, true);

        if (isset($purchase_data['buyer']) && $purchase_data['buyer'] == $buyer) {
		    return 1;
        }else{
		    return 0;
		}
  	}


}
