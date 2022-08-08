<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Grading System</title>
</head>

<body>
    <div class="container">
        <h1>Grading System</h1>
        <?php
        if (isset($_GET['register'])) {
            if ($_GET['register'] == "success") {
                echo "<p style='color:green;'>Successfully Registered! You may now log in.</p>";
            }
        }
        ?>
        <p>
            <a href="login.php"> Please Log In</a>
        </p>
        <p>
            <a href="register.php">Not registered yet?</a>
        </p>

        <p>
            <a href="login2.php">View PHP Exercise</a>
        </p>
    </div>
</body>

</html>