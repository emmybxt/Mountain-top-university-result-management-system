<?php 

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $page_title = getlang('exam_manage');
    $page_sub_title = getlang('add').', '.getlang('edit').', '.getlang('delete');
    
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
                <h1><i class="fa fa-pencil"></i> <?php echo $page_title; ?></h1>
            </div>

            <div class="col-xs-12 col-md-4 text-right">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>exam/add"><i class="fa fa-plus"></i> <?php echo getlang('add_new');?></a>
            </div>
        </div>

        
        <div class="row">
            <div class="col-xs-12 rms-data-table">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo getlang('exam_list'); ?></h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>exam" method="POST" id="searchList">
                            <div class="input-group">
                             <input type="text" value="<?php echo $searchText; ?>" name="searchText" class="form-control input-sm pull-right" style="width: 150px;" placeholder="<?php echo getlang('search'); ?>"/> 
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th><?php echo getlang('exam_name'); ?></th>
                      <th><?php echo getlang('exam_date'); ?></th>
                      <th><?php echo getlang('status'); ?></th>
                      <th style="text-align: center;" width="120px"><?php echo getlang('action'); ?></th>
                      <th class="text-center" width="90px">id</th>
                    </tr>
                    <?php if (!empty($examRecords)) 
                        { foreach ($examRecords as $records) { ?>
                            <tr>
                                <td><?php echo $records->name; ?></td>
                                <td><?php echo $records->exam_date; ?></td>
                                <td><?php 
                                    if ($records->status == 0) {
                                        echo "Unpublished";
                                    }elseif ($records->status == 1) {
                                        echo "Published";
                                    }else{
                                        echo "Published";
                                    }
                                    
                                ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url().'exam/add/'.$records->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-sm btn-danger deleteExam" data-id="<?php echo $records->id; ?>" id="examId" href="#"  title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                                <td class="text-center"><?php echo $records->id; ?></td>
                            </tr>
                    <?php } }  ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
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
            jQuery("#searchList").attr("action", baseURL + "exam/" + value);
            jQuery("#searchList").submit();
        });

        /**
        ** For Delete
        **/
        jQuery(document).on("click", ".deleteExam", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "exam/delete",
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
                    if(data.status = true) { alert("Successfully deleted"); }
                    else if(data.status = false) { alert("Deletion failed"); }
                    else { alert("Access denied..!"); }
                    location.reload();
                });
            }
        });

    });
</script>





