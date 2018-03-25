<input type="hidden" name="selltotal" id="selltotal" value="<?php echo $SellTotalReports[0]->selltotal;?>">
<table class="table table-breported table-striped table-hover js-basic-example dataTable" id="SellReportTable">
    <thead>
        <tr>
            <th>Sr.No</th>
            <th>Order Id</th>
            <th>Date</th>
            <th>Delivered Date</th>            
            <th>Total</th>                                                           

        </tr>

    </thead>

    <tfoot>

        <tr>

            <th>Sr.No</th>
            <th>Order Id</th>
            <th>Date</th>
            <th>Delivered Date</th>            
            <th>Total</th>        
        </tr>
    </tfoot>
    <tbody ID="SellReportDetails">
    <?php $i=1;if(!empty($SellReports)){
        foreach($SellReports as $report){?>
        <tr>
            <td><?php echo $i++;?></td>
            <td><?php echo $report->orderid_no;?></td>
            <td><?php echo $report->date;?></td>
            <td><?php echo $report->deliverydate;?></td>
            <td style="text-align: right;"><?php echo $report->total;?></td>           
        </tr><?php }}?>
    </tbody>
</table>
<script>
$(document).ready(function($){
    var tot = $('#selltotal').val();
    if(tot)
    {
        $("#spantotal").text(tot+' Rs');
    }
    $('#SellReportTable').DataTable( {
       
    } );  
} );
</script>