<?php

include("config.php");

if(	isset($_POST["username"]) 
	&& isset($_POST["full_name"]) 
	&& isset($_POST["gender_id"]) 
	&& isset($_POST["birth_date"])
	&& isset($_POST["domicile_id"])
	&& isset($_POST["role_id"])		) {

	$username = $_POST["username"];
	$full_name = $_POST["full_name"];
	$gender_id = $_POST["gender_id"];
	$birth_date = $_POST["birth_date"];
	$domicile_id = $_POST["domicile_id"];
	$role_id = $_POST["role_id"];

	if(isset($_POST["platform"])) {
		$platform = $_POST["platform"];
	} else {
		$platform = "frontend";	
	}
	
	$sql = "SELECT DISTINCT domicile_id FROM domicile WHERE domicile_name like '%$domicile_id%'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$domicile_id = $row["domicile_id"];
		}
	}

	$sql = "SELECT DISTINCT user_id FROM user WHERE username like '%$username%'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
        	$user_id = $row["user_id"];
			$sql = "UPDATE user SET full_name = '$full_name', gender_id = '$gender_id', birth_date = '$birth_date', domicile_id = '$domicile_id', role_id = '$role_id', stsrc = 'U', edit_by = '$user_id', edit_at = NOW() WHERE user_id = '$user_id'";

			if ($conn->query($sql) === TRUE) {
			    echo "Existing user updated sucessfully<br>";
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
   		}
	} else {
		$sql = "INSERT INTO user (username, full_name, gender_id, birth_date, role_id, domicile_id, stsrc, edit_by, edit_at)
		VALUES ('$username', '$full_name', '$gender_id', '$birth_date', '$role_id', '$domicile_id', 'A', '$username', NOW())";

		if ($conn->query($sql) === TRUE) {
		    echo "New user created successfully<br>";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	$sql = "SELECT DISTINCT user_id FROM user WHERE username like '%$username%'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
        	$user_id = $row["user_id"];
			$sql = "INSERT INTO user_log (user_id, log_time, stsrc, edit_by, edit_at)
			VALUES ('$user_id', NOW(), 'A', '$platform', NOW())";

			if ($conn->query($sql) === TRUE) {
			    echo "New log created successfully<br>";
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
   		}
	} 

} else {
	print_r("Invalid param<br>");
}

?>