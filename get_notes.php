<?php
header('Content-Type: application/json');
include "connection.php";

$input = json_decode(file_get_contents('php://input'), true);

$user_id = $input['user_id'];

$stmt = $con->prepare("SELECT id, title, content FROM Notes WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notes = [];
while ($row = $result->fetch_assoc()) {
    $notes[] = [
        "id" => $row['id'],
        "title" => $row['title'],
        "content" => $row['content']
    ];
}

if (count($notes) > 0) {
    echo json_encode(["status" => "success", "notes" => $notes]);
} else {
    echo json_encode(["status" => "error", "message" => "No notes found"]);
}

$stmt->close();
$con->close();
?>
