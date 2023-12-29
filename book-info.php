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
    <title>Managrmrnt-biblio</title>
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
<?php include("Includes/navbar.php");?>
<?php
$id = $_SESSION['bookId'];
include 'repository/BookService.php';
include 'model/Book.php';
$bookS = new BookService();
$book=new Book();
try {

    $result=$bookS->getBook($id);

    foreach ($result as $row) {
        $isbn =$row[0];
        $title=$row[1];
        $edition=$row[2];
        $price=$row[3];
        $year=$row[4];
        $publisher=$row[5];
        $imageUrl=$row[6];
        $author=$row[7];
        $category=$row[8];
        $rack=$row[9];
        $shell=$row[10];
        $bookId=$row[11];
    }
    $catArr = explode(',', $category);
    $mainCategory=$catArr[0];
    $subCategory=$catArr[1];
} catch (PDOException $th) {
    echo $th->getMessage();
}

try{
    $bookCount=$bookS->bookCount($isbn);

}catch(PDOException $ex){
    echo $th->getMessage();
}

try{
    $bookIds=$bookS->getBookIds($isbn);

}catch(PDOException $ex){
    echo $th->getMessage();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        try {
            $isbnList=$isbn.",".$_POST['isbn'];
            $catArr=$_POST['category'].",".$_POST['sub-category'];
            $bookId=$book->setBookId($id);
            $isbn=$book->setIsbn($isbnList);
            $name=$book->setTitle($_POST['title']);
            $edition=$book->setEdition($_POST['edition']);
            $price=$book->setPrice($_POST['price']);
            $year=$book->setYear($_POST['year']);
            $publisher=$book->setPublisher($_POST['publisher']);
            $imgUrl=$book->setImageUrl($_POST['imgUrl']);
            $author=$book->setAuthor($_POST['author']);
            $category=$book->setCategory($catArr);
            $rack=$book->setRack($_POST['rack']);
            $shell=$book->setShell($_POST['shell']);

            if($_POST['newNoc']>0){
                $addNoc = $book->setNumOfBooks($_POST["newNoc"]);
                $addCopy = $bookS->addBook($book);
            }

            //  Write to db
            try {
                $check=$bookS->updateBook($book);
                if ($check==1){
                    echo "<script>";
                    echo "$(document).ready(function() {";
                    echo "Swal.fire({";
                    echo " icon: 'success',";
                    echo "text: 'Book details updated successfully!',";
                    echo "}).then((result) => {";
                    echo "window.history.back();";
                    echo "});";
                    echo "});";
                    echo "</script>";
                }
                else{
                    echo "<script> alert(' Failed!');</script>";
                }
            }
            catch(Exception $ex){
                echo $ex;
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        try {
        $delete = $bookS->deleteBook($id);
            if ($delete == 1) {
                echo "<script>";
                echo "$(document).ready(function() {";
                echo "Swal.fire({";
                echo " icon: 'success',";
                echo "text: 'Book deleted successfully!',";
                echo "}).then((result) => {";
                echo "window.location.href = 'book.php'";
                echo "});";
                echo "});";
                echo "</script>";
            } else {
                echo "<script> alert('failed!');</script>";
            }
        } catch (PDOException $th) {
//            echo $th->getMessage();
            echo "<script> alert('There are exciting records or reservation for this book! Cannot delete the book');</script>";
        }
    }
}
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
?>

<!--Container Main start-->
<div class="main container">

    <div class="row">
        <div class="col-md-4" id="imageHolder" style="margin: auto">
            <img src="<?php echo $imageUrl;?>" alt="Book Cover" class="img-fluid book-cover"
                 onerror="this.onerror=null;this.src='Images/bookPlaceholder.png';">
        </div>
        <div class="col-md-8">
            <h1 class="mb-4">Book Details</h1>
            <form method="post" enctype="multipart/form-data" action="" class="book-form">
                <div class="row mb-3">
                    <label for="book-id" class="col-sm-3 col-form-label">Book ID(s)</label>
                    <div class="col-sm-9">
                        <label for="isbn" class="col-sm-3 col-form-label" name="bookId"><?php echo implode(", ", $bookIds);?></label>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="book-isbn" class="col-sm-3 col-form-label">Book ISBN</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="book-isbn" name="isbn" value="<?php echo $isbn;?>" required disabled>
                        <span id="isbnErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="book-name" class="col-sm-3 col-form-label">Book Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="book-name" name="title" value="<?php echo $title;?>" required disabled>
                        <span id="nameErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="author" class="col-sm-3 col-form-label">Author</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="author" name="author" value="<?php echo $author;?>" required disabled>
                        <span id="authorErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="category" class="col-sm-3 col-form-label">Category</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="category" name="category" disabled>
                            <option value="Fiction" <?php if($catArr[0]=="Fiction"){ echo ' selected="selected"';}?>>Fiction</option>
                            <option value="Non-fiction" <?php if($catArr[0]=="Non-fiction"){ echo ' selected="selected"';}?>>Non-fiction</option>
                            <option value="Reference" <?php if($catArr[0]=="Reference"){ echo ' selected="selected"';}?>>Reference Books</option>
                            <option value="Magazines-and-newspapers" <?php if($catArr[0]=="Magazines-and-newspapers"){ echo ' selected="selected"';}?>>Magazines and Newspapers</option>
                            <option value="Graphic-novels" <?php if($catArr[0]=="Graphic-novels"){ echo ' selected="selected"';}?>>Graphic Novels</option>
                            <option value="Poetry"  <?php if($catArr[0]=="Poetry"){ echo ' selected="selected"';}?> > Poetry</option>
                        </select>
                        <span id="catErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <input type="text" class="form-control" id="sub-cat" name="sub-cat" value="<?php echo $catArr[1];?>" hidden>
                    <label for="sub-category" class="col-sm-3 col-form-label">Sub-Category</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="sub-category" name="sub-category" disabled>
                        </select>
                        <span id="subCatErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="edition" class="col-sm-3 col-form-label">Edition</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="edition" name="edition" value="<?php echo $edition;?>" required disabled>
                        <span id="editionErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="publisher" class="col-sm-3 col-form-label">Publisher</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo $publisher;?>" required disabled>
                        <span id="publisherErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="rack-number" class="col-sm-3 col-form-label">Year</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="year" name="year" value="<?php echo $year;?>" required disabled>
                        <span id="yearErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="shelf-number" class="col-sm-3 col-form-label">Price (Rs.)</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo $price;?>" required disabled>
                        <span id="priceErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="rack-number" class="col-sm-3 col-form-label">Rack Number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="rack-number" name="rack" value="<?php echo $rack;?>" required disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="shelf-number" class="col-sm-3 col-form-label">Shelf Number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="shelf-number" name="shell" value="<?php echo $shell;?>" required disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="shelf-number" class="col-sm-3 col-form-label">Image URL</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="url" name="imgUrl" value="<?php echo $imageUrl;?>" required disabled>
                        <span id="urlErr"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="numberOfCopies" class="col-sm-3 col-form-label">Existing copies</label>
                    <div class="col-sm-9">
                        <label for="numberOfCopies" class="col-sm-3 col-form-label" name="numberOfCopies"><?php echo $bookCount;?></label>
                    </div>
                </div>
                <div class="row mb-3" id="newCopies" hidden>
                    <label for="noc" class="col-sm-3 col-form-label">New no of copies</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="newNoc" name="newNoc" min="0" value="0" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="button" class=" btn btn-primary btn-flex" id="edit-btn">Edit Book</button>
                        <input type="submit" class=" btn btn-success d-none btn-flex" id="save-btn" value="Save" name="save">
                        <input type="submit" class=" btn btn-danger btn-flex" id="delete-btn" value="Delete Book" name="delete">
                        <button type="button" id="cancel" class=" btn btn-danger d-none btn-flex" onclick="window.location.reload()">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<?php //if (isset($_POST['category'])) {
//    echo'<script>console.log('.$_POST['category'].')</script>';
//}?>
<!--Container Main end-->
<script src="js/navbar.js"></script>
<script src="js/validateEditBook.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {

        //update image
        const $imageLinkInput = $('#url');
        const $imageHolder = $('#imageHolder');

        $imageLinkInput.on('input', function() {
            const imageUrl = $imageLinkInput.val();
            $imageHolder.html(`<img src="${imageUrl}" alt="Book Cover" class="img-fluid book-cover"
                 onerror="this.onerror=null;this.src='https://bmva.org.uk/images/listings/no-image.jpg';">`);
        });


        //set sub categories
        var inputValue = $('#category').val();
        if (inputValue == "Fiction") {
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
        } else if (inputValue == "Non-fiction") {
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

        } else if (inputValue == "Reference") {
            $("#sub-category").append("<option value='Dictionaries'>Dictionaries</option>");
            $("#sub-category").append("<option value='Thesauruses'>Thesauruses</option>");
            $("#sub-category").append("<option value='Encyclopedias'>Encyclopedias</option>");
            $("#sub-category").append("<option value='Atlases'>Atlases</option>");
            $("#sub-category").append("<option value='Almanacs'>Almanacs</option>");
            $("#sub-category").append("<option value='Style-guides'>Style Guides</option>");
            $("#sub-category").append("<option value='Other'>Other</option>");

        } else if (inputValue == "Magazines-and-newspapers") {
            $("#sub-category").append("<option value='Current-events-magazines'>Current Events Magazines</option>");
            $("#sub-category").append("<option value='Science-magazines'>Science Magazines</option>");
            $("#sub-category").append("<option value='Literary-magazines'>Literary Magazines</option>");
            $("#sub-category").append("<option value='Sports-magazines'>Sports Magazines</option>");
            $("#sub-category").append("<option value='Local-and-national-newspapers'>Local and National Newspapers</option>");
            $("#sub-category").append("<option value='Other'>Other</option>");

        } else if (inputValue == "Graphic-novels") {
            $("#sub-category").append("<option value='Comics'>Comics</option>");
            $("#sub-category").append("<option value='Manga'>Manga</option>");
            $("#sub-category").append("<option value='Other'>Other</option>");

        } else if (inputValue == "Poetry") {
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

        //set selected sub category
        var getSubCategory = $('#sub-cat').val();
        $("#sub-category").val(getSubCategory);

        //sub categories
        $("#category").change(function (){
            var selected_category = $(this).children("option:selected").val();
            // console.log("hello");
            if (selected_category == "Fiction") {
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
            } else if (selected_category == "Non-fiction") {
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

            } else if (selected_category == "Reference") {
                $("#sub-category").empty();
                $("#sub-category").append("<option value=''>Select Sub-Category</option>");
                $("#sub-category").append("<option value='Dictionaries'>Dictionaries</option>");
                $("#sub-category").append("<option value='Thesauruses'>Thesauruses</option>");
                $("#sub-category").append("<option value='Encyclopedias'>Encyclopedias</option>");
                $("#sub-category").append("<option value='Atlases'>Atlases</option>");
                $("#sub-category").append("<option value='Almanacs'>Almanacs</option>");
                $("#sub-category").append("<option value='Style-guides'>Style Guides</option>");
                $("#sub-category").append("<option value='Other'>Other</option>");

            } else if (selected_category == "Magazines-and-newspapers") {
                $("#sub-category").empty();
                $("#sub-category").append("<option value=''>Select Sub-Category</option>");
                $("#sub-category").append("<option value='Current-events-magazines'>Current Events Magazines</option>");
                $("#sub-category").append("<option value='Science-magazines'>Science Magazines</option>");
                $("#sub-category").append("<option value='Literary-magazines'>Literary Magazines</option>");
                $("#sub-category").append("<option value='Sports-magazines'>Sports Magazines</option>");
                $("#sub-category").append("<option value='Local-and-national-newspapers'>Local and National Newspapers</option>");
                $("#sub-category").append("<option value='Other'>Other</option>");

            } else if (selected_category == "Graphic-novels") {
                $("#sub-category").empty();
                $("#sub-category").append("<option value=''>Select Sub-Category</option>");
                $("#sub-category").append("<option value='Comics'>Comics</option>");
                $("#sub-category").append("<option value='Manga'>Manga</option>");
                $("#sub-category").append("<option value='Other'>Other</option>");

            } else if (selected_category == "Poetry") {
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
        });
    });

    $(function () {
        $('#edit-btn').click(function () {
            $('input').prop('disabled', false);
            $('#category').prop('disabled', false);
            $('#sub-category').prop('disabled', false);
            $('#edit-btn').addClass('d-none');
            $('#delete-btn').addClass('d-none');
            $('#save-btn').removeClass('d-none');
            $('#cancel').removeClass('d-none');
            $('#newCopies').prop('hidden',false);
        });
    });
</script>
<?php include 'Includes/footer.php' ?>
</body>
</html>
