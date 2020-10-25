<?php 
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $page_title = getlang('mark_distribution_list');
    
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
                <h1><i class="fa fa-book"></i> <?php echo $page_title; ?></h1>
            </div>

            <div class="col-xs-12 col-md-4 text-right">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>markdistribution/add"><i class="fa fa-plus"></i> <?php echo getlang('add_new'); ?></a>
            </div>
        </div>

       
        <div class="row">
            <div class="col-xs-12 rms-data-table">
                <div class="box">
                    
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th class="text-center" width="90px">id</th>
                                <th><?php echo getlang('subject_name'); ?></th>
                                <th class="text-center" width="100px"><?php echo getlang('action'); ?></th>
                            </tr>
                            <?php
                            if(!empty($records))
                            {
                                foreach($records as $record)
                                {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $record->id; ?></td>
                                <td><?php echo $record->title; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url().'markdistribution/add/'.$record->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-sm btn-danger deletemarkdistribution"data-id="<?php echo $record->id; ?>" href="#"  title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
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
        ** Call Pagination
        **/
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "markdistribution/" + value);
            jQuery("#searchList").submit();
        });

        /**
        ** Call Delete subject
        **/
        jQuery(document).on("click", ".deletemarkdistribution", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "markdistribution/delete",
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
                    if(data.status = true) { alert("Mark distribution successfully deleted"); }
                    else if(data.status = false) { alert("Mark distribution deletion failed"); }
                    else { alert("Access denied..!"); }
                    location.reload();
                });
            }
        });
    
    });

</script>





