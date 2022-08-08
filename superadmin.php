<?php
//including the database connection file
include_once("classes/Crud.php");
session_start();

if (!isset($_SESSION["email"]) || strlen($_SESSION["email"]) < 1)
    die("Not logged in");

$crud = new Crud();

$query = "SELECT * FROM subjects ORDER BY SubjectID DESC";
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
    ?>
    <table width='50%' border=0>

        <tr bgcolor='pink'>
            <td>Subject</td>
            <td>Description</td>
        </tr>
        <?php
        foreach ($result as $key => $row) {
            //while($res = mysqli_fetch_array($result)) { 		
            echo "<tr>";
            echo "<td>" . $row['SubjectName'] . "</td>";
            echo "<td>" . $row['Description'] . "</td>";
        }
        ?>
    </table>
    <?php
    $crud = new Crud();

    $query = "SELECT * FROM users ORDER BY UserID DESC";
    $result = $crud->getData($query);
    ?>
    <br><br>
    <table width='50%' border=0>

        <tr bgcolor='pink'>
            <td>Email</td>
            <td>Name</td>
            <td>Role</td>
        </tr>
        <?php
        foreach ($result as $key => $row) {
            //while($res = mysqli_fetch_array($result)) { 		
            echo "<tr>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['role'] . "</td>";
        }
        ?>
    </table>
    <?php
    if (isset($_SESSION["duplicate"])) {
        echo ('<p style = "color : red;">' . htmlentities($_SESSION["duplicate"]) . "</p>\n");
        unset($_SESSION["duplicate"]);
    }
    ?>
    <p>
        <a href="addSubjects.php">Add New Subjects</a> |
        <a href="addUsers.php">Add New Users</a> | <a href="logout.php">Logout</a>
    </p>
</body>

</html>