<?php

  $token_name = $this->security->get_csrf_token_name();
  $token_hash = $this->security->get_csrf_hash();

?>
   

<div class="content-wrapper mark-page">
    <?php 
    $page_title = 'Install Result Template';
    $page_icon = 'fa fa-refresh';
    echo sectionHeader($page_title, '', $page_icon); 
    ?>
    <section class="content">

        <div class="row">
             <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <form action="<?php echo base_url(); ?>result_template/getinstall" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body form-horizontal">
                        <fieldset>
                            <legend>Upload & Install </legend>
                            <input type="file" name="install_file">
                        </fieldset>
                    </div>

                    <div class="box-footer">
                            
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Install" />
                        </div>
                    </div>
                            
                </div>
            </div>
        </div>

        <input type="hidden" name="<?php echo $token_name; ?>" value="<?php echo $token_hash; ?>" />
        </form>


        <?php if(!empty($records)): ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover rms-table">
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th class="text-center">Status</th>
                                <th class="text-center"><?php echo getlang('action'); ?></th>
                            </tr>

                            <?php foreach($records as $record): ?>
                            <tr>
                                <td>
                                    <?php 
                                    $path = './application/views/result/template/'.$record->alias.'/'.$record->thumbo;
                                    ?>
                                    <img src="<?php echo $path; ?>" alt="">
                                </td>
                                <td style="vertical-align: top !important;">
                                    <h3><?php echo $record->title; ?></h3>
                                    <p><?php echo $record->description; ?></p>
                                </td>
                                <td class="text-center">
                                    <?php 
                                    if(!empty($record->status)){
                                        echo '<span class="label label-success">Active</span>';
                                    }else{
                                        echo '<span class="label label-danger">Unactive</span>';
                                    }
                                    ?>  
                                </td>
                                <td class="text-center" width="200px">
                                    <a class="btn btn-sm btn-default"  href="<?php echo base_url().'result_template/configuration/'.$record->id; ?>" title="Edit"><i class="fa fa-cog"></i> Configuration</a>
                                  <a class="btn btn-sm btn-danger deleteTemplate"data-id="<?php echo $record->id; ?>" href="#" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                </div>
            </div>
        </div>

        <?php endif; ?>


    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){

        /**
        ** For Delete
        **/
        jQuery(document).on("click", ".deleteTemplate", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "result_template/getdelete",
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
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("Result template successfully deleted"); }
                    else if(data.status = false) { alert("Result template delete failed"); }
                    else { alert("Access denied..!"); }
                    location.reload();
                });
            }
        });

    });
</script>

