<?php
	
include 'connection/connect.php';

	$update=false;
	$id="";
	$company_id="";
	$division_name="";
	$division_address="";

	if(isset($_POST['add'])){
		$id				=	$_POST['id'];
		$company_id		=	$_POST['company_id'];
		$division_name	=	$_POST['division_name'];
		$division_address	=	$_POST['division_address'];

		
		
		$query = "INSERT INTO `branch` (`company_id`,`name`,`division_address`) VALUES ('$company_id','$division_name','$division_address')";
        $conn->query($query);
		
		
		$_SESSION['success']    =   "Division has been added successfully.";
		header("location: divisions.php");
		exit();
	}
	
	if(isset($_GET['delete'])){
		$id=$_GET['delete'];

		$query="DELETE FROM branch WHERE id=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();

		header('location:divisions.php');
		$_SESSION['response']="Successfully Deleted!";
		$_SESSION['res_type']="danger";
	}
	
	if(isset($_GET['edit'])){
		$id=$_GET['edit'];
		$query = "select * from `branch` where `id`='$id'";
		$resultd = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($resultd);
		
		
		$id				=	$row['id'];
		$company_id		=	$row['company_id'];
		$division_name	=	$row['name'];
		$division_address	=	$row['division_address'];

		$update=true;
	}
	if(isset($_POST['update'])){
		
		$id				=	$_POST['id'];
		$company_id		=	$_POST['company_id'];
		$division_name	=	$_POST['division_name'];
		$division_address	=	$_POST['division_address'];
		
		 /*
        *  Update Data Into inv_receive Table:
		*/
		
		$query2    = "UPDATE branch SET company_id='$company_id',name='$division_name',division_address='$division_address' WHERE id=$id";
		$result2 = $conn->query($query2);
		
		
	
/* 
		$_SESSION['response']="Updated Successfully!";
		$_SESSION['res_type']="primary";
		header('location:vendors.php'); */
		
		$_SESSION['success']    =   "Updated Successfully!";
		header("location: divisions.php");
		exit();
	}

	if(isset($_GET['details'])){
		$id=$_GET['details'];
		
		$query = "select * from `branch` where `id`='$id'";
		$resultd = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($resultd);

		$id				=	$row['id'];
		$company_id		=	$row['company_id'];
		$division_name	=	$row['name'];
		$division_address	=	$row['division_address'];
	}
?>