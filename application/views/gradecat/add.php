
<?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $id = '';
    $name = '';
    $mark = '';

    if(!empty($dp_data))
    {
        foreach ($dp_data as $item)
        {
            $id = $item->id;
            $name = $item->name;
            $mark = $item->mark;
        }
            
    }
		
    // Set grade category name field
    $grade_cat_text = getlang('grade_cat_title');
    $cat_field      = fieldBuilder('input', 'name', $name, $grade_cat_text, 'required');

    // Set grade category mark field
    $grade_cat_mark_text = getlang('grade_cat_mark');
    $mark_field      = fieldBuilder('input', 'mark', $mark, $grade_cat_mark_text, 'required');

      
?>

<div class="content-wrapper class-page">
    
    <?php 
    $page_title = getlang('grade_cat');
    $page_icon = 'fa-sitemap';
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
                    <form class="form-horizontal" action="<?php echo base_url() ?>gradecat/add" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6"> <?php echo $cat_field; ?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"> <?php echo $mark_field; ?></div>
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
                                            <a class="btn  btn-default" href="<?php echo base_url().'gradecat'; ?>" title="Cancel"> <?php echo getlang('cancel'); ?> </a>
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

