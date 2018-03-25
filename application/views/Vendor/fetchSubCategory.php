<div class="form-group form-float">
    <div class="form-line">
        <select class="form-control show-tick selectsubcat selectpicker" data-live-search="true" id="txtsubcatid" name="txtsubcatid" required>
            <option value="">Select Sub Category</option>
            <?php if(!empty($SubCategoryDetails)){
                foreach($SubCategoryDetails as $subcat){?>
                    <option value="<?php echo $subcat->sub_cat_id;?>"><?php echo $subcat->sub_cat_name;?></option>
            <?php }}?>
        </select>
        <div class="help-info">Sub Category<b style="color:red">*</b></div>
    </div>
</div>
<script>
$(document).ready(function($){
    $('.selectsubcat').on('change',function(){ 
        var subcatid=$(this).val(); 
        if(subcatid == "")
        {
            $('.DivfetchSubCat').addClass('collapse');
            $('.DivfetchSubSubCat').addClass('collapse');
            $('.DivfetchQtytype').addClass('collapse');  

        }
        else
        {
            $('.DivfetchSubCat').removeClass('collapse'); 
            $('.DivfetchSubSubCat').removeClass('collapse');
            $('.DivfetchQtytype').removeClass('collapse')
        }
        $.ajax({

            url: "<?php echo base_url();?>Vendor/GetSubSubCategory",
            method:"post",
            data: {'subcatid' : subcatid},
            success: function(result)
            {
                $('.DivfetchSubSubCat').html();
                $('.DivfetchSubSubCat').html(result);
                $(".selectpicker").selectpicker("refresh");          
            },
            error: function()
            {
                alert("Something went wroung!");
            }
        });
        $.ajax({

            url: "<?php echo base_url();?>Vendor/GetQtyType",
            method:"post",
            data: {'subcatid' : subcatid},
            success: function(result)
            {
                $('.DivfetchQtytype').html();
                $('.DivfetchQtytype').html(result);
                $(".selectpicker").selectpicker("refresh");          
            },
            error: function()
            {
                alert("Something went wroung!");
            }
            });
        });
});
</script>