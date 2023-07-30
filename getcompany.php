<?php
// Include the database connection file
include('connection/connect.php');
 
if (isset($_POST['companyId']) && !empty($_POST['companyId'])) {

	// Fetch Division name base on country id
	$query = "SELECT * FROM branch WHERE company_id = ".$_POST['companyId'];
	$result = $conn->query($query);

	if ($result->num_rows > 0) {
		echo '<option value="">Select Division</option>';
		while ($row = $result->fetch_assoc()) {
		echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		} 
	else 
		{
		echo '<option value="">Division not available</option>';
		}
	} 
elseif(isset($_POST['divisionId']) && !empty($_POST['divisionId'])) {

	// Fetch department name base on Division id
	$query = "SELECT * FROM department WHERE branch_id = ".$_POST['divisionId'];
	$result = $conn->query($query);

	if ($result->num_rows > 0) {
	echo '<option value="">Select department</option>';
	while ($row = $result->fetch_assoc()) {
		
	echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
	}
	} else {
	echo '<option value="">department not available</option>';
	}
	}
	
elseif(isset($_POST['departmentId']) && !empty($_POST['departmentId'])) {

	// Fetch department name base on Division id
	$query = "SELECT * FROM projects WHERE department_id = ".$_POST['departmentId'];
	$result = $conn->query($query);

	if ($result->num_rows > 0) {
	echo '<option value="">Select Project/Location</option>';
	while ($row = $result->fetch_assoc()) {
	echo '<option value="'.$row['id'].'">'.$row['project_name'].'</option>';
	}
	} else {
	echo '<option value="">Project/Location not available</option>';
	}
	}
?>