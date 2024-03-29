<?php
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    $query = "INSERT INTO news (email) VALUES (:email)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Subscription successful']);
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>