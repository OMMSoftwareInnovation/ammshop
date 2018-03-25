<div class="form-group form-float">
    <div class="form-line">
        <select class="form-control show-tick selectsubcat selectpicker" data-live-search="true" id="txtsubcatid" name="txtsubcatid" required>
            <option value="">Select Sub Category</option>
            <?php if(!empty($SubCategoryDetails)){
                foreach($SubCategoryDetails as $subcat){?>
                    <option value="<?php echo $subcat->sub_cat_id;?>"><?php echo $subcat->sub_cat_name;?></option>
            <?php }}?>
        </select>
    </div>
</div>