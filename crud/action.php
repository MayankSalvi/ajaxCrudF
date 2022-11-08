<?php
session_start();
if (isset($_POST['action'])) {
    include '../connection/dbcon.php';
    if ($_POST['action'] == 'sqlDataToExcel') {
        $query = 'select * from students';
        $result = mysqli_query($con, $query);
        $output = '<table class="table table-bordered" id="mytable">
        <thead style="background: #f8f9fa; position: sticky; top:0;">
            <tr>
                <th><button class="btn btn-sm" id="delete_multiple">&#128465;</button></th>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile No.</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    ';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                    <td align="center"><input type="checkbox" class="delete_checkbox" value = ' . $row['id'] . ' /></td>
                    <td>' . $row['id'] . '</td>
                    <td><img src="../images/' . $row["image"] . '" height="60" width="75" class="img-thumbnail" /></td>
                    <td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td class="d-none"><input id="deleteImageId" type="text" value=' . $row['image'] . ' /> </td>
                    <td>' . $row['mobile'] . '</td>
                    <td>' . $row['address'] . ', ' . $row['city'] . ' (' . $row['state'] . ') ' . $row['country'] . '</td>
                    <td><button class="btn btn-primary mr-1 btn-sm btn-edit" data-sid=' . $row['id'] . ' >Edit</button><button class="btn btn-danger btn-sm btn-del" data-sid=' . $row['id'] . '>Delete</button></td>
                </tr>
                ';
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
    }
    //change user status
    if ($_POST['action'] == 'userStatus') {
        $query = "UPDATE `users` SET `status`= {$_POST['value']} WHERE id = {$_POST['id']}";
        $result = mysqli_query($con, $query);

        // if ($result) {
        //     echo "updated";
        // } else {
        //     echo "not updated";
        // }
    }
    //fetch all users
    if ($_POST['action'] == 'fetchUsers') {
        $query = "select * from users";
        $result = mysqli_query($con, $query);

        $output = '';
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                //login if user is active-1
                if ($row['status'] == 1) {
                    $status = "checked";
                    $statusCls = "";
                } else {
                    $status = "";
                    $statusCls = "bg-danger text-white";
                }
                $output .= '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td class="" id="userStatus">
                    <div class="form-check form-switch">
                        <input class="form-check-input userActivityCheckbox" type="checkbox" role="switch" id="userActive" data-id="' . $row['id'] . '" ' . $status . '  />
                        <label class="form-check-label" for="userActive"></label>
                    </div>
                    </td>
                </tr>';
            }
        }
        echo $output;
    }
    if ($_POST['action'] == 'CheckEmailAvailability') {
        $emailExist = $_POST['email'];
        $query = "select * from users where email='$emailExist'";
        $result = mysqli_query($con, $query);

        if (($row = mysqli_num_rows($result)) > 0) {
            echo 1;
            return false;
        }
    }

    if ($_POST['action'] == 'signup') {
        $name = ucwords($_POST['name']);
        $email = $_POST['email'];
        if (($_POST['password'] === $_POST['confirmPassword'])) {
            $password = md5($_POST['password']);
        } else {
            echo "Password Doesn't Match";
            return false;
        }
        $query = "insert into users(name,email,password) values('$name','$email','$password')";
        if (mysqli_query($con, $query)) {
            echo 1;
        } else {
            echo 'Not Registered';
        }
    }
    if ($_POST['action'] == 'CheckLoginEmailAvailability') {
        $emailExist = $_POST['email'];
        $query = "select * from users where email='$emailExist'";
        $result = mysqli_query($con, $query);

        if (!($row = mysqli_num_rows($result)) > 0) {
            echo 1;
            return false;
        }
    }
    if ($_POST['action'] == 'login') {
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $query = "select * from users where email='$email' && password='$password'";
        $result = mysqli_query($con, $query);

        if (($row = mysqli_fetch_assoc($result)) > 0) {
            if ($row['status'] == 1) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['usertype'] = $row['usertype'];
                echo 1;
            } else {
                echo "'You're not active, Contact To Admin";
            }
        } else {
            echo 'Incorrect Details';
        }
    }


    // if ($_POST['action'] == 'logout') {
    //     session_start();
    //     session_destroy();
    //     session_unset($_SESSION['id']);
    //     session_unset($_SESSION['fullname']);
    //     header("Location:loginForm.php");
    //     echo '1';
    // }

    // Fetching Whole Data 
    if ($_POST['action'] == 'fetch') {

        // Uncomment For Load More
        // $limit = $_POST['showEntries'];
        // // $limit = 3;
        // if (isset($_POST['page_no'])) {
        //     $offset = $_POST['page_no'];
        //     echo $offset;
        // } else {
        //     $offset = 0;
        // }
        // pagination 
        $limit = $_POST['showEntries'];
        if (isset($_POST['page_no'])) {
            $page = $_POST['page_no'];
            // echo $page;
        } else {
            $page = 1;
        }

        $offset = ($page - 1) * $limit;

        $output = '<table class="table table-bordered" id="mytable">
        <thead style="background: #f8f9fa; position: sticky; top:0;">
            <tr>
                <th><button class="btn btn-sm" id="delete_multiple">&#128465;</button></th>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile No.</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    ';
        // $query = '';
        // if (isset($_POST['search'])) {
        //     $search = $_POST["search"];
        //     $query = "SELECT * FROM `students` WHERE `first_name` LIKE '{$search}%' || `last_name` LIKE '%{$search}%'|| `email` LIKE '{$search}%'|| `mobile` LIKE '%{$search}%'|| `country` LIKE '{$search}%'|| `state` LIKE '{$search}%'|| `city` LIKE '{$search}%'|| `address` LIKE '%{$search}%'";
        // } else {
        $query = "SELECT * FROM `students` ORDER BY `id` ASC LIMIT {$offset},{$limit}";
        // }
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $number = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $lastRecord = $row['id'];
                if (!empty($row['image'])) {
                    $image = '<img src="../images/' . $row["image"] . '" height="60" width="75" class="img-thumbnail" />';
                } else {
                    $image = '<img src="../images/UploadUser.png" height="60" width="75" class="img-thumbnail" />';
                }
                $output .= '                
                    <tr>
                        <td align="center"><input type="checkbox" class="delete_checkbox" value = ' . $row['id'] . ' /></td>
                        <td>' . $number . '</td>

                        <td>' . $image . '</td>
                        <td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>
                        <td>' . $row['email'] . '</td>
                        <td class="d-none"><input id="deleteImageId" type="text" value=' . $row['image'] . ' /> </td>
                        <td>' . $row['mobile'] . '</td>
                    <td>' . $row['address'] . ', ' . $row['city'] . ' (' . $row['state'] . ') ' . $row['country'] . '</td>
                    <td><button class="btn btn-primary mr-1 btn-sm btn-edit" data-sid=' . $row['id'] . ' >Edit</button><button class="btn btn-danger btn-sm btn-del" data-sid=' . $row['id'] . '>Delete</button></td>
                    </tr>
                ';
                $number++;
            }
            // $output .= "
            //             <tr>
            //                 <td colspan='7'>
            //                     <button class='btn btn-primary align-items-center' id='loadMore' data-id='{$lastRecord}'>Load More</button>
            //                 </td>
            //             </tr>
            //             </tbody></table>";


            $output .= '</tbody></table><div class="">
            <div class="row mt-3">
                <div class="col d-sm-flex jutify-content-sm-start align-items-sm-center">
                    <span>Showing&nbsp;</span>
                    <span>&nbsp;1&nbsp;</span>
                    <span>to</span>
                    <span id="totalRow">&nbsp' . $limit . '&nbsp;</span>
                    <span>of</span>';

            $totalRow = mysqli_num_rows(mysqli_query($con, "select * from students"));
            $totalPages = ceil($totalRow / $limit);

            $output .= '<span>&nbsp;' . $totalRow . '&nbsp;</span><tr><td>
                    <div class="col d-sm-flex justify-content-sm-end align-items-sm-center">
                        <nav>
                            <ul class="pagination">';
            if ($page > 1) {
                $previous = $page - 1;
                $output .= '<li class="page-item" id="1">
                        <a class="page-link" aria-label="Previous"><span aria-hidden="true">First Page</span></a>
                        </li>';
                $output .= '<li class="page-item" id = "' . $previous . '">
                                    <a class="page-link" aria-label="Previous"><span aria-hidden="true">«</span></a>
                                </li>';
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                $active_class = '';
                if ($i == $page) {
                    $active_class = 'active';
                }
                $output .= '<li class="page-item ' . $active_class . '" id="' . $i . '"><a class="page-link">' . $i . '</a></li>';
            }
            if ($page < $totalPages) {
                $page++;
                $output .= '
                                <li class="page-item" id = "' . $page . '">
                                    <a class="page-link" aria-label="Next"><span aria-hidden="true">»</span></a>
                                </li>
                                <li class="page-item" id="' . $totalPages . '">
                        <a class="page-link" aria-label="Next"><span aria-hidden="true">Last Page</span></a>
                        </li>
                            </ul>
                        </nav>
                    </div></td></tr>';
            }
        } else {
            $output = '<div class="alert alert-danger text-centred fw-bold p-3">No Record Please Enter New Record.</div>';
        }
        echo $output;
    }

    //Fetching Country Data
    if (($_POST['action']) == 'countryData') {
        $output = '';
        $query = "SELECT * FROM `tbl_countries` ORDER BY `name` ASC";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // $output .= '<option data-id =' . $row['id'] . ' value=' . $row['name'] . '>' . $row['name'] . '</option>';
                $output .= '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
            }
        } else {
            $output = '<h6 class="">No Record Found</h6>';
        }
        echo $output;
    }

    //Fetching State Data
    else if ($_POST['action'] == 'stateData') {
        $output = '';
        $query = "SELECT * FROM `tbl_states` WHERE `country_id` = {$_POST['id']}";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
            }
        } else {
            $output = '<h6 class="">No Record Found</h6>';
        }
        echo $output;
    }

    //Fetching City Data    
    else if ($_POST['action'] == 'cityData') {
        $output = '';
        $query = "SELECT * FROM `tbl_cities` WHERE `state_id` = {$_POST['id']}";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
            }
        } else {
            $output = '<h6 class="">No Record Found</h6>';
        }
        echo $output;
    }

    // Insert Data 
    if ($_POST['action'] == 'addstudent') {
        $id = ($_POST['id']);
        $first_name = ucwords($_POST['first_name']);
        $last_name = ucwords($_POST['last_name']);
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $filenameold = strtolower($_FILES['imageName']['name']);
        $filTempLocation = $_FILES['imageName']['tmp_name'];
        $country = $_POST['country'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $term_condition = $_POST['term_condition'];

        $extension = pathinfo($filenameold, PATHINFO_EXTENSION);
        $filename = (rand() . "(" . $first_name . ")." . $extension);
        $vaild_extension = array("jpg", "jpeg", "gif", "png", "webp");

        if (in_array($extension, $vaild_extension)) {
            $query = "INSERT INTO `students`(`id`,`image`,`first_name`, `last_name`, `email`, `mobile`, `country`, `state`, `city`, `address`,`term_condition`) VALUES ('$id','$filename','$first_name','$last_name','$email','$mobile','$country','$state','$city','$address','$term_condition') ON DUPLICATE KEY UPDATE image='$filename', first_name ='$first_name', last_name='$last_name', email='$email', mobile='$mobile', country='$country', state='$state', city='$city', address='$address', term_condition = '$term_condition'";
            $result = mysqli_query($con, $query);

            $path = "../images/" . $filename;
            if ((move_uploaded_file($filTempLocation, $path))) {
                echo "Record Inserted";
            } else {
                echo "Connection Error";
            }
        } else {
            echo "Invalid File Formate";
        }
    }

    // Update Student 
    if ($_POST['action'] == 'updateStudent') {
        $query = "SELECT * FROM students where id=" . $_POST["id"] . "";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        $query1 = "SELECT * FROM tbl_countries";
        $result1 = mysqli_query($con, $query1);
        $row1 = mysqli_fetch_assoc($result1);
        echo json_encode($row);
    }

    // Delete Student 
    if ($_POST['action'] == 'deleteStudent') {

        $query = "DELETE FROM students where id=" . $_POST["id"] . "";
        if (mysqli_query($con, $query)) {
            unlink("../images/" . $_POST['deleteImageId']);
            echo 1;
        } else {
            echo 0;
        }
    }
    // delete_multiple
    if ($_POST['action'] == 'delete_multiple') {
        $str = $_POST['id'];
        $id = implode(',', $str);
        $recordDeleteQuery = "DELETE FROM students where id IN ({$id})";
        $result1 = mysqli_query($con, $recordDeleteQuery);

        $multiImageDeleteQuery = "SELECT * FROM `students` where `id` IN ({$id})";
        $result = mysqli_query($con, $multiImageDeleteQuery);
        $rowCount = mysqli_num_rows($result);

        if ($result) {
            // unlink("../images/" . $_POST['deleteImageId']);
            for ($i = 1; $i <= $rowCount; $i++) {
                $row = mysqli_fetch_array($result);
                unlink("../images/" . $row['image']);
            }
            echo 1;
        } else {
            echo 0;
        }
    }

    // Search Records
    if ($_POST['action'] == 'search') {

        // Uncomment For Load More
        // $limit = $_POST['showEntries'];
        // // $limit = 3;
        // if (isset($_POST['page_no'])) {
        //     $offset = $_POST['page_no'];
        //     echo $offset;
        // } else {
        //     $offset = 0;
        // }

        // pagination 
        $limit = 3;
        if (isset($_POST['page_no'])) {
            $page = $_POST['page_no'];
            echo $page;
        } else {
            $page = 1;
        }

        $offset = ($page - 1) * $limit;

        $output = '<div id="mytable">
        <table class="table table-bordered" id="mytable">
        <thead style="background: #f8f9fa; position: sticky; top:0;">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile No.</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    ';

        $search = $_POST["search"];
        $query = "SELECT * FROM `students` WHERE `first_name` LIKE '{$search}%' || `last_name` LIKE '%{$search}%'|| `email` LIKE '{$search}%'|| `mobile` LIKE '%{$search}%'|| `country` LIKE '{$search}%'|| `state` LIKE '{$search}%'|| `city` LIKE '{$search}%'|| `address` LIKE '%{$search}%'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $number = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $lastRecord = $row['id'];
                $output .= '                
                    <tr>
                        <td>' . $number . '</td>
                        <td><img src="../images/' . $row["image"] . '" height="60" width="75" class="img-thumbnail" /></td>
                        <td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>
                        <td>' . $row['email'] . '</td>
                        <td class="d-none"><input id="deleteImageId" type="text" value=' . $row['image'] . ' /> </td>
                        <td>' . $row['mobile'] . '</td>
                    <td>' . $row['address'] . ', ' . $row['city'] . ' (' . $row['state'] . ') ' . $row['country'] . '</td>
                    <td><button class="btn btn-primary mr-1 btn-sm btn-edit" data-sid=' . $row['id'] . ' >Edit</button><button class="btn btn-danger btn-sm btn-del" data-sid=' . $row['id'] . '>Delete</button></td>
                    </tr>
                ';
                $number++;
            }
            // $output .= "
            //             <tr>
            //                 <td colspan='7'>
            //                     <button class='btn btn-primary align-items-center' id='loadMore' data-id='{$lastRecord}'>Load More</button>
            //                 </td>
            //             </tr>
            //             </tbody></table>";


            $output .= '</tbody></table></div>
            <div class="">
            <div class="row mt-3">
                <div class="col d-sm-flex jutify-content-sm-start align-items-sm-center">
                    <span>Showing&nbsp;</span>
                    <span>&nbsp;1&nbsp;</span>
                    <span>to</span>
                    <span id="totalRow">&nbsp;3&nbsp;</span>
                    <span>of</span>';

            $numberOfRow = "SELECT * FROM students";
            $numberOfRows = mysqli_query($con, $numberOfRow);
            $totalRow = mysqli_num_rows($numberOfRows);

            $totalPages = ceil($totalRow / $limit);

            $output .= '<span>&nbsp; ' . $totalRow . '</span>
                    <span>&nbsp;entries</span>
                </div>
                <div class="col d-sm-flex justify-content-sm-end align-items-sm-center">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a>
                            </li>';

            for ($i = 1; $i <= $totalPages; $i++) {
                $output .= '<li class="page-item"><a class="page-link" id="' . $i . '">' . $i . '</a></li>';
            }
            $output .= '<li class="page-item">
            <a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a>
        </li></ul>
                    </nav>
                </div>
            </div>
        </div>';
        } else {
            $output = '<tr class="alert alert-danger text-centred fw-bold"><td colspan="7">No Record Please Enter New Record.</td></tr>';
        }
        echo $output;
    }
}