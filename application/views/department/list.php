<?php 
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $page_title = getlang('department_manage');
    
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
                <h1><i class="fa fa-building-o"></i> <?php echo $page_title; ?></h1>
            </div>

            <div class="col-xs-12 col-md-4 text-right">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>departments/add"><i class="fa fa-plus"></i> <?php echo getlang('add_new'); ?></a>
            </div>
        </div>

        
        <div class="row">
            <div class="col-xs-12 rms-data-table">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo getlang('department_list'); ?></h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>departments" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" value="<?php echo $searchText; ?>" name="searchText" class="form-control input-sm pull-right" style="width: 150px;" placeholder="<?php echo getlang('search'); ?>"/> 
                                    <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            </form>
                        </div>
                    </div>

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover rms-table">
                            <tr>
                                <th><?php echo getlang('department_name'); ?></th>
                                <th class="text-center" width="100px" ><?php echo getlang('action'); ?></th>
                                <th class="text-center" width="90px">id</th>
                            </tr>
                            <?php
                            if(!empty($departmentRecords))
                            {
                                foreach($departmentRecords as $record)
                                {
                                ?>
                                <tr>
                                    <td><?php echo $record->department_name; ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-info"  href="<?php echo base_url().'departments/add/'.$record->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-sm btn-danger deleteDepartment"data-id="<?php echo $record->id; ?>" id="departmentId" href="#" name="Id" title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                    <td class="text-center"><?php echo $record->id; ?></td>
                                </tr>
                                <?php
                                }
                            }
                            ?>
                        </table>
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
        ** For pagination
        **/
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "departments/" + value);
            jQuery("#searchList").submit();
        });

        /**
        ** For Delete
        **/
        jQuery(document).on("click", ".deleteDepartment", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "departments/delete",
            currentRow = $(this);
            var confirmation = confirm("Are you sure want to delete ?");
        
            if(confirmation)
            {
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { Id : Id , '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'} 
                }).done(function(data){
                    console.log(data);
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("Department successfully deleted"); }
                    else if(data.status = false) { alert("Department delete failed"); }
                    else { alert("Access denied..!"); }
                    location.reload();
                });
            }
        });

    });
</script>





