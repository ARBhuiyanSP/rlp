<?php
include "phpqrcode/qrlib.php";
/*******************************************************************************
 * The following code will
 * Store Receive entry data.
 * There are 4 table to keet track on receive data. The are following:
 * 1. inv_receive (Store single row)      
 * 2. inv_receivedetail (Store Multiple row)
 * 3. inv_materialbalance (Store Multiple row)
 * 4. inv_supplierbalance (Store single row)
 * *****************************************************************************
 */
if (isset($_POST['asset_submit']) && !empty($_POST['asset_submit'])) {
	
	// check duplicate:
	$sl_no		= $_POST['sl_no'];
    $table		= 'ams_products';
    $where		= "sl_no='$sl_no'";
    if(isset($_POST['asset_update_submit']) && !empty($_POST['asset_update_submit'])){
        $notWhere   =   "id!=".$_POST['asset_update_submit'];
        $duplicatedata = isDuplicateData($table, $where, $notWhere);
    }else{
        $duplicatedata = isDuplicateData($table, $where);
    }
	if ($duplicatedata) {
		$status     =   'error';
		$_SESSION['warning']    =   "Operation faild. Duplicate data found..!";
    }else{
			
	
	
    // how to save PNG codes to server 
     $sl_no 	= $_POST['sl_no'];
     
    $tempDir = "images/qr_images/"; 
	$todaysDate = date('Ymd');
	$model = "M".$_POST['model'];
	//$id = $_GET['id'];
    $codeContents = 'SPL-'.$sl_no; 
     
    // we need to generate filename somehow,  
    // with md5 or with database ID used to obtains $codeContents... 
    $fileName = time().'qrimage.png'; 
     
    $pngAbsoluteFilePath = $tempDir.$fileName; 
    $urlRelativeFilePath = EXAMPLE_TMP_URLRELPATH.$fileName; 
     
    // generating 
    if (!file_exists($pngAbsoluteFilePath)) { 
        QRcode::png($codeContents, $pngAbsoluteFilePath); 
         
    } 
    

	$sl_no 				= $_POST['sl_no'];
	
	
	$company_id			= $_POST['company_id'];
	$division_id		= $_POST['division_id'];
	$department_id		= $_POST['department_id'];
	$proloc_id			= $_POST['proloc_id'];
	
	$store_id 			= $_POST['store_id'];
	$received_by 		= $_POST['received_by'];
	$assets_category 	= $_POST['assets_category'];
	$item_name 			= $_POST['item_name'];
	$assets_description = $_POST['assets_description'];
	$brand 				= $_POST['brand'];
	$model 				= $_POST['model'];
	$manufacturing_sl 	= $_POST['manufacturing_sl'];
	$rlp_no 			= $_POST['rlp_no'];
	$purchase_order 	= $_POST['purchase_order'];
	$delivery_chalan 	= $_POST['delivery_chalan'];
	$vendor_name 		= $_POST['vendor_name'];
	$purchase_date 		= $_POST['purchase_date'];
	$warrenty 			= $_POST['warrenty'];
	$purchase_value 	= $_POST['purchase_value'];
	$origin 			= $_POST['origin'];
	$custody 			= $_POST['custody'];
	$status 			= $_POST['status'];
	$condition 			= $_POST['condition'];



	if (is_uploaded_file($_FILES['slfileToUpload']['tmp_name'])) 
	  {
		$slimg=time()."_".$_FILES['slfileToUpload']['name'];
		$temp_file=$_FILES['slfileToUpload']['tmp_name'];
		
		 move_uploaded_file($temp_file,"products_photo/".$slimg);
	  }

	if (is_uploaded_file($_FILES['profileToUpload']['tmp_name'])) 
	  {
		$proimg=time()."_".$_FILES['profileToUpload']['name'];
		$temp_file=$_FILES['profileToUpload']['tmp_name'];
		
		 move_uploaded_file($temp_file,"products_photo/".$proimg);
	  }
		
		
               
        $query = "INSERT INTO `ams_products`(`sl_no`,`company_id`,`division_id`,`department_id`,`proloc_id`,`assets_category`,`item_name`,`assets_description`,`brand`,`model`,`manu_sl`,`rlp_no`,`purchase_order`,`delivery_challam`,`vendor_name`,`puchase_date`,`warrenty`,`purchase_value`,`origin`,`custody`,`status`,`conditions`,`photo`,`pro_photo`,`qr_image`,`store_id`,`current_store`,`received_by`) VALUES ('$sl_no','$company_id','$division_id','$department_id','$proloc_id','$assets_category','$item_name','$assets_description','$brand','$model','$manufacturing_sl','$rlp_no','$purchase_order','$delivery_chalan','$vendor_name','$purchase_date','$warrenty','$purchase_value','$origin','$custody','$status','$condition','$slimg','$proimg','$pngAbsoluteFilePath','$store_id','$store_id','$received_by')";
        $conn->query($query);
		
		
    
    $_SESSION['success']    =   "Asset Entry process have been successfully completed.";
    header("location: assets-list.php");
    exit();
	}
		

}

