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
    <h1>Manage Books</h1>

    <!--    <div class="row">-->
    <div class="d-flex flex-row" style="margin: 20px 0px 20px 10px;">
        <div class="p-2">
            <div class="row">
                <div class="feature-title">Search for a book</div>
                <input type="text" class="form-control" id="search" placeholder="Type the book name">
            </div>

            <button type="button" id="viewTable" class="btn btn-primary" style="margin-top: 10px"><span
                        class="glyphicon glyphicon-plus">View All </span></button>
        </div>

        <div class="ml-auto p-2">
            <button type="button" id="addBook" class="btn btn-success" style="margin: 20px" title="Add book"><span
                        class="glyphicon glyphicon-plus">Add New Book</span></button>
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

<!--popup template for add book-->
<div id="bookModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="bookForm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="book" class="control-label">ISBN Number</label>
                        <input type="number" name="isbn" id="isbn" oninput="checkIsbn()" autocomplete="off" class="form-control"
                               placeholder="ISBN Number" required/>
                        <span id="check-isbn"></span>
                        <span id="isbnErr"></span>

                    </div>
                    <div class="form-group">
                        <label for="book" class="control-label">Book Name</label>
                        <input type="text" name="name" id="name" autocomplete="off" class="form-control"
                               placeholder="Book name" required/>
                        <span id="titleErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="book" class="control-label">Edition</label>
                        <input type="text" name="edition" id="edition" min="0" autocomplete="off" class="form-control"
                               placeholder="Edition" required/>
                        <span id="editionErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="book" class="control-label">Price (Rs.)</label>
                        <input type="number" name="price" id="price" autocomplete="off" min="0" class="form-control"
                               placeholder="Price (Rs.)" required/>
                        <span id="priceErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="book" class="control-label">Year</label>
                        <input type="number" name="year" id="year" autocomplete="off" class="form-control"
                               placeholder="Year" required/>
                        <span id="yearErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="book" class="control-label">Publisher</label>
                        <input type="text" name="publisher" id="publisher" autocomplete="off" class="form-control"
                               placeholder="Publisher" required/>
                        <span id="publisherErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="book" class="control-label">Image URL</label>
                        <input type="text" name="imgUrl" id="imgUrl" autocomplete="off" class="form-control"
                               placeholder="Image URL" required/>
                        <span id="urlErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="book" class="control-label">Author</label>
                        <input type="text" name="author" id="author" autocomplete="off" class="form-control"
                               placeholder="Author" required/>
                        <span id="authorErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Main Category</label>
                        <select class="form-control" id="category" name="category" required >
                            <option value="">Select Main Category</option>
                            <option value="Fiction">Fiction</option>
                            <option value="Non-fiction">Non-fiction</option>
                            <option value="Reference">Reference Books</option>
                            <option value="Magazines-and-newspapers">Magazines and Newspapers</option>
                            <option value="Graphic-novels">Graphic Novels</option>
                            <option value="Poetry">Poetry</option>
                        </select>
                        <span id="catErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Sub-Category</label>
                        <select class="form-control" id="sub-category" name="sub-category" required disabled>
                            <option value="">Select Sub-Category</option>
                        </select>
                        <span id="subCatErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="book" class="control-label">Number of copies</label>
                        <input type="number" name="noc" id="noc" autocomplete="off" class="form-control"
                               placeholder="Number of copies" min="1" value="1" required/>
                        <span id="copyErr"></span>
                    </div>
                    <div class="form-group">
                        <label for="book" class="control-label">Rack</label>
                        <input type="text" name="rack" id="rack" autocomplete="off" class="form-control"
                               placeholder="Rack" required/>
                    </div>
                    <div class="form-group">
                        <label for="book" class="control-label">Shell</label>
                        <input type="text" name="shell" id="shell" autocomplete="off" class="form-control"
                               placeholder="Shell" required/>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="bookid" id="bookid"/>
                    <input type="hidden" name="action" id="action" value=""/>
                    <input type="submit" name="save" id="save" class="btn btn-success" value="Save"/>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        try {
            $categoryArr=$_POST["category"].",".$_POST["sub-category"];

            include 'model/Book.php';
            $book = new Book();
            $isbn = $book->setIsbn($_POST["isbn"]);
            $name = $book->setTitle($_POST["name"]);
            $edition = $book->setEdition($_POST["edition"]);
            $price = $book->setPrice($_POST["price"]);
            $year = $book->setYear($_POST["year"]);
            $publisher = $book->setPublisher($_POST["publisher"]);
            $imgUrl = $book->setImageUrl($_POST["imgUrl"]);
            $author = $book->setAuthor($_POST["author"]);
            $category = $book->setCategory($categoryArr);
            $rack = $book->setRack($_POST["rack"]);
            $shell = $book->setShell($_POST["shell"]);
            $noc = $book->setNumOfBooks($_POST["noc"]);

            //Write to db
            try {
                include 'repository/BookService.php';
                $add = new BookService();
                $check = $add->addBook($book);

                if ($check == 1) {
                    echo "<script>";
                    echo "$(document).ready(function() {";
                    echo "Swal.fire({";
                    echo " icon: 'success',";
                    echo "text: 'Book details saved successfully!',";
                    echo "}).then((result) => {";
                    echo "});";
                    echo "});";
                    echo "</script>";
                } else {
                    echo "<script> alert('Book adding failed!');</script>";
                }
            } catch (Exception $ex) {
                echo $ex;
//                echo "<script> alert('There is an existing book to this ISBN number! Please check again.');</script>";
            }
        } catch (PDOException $th) {
            echo $th;
        }

    }

    if (isset($_POST["viewBook"])) {
            $_SESSION["bookId"] =$_POST["viewBook"];
        echo '<script>window.location.href = "book-info.php";</script>';
    }
}
?>
<!--Container Main end-->
<script src="js/navbar.js"></script>
<script src="js/validateNewBook.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {

        //sub categories
        $("#category").change(function(){
            var selected_category = $(this).children("option:selected").val();
            if(selected_category == "Fiction"){
                $("#sub-category").empty();
                $("#sub-category").append("<option value=''>Select Sub-Category</option>");
                $("#sub-category").append("<option value='Mystery'>Mystery</option>");
                $("#sub-category").append("<option value='Romance'>Romance</option>");
                $("#sub-category").append("<option value='Science-fiction'>Science Fiction</option>");
                $("#sub-category").append("<option value='Fantasy'>Fantasy</option>");
                $("#sub-category").append("<option value='Historical-fiction'>Historical Fiction</option>");
                $("#sub-category").append("<option value='Realistic-fiction'>Realistic Fiction</option>");
                $("#sub-category").append("<option value='Graphic-novels'>Graphic Novels</option>");
                $("#sub-category").append("<option value='Short-story'>Short Story</option>");
                $("#sub-category").append("<option value='Thriller'>Thriller</option>");
                $("#sub-category").append("<option value='Horror'>Horror</option>");
                $("#sub-category").append("<option value='Crime'>Crime</option>");
                $("#sub-category").append("<option value='Comedy'>Comedy</option>");
                $("#sub-category").append("<option value='Adventure'>Adventure</option>");
                $("#sub-category").append("<option value='Literary-fiction'>Literary Fiction</option>");
                $("#sub-category").append("<option value='Satire'>Satire</option>");
                $("#sub-category").append("<option value='Gothic'>Gothic</option>");
                $("#sub-category").append("<option value='Other'>Other</option>");
            }
            else if(selected_category == "Non-fiction"){
                $("#sub-category").empty();
                $("#sub-category").append("<option value=''>Select Sub-Category</option>");
                $("#sub-category").append("<option value='Autobiography-memoir'>Autobiography/Memoir</option>");
                $("#sub-category").append("<option value='Biography'>Biography</option>");
                $("#sub-category").append("<option value='History'>History</option>");
                $("#sub-category").append("<option value='Science'>Science</option>");
                $("#sub-category").append("<option value='Technology'>Technology</option>");
                $("#sub-category").append("<option value='Business-finance'>Business/Finance</option>");
                $("#sub-category").append("<option value='Self-help-personal-development'>Self-Help/Personal Development</option>");
                $("#sub-category").append("<option value='Health-fitness'>Health/Fitness</option>");
                $("#sub-category").append("<option value='Travel'>Travel</option>");
                $("#sub-category").append("<option value='True-crime'>True Crime</option>");
                $("#sub-category").append("<option value='Politics-government'>Politics/Government</option>");
                $("#sub-category").append("<option value='Philosophy'>Philosophy</option>");
                $("#sub-category").append("<option value='Religion-spirituality'>Religion/Spirituality</option>");
                $("#sub-category").append("<option value='Art-architecture'>Art/Architecture</option>");
                $("#sub-category").append("<option value='Cooking-food'>Cooking/Food</option>");
                $("#sub-category").append("<option value='Sports-recreation'>Sports/Recreation</option>");
                $("#sub-category").append("<option value='Education-teaching'>Education/Teaching</option>");
                $("#sub-category").append("<option value='Environment-nature'>Environment/Nature</option>");
                $("#sub-category").append("<option value='Family'>Family</option>");
                $("#sub-category").append("<option value='Psychology'>Psychology</option>");
                $("#sub-category").append("<option value='Social-science'>Social Science</option>");
                $("#sub-category").append("<option value='Journalism-essays'>Journalism/Essays</option>");
                $("#sub-category").append("<option value='Cultural-social-issues'>Cultural/Social Issues</option>");
                $("#sub-category").append("<option value='Music-history'>Music/Music History</option>");
                $("#sub-category").append("<option value='Foreign-languages'>Foreign languages</option>");
                $("#sub-category").append("<option value='Other'>Other</option>");


            }else if(selected_category == "Reference"){
                $("#sub-category").empty();
                $("#sub-category").append("<option value=''>Select Sub-Category</option>");
                $("#sub-category").append("<option value='Dictionaries'>Dictionaries</option>");
                $("#sub-category").append("<option value='Thesauruses'>Thesauruses</option>");
                $("#sub-category").append("<option value='Encyclopedias'>Encyclopedias</option>");
                $("#sub-category").append("<option value='Atlases'>Atlases</option>");
                $("#sub-category").append("<option value='Almanacs'>Almanacs</option>");
                $("#sub-category").append("<option value='Style-guides'>Style Guides</option>");
                $("#sub-category").append("<option value='Other'>Other</option>");

            }else if(selected_category == "Magazines-and-newspapers"){
                $("#sub-category").empty();
                $("#sub-category").append("<option value=''>Select Sub-Category</option>");
                $("#sub-category").append("<option value='Current-events-magazines'>Current Events Magazines</option>");
                $("#sub-category").append("<option value='Science-magazines'>Science Magazines</option>");
                $("#sub-category").append("<option value='Literary-magazines'>Literary Magazines</option>");
                $("#sub-category").append("<option value='Sports-magazines'>Sports Magazines</option>");
                $("#sub-category").append("<option value='Local-and-national-newspapers'>Local and National Newspapers</option>");
                $("#sub-category").append("<option value='Other'>Other</option>");

            }else if(selected_category == "Graphic-novels"){
                $("#sub-category").empty();
                $("#sub-category").append("<option value=''>Select Sub-Category</option>");
                $("#sub-category").append("<option value='Comics'>Comics</option>");
                $("#sub-category").append("<option value='Manga'>Manga</option>");
                $("#sub-category").append("<option value='Other'>Other</option>");

            }else if(selected_category == "Poetry"){
                $("#sub-category").empty();
                $("#sub-category").append("<option value=''>Select Sub-Category</option>");
                $("#sub-category").append("<option value='Sonnets'>Sonnets</option>");
                $("#sub-category").append("<option value='Haiku'>Haiku</option>");
                $("#sub-category").append("<option value='Free-verse'>Free Verse</option>");
                $("#sub-category").append("<option value='Narrative-poetry'>Narrative Poetry</option>");
                $("#sub-category").append("<option value='Lyric-poetry'>Lyric Poetry</option>");
                $("#sub-category").append("<option value='Epic-poetry'>Epic Poetry</option>");
                $("#sub-category").append("<option value='Ballads'>Ballads</option>");
                $("#sub-category").append("<option value='Odes'>Odes</option>");
                $("#sub-category").append("<option value='Anthologies'>Anthologies</option>");
                $("#sub-category").append("<option value='Other'>Other</option>");
            }
            $("#sub-category").prop("disabled", false);
        });

        //Add book
        $('#addBook').click(function () {
            $('#bookModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $("#bookModal").on("shown.bs.modal", function () {
                $('#bookForm')[0].reset();
                $('.modal-title').html(" Add book");
                $('#save').val('Save');
            });
        });

        //get the full table
        $.ajax({
            url: 'ajax/get-book-table.php',
            method: 'POST',
            dataType: "html",
            data: "query=",

            success: function (data) {
                $('#result').html(data);
                $('#result').css('display', 'block');
                $('#viewTable').css('display', 'none');
            }
        });

        //filter table
        $("#search").keyup(function () {
            var query = $(this).val();
            if (query != "") {
                $.ajax({
                    url: 'ajax/get-book-table.php',
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

    function checkIsbn() {
        $.ajax({
            url: "ajax/check-isbn.php",
            data: 'isbn=' + $("#isbn").val(),
            type: "POST",
            success: function (data) {
                $("#check-isbn").html(data);
            }
        });
    }
</script>
<?php include 'Includes/footer.php' ?>
</body>
</html>
