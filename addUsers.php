<?php
//including the database connection file
session_start();
include_once("classes/Crud.php");
include_once("classes/Validation.php");
include_once("dbh.inc.php");

$crud = new Crud();
$validation = new Validation();

if (isset($_POST['Submit'])) {
    $userEmail = $crud->escape_string($_POST['userEmail']);
    $userPassword = $crud->escape_string($_POST['userPassword']);
    $userName = $crud->escape_string($_POST['userName']);
    $userRole = $crud->escape_string($_POST['userRole']);

    $msg = $validation->check_empty($_POST, array('userEmail', 'userPassword', 'userName', 'userRole'));

    if ($msg != null) {
        $_SESSION["empty"] = "Empty field(s)";
    } else {
        $query = "SELECT email FROM users";

        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            if ($userEmail == $row['email']) {
                header("Location: superadmin.php");
                exit($_SESSION['duplicate'] = "Email already exists");
            }
        }   
        $sqlquery = "INSERT INTO users(email,password, name, role) VALUES('$userEmail','$userPassword', '$userName', '$userRole')";

        $conn->query($sqlquery);

        echo "<font color='green'>Data added successfully.";
    }
}
?>
<html>

<head>
    <title>Add Users</title>
</head>

<body>
    <a href="superadmin.php">Home</a>
    <br /><br />
    <!-- <div id="msg"></div> -->
    <form method="post">
        <p>
            Email:
            <input type="text" name="userEmail">
        </p>
        <p>
            Password:
            <input type="text" name="userPassword">
        </p>
        <p>
            Name:
            <input type="text" name="userName">
        </p>
        <p>
            Role:
            <select name="userRole">
                <option value="Student">Student</option>
                <option value="Teacher">Teacher</option>
            </select>
        </p>
        <p>
            <input type="submit" name="Submit" value="Add">
        </p>
    </form>
    <?php
    if (isset($_SESSION["empty"])) {
        echo ('<p style = "color : red;">' . htmlentities($_SESSION["empty"]) . "</p>\n");
        unset($_SESSION["empty"]);
    }

    ?>
</body>

</html>