/* function getAssetDataDetailsById($id){
    global $conn;
    $assets      =   "";
    $assetDetails =   "";
    
    // get receive data
    $sql1           = "SELECT * FROM ams_products where id=".$id;
    $result1        = $conn->query($sql1);

    if ($result1->num_rows > 0) {
        $assets = $result1->fetch_object();
        // get receive details data
        $table                  =   'inv_receivedetail where mrr_no='."'$assets->mrr_no'";
        $order                  =   'DESC';
        $column                 =   'receive_qty';
        $dataType               =   'obj';
        $assetDetailsData     = getTableDataByTableName($table, $order, $column, $dataType);
        if(isset($assetDetailsData) && !empty($assetDetailsData)){
            $assetDetails     =   $assetDetailsData;
        }
    }
    $feedbackData   =   [
        'assetData'           =>  $assets,
        'assetDetailsData'    =>  $assetDetails
    ];
    
    return $feedbackData;
} */

/*******************************************************************************
 * The following code will
 * Update Receive entry data.
 * There are 4 table to keet track on receive data. The are following:
 * 1. inv_receive (Update single row)      
 * 2. inv_receivedetail (First Delete all rows then Store Multiple row)
 * 3. inv_materialbalance (First Delete all rows then Store Multiple row)
 * 4. inv_supplierbalance (Update single row)
 * *****************************************************************************
 */

if(isset($_POST['asset_update_submit']) && !empty($_POST['asset_update_submit'])){
    //$receive_total      =   0;
		// how to save PNG codes to server 
		 $sl_no 	= $_POST['sl_no'];
		 
		$tempDir = "images/qr_images/"; 
		$todaysDate = date('Ymd');
		$model = "M".$_POST['model'];
		$id = $_GET['id'];
		$codeContents = 'SPL-'.$sl_no; 
		 
		// we need to generate filename somehow,  
		// with md5 or with database ID used to obtains $codeContents... 
		$fileName = time().'qrimage.png'; 
		 
		$pngAbsoluteFilePath = $tempDir.$fileName; 
		$urlRelativeFilePath = EXAMPLE_TMP_URLRELPATH.$fileName; 
		 
		// generating 
		if (!file_exists($pngAbsoluteFilePath)) { 
			QRcode::png($codeContents, $pngAbsoluteFilePath); 
			 
		} 
		

		$sl_no 				= $_POST['sl_no'];
		
		$company_id			= $_POST['company_id'];
		$division_id		= $_POST['division_id'];
		$department_id		= $_POST['department_id'];
		$proloc_id			= $_POST['proloc_id'];
	
	
		$store_id 			= $_POST['store_id'];
		$received_by 		= $_POST['received_by'];
		$assets_category 	= $_POST['assets_category'];
		$item_name 			= $_POST['item_name'];
		$assets_description = $_POST['assets_description'];
		$brand 				= $_POST['brand'];
		$model 				= $_POST['model'];
		$manufacturing_sl 	= $_POST['manufacturing_sl'];
		$rlp_no 			= $_POST['rlp_no'];
		$purchase_order 	= $_POST['purchase_order'];
		$delivery_chalan 	= $_POST['delivery_chalan'];
		$vendor_name 		= $_POST['vendor_name'];
		$purchase_date 		= $_POST['purchase_date'];
		$warrenty 			= $_POST['warrenty'];
		$purchase_value 	= $_POST['purchase_value'];
		$origin 			= $_POST['origin'];
		$custody 			= $_POST['custody'];
		$status 			= $_POST['status'];
		$condition 			= $_POST['condition'];
		
		if (is_uploaded_file($_FILES['slfileToUpload']['tmp_name'])) 
				{
					$temp_file=$_FILES['slfileToUpload']['tmp_name'];
					$slimg=time().$_FILES['slfileToUpload']['name'];
					$q = move_uploaded_file($temp_file,"products_photo/".$slimg);
				}
				else
				{
				 $slimg = $_POST["old_slfileToUpload"];
				}

		if (is_uploaded_file($_FILES['profileToUpload']['tmp_name'])) 
				{
					$temp_file=$_FILES['profileToUpload']['tmp_name'];
					$proimg=time().$_FILES['profileToUpload']['name'];
					$q = move_uploaded_file($temp_file,"products_photo/".$proimg);
				}
				else
				{
				 $proimg = $_POST["old_profileToUpload"];
				}
		
		/* Update Data Into ams_products Table: */
		
		$queryupdate   = "UPDATE `ams_products` SET `sl_no`='$sl_no',`company_id`='$company_id',`division_id`='$division_id',`department_id`='$department_id',`proloc_id`='$proloc_id',`assets_category`='$assets_category',`item_name`='$item_name',`assets_description`='$assets_description',`brand`='$brand',`model`='$model',`manu_sl`='$manufacturing_sl',`rlp_no`='$rlp_no', `purchase_order`='$purchase_order',`delivery_challam`='$delivery_chalan',`vendor_name`='$vendor_name',`puchase_date`='$purchase_date',`warrenty`='$warrenty',`purchase_value`='$purchase_value',`origin`='$origin',`custody`='$custody',`status`='$status',`conditions`='$condition',`photo`='$slimg',`pro_photo`='$proimg',`qr_image`='$pngAbsoluteFilePath',`store_id`='$store_id',`current_store`='$store_id',`received_by`='$received_by' WHERE `id`='$id'";
		$resultupdate = $conn->query($queryupdate);
		
		$_SESSION['success']    =   "Asset UPDATE process have been successfully updated.";
		header("location: asset_edit.php?id=".$id);
		exit();
		
}

