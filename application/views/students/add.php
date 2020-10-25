<?php

    $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
    );

    $id               = '';
    $name             = '';
    $mobile           = '';
    $class            = '';
    $main_subjects    = '';
    $optional_subject = '';
    $department       = '';
    $year             = '';
    $roll             = '';
    $avatar           = '';

    if(!empty($studentInfo))
    {
        foreach ($studentInfo as $item)
        {
            $id               = $item->id;
            $name             = $item->name;
            $mobile           = $item->phone;
            $class            = $item->class;
            $main_subjects    = $item->main_subjects;
            $optional_subject = $item->optional_subject;
            $department       = $item->department;
            $roll             = $item->roll;
            $year             = $item->year;
            $avatar           = $item->avatar;
        }
    }

    // Set student name field
    $name_field = fieldBuilder('input', 'name', $name, getlang('full_name'), 'required');

    // Set student mobile/phone field
    $phone_field = fieldBuilder('number', 'mobile', $mobile, getlang('phone'), 'required');

    // Set roll field
    $roll_field = fieldBuilder('input', 'roll', $roll, getlang('roll'), 'required');

    // Set class field
    $class_list  = getClass($class);
    $class_field = fieldBuilder('select', 'class_name', $class_list, getlang('class'), '');

    // Set department field
    $department_list  = getDepartment('department', $department);
    $department_field = fieldBuilder('select', 'department_name', $department_list, getlang('department'), '');

    // Set year field
    $year_list = yearList('year',$year);
    $year_field = fieldBuilder('select', 'year', $year_list, getlang('select_year'), '');

    // Set class main subject field
    $subject_list = getSubjects($main_subjects);
    $subject_field = fieldBuilder('select', 'main_subjects', $subject_list, getlang('subjects'), '');

    // Set class optional subject field
    $optional_subject_list = getOptionSubjects($optional_subject);
    $optional_subject_field = fieldBuilder('select', 'optional_subject', $optional_subject_list, getlang('optional_subjects'), '');

?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css" />
<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-users"></i> <?php echo getlang('student_form'); ?></h1>
    </section>
    
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
                    <form class="form-horizontal" action="<?php echo base_url() ?>students/add" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">

                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#general"> <?php echo getlang('general'); ?></a></li>
                                <li><a data-toggle="tab" href="#academic"> <?php echo getlang('academic'); ?></a></li>
                                <li><a data-toggle="tab" href="#photo"> <?php echo getlang('photo'); ?></a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="general" class="tab-pane fade in active">
                                    <p></p>
                                    <div class="row"><div class="col-md-6"><?php echo $name_field; ?></div></div>
                                    <div class="row"><div class="col-md-6"><?php echo $phone_field; ?></div></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                                $sid = getFieldSectionID('student');
                                                $fields_list = getFieldList($sid);
                                                foreach($fields_list as $field){
                                                    $fid      = $field->id;
                                                    $sid      = $sid;
                                                    $panel_id = $id;
                                                    echo fieldshow($fid, $sid, $panel_id, $field->field_name, $field->type, $field->required);
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div id="academic" class="tab-pane fade">
                                    <p></p>
                                    <div class="row"><div class="col-md-6"><?php echo $roll_field; ?></div></div>
                                    <div class="row"><div class="col-md-6"><?php echo $class_field; ?></div></div>
                                    <div class="row"><div class="col-md-6"><?php echo $department_field; ?></div></div>
                                    <div class="row"><div class="col-md-6"><?php echo $year_field; ?></div></div>

                                    <?php 
                                    $student_choose_subject = getParam('student_choose_subject');
                                    if(!empty($student_choose_subject)):
                                    ?>
                                    <div class="row"><div class="col-md-6"><?php echo $subject_field; ?></div></div>
                                    <div class="row"><div class="col-md-6"><?php echo $optional_subject_field; ?></div></div>
                                    <?php endif; ?>
                                </div>

                                <div id="photo" class="tab-pane fade">
                                    <p></p>
                                    <div class="row">
                                        <div class="col-md-6 rms-profile-image">
                                            <?php 
                                            if(empty($avatar)){
                                                $img_path = site_url('/uploads/students/').'avator.png';
                                            }else{
                                                $img_path = site_url('/uploads/students/').$avatar;
                                            }
                                            $avatar_field = '<input type="file" name="avatar" onchange="readURL(this, 1);" />';
                                            echo fieldBuilder('select', 'avatar', $avatar_field, getlang('photo'), '');
                                            ?>

                                            <div class="form-group">
                                                <div class="col-sm-4 control-label"></div>
                                                <div class="col-sm-8">
                                                  <img src="<?php echo $img_path; ?>" id="preview_1" alt="avator"  >
                                                  <input type="hidden" value="<?php echo $avatar; ?>" name="old_avatar">
                                                </div>
                                            </div>
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
                                            <input type="hidden" value="<?php echo $id; ?>" name="id">
                                            <input type="submit" class="btn btn-primary" value="<?php echo getlang('save'); ?>" /> 
                                            <a class="btn  btn-default" href="<?php echo base_url().'students'; ?>" title="Cancel"> <?php echo getlang('cancel'); ?> </a>
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

<script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.datepicker').datepicker({
          autoclose: true,
          format : "dd-mm-yyyy"
        });
    });

    window.asd = jQuery('.subjectfield').SumoSelect({search: true, searchText: 'Search Subject Here.'});
</script>
