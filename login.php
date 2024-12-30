<?php
header('Content-Type: application/json');
include "connection.php";

$input = json_decode(file_get_contents('php://input'), true);

$email = $input['email'];
$password = $input['password'];

$stmt = $con->prepare("SELECT id, email, password FROM Users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        echo json_encode([
            "status" => "success",
            "user_id" => $user['id'],
            "email" => $user['email']
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid password"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found"]);
}

$stmt->close();
$con->close();
?>
