<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email'], $data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Missing email or password.']);
    exit;
}

$email = $data['email'];
$password = $data['password'];

try {
    // Check if database connection is working
    if (!$pdo) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
        exit;
    }

    // Fetch user by email
    $stmt = $pdo->prepare("SELECT passenger_id, first_name, password FROM passenger WHERE email = ?");
    $stmt->execute([$email]);
    $passenger = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($passenger) {
        if (password_verify($password, $passenger['password'])) {
            // Set session variables if needed
            $_SESSION['passenger_id'] = $passenger['passenger_id'];
            $_SESSION['first_name'] = $passenger['first_name'];
            echo json_encode(['success' => true, 'message' => 'Login successful.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid password.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Email not found.']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    error_log($e->getMessage());
}
?>
