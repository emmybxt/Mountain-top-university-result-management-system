
<?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $id = '';
    $field_name = '';
    $published = '';
    $type = '';
    $required = '';
    $section = '';
    $option_param = '';
    $field_order = '';
    $profile = '';
    $list = '';
    if (!empty($field_data)) {
        
        foreach ($field_data as $key => $item) {
            $id = $item->id;
            $field_name = $item->field_name;
            $published = $item->published;
            $type = $item->type;
            $required = $item->required;
            $section = $item->section;
            $option_param = $item->option_param;
            $field_order = $item->field_order;
            $profile = $item->profile;
            $list = $item->list;
        }
    }else{

    }


    $published_field = getStatus('published', $published);
    $required_field = getYesNo('required_field', $required);

    $display_on_profile = getYesNo('display_on_profile', $profile);
    $display_on_list = getYesNo('display_on_list', $list);
    $typefield = getFieldType($type, 'fields_type');
    $sectionfield = getFieldSection($section, 'fields_section');

?>


<div class="content-wrapper class-page">
    
    <?php 
    $page_title = getlang('field_manage');
    $page_icon = 'fa-cog';
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
                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url() ?>fields/add/" method="post" >
                        <div class="box-body">
                           
                            <div class="row">
                                <div class="col-md-6"> <?php echo fieldBuilder('input', 'field_name', $field_name, 'Field Name', 'required'); ?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"> <?php echo fieldBuilder('select', 'field_type', $typefield, 'Field Type', 'required'); ?></div>
                            </div>


                            <div class="row">
                                <div class="col-md-6"> <?php echo fieldBuilder('select', 'section', $sectionfield, 'Section', 'required'); ?></div>
                            </div>


                            <div class="row">
                               <div class="col-md-6"><?php echo fieldBuilder('select', 'publishe', $published_field, 'Published', ''); ?> </div>
                            </div>


                            <div class="row">
                               <div class="col-md-6"><?php echo fieldBuilder('select', 'required', $required_field, 'Required', ''); ?> </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6"> <?php echo fieldBuilder('input', 'field_order', $field_order, 'Field Order', 'required'); ?></div>
                            </div>


                            <div class="row">
                                <div class="col-md-6"> <?php echo fieldBuilder('textarea', 'option_value', $option_param, 'Option Value', ''); ?></div>
                            </div>


                            <div class="row">
                               <div class="col-md-6"><?php echo fieldBuilder('select', 'display_profile', $display_on_profile, 'Dispaly on profile', ''); ?> </div>
                            </div>

                            <div class="row">
                               <div class="col-md-6"><?php echo fieldBuilder('select', 'display_on_list', $display_on_list, 'Dispaly on list', ''); ?> </div>
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
                                            <a class="btn  btn-default" href="<?php echo base_url().'fields'; ?>" title="Cancel"> <?php echo getlang('cancel'); ?> </a>
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
