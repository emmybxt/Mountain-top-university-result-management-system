<?php
  $db_file_write_perm = is_writable('application/config/database.php');
  $routes_file_write_perm = is_writable('application/config/routes.php');
  $curl_enabled = function_exists('curl_version');
  if ($db_file_write_perm == false || $routes_file_write_perm == false || $curl_enabled == false) {
    $valid = false;
  } else {
    $valid = true;
  }
?>
<div class="row"
  style="margin-top: 30px;">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default" data-collapsed="0"
      style="border-color: #dedede;">
			<!-- panel body -->
			<div class="panel-body" style="font-size: 14px;">
        <p style="font-size: 14px;">
          We ran diagnosis on your server. Review the items that have a red mark on it. If everything is green, you
          are good to go to the next step.
        </p>
        <br>
        <p style="font-size: 14px;">
          <?php if ($db_file_write_perm == true) { ?>
            <i class="fa fa-check" style="color: #5ac52d;"></i>
          <?php } else { ?>
            <i class="fa fa-times" style="color: #f12828"></i>
          <?php } ?>
          <strong>application/config/database.php </strong>: file has write permission
        </p>
        <p style="font-size: 14px;">
          <?php if ($routes_file_write_perm == true) { ?>
            <i class="fa fa-check" style="color: #5ac52d;"></i>
          <?php } else { ?>
            <i class="fa fa-times" style="color: #f12828"></i>
          <?php } ?>
          <strong>application/config/routes.php </strong>: file has write permission
        </p>
        <p style="font-size: 14px;">
          <?php if ($curl_enabled == true) { ?>
            <i class="fa fa-check" style="color: #5ac52d;"></i>
          <?php } else { ?>
            <i class="fa fa-times" style="color: #f12828"></i>
          <?php } ?>
          <strong>Curl Enabled</strong>
        </p>
        <p style="font-size: 14px;">
          <strong>To continue the installation process, all the above requirements are needed to be checked</strong>
        </p>
        <br>
        <?php if ($valid == true) { ?>
          <p>
            
              <a href="<?php echo base_url();?>install/step2" class="btn btn-info">
                Continue
              </a>
           
          </p>
        <?php } ?>

        <?php if ($valid != true) { ?>
          <p>
            
              <a href="<?php echo base_url();?>install/step2" class="btn btn-info" disabled>
                Continue
              </a>
            <a href="<?php echo base_url();?>install/step1" class="btn btn-info" >
              <i class="entypo-cw"></i>Reload
            </a>
          </p>
        <?php } ?>
			</div>
		</div>
  </div>
</div>
