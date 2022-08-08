<?php
//including the database connection file
session_start();
include_once("classes/Crud.php");
include_once("classes/Validation.php");
include_once("dbh.inc.php");
include_once("db.inc.php");

$crud = new Crud();
$validation = new Validation();

if (isset($_POST['Submit'])) {
    $studentName = $crud->escape_string($_POST['studentName']);
    $subjectName = $crud->escape_string($_POST['subjectName']);
    $grades = $crud->escape_string($_POST['grades']);

    $msg = $validation->check_empty($_POST, array('studentName', 'subjectName', 'grades'));

    if ($msg != null) {
        $_SESSION["empty"] = "Empty field(s)";
    } else {
        $query = "SELECT * FROM grades";

        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            if ($subjectName == $row['SubjectName'] && $studentName == $row['studentName']) {

                $sqlquery = "UPDATE grades
                SET grades = '$grades' WHERE studentName = '$studentName' AND SubjectName = '$subjectName'";

                $connection->query($sqlquery);
                header("Location:grading.php");
                exit($_SESSION["success"] = "Updated successfully.");
            }
        }
        $sqlquery = "INSERT INTO grades(grades, studentName, SubjectName) VALUES('$grades','$studentName', '$subjectName')";

        $conn->query($sqlquery);

        $_SESSION["success"] = "Record Successfully added.";
    }
}
?>
<html>

<head>
    <title>Add Data</title>
</head>

<body>
    <a href="grading.php">Home</a>
    <br /><br />
    <form method="post">
        Student:
        <select name="studentName">
            <?php
            $crud = new Crud();

            $query = "SELECT * FROM users WHERE role = 'Student'";
            $result = $crud->getData($query);
            foreach ($result as $key => $row) {
            ?>
                <option value="<?php echo $row["name"] ?>"><?php echo $row["name"] ?></option>

            <?php
            } ?>
        </select>
        <br><br>
        Subject:
        <select name="subjectName">
            <?php
            $crud = new Crud();

            $query = "SELECT * FROM subjects";
            $result = $crud->getData($query);
            foreach ($result as $key => $row) {
            ?>
                <option value="<?php echo $row["SubjectName"] ?>"><?php echo $row["SubjectName"] ?></option>
            <?php
            } ?>
        </select>
        <p>
            Grades:
            <input type="text" name="grades">
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
    if (isset($_SESSION["error"])) {
        echo ('<p style = "color : red;">' . htmlentities($_SESSION["error"]) . "</p>\n");
        unset($_SESSION["error"]);
    }
    if (isset($_SESSION["success"])) {
        echo ('<p style = "color : green;">' . htmlentities($_SESSION["success"]) . "</p>\n");
        unset($_SESSION["success"]);
    }
    ?>
</body>

</html>