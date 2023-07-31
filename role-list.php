<?php include 'header.php';
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
                                <li><a href="role-add.php"><i class="fa fa-user-plus"></i> Create</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="dataTable" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>Role Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
                                    $projectsData = getTableDataByTableNameById('roles_group', '', 'id');
                                    ;
                                    if (isset($projectsData) && !empty($projectsData)) {
                                        foreach ($projectsData as $data) {
                                            ?>
									<tr>
										<td><?php echo $data['name']; ?></td>
										<td>
											<?php //if(check_permission('role-edit')){ ?>
											<a href="role-edit.php?id=<?php echo $data['id']; ?>"><i class="fa fa-edit text-success"></i></a>
										<?php //} ?>
										</td>
									</tr>
									<?php
                                        }
                                    }
                                    ?>
								</tbody>
							</table>
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



