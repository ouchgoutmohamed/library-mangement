<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
session_start();
if (isset($_POST['query'])) {
    include '../connection/config.php';
    include '../repository/BookService.php';
    $bookService = new BookService();

    if ($_POST['query'] == null) {
        $result = $bookService->getAllBooks();
        $count = $result->rowCount();
        getBookTable($count, $result);
    } else {
        $result = $bookService->getFilteredBooks();
        $count = $result->rowCount();
        getBookTable($count, $result);
    }
}

function getBookTable($count, $result)
{
    if ($count > 0) {
        echo '<span>'.$count.' record(s) found</span>';
        echo '
            <div class="row justify-content-md-center">
                <div class="col-md-12"><form method="post">';
        echo '<table class="table" style="border:solid #dee2e6 1px;">';
        echo '<thead class="thead-dark">';
        echo '<tr>
                      <th scope="col">Cover</th>
                      <th scope="col">Book ID</th>
                     <th scope="col">Name</th>
                     <th scope="col">ISBN</th>
                     <th scope="col">Author</th>
                     <th scope="col">Category </th>
                     <th scope="col"></th>

              </tr>';
        echo '</thead>';
        foreach ($result as $row) {
            $valueArr = explode(',', $row[4]);
            echo '<tbody>';
            echo '<tr class="rw">';
            $image_link = $row[0];
            echo '<td style="vertical-align: middle;"><img src="' . $image_link . '" width="80" height="90"   onerror="this.onerror=null;this.src=\'Images/bookPlaceholder.png\';" ></td>';
            echo '<td style="vertical-align: middle;"> <input type="hidden" value="' . $row[11] . '">' . $row[11] . '</td>';
            echo '<td style="vertical-align: middle;"> <input type="hidden" value="' . $row[1] . '">' . $row[1] . '</td>';
            echo '<td style="vertical-align: middle;"> <input type="hidden"  value="' . $row[2] . '">' . $row[2] . '</td>';
            echo '<td style="vertical-align: middle;"> <input type="hidden" value="' . $row[3] . '">' . $row[3] . '</td>';
            $category = $valueArr[0];
            $category = str_replace("-", " ", $category);
            $subCategory = $valueArr[1];
            $subCategory = str_replace("-", " ", $subCategory);
            echo '<td style="vertical-align: middle;"> <input type="hidden"  value="' . $row[4] . '">' . $category. ' ('.$subCategory.')</td>';
            echo '<td style="vertical-align: middle;"><button class="btn btn-primary"  style="margin: auto" name="viewBook" type="submit"  value="' . $row[11] . '"><i class="fa fa-info-circle "></i>  </button></td>';
            echo '</tr>';
            echo '</tr>';
            echo ' </tbody>';
        }
        echo '</table>';
        echo '</form></div> </div>';
    } else {
        echo "<span  style='color:red; margin-left: auto; margin-right: auto; display: table; margin-top: 50px;' class='features CardBgCol' >  No available books</span>";
    }
}

?>


