<?php 
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $userId = '';
    $name = '';
    $avatar = '';
    $email = '';
    $mobile = '';
    $roleId = '';
    $required = 'required';

    if(!empty($user_data))
    {
        foreach ($user_data as $item)
        {
            $userId = $item->userId;
            $name = $item->name;
            $avatar = $item->avatar;
            $email = $item->email;
            $mobile = $item->mobile;
            $roleId = $item->roleId;

        }

        $required = '';
    }


    $email_address = getlang('email_address');
    $teachers_name = getlang('full_name');
    $password = getlang('password');
    $c_password = getlang('confirm_password');
    $phone = getlang('phone');
    $profile_picture = getlang('avatar');
?>

<div class="content-wrapper">
    <?php 
    $page_title = getlang('teachers_manage');
    $page_icon = 'fa-users';
    echo sectionHeader($page_title, '', $page_icon); 
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
                        <h3 class="box-title"><?php echo getlang('enter_teacher_details'); ?></h3>
                    </div>
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url() ?>user/add" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8"><?php echo fieldBuilder('input', 'name', $name, $teachers_name, 'required'); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-8"><?php echo fieldBuilder('input', 'email', $email, getlang('email'), 'required'); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <?php 
                                    $pass_field = '<input type="password" class="form-control '.$required.'" id="password" name="password" maxlength="20">';
                                    echo fieldBuilder('select', 'password', $pass_field, $password, $required); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <?php 
                                    $pass_field = '<input type="password" class="form-control '.$required.' equalTo" id="cpassword" name="cpassword" maxlength="20">';
                                    echo fieldBuilder('select', 'cpassword',$pass_field,  $c_password, $required); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8"> <?php echo fieldBuilder('input', 'mobile', $mobile,  $phone, 'required'); ?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="role" class="col-sm-4 control-label"><?php echo getlang('role'); ?></label>
                                        <div class="col-sm-8">
                                        <select class="form-control required" id="role" name="role">
                                            <option value="0">Select Role</option>
                                            <?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->roleId; ?>" <?php if($rl->roleId == $roleId) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <?php 
                                    if(empty($avatar)){
                                        $img_path = site_url('/uploads/users/').'avator.png';
                                    }else{
                                        $img_path = site_url('/uploads/users/').$avatar;
                                    }
                                    $avatar_field = '<input type="file" id="avatar" name="avatar" onchange="readURL(this, 1);" />';
                                    echo fieldBuilder('select', 'avatar', $avatar_field, $profile_picture, '');

                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                                            <img height="180" width="180" id="preview_1" src="<?php echo $img_path; ?>" alt="avator" >
                                            <input type="hidden"  value="<?php echo $avatar; ?>" name="old_avatar">
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-8 ">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                                            <input type="hidden" value="<?php echo $userId; ?>" name="id">
                                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('submit'); ?>" />
                                            <a href="<?php echo base_url() ?>user" class="btn btn-default"  ><?php echo getlang('cancel'); ?></a>
                                               
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    
</div>

