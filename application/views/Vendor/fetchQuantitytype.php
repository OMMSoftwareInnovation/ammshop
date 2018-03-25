<div class="form-group form-float">
    <div class="form-line">
        <select class="form-control show-tick selectqtytype selectpicker" data-live-search="true" id="qtytype" name="qtytype" required>
            <option value="">Select Quantity Type</option>
            <?php if(!empty($QuantityTypeDetails)){
                foreach($QuantityTypeDetails as $qtytype){?>
                    <option value="<?php echo $qtytype->qty_type_id;?>"><?php echo $qtytype->qty_type_name;?></option>
            <?php }}?>
        </select>
        <div class="help-info">Quantity Type<b style="color:red">*</b></div>
    </div>
</div>
<script>
$(document).ready(function($){
    $('.selectqtytype').on('change',function(){ 
        var qtytypeid=$(this).val(); 
        alert(qtytypeid);
        if(qtytypeid == "")
        {
            $('.DivfetchQty').addClass('collapse');  
        }
        else
        {
            $('.DivfetchQty').removeClass('collapse')
        }
        $.ajax({

            url: "<?php echo base_url();?>Vendor/GetQty",
            method:"post",
            data: {'qtytypeid' : qtytypeid},
            success: function(result)
            {
                $('.DivfetchQty').html();
                $('.DivfetchQty').html(result);
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