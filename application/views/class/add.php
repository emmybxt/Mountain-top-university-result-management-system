
<?php

    $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
    );

    $id                = '';
    $name              = '';
    $s_name            = '';
    $optional_subject  = '';
    $class_field       ='';
    $subject_field     ='';
    $mark_distribution = '';

    if(!empty($class_data))
    {
        foreach ($class_data as $item)
        {
            $id                = $item->id;
            $name              = $item->name;
            $s_name            = $item->subjects;
            $optional_subject  = $item->optional_subject;
            $mark_distribution = $item->mark_distribution;
        }
            
    }

    // Get text from language
	$class_title_text       = getlang('class_name');
	$subject_text           = getlang('subjects');
    $optional_subject_text  = getlang('optional_subjects');
    $mark_distribution_text = getlang('assigning_mark_distribution');

    // Set class name field
    $class_field = fieldBuilder('input', 'name', $name, $class_title_text, 'required');

    // Set class main subject field
    $subject_list = getSubjects($s_name);
    $subject_field = fieldBuilder('select', 's_name', $subject_list, $subject_text, '');

    // Set class optional subject field
    $optional_subject_list = getOptionSubjects($optional_subject);
    $optional_subject_field = fieldBuilder('select', 's_name', $optional_subject_list, $optional_subject_text, '');


    // Set class mark distribution field
    $mark_distribution_list = getMarkDistributionList($mark_distribution);
    $mark_distribution_field = fieldBuilder('select', 'mark_distribution', $mark_distribution_list, $mark_distribution_text, '');

?>


<div class="content-wrapper class-page">
    
    <?php 
    $page_title = getlang('class_form');
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
                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url() ?>classes/add/" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6"> <?php echo $class_field; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><?php echo $subject_field; ?> </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"><?php echo $optional_subject_field; ?> </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"><?php echo $mark_distribution_field; ?> </div>
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
                                            <a class="btn  btn-default" href="<?php echo base_url().'classes'; ?>" title="Cancel"> <?php echo getlang('cancel'); ?> </a>
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

<script type="text/javascript">

    window.asd = jQuery('.subjectfield').SumoSelect({search: true, searchText: 'Search Subject Here.'});
    window.asd = jQuery('.mark_distributionfield').SumoSelect({search: true, searchText: 'Search Mark distribution Here.'});
           
 </script>