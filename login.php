<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "testback");
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$email = $conn->real_escape_string($_POST["email"]);
$password = $_POST["password"];

// Check user credentials
$stmt = $conn->prepare("SELECT password FROM registration WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $user = $result->fetch_assoc();
    if(password_verify($password, $user['password'])){
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
    } else {
        echo "<script>
                alert('Invalid password. Please try again.');
                window.location.href='login.html';
              </script>";
    }
} else {
    echo "<script>
            alert('Email not found. Please sign up.');
            window.location.href='signup.html';
          </script>";
}

$stmt->close();
$conn->close();
?>