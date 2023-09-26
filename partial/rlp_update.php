<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    $rlp_id         =   $_GET['rlp_id'];    
    $rlp_details    =   getRlpDetailsData($rlp_id);   
    $rlp_info       =   $rlp_details['rlp_info'];
    $rlp_details    =   $rlp_details['rlp_details'];
?>
<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-file"></i> RLP Details.
                <small class="pull-right">Priority: <?php echo getPriorityNameDiv($rlp_info->priority) ?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-md-4 invoice-col">
            Requested For
            <address>
                <strong>Name:&nbsp;<?php echo $rlp_info->request_person ?></strong><br>
                <!-- Designation:&nbsp;<?php// echo getDesignationNameById($rlp_info->designation) ?><br> -->
                Division:&nbsp;<?php echo getDivisionNameById($rlp_info->request_division) ?><br>
                Department:&nbsp;<?php echo getDepartmentNameById($rlp_info->request_department) ?><br>
                <!--- Contact:&nbsp;<?php //echo $rlp_info->contact_number ?><br>
                Email:&nbsp;: <?php //echo $rlp_info->email ?> -->
            </address>
        </div>
        <!-- /.col -->
        <div class="col-md-8 invoice-col">
            <div class="pull-right">
                <b>RLP NO: &nbsp;<span class="rlpno_style"><?php echo $rlp_info->rlp_no ?></span></b><br>
                <b>Request Date:</b> <?php echo human_format_date($rlp_info->created_at) ?><br>
            </div>            
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <form id="rlp_product_supplier_assign_form">
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Description</th>
                            <th>Purpose of Purchase</th>
							<?php if(is_super_admin($currentUserId)){ ?> 
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                            <th width="15%">Supplier</th>
                            <th>Remarks</th>
							<?php } else { ?>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="tbl_posts_body">
                        <?php
                        $sl =   1;
                        $dataid =   1;
                        $subtotal = 0;
                            foreach($rlp_details as $data){
                                $subtotal += $data->amount;
                        ?>
                        <tr class="txtMult">
                            <td><?php echo $sl++; ?></td>
                            <td><?php echo $data->item_des; ?></td>
                            <td><?php echo $data->purpose; ?></td>
                       
                            
                            <?php if(is_super_admin($currentUserId)){ ?>
							
                            <td><input type="text" class="form-control val1" name="quantity[<?php echo $data->id; ?>]" value="<?php echo (isset($data->quantity) && !empty($data->quantity) ? $data->quantity : ""); ?>"></td>

                            <td><input type="text" class="form-control val2" name="unit_price[<?php echo $data->id; ?>]" value="<?php echo (isset($data->unit_price) && !empty($data->unit_price) ? $data->unit_price : ""); ?>"></td>
							
                            <td><input type="text" class="form-control multTotal" name="amount[<?php echo $data->id; ?>]" value="<?php echo (isset($data->amount) && !empty($data->amount) ? $data->amount : ""); ?>"></td>

                            <td>
                                <div class="form-group">
                                    

                                    <select class="form-control select2" name="supplier[<?php echo $data->id; ?>]">
                                        <?php
                                           if(isset($data->supplier) && !empty($data->unit_price)){;
                                         ?>
                                         <option value="<?php echo (isset($data->supplier) && !empty($data->supplier) ? $data->supplier : ""); ?>"><?php echo (isset($data->supplier) && !empty($data->supplier) ? $data->supplier : ""); ?></option>
                                        <?php } ?>
                                        
                                        <option value="AST">Archive Solution</option>
                                        <option value="GP">GProjukti</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="details_remarks[<?php echo $data->id; ?>]" value="<?php echo (isset($data->details_remarks) && !empty($data->details_remarks) ? $data->details_remarks : ""); ?>">
                                </div>
                            </td>
							<script>
								 $(document).ready(function () {
								   $(".txtMult input").keyup(multInputs);

								   function multInputs() {
									   var mult = 0;
									   // for each row:
									   $("tr.txtMult").each(function () {
										   // get the values from this row:
										   var $val1 = $('.val1', this).val();
										   var $val2 = $('.val2', this).val();
										   var $total = ($val1 * 1) * ($val2 * 1);
										   // set total for the row
										   $('.multTotal', this).val($total);
										   mult += $total;
									   });
									   $("#grandTotal").val(mult);
								   }
							  });
							</script>
							
                            <?php }else{ ?>
                            <td><?php echo (isset($data->quantity) && !empty($data->quantity) ? $data->quantity : ""); ?></td>

                            <td><?php echo (isset($data->unit_price) && !empty($data->unit_price) ? $data->unit_price : ""); ?></td>
                            <td><?php echo (isset($data->amount) && !empty($data->amount) ? $data->amount : ""); ?></td>
                            <?php } ?>
                        </tr>                        
                            <?php } ?>
                        <?php if(is_super_admin($currentUserId)){ ?>
                        <tr>
                            
                        </tr>
                        <?php }?>
						<tr>
							<td colspan="5" align="right">Sub Total:</td>
							<td align="" width="10%">
								<input type="text" class="form-control multTotal" name="" value="<?php echo $subtotal; ?>" id="grandTotal">
							</td>
						</tr>
                    </tbody>
                </table>
				<table class="table table-striped table-bordered">
				 <?php if(is_super_admin($currentUserId)){ ?>
                        <tr>
                            <td colspan="6">
                                <input type="hidden" value="<?php echo $_GET['rlp_id']; ?>" name="rid">
                                <button type="button" class="btn btn-primary btn-block" onclick="execute_rlp_supplier_update_form('rlp_product_supplier_assign_form');">Update RLP</button>
                            </td>
							<!---<td>
                                <a class="btn btn-primary pull-right add-record" data-added="0"><i class="glyphicon glyphicon-plus"></i> Add Another Item</a>
                            </td> --->
                        </tr>
                        <?php } ?>
				</table>
            </div>
            <!-- /.col -->
        </div>
    </form>
	<!---<div style="display:none;">
		<table id="sample_table">
			<tr id="">
				<td><span class="sn"></span>.</td>
				<td><input type="text" class="form-control" id="" name="description[]" value="" size=""  required /></td>
				<td><input type="text" class="form-control" id="" name="purpose[]" value="" size=""  required /></td>
				<td><input type="text" class="form-control" id="" name="quantity[]" value="" size=""  required /></td>
				<td><input type="text" class="form-control" id="" name="estimatedPrice[]" value="" size=""  required /></td>
				<td><a class="btn btn-xs delete-record" data-id="0"><i class="glyphicon glyphicon-trash"></i></a></td>
			</tr>
		</table>
	</div> --->
    <!-- /.row -->
    <?php
    $role       =   get_role_group_short_name();
    
    if(is_super_admin($currentUserId)){
        include 'rlp_update_view_sa.php';
    }elseif($role    ==  "member"){
        include 'rlp_update_view_member.php';
    }elseif($role    ==  "dh"){
        include 'rlp_update_view_dh.php';
    }elseif($role    ==  "ab"){
        include 'rlp_update_view_ab.php';
    }else{
        include 'rlp_update_view_dh.php';
    }
    ?>
</section>
<!-- /.content -->
<div class="clearfix"></div>