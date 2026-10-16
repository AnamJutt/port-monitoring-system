<?php
session_start();
include("includes/db.php");

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admins 
              WHERE username='$username' 
              AND password='$password'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0)
    {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
    }
    else
    {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="login-container">

    <h2>Port Monitoring System</h2>

    <?php
    if(isset($error))
    {
        echo "<p class='error'>$error</p>";
    }
    ?>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

       <button type="submit" name="login">
        Login
    </button>
    <a href="index.php" class="back-home-btn">
    ← Back to Homepage
</a>

    </form>

</div>

</body>
</html>