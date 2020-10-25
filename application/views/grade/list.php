<?php 

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $page_title = getlang('grade_form');
    
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
                <h1><i class="fa fa-signal"></i> <?php echo $page_title; ?></h1>
            </div>

            <div class="col-xs-12 col-md-4 text-right">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>grade/add"><i class="fa fa-plus"></i> <?php echo getlang('add_new'); ?> </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 rms-data-table">
                <div class="box">
                <div class="box-header">
                    <form action="<?php echo base_url() ?>grade" method="POST" id="searchList">
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
                                    
                                </div>
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <?php 
                                        $cat_object = getGradeCategoryObject();
                                        $output = '<select name= "cat_value" onchange="this.form.submit()" class="form-control input-sm" >';
                                        $output .= '<option value="0">Select Category</option>';
                                        foreach ($cat_object as $key => $cat_item) {
                                            if ($cat_value == $cat_item->id) {
                                                $output .= '<option selected="selected" value="'.$cat_item->id.'">'.$cat_item->name.'</option>';
                                            }else{
                                                $output .= '<option value="'.$cat_item->id.'">'.$cat_item->name.'</option>';
                                            }
                                        }
                                        $output .= '</select>';
                                        echo $output;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    </form>
                </div>

                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th class="text-center"> <?php echo getlang('grade_name'); ?></th>
                        <th class="text-center"> <?php echo getlang('grade_point'); ?> </th>
                        <th class="text-center"> <?php echo getlang('mark_from'); ?> </th>
                        <th class="text-center"> <?php echo getlang('mark_upto'); ?></th>
                        <th class="text-center">Category</th>
                        <th class="text-center" width="120px"><?php echo getlang('action'); ?></th>
                        <th class="text-center" width="90px">id</th>
                    </tr>
                    <?php
                    if(!empty($subjectsRecords))
                    {
                        foreach($subjectsRecords as $record)
                        {
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $record->name; ?></td>
                            <td class="text-center"><?php echo $record->grade_point; ?></td>
                            <td class="text-center"><?php echo $record->mark_from; ?></td>
                            <td class="text-center"><?php echo $record->mark_upto; ?></td>
                            <td class="text-center">
                                <?php 
                                $catid = $record->category; 
                                echo $category = getSingledata('grade_category', 'name', 'id', $catid);
                                ?>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-info" href="<?php echo base_url().'grade/add/'.$record->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                <a class="btn btn-sm btn-danger deletegrade"data-id="<?php echo $record->id; ?>" id="deleteId" href="#"  title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                            <td class="text-center"><?php echo $record->id; ?></td>
                        </tr>
                        <?php
                        }
                    }
                    ?>
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
        ** Call Pagination
        **/
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "grade/" + value);
            jQuery("#searchList").submit();
        });

        /**
        ** Call Delete grade
        **/
        jQuery(document).on("click", ".deletegrade", function(){
            var Id = $(this).data("id"),
            hitURL = baseURL + "grade/delete",
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
                    if(data.status = true) { alert("Grade successfully deleted"); }
                    else if(data.status = false) { alert("Grade deletion failed"); }
                    else { alert("Access denied..!"); }
                    location.reload();
                });
            }
        });

    });

</script>





