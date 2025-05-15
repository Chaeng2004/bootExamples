<?php
session_start();
include 'db.php';

// Get the reference from the URL
$reference = $_GET['reference'] ?? null;

// If no reference is provided, redirect to the homepage or an error page
if (!$reference) {
    header("Location: index.php");
    exit;
}

try {
    // Query to get booking details using the reference
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE reference = :reference");
    $stmt->execute([':reference' => $reference]);
    $booking = $stmt->fetch();

    if (!$booking) {
        // If the booking is not found, redirect to the homepage or show an error message
        header("Location: index.php");
        exit;
    }

    // Fetch the bus details based on the bus_id
    $stmtBus = $pdo->prepare("SELECT bus_number, location, destination FROM buses WHERE bus_id = :bus_id");
    $stmtBus->execute([':bus_id' => $booking['bus_id']]);
    $bus = $stmtBus->fetch();
} catch (PDOException $e) {
    // Handle any database errors
    echo "Error: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ticket Confirmation</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <header>
    <h1>Ticket Confirmation</h1>
    <nav>
      <a href="index.html">Search Buses</a> |
      <a href="profile.html">My Profile</a>
    </nav>
  </header>

  <main>
    <section id="confirmation-section">
      <h2>Thank you for your booking!</h2>
      <p>Your ticket has been confirmed. Here are your details:</p>
      <p><strong>Reference Number:</strong> <?php echo htmlspecialchars($booking['reference']); ?></p>
      <p><strong>Name:</strong> <?php echo htmlspecialchars($booking['name']); ?></p>
      <p><strong>Seat Number:</strong> <?php echo htmlspecialchars($booking['seat_number']); ?></p>
      <p><strong>Bus:</strong> <?php echo htmlspecialchars($bus['bus_number']); ?> (<?php echo htmlspecialchars($bus['location']); ?> to <?php echo htmlspecialchars($bus['destination']); ?>)</p>
      <p><strong>Passenger Type:</strong> <?php echo htmlspecialchars($booking['passenger_type']); ?></p>
      <p><strong>Remarks:</strong> <?php echo htmlspecialchars($booking['remarks']); ?></p>
    </section>
  </main>

  <footer>
    <p>&copy; 2024 Bus Reservation System</p>
  </footer>

</body>
</html>
