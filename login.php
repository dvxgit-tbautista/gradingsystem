<?php

session_start();
if (isset($_SESSION["email"]))
    die("Cannot access.");

include_once("classes/Crud.php");
include_once("classes/Validation.php");
include_once("dbh.inc.php");

$crud = new Crud();
$validation = new Validation();
if (isset($_POST["cancel"])) {
    header("Location: index.php");
    return;
}

$alt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123
if (isset($_POST["email"]) && isset($_POST["pass"])) {
    if ($_POST["email"] == "superadmin@gmail.com" || $_POST["email"] == "teacher@gmail.com") {
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["pass"] = $_POST["pass"];

        if (isset($_SESSION["email"]) & isset($_SESSION["pass"])) {
            $username = $_SESSION["email"];
            $password = $_SESSION["pass"];

            if (strlen($username) < 1 || strlen($password) < 1)
                $_SESSION["error"] = "Email and password are required";
            else if (strpos($username, '@') === false)
                $_SESSION["error"] = "Email must have an at-sign (@)";
            else {
                if ($username == "superadmin@gmail.com" || $username == "superadmin2@gmail.com") {
                    $check = hash("md5", $alt . $password);
                    if ($check == $stored_hash) {
                        // Redirect the browser to view.php
                        header("Location: superadmin.php");
                        error_log("Login success " . $username);
                        return;
                    } else {
                        $_SESSION["error"] = "Incorrect password";
                        error_log("Login fail" . $username . "$check");
                    }
                } else if ($username == "teacher@gmail.com") {
                    $check = hash("md5", $alt . $password);
                    if ($check == $stored_hash) {
                        // Redirect the browser to view.php
                        header("Location: grading.php");
                        error_log("Login success " . $username);
                        return;
                    } else {
                        $_SESSION["error"] = "Incorrect password";
                        error_log("Login fail" . $username . "$check");
                    }
                }
            }

            unset($_SESSION["email"]);
            unset($_SESSION["pass"]);
        }
    } else {
        $email = $crud->escape_string($_POST['email']);
        $pass = $crud->escape_string($_POST['pass']);

        $msg = $validation->check_empty($_POST, array('email', 'pass'));

        if ($msg != null) {
            $_SESSION["error"] = "Empty field(s)";
        } else {
            $query = "SELECT * FROM users WHERE role = 'Student'";

            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                if ($email == $row['email'] && $pass == $row["password"]) {
                    // header("Location: login.php");
                    // exit($_SESSION['error'] = "Wrong email or password");
                    $sqlquery = "SELECT email, password FROM users WHERE email = '$email' AND password = '$pass'";
                    $_SESSION["email"] = $_POST["email"];
                    $_SESSION["pass"] = $_POST["pass"];


                    $conn->query($sqlquery);
                    header("Location: student.php");
                    return;
                } else {
                    $_SESSION['error'] = "Wrong email or password.";
                }
            }
        }
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Grading System</title>
</head>

<body>
    <div class="container">
        <h1>Please Log In</h1>
        <?php
        if (isset($_SESSION["error"])) {
            echo ('<p style = "color:red;">' . htmlentities($_SESSION["error"]) . "</p>\n");
            unset($_SESSION["error"]);
        }
        ?>

        <form method="post">
            <label for="nam">Email</label>
            <input type="text" name="email" id="nam"><br>
            <label for="id_1723">Password</label>
            <input type="text" name="pass" id="id_1723"><br>
            <input type="submit" value="Log In">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </div>
</body>

</html>