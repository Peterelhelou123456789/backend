<?php
header('Content-Type: application/json');
include "connection.php";

// Get the raw POST data
$input = json_decode(file_get_contents('php://input'), true);

$note_id = $input['note_id'];
$title = $input['title'];
$content = $input['content'];

if (empty($note_id) || empty($title) || empty($content)) {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit();
}

// Update the note in the database
$stmt = $con->prepare("UPDATE Notes SET title = ?, content = ? WHERE id = ?");
$stmt->bind_param("ssi", $title, $content, $note_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Note updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update note: " . $stmt->error]);
}

$stmt->close();
$con->close();
?>
