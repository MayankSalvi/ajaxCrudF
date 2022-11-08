<?php
include 'connection/dbcon.php';
header('Content-type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=report.csv');
$output = fopen("php://output", "w");
fputcsv($output, array('Id', 'Image', 'Fitst Name', 'Last Name', 'Email', 'Mobile', 'Country', 'State', 'City', 'Address', 'Term & Condition'));
$query = 'select * from students';
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);
}