<?php
	require_once 'db_em.php';

	$servername = "localhost:3306";
	$username = "root";
	$password = "root";
	$databaseName = "wanted";

	$conn = new mysqli($servername,$username,$password,$databaseName);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

    function RemoveAll ( $path ) {
        foreach ( new DirectoryIterator($path) as $item ):
            if ( $item->isFile() ) unlink($item->getRealPath());
            if ( !$item->isDot() && $item->isDir() ) RemoveAll($item->getRealPath());
        endforeach;

        rmdir($path);
    }

    if (file_exists('wanted faces/'.$_GET['cin'])){
        RemoveAll('wanted faces/'.$_GET['cin']);
    }

	$id='';
	if(!empty($_GET['id'])){
		$id = $_GET['id'];
	}
	if(empty(id)){
		throw new Exception('ID is blank');
	}

	$querry="DELETE FROM wanted WHERE id='".$id."'";
    mysqli_query($conn,$querry);

    $conn->close();
    header("Location: /add_a_person.php");
    die;
?>
