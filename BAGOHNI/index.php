<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bus Reservation System</title>
  <link rel="stylesheet" href="styles.css" />
  
</head>
<body>
  <header>
    <h1>Bus Reservation System</h1>
    <nav>
      <a href="index.php">Search Buses</a> |
      <a href="#">My Profile</a>
      <a href="LogIn.php">Log In</a>
    </nav>
  </header>

  <main>
    <section id="search-section">
      <h2>Search Bus Routes</h2>
      <form id="search-form">
        <label for="location">From:</label>
        <input type="text" id="location" name="location" required />
        <label for="destination">To:</label>
        <input type="text" id="destination" name="destination" required />
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required />
        <button type="submit">Search</button>
      </form>
      <div id="search-results"></div>
    </section>
  </main>

  <footer>
    <p>&copy; 2024 Bus Reservation System</p>
  </footer>

  <script src="scripts.js"></script>
  
</body>
</html>
