<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    $rlp_id         =   $_GET['rlp_id'];    
    $rlp_details    =   getRlpDetailsData($rlp_id);   
    $rlp_info       =   $rlp_details['rlp_info'];
    $rlp_details    =   $rlp_details['rlp_details'];
?>
<style>
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td{
	border: 1px solid #000000;
}
</style>
<!-- Main content -->
<section class="invoice" id="printableArea">
    <!-- title row
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> RLP Details.
                <small class="pull-right">Priority: <?php //echo getPriorityName($rlp_info->priority) ?></small>
            </h2>
        </div>
    </div> 
        .col -->
    <!-- info row -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-bottom:20px;">
			<center>
				<h3><?php echo getDivisionNameById($rlp_info->request_division) ?></h3>
				<p><?php echo getDivisionAddressById($rlp_info->request_division) ?></p>
			</center>
		</div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            Requested For
            <address>
                <strong>Name:&nbsp;<?php echo $rlp_info->request_person ?></strong><br>
                Division:&nbsp;<?php echo getDivisionNameById($rlp_info->request_division) ?><br>
                Department:&nbsp;<?php echo getDepartmentNameById($rlp_info->request_department) ?><br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <span class="pull-right">
                <b>RLP NO: &nbsp;<span style="border:1px solid;padding:2px 5px;"><?php echo $rlp_info->rlp_no ?></span></b><br>
                <b>Request Date:</b> <?php echo human_format_date($rlp_info->created_at) ?><br>
                <b>Priority:</b> <?php echo getPriorityName($rlp_info->priority) ?><br>
                <b>Current Status: &nbsp;<span style="border:1px solid;padding:2px 5px;"><?php echo get_status_name($rlp_info->rlp_status) ?></span></b><br>
            </span>            
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-sm-12 table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Description</th>
                        <th>Purpose of Purchase</th>
                        <th>Quantity</th>
                        <th>Unit price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sl =   1;
                        foreach($rlp_details as $data){
                    ?>
                    <tr>
                        <td><?php echo $sl++; ?></td>
                        <td><?php echo $data->item_des; ?></td>
                        <td><?php echo $data->purpose; ?></td>
                        <td><?php echo $data->quantity; ?></td>
                        <td><?php echo $data->unit_price; ?></td>
                        <td><?php echo $data->amount; ?></td>
                    </tr>
                        <?php } ?>
					<tr>
                        <td colspan="6"><?php echo $rlp_info->user_remarks; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
	<div class="row">
					<div class="col-sm-3 col-xs-3" style="padding-top:100px;">
						<center><img src="images/signatures/<?php echo getSignatureByUserId($rlp_info->created_by); ?>" height="70px"/></br><?php echo getUserNameByUserId($rlp_info->created_by); ?></br>________________________</br>Requested By</center>
					</div>
					<?php
					$table = "rlp_acknowledgement WHERE rlp_info_id=$rlp_id";
					$order = 'DESC';
					$column = 'ack_request_date';
					$allRemarksHistory = getTableDataByTableName($table, $order, $column);
						if (isset($allRemarksHistory) && !empty($allRemarksHistory)) {
						foreach ($allRemarksHistory as $dat) {
					?>
					
					<?php //echo (isset($dat->ack_updated_date) && !empty($dat->ack_updated_date) ? human_format_date($dat->ack_updated_date) : ""); ?>
					<!-- <div class="col-sm-3 col-xs-3" style="padding-top:100px;">
						<center><?php if(get_status_name($dat->ack_status)=='Approve' || get_status_name($dat->ack_status)=='Recommended'){ ?><img src="images/signatures/<?php echo getSignatureByUserId($dat->user_id); ?>" height="70px"/><?php } ?></br><?php echo getUserNameByUserId($dat->user_id) ?></br>________________________</br><?php echo getDesignationByUserId($dat->user_id) ?></center>
					</div> -->
					
					<?php if(get_status_name($dat->ack_status)=='Approve' || get_status_name($dat->ack_status)=='Recommended'){ ?>
					<div class="col-sm-3 col-xs-3" style="padding-top:100px;">
						<center><img src="images/signatures/<?php echo getSignatureByUserId($dat->user_id); ?>" height="70px"/></br><?php echo getUserNameByUserId($dat->user_id) ?></br>________________________</br><?php echo getDesignationByUserId($dat->user_id) ?></center>
					</div>
					<?php } ?>
					<?php
					}
				}
				?>			
			</div>
    <!-- /.row -->
	
</section>
	<div class="row">
		<div class="col-sm-12">
			<center>
				<a class="btn btn-app" onclick="printDiv('printableArea')" value="print a div!">
					<i class="fa fa-print"></i> Print 
				</a>
			</center>
			<script>
			function printDiv(divName) {
				 var printContents = document.getElementById(divName).innerHTML;
				 var originalContents = document.body.innerHTML;

				 document.body.innerHTML = printContents;

				 window.print();

				 document.body.innerHTML = originalContents;
			}
			</script>
		</div>
	</div>
<!-- /.content -->
<div class="clearfix"></div>