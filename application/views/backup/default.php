<?php
    $token_name = $this->security->get_csrf_token_name();
    $token_hash = $this->security->get_csrf_hash();

?>

<div class="content-wrapper">
	<section class="content">
        <div class="row">
            <div class="col-md-12">
            	<div class="box">
            		<div class="box-body ">

                        <h3 class="text-center">Student's Backup & Restore</h3>
                        <a href="<?php echo base_url() ?>backup/download_students_csv" class="btn btn-primary">Download CSV</a>
                        <a href="<?php echo base_url() ?>backup/download_students_avatar" class="btn btn-primary">Download Student's Avatar</a>

                        <hr>

                        
                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 20px;">
                        	<div class="container-fluid">
                        		<div class="row">
                        			<div class="col-md-3 text-right"><b>Upload CSV:</b></div>
                        			<div class="col-md-3"><input type="file" id="student_data" name="student_data"></div>
                        			<div class="col-md-2 text-center"><input type="button" id="upload_student_csv" class="btn btn-primary" value="Restore" ></div>
                        			<div class="col-md-4 text-left"><div id="student_csv_result"></div></div>
                        		</div>
                        	</div>
                        </form>

                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 20px;">
                        	<div class="container-fluid">
                        		<div class="row">
                        			<div class="col-md-3 text-right"><b>Upload Avatar:</b></div>
                        			<div class="col-md-3"><input type="file" id="student_avatars" name="student_avatars"></div>
                        			<div class="col-md-2 text-center"><input type="button" id="upload_student_avatar" class="btn btn-primary" value="Restore" name=""></div>
                        			<div class="col-md-4 text-left"><div id="student_avatar_result"></div></div>
                        		</div>
                        	</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
            	<div class="box">
            		<div class="box-body ">

                        <h3 class="text-center">Teacher's Backup & Restore</h3>
                        <a href="<?php echo base_url() ?>backup/download_teachers_csv" class="btn btn-primary">Download CSV</a>
                        <a href="<?php echo base_url() ?>backup/download_teachers_avatar" class="btn btn-primary">Download Teacher's Avatar</a>

                        <hr>

                        
                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 20px;">
                        	<div class="container-fluid">
                        		<div class="row">
                        			<div class="col-md-3 text-right"><b>Upload CSV:</b></div>
                        			<div class="col-md-3"><input type="file" id="teachers_data" name="teachers_data"></div>
                        			<div class="col-md-2 text-center"><input type="button" id="upload_teachers_csv" class="btn btn-primary" value="Restore" ></div>
                        			<div class="col-md-4 text-left"><div id="teachers_csv_result"></div></div>
                        		</div>
                        	</div>
                        </form>

                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 20px;">
                        	<div class="container-fluid">
                        		<div class="row">
                        			<div class="col-md-3 text-right"><b>Upload Avatar:</b></div>
                        			<div class="col-md-3"><input type="file" id="teacher_avatars" name="teacher_avatars"></div>
                        			<div class="col-md-2 text-center"><input type="button" id="upload_teachers_avatar" class="btn btn-primary" value="Restore" name=""></div>
                        			<div class="col-md-4 text-left"><div id="teachers_avatar_result"></div></div>
                        		</div>
                        	</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
            	<div class="box">
            		<div class="box-body ">

                        <h3 class="text-center">Other's Backup & Restore</h3>
                        <a href="<?php echo base_url() ?>backup/download_class_csv" class="btn btn-primary">Download Class CSV</a>
                        <a href="<?php echo base_url() ?>backup/download_subjects_csv" class="btn btn-primary">Download Subjects CSV </a>
                        <a href="<?php echo base_url() ?>backup/download_exams_csv" class="btn btn-primary">Download Exams CSV </a>
                        <a href="<?php echo base_url() ?>backup/download_field_csv" class="btn btn-primary">Download Custom field CSV </a>
                        <hr>

                        
                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 20px;">
                        	<div class="container-fluid">
                        		<div class="row">
                        			<div class="col-md-3 text-right"><b>Upload Class CSV:</b></div>
                        			<div class="col-md-3"><input type="file" id="upload_class" ></div>
                        			<div class="col-md-2 text-center"><input type="button" id="btn_upload_class" class="btn btn-primary" value="Restore" ></div>
                        			<div class="col-md-4 text-left"><div id="result_class"></div></div>
                        		</div>
                        	</div>
                        </form>

                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 20px;">
                        	<div class="container-fluid">
                        		<div class="row">
                        			<div class="col-md-3 text-right"><b>Upload Subjects CSV:</b></div>
                        			<div class="col-md-3"><input type="file" id="upload_subjects" ></div>
                        			<div class="col-md-2 text-center"><input type="button" id="btn_upload_subjects" class="btn btn-primary" value="Restore" ></div>
                        			<div class="col-md-4 text-left"><div id="result_subjects"></div></div>
                        		</div>
                        	</div>
                        </form>

                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 20px;">
                        	<div class="container-fluid">
                        		<div class="row">
                        			<div class="col-md-3 text-right"><b>Upload Exams CSV:</b></div>
                        			<div class="col-md-3"><input type="file" id="upload_exam" ></div>
                        			<div class="col-md-2 text-center"><input type="button" id="btn_upload_exam" class="btn btn-primary" value="Restore" ></div>
                        			<div class="col-md-4 text-left"><div id="result_exam"></div></div>
                        		</div>
                        	</div>
                        </form>

                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 20px;">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3 text-right"><b>Upload Custom Field CSV:</b></div>
                                    <div class="col-md-3"><input type="file" id="upload_field" ></div>
                                    <div class="col-md-2 text-center"><input type="button" id="btn_upload_field" class="btn btn-primary" value="Restore" ></div>
                                    <div class="col-md-4 text-left"><div id="result_field"></div></div>
                                </div>
                            </div>
                        </form>

                        
                        
                    </div>
                </div>
            </div>
        </div>


        


    </section>
