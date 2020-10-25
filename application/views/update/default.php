<?php

  $token_name = $this->security->get_csrf_token_name();
  $token_hash = $this->security->get_csrf_hash();

?>
   

<div class="content-wrapper mark-page">
    <?php 
    $page_title = 'Update';
    $page_icon = 'fa fa-refresh';
    echo sectionHeader($page_title, '', $page_icon); 
    ?>
    <section class="content">

        <div class="row">
             <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <form action="<?php echo base_url(); ?>update/install" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body form-horizontal">
                        <fieldset>
                            <legend>Upload & Install </legend>
                            <input type="file" name="install_file">
                        </fieldset>
                    </div>

                    <div class="box-footer">
                            
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Install" />
                        </div>
                    </div>
                            
                </div>
            </div>
        </div>

        <input type="hidden" name="<?php echo $token_name; ?>" value="<?php echo $token_hash; ?>" />
        </form>


    </section>
</div>

