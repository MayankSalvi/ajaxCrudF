<?php
include 'connection/dbcon.php';
$query = 'select * from students';
$result = mysqli_query($con, $query);
$output = '<table border="1" class="table table-bordered" id="mytable">
        <thead style="background: #f8f9fa; position: sticky; top:0;">
            <tr>
                <th>ID</th>
                <th style="width: 65px">Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile No.</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
    ';
if (mysqli_num_rows($result) > 0) {
    $number = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<tr style="height: 82px">
                    <td>' . $number . '</td>
                    <td><img src="http://localhost/vs%20code/ajaxCrudF/images/' . $row["image"] . '" height="73" width="57" class="img-thumbnail" /></td>
                    <td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td>' . $row['mobile'] . '</td>
                    <td>' . $row['address'] . ', ' . $row['city'] . ' (' . $row['state'] . ') ' . $row['country'] . '</td>
                </tr>
                ';
        $number++;
    }
    $output .= '</tbody></table>';

    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename=report.xls');
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $output;
} else {
    echo "No Record Found";
}