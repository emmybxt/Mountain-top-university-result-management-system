<?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $id          = '';
    $name        = '';
    $grade_point = '';
    $point_from  = '';
    $point_to    = '';
    $mark_from   = '';
    $mark_upto   = '';
    $comment     = '';
    $category    = '';

    if(!empty($grade_data))
    {
        foreach ($grade_data as $item)
        {
            $id           = $item->id;
            $name         = $item->name;
            $grade_point  = $item->grade_point;
            $point_from   = $item->point_from;
            $point_to     = $item->point_to;
            $mark_from    = $item->mark_from;
            $mark_upto    = $item->mark_upto;
            $comment      = $item->comment;
            $category     = $item->category;
        }
    }

    // Set category
    $category_list  = getGradeSystem($category, 'category');
    $category_field = fieldBuilder('select', 'category', $category_list, 'Category', '');

    $grade_details = getlang('grade_details');
    $subject_name = getlang('grade_name');
    $grade_credit = getlang('grade_point');
    $mark_start = getlang('mark_from');
    $mark_end = getlang('mark_upto');

?>


<div class="content-wrapper">

    <?php 
    $page_title = getlang('grade_form');
    $page_icon = 'fa-signal';
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
                        <h3 class="box-title"><?php echo getlang('grade_details'); ?></h3>
                    </div>

                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" class="form-horizontal" id="addUser" action="<?php echo base_url() ?>grade/add" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6"><?php echo fieldBuilder('input', 'name', $name, $subject_name, 'required'); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><?php echo fieldBuilder('input', 'grade_point', $grade_point, $grade_credit, 'required'); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo fieldBuilder('input', 'point_from', $point_from, 'Point from', 'required'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo fieldBuilder('input', 'point_to', $point_to, 'Point to', 'required'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><?php echo fieldBuilder('input', 'mark_from', $mark_from, $mark_start, 'required'); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><?php echo fieldBuilder('input', 'mark_upto', $mark_upto, $mark_end, 'required'); ?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"><?php echo fieldBuilder('input', 'comment', $comment, 'Comment', 'required'); ?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"><?php echo $category_field; ?></div>
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
                                            <a class="btn  btn-default" href="<?php echo base_url().'grade'; ?>" title="Cancel"> <?php echo getlang('cancel'); ?> </a>
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
