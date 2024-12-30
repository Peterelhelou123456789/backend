<?php
header('Content-Type: application/json');
include "connection.php";

// Get the raw POST data
$input = json_decode(file_get_contents('php://input'), true);

$note_id = $input['note_id'];

if (empty($note_id)) {
    echo json_encode(["status" => "error", "message" => "Note ID is required"]);
    exit();
}

// Delete the note from the database
$stmt = $con->prepare("DELETE FROM Notes WHERE id = ?");
$stmt->bind_param("i", $note_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Note deleted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to delete note: " . $stmt->error]);
}

$stmt->close();
$con->close();
?>
