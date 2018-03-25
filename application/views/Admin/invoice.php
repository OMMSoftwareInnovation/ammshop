<style>
.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>
<div class="modal-body js-expotable">
	<div class="row">
		<div class="col-xs-12">
			<div class="invoice-title">
				<h2>Invoice</h2><h3 class="pull-right">Order # <?php echo $OrderDetails[0]->order_id;?></h3>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-6">
					<address>
						<strong>Order Date: </strong> <?php echo $OrderDetails[0]->date;?>					
					</address>
					<address>
						<strong>Delivered Date: </strong><?php echo $OrderDetails[0]->deliverydate;?>					
					</address>
					<address>
						<strong>Payment Method: </strong><?php echo $OrderDetails[0]->Paymentname;?>						
					</address>
				</div>
				<div class="col-xs-6 text-right">
					<address>
					<strong>Shipped To:</strong><br>
					<?php echo $OrderDetails[0]->uname;?><br>
					<?php echo $OrderDetails[0]->umobile;?><br>
					<?php echo $OrderDetails[0]->uemail;?><br>					 
					<?php echo $OrderDetails[0]->uaddress;?>
					</address>
				</div>
			</div>			
		</div>
	</div>
		
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Order summary</strong></h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-condensed">
							<thead>
								<tr>
									<td class="text-center"><strong>Vendor Details</strong></td>
									<td><strong>Item</strong></td>
									<td class="text-center"><strong>Qty</strong></td>									
									<td class="text-center"><strong>Price</strong></td>	
									<td class="text-center"><strong>CGST</strong></td>	
									<td class="text-center"><strong>SGST</strong></td>	
									<td class="text-center"><strong>Shipping</strong></td>
									<td class="text-center"><strong>Total</strong></td>						
								</tr>
							</thead>
							<tbody>
								<?php 
									$iname = explode("/",$OrderDetails[0]->iname);	
									$vname = explode("/",$OrderDetails[0]->vname);
									$iprice = explode("/",$OrderDetails[0]->iprice);		
									$qty =  explode(",",$OrderDetails[0]->qty);	
									if(count($iname)>0)
									{
										$subtotal=0;
										for($k=0;$k<count($iname);$k++)
										{
											$singlevname=explode(":",$vname[$k]);
												
											echo "<tr>";
											echo "<td class=text-left>";
											if(count($singlevname)>0)
												{
													for($r=0;$r<count($singlevname);$r++)
													{
														print_r($singlevname[$r]);echo "<br>";
													}
												}
											echo "</td>";
											echo "<td class=text-left>";
											print_r($iname[$k]);
											echo "</td>";
											echo "<td class=text-right>";
											print_r($qty[$k]);
											echo "</td>";
											echo "<td class=text-right>";
											print_r($iprice[$k]);
											echo "</td>";												
											echo "<td class=text-right>";
											print_r(0);
											echo "</td>";	
											echo "<td class=text-right>";
											print_r(0);
											echo "</td>";
											echo "<td class=text-right>";
											print_r(0);
											echo "</td>";		
											echo "<td class=text-right>";
											print_r($iprice[$k]*$qty[$k]);
											echo "</td>";										
											echo "</tr>";	
											$subtotal=$subtotal+($iprice[$k]*$qty[$k]);										
										}
									}									
									?>		
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-right"><strong>SellingPrice Total</strong></td>
									<td class="no-line text-right"><?php echo $OrderDetails[0]->total;?></td>
								</tr>
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-right"><strong>GSTPrice Total</strong></td>
									<td class="no-line text-right"><?php print_r(0);?></td>
								</tr>
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-right"><strong>Shipping Total</strong></td>
									<td class="no-line text-right"><?php print_r(0);?></td>
								</tr>	
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-right"><strong>SubTotal</strong></td>
									<td class="no-line text-right"><?php echo $subtotal;?></td>
								</tr>	
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-right"><strong>Discount</strong></td>
									<td class="no-line text-right"><?php echo $OrderDetails[0]->discount;?></td>
								</tr>	
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-right"><strong>Wallet Pay</strong></td>
									<td class="no-line text-right"><?php echo $OrderDetails[0]->walletpay;?></td>
								</tr>	
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-right"><strong>Grand Total</strong></td>
									<td class="no-line text-right">
										<?php
											$grandtotal=($OrderDetails[0]->total)-((($OrderDetails[0]->total)*($OrderDetails[0]->discount/100))+$OrderDetails[0]->walletpay);
											echo $grandtotal;
										?>
									</td>
								</tr>								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<form name="frmPdfInvoice" method="get" action="<?php echo base_url();?>Admin/DownloadInvoicePDF">
		<input type="hidden" name="orderid" value="<?php echo $OrderDetails[0]->order_id;?>">
		<!--a href="<?php echo base_url();?>fpdf_test/index"><i class="material-icons">download</i>Download</a></li-->
		<!--a class="DownloadPdfInvoice right" href="#" data-uid="" data-uaid="" data-orderid=""><i class="material-icons">file_download</i></a-->
		<div class="icon-circle right">
			<a class="DownloadPdfInvoice" href="#"><i class="material-icons" data-toggle="tooltip" title="PDF Invoice Download">file_download</i></a>
		</div>
	</form>
</div>
<script>
$(document).ready(function(){
      
    $('.DownloadPdfInvoice').on('click',function(){
      $(this).closest('form').submit();
    });
  });
  </script> 