if(isset($_POST['assign_submit'])){
        $product_id 	= $_POST['product_id'];
		$employee_id 	= $_POST['employee_id'];
		$assign_date 	= $_POST['assign_date'];
		$remarks 		= $_POST['remarks'];
		$status 		= 'Active';
		$create 		= date('Y-m-d');
		$assigned_by 		= $_POST['assigned_by'];
		
		/* Insert Data Into product_assign Table: */
		
		$query = "INSERT INTO `product_assign`(`product_id`,`employee_id`,`assign_date`,`remarks`,`assigned_by`,`status`,`created_at`) VALUES ('$product_id','$employee_id','$assign_date','$remarks','$assigned_by','$status','$create')";
        $conn->query($query);
		$last_id = $conn->insert_id;
		
		/* Update Data Into ams_products Table: */
		
		$queryupdate   = "UPDATE `ams_products` SET `assign_status`='assigned' WHERE `id`='$product_id'";
		$conn->query($queryupdate);
		
		$_SESSION['success']    =   "Asset Assign process have been successfully Completed.";
		header("location: assign-list.php");
		exit();
		
		/* if ($conn->query($query) === TRUE) {
				  $_SESSION['success']    =   "Asset Assign process have been successfully Completed.";
					header("location: handover-receipt.php?id='$last_id'");
					exit();
				} else {
				  header("location: product-assign.php?id='$product_id'");
					exit();
				} */
}

if(isset($_POST['transfer_submit'])){

	$product_id 	= $_POST['product_id'];
	$employee_id 	= $_POST['employee_id'];
	$assign_date 	= $_POST['assign_date'];
	$remarks 		= $_POST['remarks'];
	$status 		= 'Active';
	$create 		= date('Y-m-d');
	$id 			= $_POST['id'];

		
		
		
		$query = "insert into product_assign values('','$product_id','$employee_id','$assign_date','','$remarks','$status','$create','')";
        $conn->query($query);
		
		
		
		
		$queryupdate   = "UPDATE `product_assign`  set `refund_date`='$assign_date', `status`='Transfered' where `id`='$id'";
		$result	= $conn->query($queryupdate);
		
		$_SESSION['success']    =   "Asset transfer process have been successfully Completed.";
		header("location: assets-list.php");
		exit();
} 

