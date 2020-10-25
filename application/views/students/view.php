

<div class="content-wrapper">
    <?php echo sectionHeader($studentInfo->name.' profile', '', 'fa-user'); ?>
    <section class="content profile-page">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="box box-primary">
    				<div class="box-body">
    				    <div class="avatar">
    					    <?php 
                            if(empty($studentInfo->avatar)){
                                $img_path = site_url('/uploads/students/').'/avator.png';
                            }else{
                                $img_path = site_url('/uploads/students/').'/'.$studentInfo->avatar;
                            }
    					    ?>
    					    <img src="<?php echo $img_path; ?>" alt="<?php echo $studentInfo->name; ?>">
    				    </div>

    				    <table>
					        <tr>
								<td class="first"><?php echo getlang('students');?></td>
								<td class="second"><?php echo $studentInfo->name; ?></td>
							</tr>
					
					        <?php $fields = getfieldsdata('fields', '*', 'profile');
						    foreach ($fields as $key => $item) { ?>
								<tr>
									<td class="first"><?php echo $item->field_name;?></td>
									<td class="second"><?php echo getSingledata('fields_data', 'data', 'fid', $item->id); ?></td>
								</tr>
						    <?php }?>
					        <tr>
								<td class="first"><?php echo getlang('class');?></td>
								<td class="second">
									<?php 
									if(!empty($studentInfo->class)){
										echo getSingledata('class', 'name', 'id', $studentInfo->class); 
									}
									?>
								</td>
					        </tr>
					        <tr>
						        <td class="first"><?php echo getlang('department');?></td>
						        <td class="second">
						        	<?php 
									if(!empty($studentInfo->department)){
										echo getSingledata('departments', 'department_name', 'id', $studentInfo->department); 
									}
									?>
								</td>
					        </tr>
							<tr>
								<td class="first"><?php echo getlang('roll');?></td>
								<td class="second"><?php echo $studentInfo->roll; ?></td>
							</tr>
							<tr>
								<td class="first"><?php echo getlang('phone');?></td>
								<td class="second"><?php echo $studentInfo->phone; ?></td>
							</tr>
		  				</table> 
    			    </div>
    		    </div>
    		</div>
    	</div>
    </section>
</div>
 

