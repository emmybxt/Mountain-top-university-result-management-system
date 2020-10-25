
<?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $new_password = getlang('new_password');
    $confirm_password = getlang('confirm_password');
    $old_password = getlang('old_password');

?>


<div class="content-wrapper">
    <?php 
    $page_title = getlang('change_password');
    echo sectionHeader($page_title, '', ''); 
    ?>
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo getlang('enter_details'); ?></h3>
                    </div>

                    <!-- form start -->
                    <form role="form" class="form-horizontal" action="<?php echo base_url() ?>user/updatepassword" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <?php 
                                    $oldpass_field = '<input type="password" class="form-control" id="inputOldPassword" placeholder="Old password" name="oldPassword" maxlength="20" required>';
                                    echo fieldBuilder('select', 'password', $oldpass_field, $old_password, ''); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-8">
                                    <?php 
                                    $pass1_field = '<input type="password" class="form-control" id="inputPassword1" placeholder="New password" name="newPassword" maxlength="20" required>';
                                    echo fieldBuilder('select', 'password1', $pass1_field, $new_password, ''); ?>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <?php 
                                    $pass2_field = '<input type="password" class="form-control" id="inputPassword2" placeholder="Confirm new password" name="cNewPassword" maxlength="20" required>';
                                    echo fieldBuilder('select', 'password2', $pass2_field, $confirm_password, ''); ?>
                                    
                                </div>
                            </div>

                           
                        </div><!-- /.box-body -->

                       
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('submit'); ?>" />
                            <input type="reset" class="btn btn-default" value="<?php echo getlang('reset'); ?>" />
                        </div>

                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    </form>
                </div>
            </div>
            
        </div>
    </section>
</div>