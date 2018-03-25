<div class="form-group form-float">
    <div class="form-line">
        <select class="form-control show-tick selectqty selectpicker" data-live-search="true" id="qty" name="qty" required>
            <option value="">Select Quantity</option>
            <?php if(!empty($QuantityDetails)){
                foreach($QuantityDetails as $qty){?>
                    <option value="<?php echo $qty->qty_id;?>"><?php echo $qty->qty_name;?></option>
            <?php }}?>
        </select>
        <div class="help-info">Quantity<b style="color:red">*</b></div>
    </div>
</div>