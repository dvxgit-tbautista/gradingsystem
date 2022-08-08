<?php

if (isset($_POST['signup'])) {

    require 'dbh.inc.php';

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $passwordrepeat = mysqli_real_escape_string($conn, $_POST['cpassword']);


    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    /*$specialChars = preg_match('@[^\w]@', $password);*/

    if (empty($username) || empty($email) || empty($password) || empty($passwordrepeat)) {
        header("Location: index.php?error=emptyfields&username=" . $username . "&email=" . $email);
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: index.php?error=invalidemailusername");
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) //checks if its valid
    {
        header("Location: index.php?error=invalidemail&username=" . $username);
        exit();
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) //checks if it matches
    {
        header("Location: index.php?error=invalidusername&email=" . $email);
        exit();
    } else if ($password !== $passwordrepeat) //check if both passwords are matched
    {
        header("Location: index.php?error=passwordcheck&email=" . $email . "&username=" . $username);
        exit();
    } else if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        header("Location: index.php?error=weakpassword");
        exit();
    } else {
        $sql = "SELECT name FROM users WHERE name = ?"; //to be secured here, we are going to use prepared statement. so the user cant query in the website and destroy our database.

        //here is the prepared statement
        $stmt = mysqli_stmt_init($conn);

        //check if we can prepare this specific sql statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username); //the first parameter which statement do we want to bind the information,  the second is what data type are we passing into the statement. s = string, i = int, boolean = b.. we should also tell how many data types we are passing

            /*
            mysqli_stmt_bind_param($stmt, "ss", $username, $password); -if the query has one or more strings.
            */
            mysqli_stmt_execute($stmt);  //run this info from the user into  the database
            mysqli_stmt_store_result($stmt); //it takes the result and stores it back into the variable called stmt.
            $resultCheck = mysqli_stmt_num_rows($stmt); //checks hows many rows we got from the database.

            if ($resultCheck > 0) //checks if the username is already taken
            {
                header("Location: index.php?error=usertaken&email=" . $email);
                exit();
            } else {
                $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: index.php?error=sqlerror");
                    exit();
                } else {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT); //hashing the password

                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
                    mysqli_stmt_execute($stmt);
                    header("Location: index.php?register=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: index.php");
    exit();
}
