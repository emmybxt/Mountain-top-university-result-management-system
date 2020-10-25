

<?php 


$csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
);


function randomString($length = 6) {
  $str = "";
  $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
  $max = count($characters) - 1;
  for ($i = 0; $i < $length; $i++) {
    $rand = mt_rand(0, $max);
    $str .= $characters[$rand];
  }
  return $str;
}
?>


<?php if(isset($error_con_fail)) { ?>
  <div class="row"
    style="margin-top: 20px;">
    <div class="col-md-8 col-md-offset-2">
      <div class="alert alert-danger">
        <strong><?php echo $error_con_fail; ?></strong>
      </div>
    </div>
  </div>
<?php } ?>
<?php if(isset($error_nodb)) { ?>
  <div class="row"
    style="margin-top: 20px;">
    <div class="col-md-8 col-md-offset-2">
      <div class="alert alert-danger">
        <strong><?php echo $error_nodb; ?></strong>
      </div>
    </div>
  </div>
<?php } ?>
<div class="row"
  style="margin-top: 30px;">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default" data-collapsed="0"
      style="border-color: #dedede;">
      <!-- panel body -->
      <div class="panel-body" style="font-size: 14px;">
        <p style="font-size: 14px;">
          Below you should enter your database connection details. If you’re not sure about these, contact your host.
        </p>
        <br>
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal form-groups" method="post" action="<?php echo base_url();?>install/step3/configure_database">
              <hr>
              <div class="form-group">
                <label class="col-sm-3 control-label">Database Type</label>
                <div class="col-sm-5">
                  <select id="pos_select" name="dbtype" class="form_input"  >
                    <option value="mysqli">MySQLi</option>
                    <option value="pdo">MySQL (PDO)</option>
                  </select>
                </div>
                <div class="col-sm-4" style="font-size: 12px;">
                  This is probably "MySQLi".
                </div>
              </div>
              <hr>
              <div class="form-group">
        				<label class="col-sm-3 control-label">Database Name</label>
        				<div class="col-sm-5">
        					<input type="text" class="form-control" name="dbname" placeholder=""
                    required autofocus>
        				</div>
                <div class="col-sm-4" style="font-size: 12px;">
                  The name of the database you want to use with this application
                </div>
        			</div>
              <hr>
              <div class="form-group">
        				<label class="col-sm-3 control-label">Username</label>
        				<div class="col-sm-5">
        					<input type="text" class="form-control" name="username" placeholder=""
                    required>
        				</div>
                <div class="col-sm-4" style="font-size: 12px;">
                  Your database Username
                </div>
        			</div>
              <hr>
              <div class="form-group">
        				<label class="col-sm-3 control-label">Password</label>
        				<div class="col-sm-5">
        					<input type="password" class="form-control" name="password" placeholder="">
        				</div>
                <div class="col-sm-4" style="font-size: 12px;">
                  Your database Password
                </div>
        			</div>
              <hr>
              <div class="form-group">
        				<label class="col-sm-3 control-label">Database Host</label>
        				<div class="col-sm-5">
        					<input type="text" class="form-control" name="hostname" placeholder=""
                    required>
        				</div>
                <div class="col-sm-4" style="font-size: 12px;">
                  If 'localhost' does not work, you can get the hostname from web host
                </div>
        			</div>
              <hr>

              <div class="form-group">
                <label class="col-sm-3 control-label">Table Prefix</label>
                <div class="col-sm-5">
                  <?php 
                  $db_pref_rand = randomString('4');
                  $db_pref = strtolower($db_pref_rand).'_';
                  ?>
                  <input type="text" class="form-control" name="db_prefix" value="<?php echo $db_pref; ?>" placeholder=""
                    required>
                </div>
                <div class="col-sm-4" style="font-size: 12px;">
                  Create a table prefix or use the randomly generated one. Ideally four or five characters long, it may only contain alphanumeric characters and MUST end in an underscore. Make sure that the prefix chosen is not already used by other tables. 
                </div>
              </div>
              <hr>
              <div class="form-group">
        				<label class="col-sm-3 control-label"></label>
        				<div class="col-sm-7">
        					<button type="submit" class="btn btn-info">Continue</button>
                  <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
        				</div>
        			</div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
