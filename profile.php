<?php session_start();

if (!isset($_SESSION['username'])) {
    echo "not logged in. sorry";
} else {
    echo $_SESSION['username'];
}
?>

<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <p><a href="profile-photo.php">Upload Image</a></p>

    <p><a href="browser.php">View Excel file using Browser</a></p>
    <p><a href="php_spreadsheet_import.php">Import Excel File</a></p>
    <p><a href="php_spreadsheet_export.php">Export File</a></p>
    <p><a href="pdf-grades.php">View Grades via PDF</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>

</html>