<?php
function getCon(){
    try {
        $database = "mysql:dbname=lms";
        $username = "root";
        $password = "";
        $conn = new PDO($database, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }catch(PDOException $ex){


    }
}
