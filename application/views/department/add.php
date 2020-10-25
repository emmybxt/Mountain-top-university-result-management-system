<?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $id = '';
    $name = '';

    if(!empty($dp_data))
    {
        foreach ($dp_data as $item)
        {
            $id = $item->id;
            $name = $item->department_name;
        }
            
    }
    $department_name = getlang('department_name');
    $department_field = fieldBuilder('input', 'department_name', $name, $department_name, 'required');
   
?>


<div class="content-wrapper class-page">
    
    <?php 
    $page_title = getlang('department_manage');
    $page_icon = 'fa-building-o';
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
                    
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url() ?>departments/add/" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6"> <?php echo $department_field; ?></div>
                            </div>
                        </div>
    
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                        	                <input type="hidden" value="<?php echo $id; ?>" name="id">
                                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('submit'); ?>" /> 
                                            <a class="btn  btn-default" href="<?php echo base_url().'departments'; ?>" title="Cancel"> <?php echo getlang('cancel'); ?> </a>
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

