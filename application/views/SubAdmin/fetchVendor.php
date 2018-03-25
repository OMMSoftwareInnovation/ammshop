<div class="form-group form-float">
    <div class="form-line">
        <select class="form-control show-tick selectvendor selectpicker" data-live-search="true" id="txtvedorid" name="txtvedorid" required>
        <?php if(!empty($VendorDetails)){?>
            <option value="">Select Vendor</option>          
            <?php foreach($VendorDetails as $vendor){?>
                    <option value="<?php echo $vendor->vid;?>"><?php echo $vendor->name;?> (<?php echo $vendor->mobile_no;?>)</option>
            <?php }}else{?>
                <option value="">No Vendor Found</option>
            <?php }?>  
        </select>
        <div class="help-info">Select Vendor<b style="color:red">*</b></div>
    </div>
</div>