
<?php
session_start();
require_once("includes/db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username !== "" && $password !== "") {

        $query = "SELECT username, password FROM admins WHERE username = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $admin = mysqli_fetch_assoc($result);

            if ($admin && password_verify($password, $admin["password"])) {

                session_regenerate_id(true);
                $_SESSION["admin"] = $admin["username"];

                mysqli_stmt_close($stmt);
                header("Location: dashboard.php");
                exit;

            } else {
                $error = "Invalid Username or Password";
            }

            if (isset($stmt) && $stmt instanceof mysqli_stmt) {
                mysqli_stmt_close($stmt);
            }
        } else {
            $error = "Something went wrong. Please try again.";
        }
    } else {
        $error = "Please enter username and password.";
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

    <?php if ($error !== ""): ?>
        <p class="error">
            <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <input
            type="text"
            name="username"
            placeholder="Username"
            autocomplete="username"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Password"
            autocomplete="current-password"
            required
        >

        <button type="submit" name="login">Login</button>

        <a href="index.php" class="back-home-btn">
            ← Back to Homepage
        </a>
    </form>

</div>

</body>
</html>
