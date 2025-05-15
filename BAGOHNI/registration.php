<?php
header('Content-Type: application/json');
include 'db.php';

// Read JSON from request body
$data = json_decode(file_get_contents("php://input"), true);

// Check if data is valid
if (!isset($data['firstName'], $data['lastName'], $data['email'], $data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit;
}

$firstName = $data['firstName'];
$lastName = $data['lastName'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);

try {

    // Check if email exists
    $stmt = $pdo->prepare("SELECT passenger_id FROM passenger WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already registered.']);
        exit;
    }

    // Insert user
    $stmt = $pdo->prepare("INSERT INTO passenger (first_name, last_name, email, password)
                           VALUES (?, ?, ?, ?)");
    $stmt->execute([$firstName, $lastName, $email, $password]);

    echo json_encode(['success' => true, 'message' => 'Registration successful!']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
