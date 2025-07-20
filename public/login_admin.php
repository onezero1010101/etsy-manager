<?php session_start(); ?>
<form method="POST" action="login_admin.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === getenv('ADMIN_USER') && $_POST['password'] === getenv('ADMIN_PASS')) {
        $_SESSION['admin'] = true;
        header("Location: index.php");
        exit;
    } else {
        echo "Invalid login";
    }
}