<?php
header('Content-Type: application/json');
include "connection.php";

$input = json_decode(file_get_contents('php://input'), true);

$email = $input['email'];
$password = password_hash($input['password'], PASSWORD_DEFAULT);

$stmt = $con->prepare("INSERT INTO Users (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $password);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User registered successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Registration failed: " . $stmt->error]);
}

$stmt->close();
$con->close();
?>
