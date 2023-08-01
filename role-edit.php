<?php include 'header.php';
include 'includes/role_process.php';
    $_SESSION['activeMenu'] =   'agency';
?>
<?php include 'top_sidebar.php'; ?>
<!-- Left side column. contains the logo and sidebar -->
<?php include 'left_sidebar.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <?php include 'operation_message.php'; ?>
        <h1>
            Home
            <small>RLP Info</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">RLP Info</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"></h3>
                        <div class="box-tools">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                <?php if(hasAccessPermission($user_id_session, 'crlp', 'view_access')){ ?>
                                <li><a href="role-list.php"><i class="fa fa-user-plus"></i> List</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php 
						$id = $_GET['id'];
						$queryRole = "SELECT * FROM `roles_group` WHERE `id`='$id'";
						$resultRole = $conn->query($queryRole);
						$roleData = $resultRole->fetch_object();

						$queryPermissions = "SELECT * FROM `permission_role` WHERE `role_id`='$id'";
						$resultPermissions = $conn->query($queryPermissions);
						$assignPermissions = [];
						while ($row = $resultPermissions->fetch_assoc()) 
							{
								$assignPermissions[] = $row["permission_id"];
							}

						?>

						<div class="card-body">
							<!--here your code will go-->
							<div class="form-group">
								<form action="role-edit.php?id=<?php echo $id;  ?>" method="post" name="add_name" >
									<div class="row" id="div1" style="">
										<div class="col-xs-4">
											<div class="form-group">
												<label>Role Name</label>
												<input type="text" name="name" id="name" class="form-control" required value="<?php echo $roleData->name; ?>" >
												<input type="hidden" name="id" id="name" class="form-control" required value="<?php echo $roleData->id; ?>" >
												<!-- <input type="hidden" name="role_create" value="role_update"> -->
											</div>
										</div>
										<label></label>
										<?php

										$rearrange = [];
										$permissionData = getTableDataByTableNameById('permissions', '', 'id');
										;
										if (isset($permissionData) && !empty($permissionData)) {
											foreach ($permissionData as $data) {
													$rearrange[$data["permission_category"]][]=$data;
											   
											}
										}
										?>
										<div class="col-xs-12">
										   <?PHP 
											 foreach ($rearrange as $key=> $data) {
												?>
												<div class="col-md-12"><h3 style="background-color:#222D32;color: #ffffff; padding:0px 3px;border-radius:5px;"><?php echo $key; ?></h3></div>
												
												<?php
												foreach($data as $key_val){ ?>
													<div class="col-xs-3">
														<div class="d-flex">
															<input id="<?php echo $key_val['id']; ?>" type="checkbox" name="permissions[]"  value="<?php echo $key_val['id']; ?>" style="width: 14px;height: 14px;" <?php if(in_array($key_val['id'], $assignPermissions)){echo 'checked';} ?> >
															<label for="<?php echo $key_val['id']; ?>" ><?php echo $key_val["display_name"]; ?></label>
														</div>
													</div>
												 
											<?php     }     } ?>
										</div>
										<div class="col-xs-4">
											<div class="form-group">
												<label>.</label>
												<input type="submit" name="role_update" id="submit" class="btn btn-block" style="background-color:#007BFF;color:#ffffff;" value="Save" />   
											</div>
										</div>
									</div>
								</form>
							</div>
							<!--here your code will go-->
						</div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include 'footer.php'; ?>


