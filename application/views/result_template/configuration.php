
<?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $id     = '';
    $fields = '';
    $param  = '';

    if(!empty($records))
    {
        foreach ($records as $item)
        {
            $id     = $item->id;
            $fields = $item->fields;
            $param  = $item->param;
        }
            
    }


	
    $department_name = getlang('department_name');
    $department_field = fieldBuilder('input', 'department_name', $name, $department_name, 'required');

      
?>


<div class="content-wrapper class-page">
    
    <?php 
    $page_title = 'Result Template Configuration';
    $page_icon = 'fa-graduation-cap';
    echo sectionHeader($page_title, '', $page_icon); 
    ?>
    
    <section class="content">

        
        <div class="row">
            <div class="col-md-12">
                
                <div class="box box-primary">
                    
                    <?php $this->load->helper("form"); ?>
                    <form  class="form-horizontal" action="<?php echo base_url() ?>result_template/configuration_save/" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6"> 
                                    <?php 
                                    if(!empty($fields)){
                                        $param_data = json_decode($param,true);
                                        $field_object = explode(',', $fields);
                                        foreach ($field_object as $key => $item) {
                                            $field_array   = explode(':', $item);

                                            $field_type    = trim($field_array[0]);
                                            $field_name    = 'conf['.trim($field_array[1]).'][]';
                                            $field_label   = trim($field_array[2]);
                                            $field_default = trim($field_array[3]);

                                            if(isset($param_data[$field_array[1]][0])){
                                                $field_data = $param_data[$field_array[1]][0];
                                            }else{
                                                $field_data = $field_default;
                                            }

                                            if($field_type == 'list'){
                                                $field_list = getYesNo($field_name, $field_data);
                                                echo fieldBuilder('select', '', $field_list, $field_label, '');
                                            }

                                            if($field_type == 'text'){
                                                echo fieldBuilder('input', $field_name, $field_data, $field_label, '');
                                            }
                                        }
                                    }
                                    ?>
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
                                            <a class="btn  btn-default" href="<?php echo base_url().'result_template'; ?>" title="Cancel"> <?php echo getlang('cancel'); ?> </a>
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