if(isset($_POST['return_submit'])){

	$id 			= $_POST['id'];
	$product_id 	= $_POST['product_id'];
	$refund_date 	= $_POST['refund_date'];
	$status 		= 'Refund';

		
		/* Insert Data Into product_assign Table: */
		
		$query = "UPDATE `product_assign`  set `refund_date`='$refund_date', `status`='$status' where `id`='$id'";
        $conn->query($query);
		
		/* Update Data Into product_assign Table: */
		$assign_date 	= $_POST['assign_date'];
		
		
		$queryupdate   = "UPDATE `ams_products`  set `assign_status`='' where `id`='$product_id'";
		$conn->query($queryupdate);
		
		$_SESSION['success']    =   "Asset transfer process have been successfully Completed.";
		header("location: assets-list.php");
		exit();
}

if(isset($_POST['service_submit'])){

	$srv_no			= $_POST['srv_no'];
	$assets_id 		= $_POST['assets_id'];
	$assets_slno 	= $_POST['assets_slno'];
	$warranty 		= $_POST['warranty'];
	$vendor 		= $_POST['vendor'];
	$handover_date 	= $_POST['handover_date'];
	$handover_by 	= $_POST['handover_by'];
	$status 		= 'at_servicing';
	$ho_remarks 	= $_POST['ho_remarks'];
	$store_id 		= $_POST['store_id'];

		/* Insert Data Into product_assign Table: */
		
		$query = "INSERT INTO `inv_services`(`srv_no`,`assets_id`,`assets_slno`,`warranty`,`vendor`,`handover_date`,`handover_by`,`status`,`ho_remarks`,`store_id`) VALUES ('$srv_no','$assets_id','$assets_slno','$warranty','$vendor','$handover_date','$handover_by','$status','$ho_remarks','$store_id')";
        $conn->query($query);
		
		
		/* Update Data Into product_assign Table: */
		
		$queryupdate   = "UPDATE `ams_products` set `status`='$status' where `id`='$assets_id'";
		$conn->query($queryupdate);
		
		$_SESSION['success']    =   "Service Entry process have been successfully Completed.";
		header("location: service_entry.php");
		exit();
}	

if(isset($_POST['service_update_submit'])){

	$id				= $_POST['a_id'];
	$assets_id 		= $_POST['assets_id'];
	$assets_slno 	= $_POST['assets_slno'];
	$status 		= $_POST['status'];
	$receive_date 	= $_POST['receive_date'];
	$receive_by 	= $_POST['receive_by'];
	$recv_remarks 	= $_POST['recv_remarks'];
	$updated_at 	= date("Y-m-d");

		/* Insert Data Into product_assign Table: */
		
		$query = "UPDATE `inv_services` set `status`='$status',`receive_date`='$receive_date',`receive_by`='$receive_by',`recv_remarks`='$recv_remarks',`updated_at`='$updated_at' where `id`='$id'";
        $conn->query($query);
		
		
		/* Update Data Into product_assign Table: */
		
		$queryupdate   = "UPDATE `ams_products` set `status`='$status' where `id`='$assets_id'";
		$conn->query($queryupdate);
		
		$_SESSION['success']    =   "Service Update process have been successfully Completed.";
		header("location: service_entry.php");
		exit();
}

if(isset($_POST['disposal_submit'])){

	$product_id 	= $_POST['product_id'];
	$disposal_date 	= $_POST['disposal_date'];
	$disposal_value = $_POST['disposal_value'];
	$reason 		= $_POST['reason'];
	$remarks 		= $_POST['remarks'];
	$store_id 		= $_POST['store_id'];
	$disposal_by 		= $_POST['disposal_by'];

		/* Insert Data Into product_assign Table: */
		
		$query = "INSERT INTO `disposals`(`product_id`,`disposal_date`,`disposal_value`,`reason`,`remarks`,`store_id`,`disposal_by`) VALUES ('$product_id','$disposal_date','$disposal_value','$reason','$remarks','$store_id','$disposal_by')";
        $conn->query($query);
		
		
		/* Update Data Into product_assign Table: */
		
		$queryupdate   = "UPDATE `ams_products` set `status`='disposed' where `id`='$product_id'";
		$conn->query($queryupdate);
		
		$_SESSION['success']    =   "disposal entry process have been successfully Completed.";
		header("location: disposal.php");
		exit();
}



?>