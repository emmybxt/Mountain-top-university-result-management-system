
<?php
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $id = '';
    $title = '';
    if(!empty($data))
    {
        foreach ($data as $item)
        {
            $id = $item->id;
            $title = $item->title;
        }
    }
    $markdistribution_title = getlang('markdistribution_title');

?>


<div class="content-wrapper">

    <?php 
    $page_title = getlang('markdistribution_from');
    $page_icon = 'fa-book';
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

                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addSubject" class="form-horizontal" action="<?php echo base_url() ?>markdistribution/add" method="post" >
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <?php echo fieldBuilder('input', 'title', $title, $markdistribution_title, 'required'); ?>
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
                                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('save'); ?>" /> 
                                            <a class="btn  btn-default" href="<?php echo base_url().'markdistribution'; ?>" title="Cancel"> <?php echo getlang('cancel'); ?> </a>
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
