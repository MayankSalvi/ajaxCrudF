<?php
require '../connection/session.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- <link rel="stylesheet" href="../css/style.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>

    <div class="container mt-3">
        <div class="row">
            <h5>Hello, <?php echo ($_SESSION['name']) ?>
                <span style="float: right;"><a href="logout.php" id="logout">Logout</a><span>
            </h5>
            <input type="hidden" name="action" id="action">
        </div>
    </div>
    <div class="container">
        <!-- Button to Open the Modal -->
        <div>
            <button type="button" class="alert alert-success p-3 mt-3 w-100" data-bs-toggle="modal"
                data-bs-target="#myModal" id="addNewStudent">
                <h2 class="text-uppercase">Add New Student</h2>
            </button>
            <!-- <input type="search" class="form-control mb-3" id="search" name="search"
                placeholder="Search Student Here..." autocomplete="off" /> -->

            <div class="">
                <div class="row mb-3">
                    <div class="col-md-2 d-sm-flex jutify-content-sm-start align-items-sm-center">
                        <label for="">Show&nbsp;</label>
                        <select name="showEntries" id="showEntries" class="form-select">
                            <optgroup label="This is a group">
                                <option value="3" selected>3</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                            </optgroup>
                        </select>
                        <label for="">&nbsp;entries</label>
                    </div>
                    <div class="col-md-2">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Export To
                            </button>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <iframe id="txtArea1" style="display: none"></iframe>
                                <li id="btPrint" onclick="createPDF();"><a class="dropdown-item"
                                        href="javascript:void(0)">Pdf</a></li>
                                <li onclick="tableToCSV();"><a class="dropdown-item" href="javascript:void(0)">CSV</a>
                                </li>
                                <li id="btnExport" onclick="fnExcelReport();"><a class="dropdown-item"
                                        href="javascript:void(0)">Excel</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-8 d-sm-flex justify-content-sm-end align-items-sm-center">
                        <!-- <label for="">Search:&nbsp;</label> -->
                        <a href="../downloadToExcel.php"><button type="button" class="btn btn-primary mr-3" id="">
                                Export To Excel
                            </button></a>
                        <a href="../downloadToCsv.php"><button type="button" class="btn btn-primary mr-3" id="">
                                Export To CSV
                            </button></a>
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-primary mr-3 <?php echo $userType ?>"
                            data-bs-toggle="modal" data-bs-target="#myModal2" id="fetchUsers">
                            View Users List
                        </button>

                        <input type="Search" name="search" id="search" class="form-control w-25"
                            placeholder="Search Student Here..." autocomplete="off">
                    </div>
                </div>
            </div>

        </div>

        <form id="addStudent">
            <!-- The Modal -->
            <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-dialog-centered modal-lg ">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Add New Student</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">

                            <div class="row">
                                <div class="">
                                    <input type="hidden" class="form-control" id="stuId" placeholder="" name="id"
                                        value="">

                                </div>

                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control mb-3" id="first_name"
                                                placeholder="First Name*" name="first_name" value="" minlength="2"
                                                autofocus>
                                            <input type="text" class="form-control" id="last_name"
                                                placeholder="Last Name*" name="last_name" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col">

                                    <!-- <div class="profileImageCard">
                                        <div class="profileImage">
                                            <img src=""
                                                alt="Upload-Image" id="uploadImg">
                                        </div>
                                        <div class="customFile">
                                            <label for="image">Upload Your Image</label>
                                            <input type="file" class="form-control" name="imageName" id="image">
                                        </div>
                                    </div> -->
                                    <div class="container">
                                        <div class="row border rounded p-2">
                                            <div class="col-sm-3 col-md-" 3 d-sm-flex align-items-sm-center"
                                                width="130px" height="130px">
                                                <img src="
                                                ../images/UploadUser.png" alt="Upload Image"
                                                    class="rounded-circle img-fluid"
                                                    style="object-fit: cover; width: 100%; height: 100%;"
                                                    id="uploadImg">
                                            </div>
                                            <div class="col d-sm-flex align-items-sm-center border-start">
                                                <label for="image" class="col-form-label border-bottom"
                                                    id="imageLabel">Upload Your
                                                    Image?*</label>
                                                <input type="file" class="form-control d-none" name="imageName"
                                                    id="image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <input type="Email" class="form-control" id="email" placeholder="Email*"
                                        name="email">
                                </div>
                                <div class="col-md-4">
                                    <input type="tel" class="form-control" id="mobile" placeholder="Mobile No*"
                                        name="mobile">
                                </div>
                            </div>
                            <div class="mb-3 mt-3">
                            </div>
                            <div class="mb-3 mt-3">

                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <select class="form-select text-muted" name="country" id="country">
                                        <option class="" value="" selected disabled>Select Country*</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-select text-muted" name="state" id="state">
                                        <option class="" value="" selected disabled>Select State*</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-select text-muted" name="city" id="city">
                                        <option class="" value="" selected disabled>Select City*</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="4" id="address" name="address"
                                    placeholder="Your Permanent Address...*"></textarea>
                            </div>
                            <div class="form-check ">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="term_condition" value="1"><a
                                        href="">Term &
                                        Condition*</a>
                                </label>
                            </div>

                            <input type="hidden" name="action" id="action" value="addstudent">

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div style="height: 60vh; border-radius:5px;" id="tbody"></div>
        <small id="msg"></small>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="myModal2">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">All Users</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body userBody">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="userBody"></tbody>
                    </table>
                </div>

                <!-- Modal footer -->
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div> -->

            </div>
        </div>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="../js/validation.js"></script>
    <script>
    $(function() {
        $("#sqlDataToExcel").click(function(e) {
            // e.preventDefault();
            alert("helo");
            var action = "sqlDataToExcel";
            $.ajax({
                url: "../crud/action.php",
                method: "post",
                data: {
                    action: action
                },
                success: function(data) {
                    alert(data);
                }
            })
        })
        // if userType is user 
        $(".thisisuser").remove();
        $("#fetchUsers").click(function() {
            var action = 'fetchUsers';
            $.ajax({
                url: '../crud/action.php',
                method: 'post',
                data: {
                    action: action
                },
                success: function(data) {
                    $('#userBody').html(data);
                }
            })
        })
        //check user active or not
        $("#userBody").on("change", ".userActivityCheckbox", function() {
            if ($(this).attr('type') === 'checkbox') {
                var value = +$(this).is(':checked');
                // alert(value);
                var action = 'userStatus';
                var id = $(this).attr("data-id");
            }
            $.ajax({
                url: "../crud/action.php",
                method: "post",
                data: {
                    id: id,
                    action: action,
                    value: value
                },

                success: function(data) {
                    // alert(data);
                }
            });
        });

        $("#addStudent").validate();
        // $("#myModal").modal("show");        

        //fetch Students
        function fetchData(page) {
            var action = 'fetch';
            // $('#search').keyup(function() {
            //     var search = $(this).val();
            // })
            var showEntries = $('#showEntries').val();
            // alert(showEntries);

            $.ajax({
                url: "../crud/action.php",
                method: "POST",
                data: {
                    action: action,
                    page_no: page,
                    showEntries: showEntries,
                    // search: search,
                },
                success: function(data) {
                    $('#loadMore').remove();
                    // $('#tbody').append(data);
                    $('#tbody').html(data);
                }
            })

        }
        fetchData();

        //showing entries while changing 
        $('#showEntries').change(function() {
            fetchData();
            $('#totalRow').html("&nbsp;" + $(this).val() + "&nbsp;");

        })

        //load more
        $('#tbody').on("click", "#loadMore", function() {
            var pagination_id = $(this).data('id');
            fetchData(pagination_id);
        })

        //Pagination
        $('#tbody').on("click", ".pagination li", function(e) {
            e.preventDefault();
            var page_id = $(this).attr('id');
            fetchData(page_id);
            // alert(page_id);

        })

        //fetch CountryStateCity
        function fetchCSC(action, category_id) {
            // var action = 'fetchCountry';
            $.ajax({
                url: "../crud/action.php",
                method: "POST",
                data: {
                    // action: action,
                    action: action,
                    id: category_id,
                },
                success: function(data) {
                    if (action == 'stateData') {
                        $('#state').html(data);
                    } else if (action == 'cityData') {
                        $('#city').html(data)
                    } else {
                        $('#country').append(data);
                    }
                }
            })
        }
        //fetch contry data        

        fetchCSC('countryData', null);
        //fetch state data based on country id
        $('#country').change(function() {
            var country = $('#country').val();
            fetchCSC('stateData', country);
        })
        //fetch city data based on state id
        $('#state').change(function() {
            var state = $('#state').val();
            fetchCSC('cityData', state)
        })
        $("#addNewStudent").click(function() {
            $('#addStudent')[0].reset();
            $('#uploadImg').attr("src", "../images/UploadUser.png");
            $('#imageLabel').removeClass("fw-bold").html(
                "Upload Your Image?");
        })

        // Fetch Image Before Upload 
        $('#image').change(function(e) {
            var extension = $(this).val().split(".").pop().toLowerCase();
            if ($.inArray(extension, ["gif", "png", "jpg", "jpeg", "webp"]) == -1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid File Formate!',
                    footer: '<a href="">Why do I have this issue?</a>'
                })
                $(this).val("");
                return false;
            } else {
                var x = URL.createObjectURL(e.target.files[0]);
                // alert(x.val());
                // alert($('#image').val());
                if ($('#uploadImg').attr("src", x)) {
                    $('#imageLabel').addClass("fw-bold").html($('#image').val().toLowerCase().replace(
                        /C:\\fakepath\\/i, ''));
                }
            } // console.log(e);
        })

        //Add Student
        $('#addStudent').submit(function(e) {
            e.preventDefault();

            var image = $("#image").val();
            if (image == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'All Field are Mandatory',
                    footer: '<a href="">Why do I have this issue?</a>'
                })
                // alert("All Fields are Mandatory");
                return false;
            } else {
                var extension = $("#image").val().split(".").pop().toLowerCase();
                if ($.inArray(extension, ["gif", "png", "jpg", "jpeg", "webp"]) == -1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Invalid File Formate!',
                        footer: '<a href="">Why do I have this issue?</a>'
                    })
                    $("#image").val("");
                    return false;
                } else {
                    if (!$(this).valid) return false;
                    $('input').focus();
                    $('#action').val('addstudent');
                    $.ajax({
                        url: "../crud/action.php",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            // $('#msg').html(data).fadeToggle(4000);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            fetchData();
                            $("#myModal").modal("hide");
                            ($('#uploadImg').attr("src", "../images/UploadUser.png"));
                            $('#imageLabel').removeClass("fw-bold").html(
                                "Upload Your Image?");
                            $('#addStudent')[0].reset();
                        }
                    })
                }
            }
        })

        //Update Student
        $('#tbody').on("click", ".btn-edit", function() {
            $('#submitButton').text("Update");
            $('.modal-title').text("Update Record");

            var id = $(this).attr("data-sid");
            var action = "updateStudent";
            var imageName = $('#image').val();
            // alert(imageName);

            $.ajax({
                url: "../crud/action.php",
                method: "POST",
                dataType: "json",
                data: {
                    id: id,
                    action: action,
                    // imageName: imageName,
                },
                success: function(data) {
                    // console.log(data);
                    $("#myModal").modal("show");
                    $("#stuId").val(data.id);
                    $('#uploadImg').attr("src", "../images/" + data.image);
                    $('#imageLabel').addClass("fw-bold").html(data.image);
                    // $("#image").val(data.image);
                    $("#first_name").val(data.first_name);
                    $('#last_name').val(data.last_name);
                    $('#email').val(data.email);
                    $('#mobile').val(data.mobile);
                    $('#country').val(data.country);
                    $('#state').val(data.state);
                    $('#city').val(data.city);
                    $('#image').val(data.image);
                    $('#address').val(data.address);
                    if (data.term_condition == 1) {
                        $('#term_condition').attr("checked", true);
                    }
                }
            })
        })

        //Delete Student
        $('#tbody').on("click", ".btn-del", function() {
            var id = $(this).attr("data-sid");
            // alert(id);
            var deleteImageId = $('#deleteImageId').val();
            var action = 'deleteStudent';
            // alert(deleteImageId);
            mythis = this;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "../crud/action.php",
                        method: "POST",
                        data: {
                            id: id,
                            action: action,
                            deleteImageId: deleteImageId,
                        },
                        success: function(data) {
                            if (data == 1) {
                                Swal.fire(
                                    'Deleted!',
                                    'Record has been deleted.',
                                    'success'
                                )
                                $(mythis).closest("tr").fadeOut();
                                fetchData();
                            } else if (data == 0) {
                                Swal.fire(
                                    'Oops!',
                                    'Record not deleted.',
                                    'Unsuccess'
                                )
                            }
                        }

                    })

                }
            })
        })

        // delete_multiple
        $('#tbody').on("click", "#delete_multiple", function() {
            var action = 'delete_multiple';
            var deleteImageId = $('#deleteImageId').val();
            // var imgId = [];
            // $(":checkbox:checked").each(function(key) {
            //     imgId[key] = deleteImageId;
            // })
            // console.log(imgId);
            var id = [];
            $(":checkbox:checked").each(function(key) {
                id[key] = $(this).val();
            })
            // console.log(id);

            if (id.length < 2) {
                Swal.fire({
                    title: 'OOps!',
                    text: "Please Select Atleast 2 Checkbox!",
                    icon: 'warning',
                    showCancelButton: true,
                })
                alert("Please Select Atleast 2 Checkbox");
                return false;
            } else {

                // alert(deleteImageId);
                mythis = this;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "../crud/action.php",
                            method: "POST",
                            data: {
                                id: id,
                                action: action,
                                deleteImageId: deleteImageId,
                            },
                            success: function(data) {
                                if (data == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Record has been deleted.',
                                        'success'
                                    )
                                    $(mythis).closest("tr").fadeOut();
                                    fetchData();
                                } else if (data == 0) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Record not deleted.',
                                        'success'
                                    )
                                }
                            }

                        })

                    }
                })
            }
        })

        // Search Student 
        $('#search').keyup(function() {
            var action = 'search';
            var search = $(this).val();
            // alert(search);
            if (search.length > 0) {
                $.ajax({
                    url: "../crud/action.php",
                    method: "POST",
                    data: {
                        action: action,
                        search: search
                    },
                    success: function(data) {
                        $('#tbody').html(data);
                        // alert(data);
                    }
                })
            } else {
                fetchData();
            }
        })

        // $('#logout').click(function() {
        //     // e.preventDefault();

        //     var action = 'logout';
        //     // var action = $('#action').val();
        //     // alert(action);

        //     $.ajax({
        //         url: "../crud/action.php",
        //         method: "POST",
        //         data: {
        //             action: action,
        //         },
        //         success: function(data) {
        //             if (data == '1') {
        //                 window.location.replace("loginForm.php");
        //                 location.reload(true);
        //             }
        //         }
        //     })
        // })
        setInterval(function() {
            // last_active_time();
        }, 2000);

        function last_active_time() {
            var action = 'user_last_active_time';
            $.ajax({
                url: "../connection/session.php",
                method: "POST",
                data: {
                    action: action
                },
                success: function(data) {
                    console.log(data);

                    if (data == 'logout') {
                        window.location.replace('logout.php');
                        console.log(data);

                    }
                }
            })
        }
    })
    </script>
    <script>
    //TABLE EXPORT TO EXCEL
    function fnExcelReport() {
        var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange;
        var j = 0;
        tab = document.getElementById("mytable"); // id of table

        for (j = 0; j < tab.rows.length; j++) {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
            // If Internet Explorer
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand(
                "SaveAs",
                true,
                "Say Thanks to Sumit.xls"
            );
        } //other browser not tested on IE 11
        else
            sa = window.open(
                "data:application/vnd.ms-excel," + encodeURIComponent(tab_text)
            );

        return sa;
    }
    </script>
    <script>
    function createPDF() {
        var sTable = document.getElementById("mytable").innerHTML;


        var style = "<style>";
        style = style + "table {width: 100%;font: 17px Calibri;}";
        style =
            style +
            "table, th, td {border: 1px solid #DDD; border-collapse: collapse;";
        style = style + "padding: 2px 3px;text-align: left;}";
        style = style + "</st>";

        // CREATE A WINDOW OBJECT.
        var win = window.open("", "", "height=700,width=700");

        win.document.write("<html><head>");
        win.document.write("<title>Profile</title>"); // <title> FOR PDF HEADER.
        win.document.write(style); // ADD STYLE INSIDE THE HEAD TAG.
        win.document.write("</head>");
        win.document.write("<body>");
        win.document.write(sTable); // THE TABLE CONTENTS INSIDE THE BODY TAG.
        win.document.write("</body></html>");

        win.document.close(); // CLOSE THE CURRENT WINDOW.

        win.print(); // PRINT THE CONTENTS.
    }
    </script>

    <script type="text/javascript">
    function tableToCSV() {

        // Variable to store the final csv data
        var csv_data = [];

        // Get each row data
        var rows = document.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {

            // Get each column data
            var cols = rows[i].querySelectorAll('td,th');

            // Stores each csv row data
            var csvrow = [];
            for (var j = 0; j < cols.length; j++) {

                // Get the text data of each cell
                // of a row and push it to csvrow
                csvrow.push(cols[j].innerHTML);
            }

            // Combine each column value with comma
            csv_data.push(csvrow.join(","));
        }

        // Combine each row data with new line character
        csv_data = csv_data.join('\n');

        // Call this function to download csv file
        downloadCSVFile(csv_data);

    }

    function downloadCSVFile(csv_data) {

        // Create CSV file object and feed
        // our csv_data into it
        CSVFile = new Blob([csv_data], {
            type: "text/csv"
        });

        // Create to temporary link to initiate
        // download process
        var temp_link = document.createElement('a');

        // Download csv file
        temp_link.download = "GfG.csv";
        var url = window.URL.createObjectURL(CSVFile);
        temp_link.href = url;

        // This link should not be displayed
        temp_link.style.display = "none";
        document.body.appendChild(temp_link);

        // Automatically click the link to
        // trigger download
        temp_link.click();
        document.body.removeChild(temp_link);
    }
    </script>
</body>

</html>