</div>

<input type="hidden" id="csrf" name="<?php echo $token_name; ?>" value="<?php echo $token_hash; ?>" />

<?php 
$student_csv_controler = base_url()."backup/upload_students_csv";
$student_avatar_controler = base_url()."backup/upload_students_avatar";

$teachers_csv_controler = base_url()."backup/upload_teachers_csv";
$teachers_avatar_controler = base_url()."backup/upload_teachers_avatar";

$class_csv_controler = base_url()."backup/upload_class_csv";
$subjects_csv_controler = base_url()."backup/upload_subjects_csv";
$exams_csv_controler = base_url()."backup/upload_exam_csv";
$field_csv_controler = base_url()."backup/upload_field_csv";

?>
<script type="text/javascript">

	// ##### Student's avatar upload
    jQuery( "#upload_student_avatar" ).click(function() { 
    	var formData = new FormData();
        var hashValue  = jQuery('#csrf').val();
        formData.append('<?php echo $token_name; ?>', hashValue);
        formData.append('file', jQuery('#student_avatars')[0].files[0]);
        jQuery('#student_avatar_result').html('Loading....');
        if (formData) {
	        jQuery.ajax({
		        url : '<?php echo $student_avatar_controler; ?>',
		        type : 'POST',
		        data : formData,
		        processData: false,  // tell jQuery not to process the data
		        contentType: false,  // tell jQuery not to set contentType
		        success : function(data) {
                    var obj = jQuery.parseJSON(data); 
                    var new_hash = obj.csrfHash; 
                    jQuery("#csrf").val(new_hash);
		            jQuery('#student_avatar_result').html(obj.html);
		            jQuery('#student_avatars').val(''); 
		       }
	        });
         }
    });

    // ##### Student's CSV upload
    jQuery( "#upload_student_csv" ).click(function() { 
    	var csvData    = new FormData();
        var hashValue  = jQuery('#csrf').val();
        csvData.append('<?php echo $token_name; ?>', hashValue);
        csvData.append('csv', jQuery('#student_data')[0].files[0]);
        jQuery('#student_csv_result').html('Loading....');
        if (csvData) {
	        jQuery.ajax({
		        url : '<?php echo $student_csv_controler; ?>',
		        type : 'POST',
		        data : csvData,
		        processData: false,  // tell jQuery not to process the data
		        contentType: false,  // tell jQuery not to set contentType
		        success : function(data) {
                    var obj = jQuery.parseJSON(data); 
                    var new_hash = obj.csrfHash; 
                    jQuery("#csrf").val(new_hash);
		            jQuery('#student_csv_result').html(obj.html);
		            jQuery('#student_data').val(''); 
		       }
	        });
         }
    });

    // ##### Teacher's avatar upload
    jQuery( "#upload_teachers_avatar" ).click(function() { 
    	var tformData = new FormData();
        var hashValue  = jQuery('#csrf').val();
        tformData.append('<?php echo $token_name; ?>', hashValue);
        tformData.append('file', jQuery('#teacher_avatars')[0].files[0]);
        jQuery('#teachers_avatar_result').html('Loading....');
        if (tformData) {
	        jQuery.ajax({
		        url : '<?php echo $teachers_avatar_controler; ?>',
		        type : 'POST',
		        data : tformData,
		        processData: false,  // tell jQuery not to process the data
		        contentType: false,  // tell jQuery not to set contentType
		        success : function(data) {
                    var obj = jQuery.parseJSON(data); 
                    var new_hash = obj.csrfHash; 
                    jQuery("#csrf").val(new_hash);
		            jQuery('#teachers_avatar_result').html(obj.html);
		            jQuery('#teacher_avatars').val(''); 
		       }
	        });
         }
    });

    // ##### Teacher's CSV upload
    jQuery( "#upload_teachers_csv" ).click(function() { 
    	var tcsvData = new FormData();
        var hashValue  = jQuery('#csrf').val();
        tcsvData.append('<?php echo $token_name; ?>', hashValue);
        tcsvData.append('tcsv', jQuery('#teachers_data')[0].files[0]);
        jQuery('#teachers_csv_result').html('Loading....');
        if (tcsvData) {
	        jQuery.ajax({
		        url : '<?php echo $teachers_csv_controler; ?>',
		        type : 'POST',
		        data : tcsvData,
		        processData: false,  // tell jQuery not to process the data
		        contentType: false,  // tell jQuery not to set contentType
		        success : function(data) {
                    var obj = jQuery.parseJSON(data); 
                    var new_hash = obj.csrfHash; 
                    jQuery("#csrf").val(new_hash);
		            jQuery('#teachers_csv_result').html(obj.html);
		            jQuery('#teachers_data').val(''); 
		       }
	        });
         }
    });

    // ##### Class CSV upload
    jQuery( "#btn_upload_class" ).click(function() { 
        var class_csv = new FormData();
        var hashValue  = jQuery('#csrf').val();
        class_csv.append('<?php echo $token_name; ?>', hashValue);
        class_csv.append('csv', jQuery('#upload_class')[0].files[0]);
        jQuery('#result_class').html('Loading....');
        if (class_csv) {
            jQuery.ajax({
                url : '<?php echo $class_csv_controler; ?>',
                type : 'POST',
                data : class_csv,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success : function(data) {
                    var obj = jQuery.parseJSON(data); 
                    var new_hash = obj.csrfHash; 
                    jQuery("#csrf").val(new_hash);
                    jQuery('#result_class').html(obj.html);
                    jQuery('#upload_class').val(''); 
               }
            });
         }
    });

    // ##### Subjects CSV upload
    jQuery( "#btn_upload_subjects" ).click(function() { 
        var sub_csv = new FormData();
        var hashValue  = jQuery('#csrf').val();
        sub_csv.append('<?php echo $token_name; ?>', hashValue);
        sub_csv.append('csv', jQuery('#upload_subjects')[0].files[0]);
        jQuery('#result_subjects').html('Loading....');
        if (sub_csv) {
            jQuery.ajax({
                url : '<?php echo $subjects_csv_controler; ?>',
                type : 'POST',
                data : sub_csv,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success : function(data) {
                    var obj = jQuery.parseJSON(data); 
                    var new_hash = obj.csrfHash; 
                    jQuery("#csrf").val(new_hash);
                    jQuery('#result_subjects').html(obj.html);
                    jQuery('#upload_subjects').val(''); 
               }
            });
         }
    });

    // ##### Exams CSV upload
    jQuery( "#btn_upload_exam" ).click(function() { 
        var exam_csv = new FormData();
        var hashValue  = jQuery('#csrf').val();
        exam_csv.append('<?php echo $token_name; ?>', hashValue);
        exam_csv.append('csv', jQuery('#upload_exam')[0].files[0]);
        jQuery('#result_exam').html('Loading....');
        if (exam_csv) {
            jQuery.ajax({
                url : '<?php echo $exams_csv_controler; ?>',
                type : 'POST',
                data : exam_csv,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success : function(data) {
                    var obj = jQuery.parseJSON(data); 
                    var new_hash = obj.csrfHash; 
                    jQuery("#csrf").val(new_hash);
                    jQuery('#result_exam').html(obj.html);
                    jQuery('#upload_exam').val(''); 
               }
            });
         }
    });

    // ##### Custom Field CSV upload
    jQuery( "#btn_upload_field" ).click(function() { 
        var field_csv = new FormData();
        var hashValue  = jQuery('#csrf').val();
        field_csv.append('<?php echo $token_name; ?>', hashValue);
        field_csv.append('csv', jQuery('#upload_field')[0].files[0]);
        jQuery('#result_field').html('Loading....');
        if (field_csv) {
            jQuery.ajax({
                url : '<?php echo $field_csv_controler; ?>',
                type : 'POST',
                data : field_csv,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success : function(data) {
                    var obj = jQuery.parseJSON(data); 
                    var new_hash = obj.csrfHash; 
                    jQuery("#csrf").val(new_hash);
                    jQuery('#result_field').html(obj.html);
                    jQuery('#upload_field').val(''); 
               }
            });
         }
    });

   

</script>