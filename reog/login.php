<?php
session_start();
// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container" style="margin-top: 5rem;">
            <h2>Login Admin Dashboard</h2>

            <?php if(isset($_SESSION['error_message'])): ?>
                <p style="background: #ff6b6b; color: #121212; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </p>
            <?php endif; ?>

            <form action="proses_login.php" method="POST">
                <div class="form-grup">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-grup">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
        </div>
    </div>
</body>
</html>