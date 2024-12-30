<?php
header('Content-Type: application/json');
include "connection.php";

// Get the raw POST data
$input = json_decode(file_get_contents('php://input'), true);

$user_id = $input['user_id'];
$title = $input['title'];
$content = $input['content'];

if (empty($user_id) || empty($title) || empty($content)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit();
}

// Insert the note into the database
$stmt = $con->prepare("INSERT INTO Notes (user_id, title, content) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $title, $content);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Note added successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add note: " . $stmt->error]);
}

$stmt->close();
$con->close();
?>
