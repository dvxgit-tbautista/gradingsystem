<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: profile.php");
    exit();
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Grading System</title>
</head>

<body>
    <form action="login.inc.php" method="post">
        <div>
            <h3>Sign In</h3>
            <div>
                <label>Username</label>
                <input type="text" name="username" id="login-user" placeholder="johndoe">
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" id="login-password" placeholder="******">
            </div>

            <div>
                <div>
                    <label>
                        <input type="checkbox" id="remember-me" name="iCheck">
                        Remember Me
                    </label>
                    <a href="#reset">Forgot Password?</a>
                </div>
            </div>

            <div>
                <button name="submit" type="submit">
                    Log In
                </button>
            </div>
        </div>
    </form>
</body>

</html>