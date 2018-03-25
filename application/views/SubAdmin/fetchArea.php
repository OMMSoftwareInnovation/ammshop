<div class="form-group form-float">
    <div class="form-line">
        <select class="form-control show-tick selectarea selectpicker" data-live-search="true" id="txtareaid" name="txtareaid" required>
            <option value="">Select Area</option>
            <?php if(!empty($AreaDetails)){
                foreach($AreaDetails as $area){?>
                    <option value="<?php echo $area->area_id;?>"><?php echo $area->area_name;?></option>
            <?php }}?>
        </select>
        <div class="help-info">Select Area<b style="color:red">*</b></div>
    </div>
</div>