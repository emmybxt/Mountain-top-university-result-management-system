<?php if(isset($error)) { ?>
  <div class="row"
    style="margin-top: 20px;">
    <div class="col-md-8 col-md-offset-2">
      <div class="alert alert-danger">
        <strong><?php echo $error; ?></strong>
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
          <strong>Your database is successfully connected</strong>. All you need to do now is
          <strong>hit the 'Install' button</strong>.
          The auto installer will run a sql file, will do all the tiresome works and set up your application automatically.
        </p>
        <br>
        <div class="row">
          <div class="col-md-12">
            <button type="button" id="install_button" class="btn btn-info">
              <i class="entypo-check"></i> &nbsp; Install
            </button>
            <div id="loader" style="margin-top: 20px;">
              <img src="assets/loader.gif" alt="" width="20">
              &nbsp; Importing database ....
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery('#loader').hide();
    jQuery('#install_button').click(function() {
      jQuery('#loader').fadeIn();
      window.location.href = '<?php echo base_url();?>install/step4/confirm_install';
    });
  });
</script>
