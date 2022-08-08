<?php

if (isset($_POST['submit'])) {

    require 'dbh.inc.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username || empty($password))) {
        header("Location: index.php?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $username, $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt); //to get the result of the statement executed
            if ($row = mysqli_fetch_assoc($result)) //to fetch data and display it in an associative array
            {
                $pwdCheck = password_verify($password, $row['password']); //to check if the password entered matched the password in the database after it is unhashed
                if ($pwdCheck == false) {
                    header("Location: index.php?error=wrongpwd");
                    exit();
                } else if ($pwdCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row['UserID'];
                    $_SESSION['username'] = $row['username'];

                    header("Location: profile.php");
                    exit();
                } else {
                    header("Location: index.php?error=wrongpwd");
                    exit();
                }
            } else {
                header("Location: index.php?error=nouser");
                exit();
            }
        }
    }
} else {
    header("Location: index.php");
    exit();
}
