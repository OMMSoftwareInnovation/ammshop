<div class="form-group form-float">
    <div class="form-line">
        <select class="form-control show-tick selectsubsubsubcat selectpicker" data-live-search="true" id="txtsubsubsubcatid" name="txtsubsubsubcatid" required>
            <option value="">Select Sub Sub Category</option>
            <?php if(!empty($SubSubCategoryDetails)){
                foreach($SubSubCategoryDetails as $subsubsubcat){?>
                    <option value="<?php echo $subsubsubcat->filt_id;?>"><?php echo $subsubsubcat->filt_name;?></option>
            <?php }}?>
        </select>
        <div class="help-info">Sub Sub Category<b style="color:red">*</b></div>
    </div>
</div>
<script>
$(document).ready(function($){
   
});
</script>