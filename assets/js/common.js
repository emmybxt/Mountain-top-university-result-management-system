/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	
});

// Use for upload image show on the same page 

function readURL(input, id) {

    //alert( "Data Saved: " + id );
       
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                jQuery('#preview_'+id)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }

 
    }





