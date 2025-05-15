<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'db.php';

$bus_id = $_GET['bus_id'] ?? '';

if (!$bus_id) {
    echo json_encode(['success' => false, 'message' => 'Bus ID not provided']);
    exit;
}

try {
    $stmtBus = $pdo->prepare("SELECT * FROM buses WHERE bus_id = :bus_id");
    $stmtBus->execute([':bus_id' => $bus_id]);
    $bus = $stmtBus->fetch();

    if (!$bus) {
        echo json_encode(['success' => false, 'message' => 'Bus not found']);
        exit;
    }

    // Get booked seats for the bus
    $stmtSeats = $pdo->prepare("SELECT seat_number FROM bookings WHERE bus_id = :bus_id AND status = 'confirmed'");
    $stmtSeats->execute([':bus_id' => $bus_id]);
    $bookedSeats = $stmtSeats->fetchAll(PDO::FETCH_COLUMN, 0);

    // Assuming $bus['available_seats'] is total seat count or total seats as a number
    // If you have total seats count stored as integer, say $totalSeats
    $totalSeats = intval($bus['available_seats']); // adjust if your DB stores total seats here

    // Generate all seat numbers (1 to totalSeats)
    $allSeats = range(1, $totalSeats);

    // Calculate available seats by removing booked seats
    $availableSeats = array_diff($allSeats, $bookedSeats);

    echo json_encode([
        'success' => true,
        'available_seats' => array_values($availableSeats),  // send numeric array
        'bus' => [
            'bus_id' => $bus['bus_id'],  
            'bus_number' => $bus['bus_number'],
            'location' => $bus['location'],
            'destination' => $bus['destination'],
            'bus_type' => $bus['bus_type'],
            'date' => $bus['date'],
            'departure_time' => $bus['departure_time'],
            'arrival_time' => $bus['arrival_time'],
            'price' => $bus['price']
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
