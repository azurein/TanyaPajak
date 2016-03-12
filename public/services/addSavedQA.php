<?php

include("config.php");

if(	isset($_POST["user_id"]) 
	&& isset($_POST["tax_qa_id"]) 
	&& isset($_POST["transaction_value"]) 
	&& isset($_POST["transaction_type"])	) {

	$user_id = $_POST["user_id"];
	$tax_qa_id = $_POST["tax_qa_id"];
	$transaction_value = $_POST["transaction_value"];
	$transaction_type = $_POST["transaction_type"];

	$sql = "SELECT DISTINCT user_id FROM user WHERE username like '%$user_id%'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
        	$user_id = $row["user_id"];
   		}
	}

	$sql = "INSERT INTO saved_qa (user_id, tax_qa_id, submit_date, transaction_value, transaction_type, stsrc, edit_by, edit_at)
	VALUES ('$user_id', '$tax_qa_id', NOW(), '$transaction_value', '$transaction_type', 'A', '$user_id', NOW())";

	if ($conn->query($sql) === TRUE) {
	    echo "New QA saved successfully<br>";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

} else {
	print_r("Invalid param<br>");
}

?>