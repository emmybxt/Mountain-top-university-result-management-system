<?php 

    // Get Total Student
    $studentList = getMultipaledata('students', '*');
    $total_students = count($studentList);

    // Get Total Class
    $classList = getMultipaledata('class', '*');
    $total_class = count($classList);

    // Get Total Subject
    $subjectsList = getMultipaledata('subjects', '*');
    $total_subjects = count($subjectsList);

    // Get Total Exam
    $examList = getMultipaledata('exam', '*');
    $total_exam = count($examList);

?>


<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
             <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>
        
        <h1>
            <i class="fa fa-tachometer" aria-hidden="true"></i><?php echo getlang('dashboard'); ?>
            <small><?php echo getlang('control_panel') ?></small>
        </h1>

    </section>
    
    <section class="content">

        
        <!-- Get Panel -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo $total_students; ?></h3>
                        <p><?php echo getlang('total_students'); ?></p>
                    </div>
                    <div class="icon">
                        <i class="ion-ios-people"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $total_class; ?></h3>
                        <p><?php echo getlang('total_class'); ?></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sitemap"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo $total_subjects; ?></h3>
                        <p><?php echo getlang('total_subjects'); ?></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo $total_exam; ?></h3>
                        <p><?php echo getlang('total_exam'); ?></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-pencil"></i>
                    </div>
                </div>
            </div>
        </div>
	                                        
        <!-- Get Quick Icon Link -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="box-header">
                            <h3 class="box-title"> <i class="fa fa-university"></i> Quick icon</h3>
                        </div>

                        <a href="<?php echo base_url();?>classes/classlist" class="btn btn-app">
                  	    <i class="fa fa-sitemap"></i> <?php echo getlang('list_class');?>
                        </a>

                        <a href="<?php echo base_url();?>classes/add" class="btn btn-app">
                  	    <i class="fa fa-sitemap"></i> <?php echo getlang('new_class'); ?>
                        </a>

                        <a href="<?php echo base_url();?>subjects" class="btn btn-app">
                  	    <i class="fa fa-book"></i> <?php echo getlang('list_subject'); ?>
                        </a>

                        <a href="<?php echo base_url();?>subjects/add" class="btn btn-app">
                  	    <i class="fa fa-book"></i> <?php echo getlang('new_subject'); ?>
                        </a>

                        <a href="<?php echo base_url();?>departments/departmentslist" class="btn btn-app">
                        <i class="fa fa-building-o"></i> Departments
                        </a>

                        <a href="<?php echo base_url();?>user/userlist" class="btn btn-app">
                  	    <i class="fa fa-users"></i> <?php echo getlang('list_teacher'); ?>
                        </a>

                        <a href="<?php echo base_url();?>user/add" class="btn btn-app">
                  	    <i class="fa fa-user"></i> <?php echo getlang('new_teacher'); ?>
                        </a>

                        <a href="<?php echo base_url();?>configuration"  class="btn btn-app">
                  	    <i class="fa fa-cog"></i> <?php echo getlang('configuration'); ?>
                        </a>

                        <a href="<?php echo base_url();?>languages" class="btn btn-app">
                  	    <i class="fa fa-support"></i> <?php echo getlang('manage_language'); ?>
                        </a>

                        <a href="<?php echo base_url();?>backup" class="btn btn-app">
                        <i class="fa fa-archive"></i> <?php echo getlang('backup_restore'); ?>
                        </a>

                        <a href="<?php echo base_url();?>exam" class="btn btn-app">
                        <i class="fa fa-pencil"></i> <?php echo getlang('list_exam'); ?>
                        </a>

                        <a href="<?php echo base_url();?>exam/add" class="btn btn-app">
                        <i class="fa fa-pencil"></i> <?php echo getlang('new_exam'); ?>
                        </a>

                        <a href="<?php echo base_url();?>mark" class="btn btn-app">
                        <i class="fa fa-pencil-square-o"></i> <?php echo getlang('get_mark'); ?>
                        </a>

                        <a href="<?php echo base_url();?>grade" class="btn btn-app">
                        <i class="fa fa-signal"></i> <?php echo getlang('list_grade'); ?>
                        </a>

                        <a href="<?php echo base_url();?>grade/add" class="btn btn-app">
                        <i class="fa fa-signal"></i> <?php echo getlang('new_grade'); ?>
                        </a>

                        <a href="<?php echo base_url();?>students/studentlist" class="btn btn-app">
                        <i class="fa fa-users"></i> <?php echo getlang('list_student'); ?>
                        </a>

                        <a href="<?php echo base_url();?>students/add" class="btn btn-app">
                        <i class="fa fa-user"></i> <?php echo getlang('new_student'); ?>
                        </a>

                        <a href="<?php echo base_url();?>result" class="btn btn-app">
                        <i class="fa fa-graduation-cap"></i> <?php echo getlang('result_quick'); ?>
                        </a>

                        <a href="<?php echo base_url();?>certificate" class="btn btn-app">
                        <i class="fa fa-certificate"></i> <?php echo getlang('certificate_quick'); ?>
                        </a>

                        <a href="<?php echo base_url();?>fields/fieldslist" class="btn btn-app">
                        <i class="fa fa-cog"></i> Field Builder
                        </a>
                  
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



