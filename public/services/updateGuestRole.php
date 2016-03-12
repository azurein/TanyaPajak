<?php

include("config.php");

if(isset($_POST["user_id"]) && isset($_POST["role_id"])) {

	$user_id = $_POST["user_id"];
	$role_id = $_POST["role_id"];

	$sql = "SELECT DISTINCT user_id FROM user WHERE username like '%$user_id%'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
        	$user_id = $row["user_id"];
   		}
	} 

	$sql = "SELECT DISTINCT role_id FROM role WHERE role_name like '%$role_id%'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
        	$role_id = $row["role_id"];
   		}
	} 

	$sql = "UPDATE user SET role_id = '$role_id', stsrc = 'A', edit_by = '$user_id', edit_at = NOW() WHERE user_id = '$user_id'";

	if ($conn->query($sql) === TRUE) {
	    echo "User role updated successfully<br>";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

} else {
	print_r("Invalid param<br>");
}

?>