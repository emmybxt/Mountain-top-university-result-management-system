
<?php
$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash()
);

$id = '';
$name = '';
if(!empty($subject_data))
{
    foreach ($subject_data as $item)
    {
        $id = $item->id;
        $name = $item->name;
    }
}
$subject_name = getlang('subject_name');

?>


<div class="content-wrapper">

    <?php 
    $page_title = getlang('subject_from');
    $page_sub_title = getlang('add').', '.getlang('edit');
    $page_icon = 'fa-book';
    echo sectionHeader($page_title, $page_sub_title, $page_icon); 
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
                        <h3 class="box-title"><?php echo getlang('enter_sub_details'); ?></h3>
                    </div>

                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addSubject" class="form-horizontal" action="<?php echo base_url() ?>subjects/add" method="post" >
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <?php echo fieldBuilder('input', 'name', $name, $subject_name, 'required'); ?>
                                </div>
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
                                            <a class="btn  btn-default" href="<?php echo base_url().'subjects'; ?>" title="Cancel"> <?php echo getlang('cancel'); ?> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        
                    </form>
                    <!-- form end -->

                </div>
            </div>
        </div> 
           
    </section>
    
</div>
