<?php
//including the database connection file
session_start();
include_once("classes/Crud.php");
include_once("classes/Validation.php");
include_once("dbh.inc.php");

$crud = new Crud();
$validation = new Validation();

if (isset($_POST['Submit'])) {
    $subjectName = $crud->escape_string($_POST['subjectname']);
    $description = $crud->escape_string($_POST['description']);

    $msg = $validation->check_empty($_POST, array('subjectname', 'description'));

    if ($msg != null) {
        $_SESSION["empty"] = "Empty field(s)";
    } else {
        $query = "SELECT SubjectName FROM subjects";

        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            if ($subjectName == $row['SubjectName']) {
                header("Location: superadmin.php");
                exit($_SESSION['duplicate'] = "Subject already exists");
            }
        }
        $sqlquery = "INSERT INTO subjects(SubjectName,Description) VALUES('$subjectName','$description')";

        $conn->query($sqlquery);

        echo "<font color='green'>Data added successfully.";
    }
}
?>
<html>

<head>
    <title>Add Data</title>
</head>

<body>
    <a href="superadmin.php">Home</a>
    <br /><br />
    <!-- <div id="msg"></div> -->
    <form method="post" name="form1">
        <table width="25%" border="0">
            <tr>
                <td>Subject</td>
                <td><input type="text" name="subjectname"></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><input type="text" name="description"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="Submit" value="Add"></td>
            </tr>
        </table>
    </form>
    <?php
    if (isset($_SESSION["empty"])) {
        echo ('<p style = "color : red;">' . htmlentities($_SESSION["empty"]) . "</p>\n");
        unset($_SESSION["empty"]);
    }
    if (isset($_SESSION["duplicate"])) {
        echo ('<p style = "color : red;">' . htmlentities($_SESSION["duplicate"]) . "</p>\n");
        unset($_SESSION["duplicate"]);
    }
    ?>
</body>

</html>