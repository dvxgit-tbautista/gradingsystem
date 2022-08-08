<?php
//including the database connection file
include_once("classes/Crud.php");
session_start();

if (!isset($_SESSION["email"]) || strlen($_SESSION["email"]) < 1)
    die("Not logged in");

$crud = new Crud();

$query = "SELECT * FROM grades";
$result = $crud->getData($query);
?>

<html>

<head>
    <title>Homepage</title>
</head>

<body>
    <h1>Hello, <?php echo (htmlentities($_SESSION["email"])) ?></h1>
    <?php
    if (isset($_SESSION["success"])) {
        echo ('<p style = "color: green;">' . htmlentities($_SESSION["success"]) . "</p>\n");
        unset($_SESSION["success"]);
    }
    if (isset($_SESSION["error"])) {
        echo ('<p style = "color: red;">' . htmlentities($_SESSION["error"]) . "</p>\n");
        unset($_SESSION["error"]);
    }
    ?>
    <table width='40%' border=0>

        <tr bgcolor='pink'>
            <td>Student Name</td>
            <td>Subjects</td>
            <td>Grades</td>
        </tr>
        <?php
        foreach ($result as $key => $row) {
            echo "<tr>";
            echo "<td>" . $row['studentName'] . "</td>";
            echo "<td>" . $row['SubjectName'] . "</td>";
            echo "<td>" . $row['grades'] . "</td>";
        }
        ?>
    </table>
    <p>
        <a href="updateGrades.php">Update Grades</a> |
        <a href="logout.php">Logout</a>
    </p>
</body>

</html>