<?php
require('fpdf184/fpdf.php');
// Database Connection 
$conn = new mysqli('localhost', 'root', '', 'gradingsystem');
//Check for connection error
if ($conn->connect_error) {
    die("Error in DB connection: " . $conn->connect_errno . " : " . $conn->connect_error);
}
// Select data from MySQL database
$select = "SELECT * FROM `grades`";
$result = $conn->query($select);
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
while ($row = $result->fetch_object()) {
    $grades = $row->grades;
    $studentName = $row->studentName;
    $SubjectName = $row->SubjectName;
    $pdf->Cell(20, 10, $grades, 1);
    $pdf->Cell(40, 10, $studentName, 1);
    $pdf->Cell(40, 10, $SubjectName, 1);
    $pdf->Ln();
}
$pdf->Output();
