<?php
session_start();
include 'connection/config.php';
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

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />

</head>
<body id="body-pd">
<?php include("Includes/navbar.php") ?>

<!--Container Main start-->
<div class="main container">
    <div class="college-data">
        <img src="./Images/logo.png" style="width: 10%">
        <h1 style="padding-top: 14px;padding-left: 20px"><b> Project PHP - Library Management System</b></h1>
    </div>

    <h3 style="margin-top: 60px; padding-left: 18%">Browse Books</h3>
    <div class="col-md-8 offset-md-2 mt-1">
        <div class="input-group mb-3">
            <input type="text" id="search" class="form-control" placeholder="Search books by name..." aria-label="Recipient's username">
            <div class="input-group-append">
                <button class="btn btn-danger" id="searchBtn" onclick="clearInputField(),onSelect('All')" hidden ><i id="searchIcon" class="fa fa-close"></i></button>
            </div>
        </div>
        <button class="btn btn-success" id="categoryBtn" style="margin: auto; display: block" ><i id="catIcon" class="fa fa-arrow-down" style="margin-right: 5px"> </i> Filter by category</button>
    </div>

    <form action="" method="post" style="margin-top: 20px">
        <ul class="ks-cboxtags" style="display: none; transition: all 0.5s ease-in-out;" id="categories">
            <li><input type="checkbox" id="checkboxOne" value="All" onclick="onSelect('All')" name="All" checked><label for="checkboxOne">All</label></li>
            <li><input type="checkbox" id="checkboxTwo" value="Fiction" onclick="onSelect('Fiction')"><label for="checkboxTwo" >Fiction</label></li>
            <li><input type="checkbox" id="checkboxThree" value="Non-fiction" onclick="onSelect('Non-fiction')"><label for="checkboxThree">Non-fiction</label></li>
            <li><input type="checkbox" id="checkboxFour" value="Reference Books" onclick="onSelect('Reference')"><label for="checkboxFour">Reference Books</label></li>
            <li><input type="checkbox" id="checkboxFive" value="Magazines and Newspapers" onclick="onSelect('Magazines-and-newspapers')"><label for="checkboxFive">Magazines and Newspapers</label></li>
            <li><input type="checkbox" id="checkboxSix" value="Graphic Novels" onclick="onSelect('Graphic-novels')"><label for="checkboxSix">Graphic Novels</label></li>
            <li><input type="checkbox" id="checkboxSeven" value="Poetry" onclick="onSelect('Poetry')"><label for="checkboxSeven">Poetry</label></li>
            <!-- <li><input type="checkbox" id="checkboxTen" value="Other" onclick="onSelect('Other')"><label for="checkboxTen">Other</label></li> -->
        </ul>
    </form>

    <div class="book-section-container" id="sectionBelow" style="transition: all 0.5s ease-out;" >
        <div class="book-section section-a">
            <div class="card-wrapper" id="result">
                <div id="bookCards"></div>
            </div>
            <div id="noData" class="noData">No Available Books!</div>
        </div>
    </div>

    <!--Container Main end-->
    <script src="js/navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Optional JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.0.3/nouislider.min.js"></script>

    <!--Mustache.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>

    <!--book card template    -->
    <script type="text/html" id="templateBookCards">
        <div class="row" style="padding-left: 40px">
            {{#data}}
            <div class="card">
                <img src="{{imgUrl}}" alt="Book" onerror="this.onerror=null;this.src='Images/bookPlaceholder.png';"/>
                <h3><b>{{name}}</b></h3>
                <p>by {{author}}</p>
                <div class="additional-info">
                    <h3><b>{{name}}</b></h3>
                    <p><b>Author:</b>{{author}}</p>
                    <p><b>Sub-category:</b> {{subCat}}</p>
                    <p><b>ISBN:</b> {{isbn}}</p>
                    <p><b>Publisher:</b> {{pub}}</p>
                    <p><b>Edition:</b> {{edition}}</p>
                    <p><b>Year:</b> {{year}}</p>
                </div>
            </div>
            {{/data}}
        </div>
    </script>
    <script>
        // show hide category section
        const categoryIcon =document.getElementById("catIcon");
        const toggleBtn = document.getElementById("categoryBtn");
        const section = document.getElementById("categories");
        const sectionBelow = document.getElementById("sectionBelow");

        toggleBtn.addEventListener("click", () => {
            if (section.style.display === "none") {
                categoryIcon.className = "fa fa-arrow-up";
                section.style.display = "block";
                setTimeout(() => {
                    section.style.opacity = 1;
                    section.style.transform = "translateY(0)";
                    sectionBelow.style.transform="translateY(-20px)"
                    // sectionBelow.style.marginTop = section.offsetHeight + "px";
                }, 50);
            } else {
                categoryIcon.className = "fa fa-arrow-down";
                section.style.opacity = 0;
                section.style.transform = "translateY(-20px)";
                sectionBelow.style.transform="translateY(0)"
                sectionBelow.style.marginTop = "0";
                setTimeout(() => {
                    section.style.display = "none";
                }, 500);
            }
        });

        $(document).ready(function(){

            // set clicked checkbox active
            $('input:checkbox').click(function() {
                $('input:checkbox').not(this).prop('checked', false);
            });

            //search bar function
            $("#search").keyup(function () {
                // $("#searchIcon").removeClass("fa-search").addClass("fa-close");
                uncheck();
                $("#searchBtn").prop('hidden',false);
                $("#noData").prop('hidden',true);
                $("#checkboxOne").prop("checked", false);

                var query = $(this).val();
                if (query != "") {
                    $.ajax({
                        url: 'ajax/get-search-results.php',
                        method: 'POST',
                        data: {
                            query: query
                        },
                        success: function (data) {
                            $('#bookCards').html(data);
                            $('#bookCards').css('display', 'block');
                            $('#viewTable').css('display', 'block');

                        }
                    });

                } else {
                    $('#bookCards').css('display', 'none');
                }
            });
        });

        //hide no data tag
        $(function () {
            $('#noData').hide();
            onSelect("All");
        });

        //clearing search bar
        function clearInputField() {
            $("#search").val("")
            $("#searchBtn").prop('hidden',true);
            // $("#searchIcon").removeClass("fa-close").addClass("fa-search");
            $("#checkboxOne").prop("checked", true);
        }

        //getting data and display
        function onSelect(field){
            clearInputField();
            console.log(field);
            $.ajax({
                url: "ajax/get-book-by-category.php",
                data: 'option=' + field,
                type: "POST",
                // data: "query=",
                success: function (data) {
                    // console.log(data);
                    let obj ;
                    try{
                        obj = JSON.parse(data);
                        $("#noData").hide();
                    }catch(err){
                        console.log("null")
                        $("#noData").prop('hidden',false);
                        $("#noData").show();
                    }
                    let res = [];
                    for(let i in obj)
                        res.push(obj[i]);
                    console.log(res);

                    let content = Mustache.render(
                        $('#templateBookCards').html(), { 'data': res });
                    $('#bookCards').html(content);
                }
            });
        }

        // uncheck the checkboxes
        function uncheck() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    checkbox.checked = false;
                }
            });
        }
    </script>
    <?php include 'Includes/footer.php' ?>
</body>
</html>
