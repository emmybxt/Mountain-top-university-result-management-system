<?php 

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );
?>
<div class="content-wrapper">
    
    <section class="content">
        <div class="row">
             <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-8 title-bar">
                <h1>
                    <i class="fa fa-users"></i> 
                    <?php echo getlang('student_list'); ?>
                </h1>
            </div>

            <div class="col-xs-12 col-md-4 text-right">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>students/add"><i class="fa fa-plus"></i> <?php echo getlang('add_new'); ?></a>
            </div>
        </div>
       

        <div class="row">
            <div class="col-xs-12 rms-data-table">
                <div class="box">
                <div class="box-header">
                    <form action="<?php echo base_url() ?>students" method="post" id="searchList">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-3 " style="padding-left: 0;">
                                    <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" placeholder="Search"/>
                                    <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <?php 
                                        $class_object = getClassObject();
                                        $output = '<select name= "class_value" onchange="this.form.submit()" class="form-control input-sm" >';
                                        $output .= '<option value="0">'.getlang('select_class').'</option>';
                                        foreach ($class_object as $key => $class_item) {
                                            if ($class_value == $class_item->id) {
                                                $output .= '<option selected="selected" value="'.$class_item->id.'">'.$class_item->name.'</option>';
                                            }else{
                                                $output .= '<option value="'.$class_item->id.'">'.$class_item->name.'</option>';
                                            }
                                        }
                                        $output .= '</select>';
                                        echo $output;
                                        ?>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <?php 
                                        $department_object = getDepartmentObject();
                                        $output = '<select name= "department_value" onchange="this.form.submit()" class="form-control input-sm" >';
                                        $output .= '<option value="0">'.getlang('select_class').'</option>';
                                        foreach ($department_object as $key => $department_item) {
                                            if ($department_value == $department_item->id) {
                                                $output .= '<option selected="selected" value="'.$department_item->id.'">'.$department_item->department_name.'</option>';
                                            }else{
                                                $output .= '<option value="'.$department_item->id.'">'.$department_item->department_name.'</option>';
                                            }
                                        }
                                        $output .= '</select>';
                                        echo $output;
                                        ?>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <?php 
                                        $year_start = getParam('year_start');
                                        $year_end = getParam('year_end');
                                        $year_html ='<select onchange="this.form.submit()" class="form-control input-sm" name="year_value" >';
                                        for($i = $year_start; $i <= $year_end; $i++) {
                                                if(!empty($year_value)){
                                                    $isCurrentY = ($i == $year_value) ? 'true': 'false';
                                                }else{
                                                    $isCurrentY = ($i == $i) ? 'true': 'false';
                                                    $isCurrentY = ($i == intVal(date("Y"))) ? 'true': 'false';
                                                }

                                            $year_html .='<option value="'.$i.'"';
                                            if($isCurrentY=="true"){ $year_html .='selected="selected"';}else{ } 
                                            $year_html .='>'.$i.'</option>';
                                        }
                                        $year_html .='</select>';
                                        echo $year_html;
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    </form>
                </div>


                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover rms-table">
                        <tr>
                      	<th><?php echo getlang('students'); ?></th>
                      	<th><?php echo getlang('class'); ?></th>
                      	<th><?php echo getlang('department'); ?></th>
                      	<th><?php echo getlang('roll'); ?></th>
                      	<?php 
                      	$showFieldData = getfieldsdata('fields', '*', 'list');
                      	foreach ($showFieldData as $key => $item) { ?>
                      		<th><?php echo $item->field_name; ?></th>
                      	<?php } 
                        ?>
                      	<th><?php echo getlang('phone'); ?></th>
                      	<th><?php echo getlang('year'); ?></th>
                      	<th class="text-center" width="120px"><?php echo getlang('action'); ?></th>
                      	<th class="text-center" width="90px">id</th>
                        </tr>

                        <?php
                        if(!empty($studentsRecords))
                        {
                            foreach($studentsRecords as $record)
                            {
                          
                              	if(empty($record->avatar)){
                                  $img_path = site_url('/uploads/students/').'/avator.png';
                              	}else{
                                  $img_path = site_url('/uploads/students/').'/'.$record->avatar;
                              	}
                                ?>
                                <tr>
                              	<td>
                                	<img src="<?php echo $img_path; ?>" alt="<?php echo $record->name; ?>" class="avatar" > 
                                	<?php echo $record->name; ?>
                              	</td>
                              	<td>
                                <?php
                               	if (!empty($record->class)) {
                                	echo getSingledata('class', 'name', 'id', $record->class);
                                }else{				

                                } 
                               	?>
                       	        </td>

                      	        <td>
                                <?php 
                          		if (!empty($record->department)) {
    	                         	echo getSingledata('departments', 'department_name', 'id', $record->department);
    	                        }else{        

    	                        } 
	                            ?>  
                                </td>
                      	        <td><?php echo $record->roll; ?></td>

	                            <?php 
	                  		    $showFieldData = getfieldsdata('fields', '*', 'list');
	                  		    foreach ($showFieldData as $key => $item) {?>
	                  			<td><?php echo getSingledata('fields_data', 'data', 'fid', $item->id); ?></td>
	                  		    <?php } ?>
                              	<td><?php echo $record->phone; ?></td>
                              	<td><?php echo $record->year; ?></td>
                      	        <td class="text-center">
                          	       <a class="btn btn-sm btn-primary" href="<?= base_url().'students/view/'.$record->id; ?>" title="Profile view"><i class="fa fa-eye"></i></a> 
                          	       <a class="btn btn-sm btn-info" href="<?php echo base_url().'students/edit/'.$record->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                          	       <a class="btn btn-sm btn-danger deleteStudent" data-id="<?php echo $record->id; ?>" id="studentId" href="#"  title="Delete"><i class="fa fa-trash"></i></a>
                      	        </td>
                      	        <td class="text-center"><?php echo $record->id; ?></td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                    </table>

                    <?php 
                    if(empty($studentsRecords)){
                        echo '<p style="text-align:center;color:red;">No item found !</p>';
                    }
                    ?>
                </div>
                
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){

        /**
        ** Call Pagination
        **/
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "students/" + value);
            jQuery("#searchList").submit();
        });


        /**
        ** Call Delete
        **/
        jQuery(document).on("click", ".deleteStudent", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "students/delete",
            currentRow = $(this);
            var confirmation = confirm("Are you sure want to delete ?");
        
            if(confirmation)
            {
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { Id : Id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>' } 
                }).done(function(data){
                    console.log(data);
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("Student successfully deleted"); }
                    else if(data.status = false) { alert("Student deletion failed"); }
                    else { alert("Access denied..!"); }
                    location.reload();
                });
            }
        });

    });
</script>





