<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "testback");
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$firstName = $conn->real_escape_string($_POST["firstName"]);
$lastName = $conn->real_escape_string($_POST["lastName"]);
$gender = $conn->real_escape_string($_POST["gender"]);
$email = $conn->real_escape_string($_POST["email"]);
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$number = $conn->real_escape_string($_POST["number"]);

// Check if email exists
$check_email = $conn->prepare("SELECT email FROM registration WHERE email = ?");
$check_email->bind_param("s", $email);
$check_email->execute();
$result = $check_email->get_result();

if($result->num_rows > 0){
    echo "<script>
            alert('Email already exists. Please use a different email or login.');
            window.location.href='signup.html';
          </script>";
} else {
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO registration (firstName, lastName, gender, email, password, number) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstName, $lastName, $gender, $email, $password, $number);
    
    if($stmt->execute()){
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
    } else {
        echo "<script>
                alert('Error during registration. Please try again.');
                window.location.href='signup.html';
              </script>";
    }
    $stmt->close();
}
$conn->close();
?>