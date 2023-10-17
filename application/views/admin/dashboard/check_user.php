<?php
// Include your database connection and setup here

$userID = $_SESSION['user_id']; // You can retrieve the user ID from your session or any other source

if ($userID == $desiredUserID) {
    $response = array('show_modal' => true);
} else {
    $response = array('show_modal' => false);
}

header('Content-Type: application/json');
echo json_encode($response);
?>
