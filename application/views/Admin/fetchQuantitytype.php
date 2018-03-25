<div class="form-group form-float">
    <div class="form-line">
        <select class="form-control show-tick selectcat selectpicker" data-live-search="true" id="qtytype" name="qtytype" required>
            <option value="">Select Quantity Type</option>
            <?php if(!empty($QuantityTypeDetails)){
                foreach($QuantityTypeDetails as $qtytype){?>
                    <option value="<?php echo $qtytype->qty_type_id;?>"><?php echo $qtytype->qty_type_name;?></option>
            <?php }}?>
        </select>
    </div>
</div>