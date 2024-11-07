<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'sathi');

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: ./admin/');
    exit;
}

// Handle the login form submission
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple query to verify user
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;

            // Success toastr notification
            $success = 'Login successful!';
            header('Location: ./admin/');
            exit;
        } else {
            $error = 'Invalid password.';
        }
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sathi Telecom - Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(45deg, #f3ec78, #af4261);
            height: 100vh;
        }
        .container {
            height: 100%; /* Make sure the container takes full height */
            display: flex;
            justify-content: center;
            align-items: center; /* Center content vertically */
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            background-color: #ffffff;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card-header {
            background-color: #af4261;
            color: white;
            font-size: 24px;
            text-transform: uppercase;
            font-weight: bold;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            padding: 2rem;
        }
        .btn-primary {
            background-color: #af4261;
            border-color: #af4261;
        }
        .btn-primary:hover {
            background-color: #f3ec78;
            border-color: #f3ec78;
            color: black;
        }
        .team-card {
            display: flex;
            justify-content: center; /* Center align the cards */
            gap: 20px; /* Space between cards */
            width: 90%;
            max-width: 800px;
            margin-top: 20px;
        }
        .team-member {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            color: #af4261;
            width: 500px; /* Increased width for team member cards */
            padding: 10px; /* Add padding */
        }
        .team-member img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #af4261;
            margin-bottom: 5px;
            transition: transform 0.2s;
        }
        .team-member img:hover {
            transform: scale(1.1);
        }
        .team-member p {
            font-weight: bold;
            margin: 0;
        }
        .team-member small {
            color: #555;
        }
    </style>
</head>
<body>

    <marquee behavior="scroll" direction="left" style="color: blue; font-size: 30px; font-weight: bold" scrollamount="10">Welcome to Sathi Telecom, Bilsha Bazar,Delduar,Tangail</marquee>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    Welcome to Sathi Telecom
                </div>
                <div class="card-body">
                    <!-- Login Form -->
                    <form action="index.php" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Team Members -->
            <div class="team-card">
                <div class="team-member">
                    <img src="./logo.jpg" alt="Sourov Kumar">
                    <p>Sourov Kumar</p>
                    <small>Developer</small>
                </div>
                <div class="team-member">
                    <img src="./sattajit.jpg" alt="Sattajit Mondal">
                    <p>Sattajit Mondal</p>
                    <small>Owner</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toastr JS and jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        <?php if ($error): ?>
        toastr.error('<?php echo $error; ?>');
        <?php endif; ?>
        
        <?php if ($success): ?>
        toastr.success('<?php echo $success; ?>');
        <?php endif; ?>
    });
</script>
</body>
</html>
