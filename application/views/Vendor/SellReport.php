<section class="content">
    <div class="container-fluid">           
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Sell Reports                         
                            <span class="label label-danger" id="spantotal"></span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control AutocompleteCityName" id="txtcityname" name="txtcityname" value="" required style="text-transform: capitalize;" required>
                                        <label class="form-label">City Name<b style="color:red">*</b></label>
                                    </div>
                                </div>                                     
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker" id="txtstartdate" name="txtstartdate" value="" required >
                                        <label class="form-label">Startdate<b style="color:red">*</b></label>                                    
                                    </div>
                                </div>                                     
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <input type="text" class="form-control datepicker" id="txtenddate" name="txtenddate" value="" required >
                                    <label class="form-label">Enddate<b style="color:red">*</b></label>
                                    </div>
                                </div>                                     
                            </div>                            
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <button class="btn btn-primary waves-effect" type="submit" id="btnSellReport">SUBMIT</button>
                            </div>
                        </div>
                        <div class="table-responsive collapse" id="fetchSellReports">
                               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
 $(document).ready(function($){       
    $( ".AutocompleteCityName" ).autocomplete({
        source: "CityNameAutocomplete",
        minLength: 2,
        autoFocus:true
    });   
    $('#btnSellReport').on('click',function(){ 
        $("#fetchSellReports").html();  
        var cityname=$('#txtcityname').val();
        var startdate=$('#txtstartdate').val();
        var enddate=$('#txtenddate').val();       
        $.ajax({
            url: "<?php echo base_url();?>Admin/GetSellReport",
            method:"post",
            data: {'cityname' : cityname,'startdate' : startdate,'enddate' : enddate},
            success: function(result)
            {
                $("#fetchSellReports").removeClass('collapse');
                $("#fetchSellReports").html(result);                 
            },
            error: function()
            {
            alert("Something Went Wroung!");
            }
        });           
        
    });
});

</script>
