
<?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $avatar = '';
    if(!empty($userInfo))
    {
        foreach ($userInfo as $item)
        {
            $avatar = $item->avatar;
        }
    }

    $profile_pic = getlang('avatar');

?>
<div class="content-wrapper">
    <?php 
    $page_title = getlang('change_avatar');
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
                    
                    <!-- form start -->
                    <form role="form" action="<?php echo base_url() ?>user/updateavatar" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <?php 
                                    if(empty($avatar)){
                                        $img_path = site_url('/uploads/users/').'/avator.png';
                                    }else{
                                        $img_path = site_url('/uploads/users/').'/'.$avatar;
                                    }
                                    $avatar_field = '<input type="file" name="avatar" onchange="readURL(this, 1);" />';
                                    echo fieldBuilder('select', 'avatar', $avatar_field, $profile_pic, '');

                                    ?>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                                        	<p></p>
                                        	<img src="<?php echo $img_path; ?>" alt="avator" id="preview_1" >
                                            <input type="hidden" value="<?php echo $avatar; ?>" name="old_avatar">
                                        </div>
                                    </div>
                                </div> 
                            </div>

                        </div>

                        <div class="box-footer">
                        	<div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
				                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('submit'); ?>" />
				                            <input type="reset" class="btn btn-default" value="<?php echo getlang('reset'); ?>" />
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