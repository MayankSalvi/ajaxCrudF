$(function () {
    //Check Email Availability on signup
    $("#email").keyup(function () {
      var action = "CheckEmailAvailability";
      var email = $(this).val();
      $.ajax({
        url: "../crud/action.php",
        method: "POST",
        data: { email: email, action: action },
        success: function (data) {
          if (data == 1) {
            $("#sign-in").addClass("disabled");
            $("#msg").html("Email Exist! Use Another Email").fadeIn(fast);
          } else {
            $("#sign-in").removeClass("disabled");
            $("#msg").html("").fadeOut(fast);
          }
        },
      });
    });
  
    //Check Password and Confirm Password both are matched
    if (!$("#confirmPassword").val()) {
      $("#confirmPassword").keyup(function () {
        if ($("#password").val() != $("#confirmPassword").val()) {
          $("#sign-in").addClass("disabled");
          $("#msg").html("password Doesn't Match").fadeIn(fast);
          return false;
        } else {
          $("#sign-in").removeClass("disabled");
          $("#msg").html("").fadeOut(fast);
        }
        $.ajax({
          url: "../crud/action.php",
          method: "POST",
          data: { email: email, action: action },
          success: function (data) {
            if (data == 1) {
              $("#sign-in").addClass("disabled");
              $("#msg").html("Email Exist! Use Another Email").fadeIn(fast);
            } else {
              $("#sign-in").removeClass("disabled");
              $("#msg").html("").fadeOut(fast);
            }
          },
        });
      });
    }
    //user registration
    $(".signin-form").submit(function (e) {
      e.preventDefault();
      // alert("clicked");
      $("#action").val("signup");
      $.ajax({
        url: "../crud/action.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (data) {
          if (data == 1) {
            $(".signin-form")[0].reset();
            window.location.replace("../loginSystem/login.php");
          } else {
            $("#msg").html(data).fadeToggle(4000);
          }
        },
      });
    });

    //Check Email Availability on signup
    $("#loginEmail").keyup(function () {
        var action = "CheckLoginEmailAvailability";
        var email = $(this).val();
        $.ajax({
          url: "../crud/action.php",
          method: "POST",
          data: { email: email, action: action },
          success: function (data) {
            if (data == 1) {
              $("#sign-in").addClass("disabled");
              $("#msg").html("Email Doesn't Exist! Register First").fadeIn(fast);
            } else {
              $("#sign-in").removeClass("disabled");
              $("#msg").html("").fadeOut(fast);
            }
          },
        });
      });
  
    //user Login
    $(".login-form").submit(function (e) {
      e.preventDefault();
      $("#action").val("login");
      $.ajax({
        url: "../crud/action.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (data) {
          if (data == 1) {
            $(".login-form")[0].reset();
            window.location.replace("../loginSystem/profile.php");
            if (data == 'thisisuser') {
              $("#fetchUsers").remove();
          }
          } else {
            $("#msg").html(data).fadeToggle(8000);
          }
        },
      });
    });
    //fetch whole data
    function fetchData() {
      var action = "fetchData";
      $.ajax({
        url: "../crud/action.php",
        method: "POST",
        data: { action: action },
        success: function (data) {
          $("#tbody").html(data);
        },
      });
    }
    fetchData();
    //pagination
    var table = "#mytable tbody tr";
    var numberOfItems = $(table).length;
    $("#totalEntries").html(numberOfItems);
    //filter table using jQuery
    $("#filter").keyup(function () {
      var search_term = $(this).val().toLowerCase();
      $(table).filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(search_term) > -1);
      });
    });
    //adding table heading rows to table
    $("#mytable tr:eq(0)").prepend("<th>ID</th>");
    var id = 0;
    $("#mytable tr:gt(0)").each(function () {
      id++;
      $(this).prepend("<td> " + id + "</td>");
    });
  
    $("#maxRows").on("change", function () {
      $("#showingEntries").html($(this).val());
      $(".pagination").html("");
  
      var limitPerPage = $(this).val();
      $(table + ":gt(" + (limitPerPage - 1) + ")").hide();
  
      var totalPages = Math.ceil(numberOfItems / limitPerPage);
  
      $(".pagination").append(
        "<li class='page-item active'><a class='page-link' href='javascript:void(0)'>" +
          1 +
          "</a></li>"
      );
      for (var i = 2; i <= totalPages; i++) {
        $(".pagination").append(
          "<li class='page-item' current-page='" +
            i +
            "'><a class='page-link' href='javascript:void(0)'>" +
            i +
            "</a></li>"
        );
      }
      $(".pagination").append(
        "<li class='page-item' current-page='" +
          (i + 1) +
          "'><a class='page-link next-page' href='javascript:void(0)' aria-lebel='Next'><span aria-hidden'true'>Next</a></li>"
      );
  
      $(".pagination li").on("click", function () {
        if ($(this).hasClass("active")) {
          return false;
        } else {
          var currentPage = $(this).index();
          $(".pagination li").removeClass("active");
          $(this).addClass("active");
          $(table).hide();
  
          var grandtotal = limitPerPage * (currentPage + 1);
          for (var i = grandtotal - limitPerPage; i < grandtotal; i++) {
            $(table + ":eq(" + i + ")").show();
          }
        }
      });
  
      $(".next-page").on("click", function () {
        var currentPage = $(".pagination .active").index();
        if (currentPage === totalPages) {
          return false;
        } else {
          currentPage++;
  
          $(this).removeClass("active");
          $(".pagination li").removeClass("active");
          $(table).hide();
          var grandtotal = limitPerPage * currentPage;
          for (var i = grandtotal - limitPerPage; i < grandtotal; i++) {
            $(table + ":eq(" + i + ")").show();
          }
          //   $(".pagination .current-page:eq(" + (currentPage - 1) + ")").addClass(
          //     "active"
          //   );
        }
        //   alert(grandtotal);
      });
    });
  
    //end of pagination 
    
    
  });
  // (function ($) {
  //   "use strict";
  // })(jQuery);
  