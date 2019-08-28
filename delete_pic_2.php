<?php
    $id = $_GET['id'];
    $pic='';
    if(!empty($_GET['pic'])){
	    $pic = $_GET['pic'];
    }

    if(empty(pic)){
	    throw new Exception('Error');
    }

    unlink($pic);
    $dirname = dirname($pic);
    $files = scandir($dirname);

    $servername = "localhost:3306";
    $username = "root";
    $password = "root";
    $databaseName = "wanted";

    $conn = new mysqli($servername,$username,$password,$databaseName);

    if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM `wanted_result`";
    mysqli_query($conn, $sql);

    $conn->close();
    header("Location: /index.php");
?>