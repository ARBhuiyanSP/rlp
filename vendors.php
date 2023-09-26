<?php include 'header.php';
    $_SESSION['activeMenu'] =   'agency';
?>
<?php include 'top_sidebar.php';
include ('vendor_process.php');
 ?>
<!-- Left side column. contains the logo and sidebar -->
<?php include 'left_sidebar.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <?php include 'operation_message.php'; ?>
        <h1>
            Home
            <small>Vendor Setup</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Vendor List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row justify-content-center">
			<div class="col-md-10">
				<?php if (isset($_SESSION['response'])) { ?>
				<div class="alert alert-<?= $_SESSION['res_type']; ?> alert-dismissible text-center">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
				  <b><?= $_SESSION['response']; ?></b>
				</div>
				<?php } unset($_SESSION['response']); ?>
			</div>
		</div>
		<div class="row">
		  <div class="col-md-4">
			<h3 class="text-center">Add New Vendor</h3>
			<form action="vendor_process.php" method="post">
			  <input type="hidden" name="id" value="<?= $id; ?>">
			  
			  <!--- New Form Suppliers as Vendors--->
			  <!--- New Form Suppliers as Vendors--->
			  <div class="form-group">
				<input type="text" name="vendor_name" value="<?= $vendor_name; ?>" class="form-control" placeholder="Enter Vendor Name" required>
			  </div></br>
			  <!--- New Form Suppliers as Vendors--->
			  <div class="form-group">
				<textarea class="form-control" name="address" placeholder="Enter Vendor Address"><?= $address; ?></textarea>
			  </div></br>
			  <div class="form-group">
				<input type="text" name="phone" value="<?= $phone; ?>" class="form-control" placeholder="Enter Vendor Name">
			  </div></br>
			  <!--- New Form Suppliers as Vendors--->
			  <!--- New Form Suppliers as Vendors--->
			  
			  
			  
			  <div class="form-group">
				<?php if ($update == true) { ?>
				<input type="submit" name="update" class="btn btn-success btn-block" style="width:100%" value="Update Company">
				<?php } else { ?>
				<input type="submit" name="add" class="btn btn-primary btn-block" style="width:100%" value="Add Company">
				<?php } ?>
			  </div>
			</form>
		  </div>
		  <div class="col-md-8">
			<table class="table table-hover" id="example">
				<thead>
					<tr>
						<th width="30%">Vendor Name</th>
						<th width="30%">Address</th>
						<th width="20%">Phone</th>
						<th width="20%">Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$projectsData = getTableDataByTableNameById('vendors');
					if (isset($projectsData) && !empty($projectsData)) {
						$i=1;
						foreach ($projectsData as $data) { ?>
					<tr>
						<td width="40%"><?php echo $data['vendor_name']; ?></td>
						<td><?php echo $data['address']; ?></td>
						<td><?php echo $data['phone']; ?></td>
						<td width="15%">
							<a href="vendor_process.php?delete=<?php echo $data['id']; ?>" class="btn btn-danger" onclick="return confirm('Do you want delete this record?');"><i class="fa fa-trash"></i></a>
							<a href="vendors.php?edit=<?= $data['id']; ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
						</td>
					</tr>
					<?php
						}
					}
					?>
				</tbody>
			</table>
		  </div>
		</div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include 'footer.php'; ?>
