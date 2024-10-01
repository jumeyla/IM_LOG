<?php
session_start();

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['username'] = $user['username'];
            // Redirect to the dashboard
            header("Location: dashboard.php"); 
            exit(); 
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that username!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log-in</title>
  <link rel="stylesheet" href="css/log.css">
</head>
<body>
    <div class="login-container">
      <h1>Please Log-in</h1>
      
      <form id="loginForm" method="POST" action="">
        <div class="input-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required>
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>

        <div id="error-message"></div>
        <button type="submit" class="login-btn" href = "dashboard.php">Login</button>
      </form>
      <p>Don't have an account?</p>
      <a href="register.php" class="reg-link">Sign-Up</a>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>

