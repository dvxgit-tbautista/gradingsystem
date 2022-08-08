<?php
//including the database connection file
include_once("classes/Crud.php");
session_start();

if (!isset($_SESSION["email"]) || strlen($_SESSION["email"]) < 1)
    die("Not logged in");
?>

<html>

<head>
    <title>Homepage</title>
</head>

<body>
    <h1>Hello, <?php echo (htmlentities($_SESSION["email"])) ?></h1>
    <?php

    $email = $_SESSION["email"];
    if (isset($_SESSION["success"])) {
        echo ('<p style = "color: green;">' . htmlentities($_SESSION["success"]) . "</p>\n");
        unset($_SESSION["success"]);
    }
    $crud = new Crud();

    $query = "SELECT * FROM grades INNER JOIN users ON grades.studentName = users.name WHERE email = '$email'";
    $result = $crud->getData($query);
    ?>
    <br><br>
    <table width='50%' border=0>

        <tr bgcolor='pink'>
            <td>Subject</td>
            <td>Grades</td>
        </tr>
        <?php
        foreach ($result as $key => $row) {
            echo "<tr>";
            echo "<td>" . $row['SubjectName'] . "</td>";
            echo "<td>" . $row['grades'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <br><br>
    <a href="logout.php">Logout</a>
</body>

</html>