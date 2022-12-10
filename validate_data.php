<?php
$email = strip_tags(isset($_POST["email"]) ? $_POST['email'] : NULL);
include('connection.php');
$query1 = "Select * from kinders where email='$email'";
$result = $conn->query($query1);
$duplicateEmail = 0;
$testResult = 0;
if ($result->num_rows > 0) {
    $testResult = 1;
    $duplicateEmail = 1;
}
echo json_encode(
    array(
        "returnValue" => "" . $testResult,
        "duplicateEmail" => $duplicateEmail
    )
);

mysqli_close($conn);
?>