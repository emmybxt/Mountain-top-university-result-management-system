
<?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $id        = '';
    $name      = '';
    $exam_date = '';
    $class     = '';
    $param     = '';
    $status    = '';

    if(!empty($exam_data))
    {
        foreach ($exam_data as $item)
        {
            $id        = $item->id;
            $name      = $item->name;
            $exam_date = $item->exam_date;
            $class     = $item->class;
            $param     = $item->param;
            $status    = $item->status;
        }
    }


    $date_field = '<input  type="text" name="exam_date" value="'.$exam_date.'" class="form-control datepicker" placeholder="Exam Date"/>  ';
    $status_list =  getStatus('status', $status);

    $class_list = getClassList($class);
    $class_field = fieldBuilder('select', 'class', $class_list, 'Select Class', '');

    $exam_name = getlang('exam_name');
    $date = getlang('exam_date');
    $exam_status = getlang('status');

?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css" />
<div class="content-wrapper">
    <?php 
    $page_title = getlang('exam_manage');
    $page_icon = 'fa-pencil';
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
                    <form role="form" class="form-horizontal"  id="exam_form" action="<?php echo base_url() ?>exam/add/" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6"><?php echo fieldBuilder('input', 'name', $name, $exam_name, 'required'); ?> </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"><?php echo fieldBuilder('select', 'date_field', $date_field, $date, ''); ?> </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"><?php echo $class_field; ?> </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6"><?php echo fieldBuilder('select', 'status', $status_list, $exam_status, ''); ?> </div>
                            </div>

                            <?php if(!empty($class)){ ?>
                            <div class="row">
                                <div class="col-md-12">

                                    <?php 
                                    $param_data = json_decode($param,true);
                                    $exam_class = explode(",", $class);
                                    foreach ($exam_class as $exam_class_row){
                                        $class_id   = $exam_class_row;
                                        $class_name = getSingledata('class', 'name', 'id', $class_id);

                                        // Get main subject
                                        $main_subject = getSingledata('class', 'subjects', 'id', $class_id);
                                        if(!empty($main_subject)){
                                            $main_subject_array = explode(",", $main_subject);
                                        }else{
                                            $main_subject_array = array();
                                        }

                                        // Get optional subject
                                        $optional_subject = getSingledata('class', 'optional_subject', 'id', $class_id);
                                        if(!empty($optional_subject)){
                                            $optional_subject_array = explode(",", $optional_subject);
                                        }else{
                                            $optional_subject_array = array();
                                        }

                                        $subject_array = array_merge($main_subject_array, $optional_subject_array);

                                        $mark_distribution_data = getSingledata('class', 'mark_distribution', 'id', $class_id);
                                        $md_values = explode(",", $mark_distribution_data);


                                        if(isset($param_data['class_id'][$class_id]['result_template'][0])){
                                            $result_template = $param_data['class_id'][$class_id]['result_template'][0];
                                        }else{
                                            $result_template = '';
                                        }

                                        echo'<table class="admin-table" style="width: 100%;"><tr><td>';
                                            echo'<fieldset style="border: 1px solid #ccc;margin: 10px;">';
                                                echo'<legend id="class-legend"> Class: '.$class_name.'</legend>';
                                                echo'<input type="hidden" name="exam_params[class_id][]" value="'.$class_id.'" />';


                     echo '<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_id_class" class="col-sm-4 control-label">Select result template</label>
                                        <div class="col-sm-8">
                                        '.getResultTemplateList($result_template,'exam_params[class_id]['.$class_id.'][result_template][]').'
                                        </div>
                                    </div>
                                </div>
                            </div>';
                     
                                                echo'<table style="width: 100%;" class="table table-striped class-choose">';
                                                echo'<tr>
                                                    <th style="width: 1%;">#</th>
                                                    <th>Subject Name</th>
                                                    <th style="text-align: left;">Grade System</th> 
                                                 </tr>';
                     $s=0;
                     foreach($subject_array as $subject_row){
                        $s++;
                            $subject_id = $subject_row;
                            $subject_name = getSingledata('subjects', 'name', 'id', $subject_id);
                            
                            if(isset($param_data['class_id'][$class_id]['subject_id'][$subject_id]['grade_system'][0])){
                                $grade_system = $param_data['class_id'][$class_id]['subject_id'][$subject_id]['grade_system'][0];
                            }else{
                                $grade_system = '';
                            }
                            
                            echo'<tr>';
                            echo'<td>'.$s.'</td>';
                            echo '<td style="width: 250px;padding: 10px;">'.$subject_name.'<input type="hidden" name="exam_params[class_id]['.$class_id.'][subject_id][]" value="'.$subject_id.'" /></td>';
                            echo'<td>'.getGradeSystem($grade_system,'exam_params[class_id]['.$class_id.'][subject_id]['.$subject_id.'][grade_system][]').'</td>';
                            echo'</tr>';
                     }
                     echo'</table>';
                     
                     
                     
                     echo'</fieldset>';
                     echo'</td></tr></table>';

                                    }
                                    ?>
                                    
                                </div>
                            </div>
                            <?php } ?>
                        </div>
    
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <div class="col-sm-4 control-label"></div>
                                        <div class="col-sm-8">
                                        	<input type="hidden" value="<?php echo $id; ?>" name="id">
                                            <input type="button" id="save" class="btn btn-primary" value="<?php echo getlang('save'); ?>" /> <input type="button" id="save_here" class="btn btn-primary" value="<?php echo getlang('save_here'); ?>" />
                                            <a class="btn  btn-default" href="<?php echo base_url().'exam'; ?>" title="Cancel"> <?php echo getlang('cancel'); ?> </a>
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

<?php $form_action = base_url().'exam/savehere'; ?>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    window.asd = jQuery('.class_field').SumoSelect({search: true, searchText: 'Search Subject Here.'});
    jQuery(document).ready(function(){
        jQuery('.datepicker').datepicker({
          autoclose: true,
          format : "dd-mm-yyyy"
        });
    });

    jQuery("#save").click(function(){  
        jQuery("#exam_form").submit(); 
    });

    jQuery("#save_here").click(function(){  
        jQuery('#exam_form').attr('action', '<?php echo $form_action; ?>');
        jQuery("#exam_form").submit(); 
    });
</script>