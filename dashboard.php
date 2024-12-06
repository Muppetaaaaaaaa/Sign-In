<?php
session_start();

if(!isset($_SESSION['email'])){
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "testback");
$stmt = $conn->prepare("SELECT firstName, lastName, email, number FROM registration WHERE email = ?");
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 50px; }
        .panel { box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 20px; }
        .welcome-header { background-color: #337ab7; color: white; padding: 20px; margin: -20px -20px 20px -20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel">
                    <div class="welcome-header">
                        <h1>Welcome, <?php echo htmlspecialchars($user['firstName']); ?>!</h1>
                    </div>
                    <div class="user-info">
                        <h3>Your Profile Information:</h3>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['firstName'] . " " . $user['lastName']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['number']); ?></p>
                    </div>
                    <a href="logout.php" class="btn btn-primary mt-3">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>