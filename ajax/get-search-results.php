<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
session_start();
if (isset($_POST['query'])) {
    include '../connection/config.php';
    include '../repository/BookService.php';
    $bookService = new BookService();


        $result = $bookService->getSearchedBooks();
        $count = $result->rowCount();
        getBookCard($count, $result);

}

function getBookCard($count, $result)
{
    if ($count > 0) {
        echo'<div class="row" style="padding-left: 40px">';
        foreach ($result as $row) {
            $catArr = explode(',', $row[9]);
            $subCategory = $catArr[1];
            $subCategory = str_replace("-", " ", $subCategory);
            echo ' 
             <div class="card">
                <img src="'.$row[7].'" alt="Book" onerror="this.onerror=null;this.src=\'Images/bookPlaceholder.png\';"/>
                <h3><b>'.$row[2].'</b></h3>
                <p>by '.$row[8].'</p>
                <div class="additional-info">
                    <h3><b>'.$row[2].'</b></h3>
                    <p><b>Author:</b>'.$row[8].'</p>
                    <p><b>Sub-category:</b> '.$subCategory.'</p>
                    <p><b>ISBN:</b>'.$row[1].'</p>
                    <p><b>Publisher:</b> '.$row[6].'</p>
                    <p><b>Edition:</b> '.$row[3].'</p>
                    <p><b>Year:</b> '.$row[5].'</p>
                </div>
            </div> 
            ';
        }
        echo '</div>';
    } else {
        echo "<span  style='color:red; margin-left: auto; margin-right: auto; display: table; margin-top: 50px;' class='features CardBgCol' > No Available Books!</span>";
    }
}

?>


