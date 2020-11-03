<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","admin","phppot");

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_errno());
}
$result = mysqli_query($conn, "SELECT student_id,student_name,marks FROM tbl_marks ORDER BY student_id");
// $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$data = array();




// $sqlQuery = "SELECT student_id,student_name,marks FROM tbl_marks ORDER BY student_id";

// $result = mysqli_query($conn,$sqlQuery);

// print_r($result);

// $data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);
// mysqli_close($conn);

echo json_encode($data);
?>