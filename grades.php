<?php
// including the database connection file
session_start();
include_once("classes/Crud.php");
include_once("classes/Validation.php");

$crud = new Crud();
$validation = new Validation();

if (isset($_POST['update'])) {
    $studentName = $crud->escape_string($_POST['studentName']);
    $subject = $crud->escape_string($_POST['subject']);
    $grades = $crud->escape_string($_POST['grades']);

    $msg = $validation->check_empty($_POST, array('studentName', 'subject', 'grades'));

    if ($msg) {
        $_SESSION["error"] = "Empty fields";
        header("Location:grading.php");
    } else {
        $crud = new Crud();
        //updating the table
        $result = $crud->execute("UPDATE grades
        SET grades = '$grades' WHERE UserID = '$studentName' AND SubjectID = '$subject'");
        $_SESSION["success"] = "Record successfully updated.";

        header("Location: grading.php");
    }
}
