<?php
require_once "../config/database.php";

$json = array();
$sql = "SELECT * FROM tbl_events ORDER BY id";

$statement = $conn->prepare($sql);
$statement->execute();
$databaseResult = $statement->get_result();

$eventArray = array();
while ($row = mysqli_fetch_assoc($databaseResult)) {
    array_push($eventArray, $row);
}
mysqli_free_result($databaseResult);

mysqli_close($conn);
echo json_encode($eventArray);
?>