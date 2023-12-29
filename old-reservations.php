<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
session_start();
require("login-check/login-check-a.php");
include("connection/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Biblio-Gest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/jpg" href="Images/icon.ico"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"/>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body id="body-pd">
<?php include("Includes/navbar.php") ?>

<!--Container Main start-->
<div class="main container">
    <h1>Old Reservations</h1>

    <!--    <div class="row">-->
    <div class="d-flex flex-row" style="margin: 20px 0px 20px 10px;">
        <div class="p-2">
            <div class="row">
                <div class="feature-title">Search for a book reservation</div>
                <input type="text" class="form-control" id="search" placeholder="Type the book name">
            </div>
            <button type="button" id="viewTable" class="btn btn-primary" style="margin-top: 10px"><span
                    class="glyphicon glyphicon-plus">View All </span></button>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-md-12">
            <form method="post" enctype="multipart/form-data">
                <div id="result"></div>
            </form>
        </div>
    </div>

</div>

<!--Container Main end-->
<script src="js/navbar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {

        //get the full table
        $.ajax({
            url: 'ajax/get-old-reservations.php',
            method: 'POST',
            dataType: "html",
            data: "query=",

            success: function (data) {
                $('#result').html(data);
                $('#result').css('display', 'block');
                $('#viewTable').css('display', 'none');
            }
        });

        // filter table
        $("#search").keyup(function () {
            var query = $(this).val();
            if (query != "") {
                $.ajax({
                    url: 'ajax/get-old-reservations.php',
                    method: 'POST',
                    data: {
                        query: query
                    },
                    success: function (data) {
                        $('#result').html(data);
                        $('#result').css('display', 'block');
                        $('#viewTable').css('display', 'block');

                    }
                });
            } else {
                $('#result').css('display', 'none');
            }
        });

        // reload table by button
        $('#viewTable').click(function () {
            window.location.reload();
        });

    });

</script>
<?php include 'Includes/footer.php' ?>
</body>
</html>
