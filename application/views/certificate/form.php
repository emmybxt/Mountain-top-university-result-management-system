<?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    // Get language
    $roll_no = getlang('roll');
    $select_exam = getlang('select_exam');
    $select_class = getlang('select_class');
    $select_department = getlang('select_department');
    $select_year = getlang('select_year');

    // Roll Field
    $roll_field = fieldBuilder('input', 'roll', '',  $roll_no, '');

    // Exam list
    $examList = getExam('', 0, '');
    $exam_field = fieldBuilder('select', 'exam', $examList, $select_exam, '');

    // Class list
    $classList = getClass('');
    $class_field = fieldBuilder('select', 'class', $classList, $select_class, '');

    // Department List
    $department_list = getDepartment('department','');
    $department_field = fieldBuilder('select', 'department', $department_list, $select_department, '');

    // Year list
    $yearlist = yearList('year', '');
    $year_field = fieldBuilder('select', 'year', $yearlist, $select_year, '');

    $base_controler = base_url()."result/student_result";
?>

<div class="content-wrapper mark-page">
    <section class="content-header">
        <h1>
            <i class="fa fa-certificate"></i> Certificate Form 
        </h1>

        <div class="row">
             <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <form role="form" class="form-horizontal"  action="<?php echo base_url() ?>certificate/details" method="post">
                <div class="box" id="form-box">
                    <div class="box-body form-horizontal" >
                        <div class="row"><div class="col-md-6"> <?php echo $roll_field; ?> </div></div>
                        <div class="row"><div class="col-md-6"> <?php echo $class_field; ?> </div></div>
                        <div class="row"><div class="col-md-6"> <?php echo $department_field; ?> </div></div>
                        <div class="row"><div class="col-md-6"> <?php echo $exam_field; ?> </div></div>
                        <div class="row"><div class="col-md-6"> <?php echo $year_field; ?> </div></div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                               <div class="col-sm-4 control-label"></div>
                               <div class="col-sm-8">
                               <input type="submit" class="btn btn-primary" value="<?php echo getlang('view_result');?>" name="">
                               </div>
                            </div>
                          </div>
                       </div>
                    </div>
                </div>

                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                </form>

                <div class="box" id="result-area" style="display: none;">
                  <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="result"></div>
                            </div>
                        </div>
                  </div>
                </div>
            </div>
        </div>
    </section>
</div>
