<?php

  $dbHost     = "localhost:3306";
  $dbUsername = "root";
  $dbPassword = "root";
  $dbName     = "wanted";

  $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }

  $file = $_FILES['file'];
  $fileName = $_FILES['file']['name'];
  $name = $_POST['name'];
  $cin = $_POST['cin'];

  $total = count($fileName);
  for( $i=0 ; $i < $total ; $i++ ) {
    $b=false;
    $n='';
    $file = $_FILES['file'][$i];
    $fileName = $_FILES['file']['name'][$i];
    $fileTmpName = $_FILES['file']['tmp_name'][$i];
    $fileSize = $_FILES['file']['size'][$i];
    $fileError = $_FILES['file']['error'][$i];
    $fileType = $_FILES['file']['type'][$i];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg','bmp', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)){
        if ($fileError == 0){
            if ($fileSize < 5000000){
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                if (!file_exists('wanted faces/'.$_POST["cin"])) {
                    mkdir('wanted faces/'.$_POST["cin"], 0777, true);
                }
                $fileDestination = 'wanted faces/'.$_POST["cin"].'/'.$fileNameNew;

                move_uploaded_file($fileTmpName, $fileDestination);
                $sql = "SELECT * FROM `wanted`";
                $result = $db->query($sql);
                if ($result->num_rows> 0) {
                     while($row = $result->fetch_assoc()) {
                      if((strcmp($row["cin"],$cin)==0)){
                          echo "<h3>".$total."<h3/>";
                          $n=$row["imagename"].$fileDestination.'-';
                          $row_cin = $row["cin"];
                          $s = "UPDATE `wanted` SET `imagename`='".$n."' WHERE cin='".$row_cin."'";
                          mysqli_query($db,$s);
                          $b=true;
                          $n="";
                          break;
                        }
                    }
                    if($b!=true){
                        $query = "insert into wanted (name,cin,imagename) values('".$name."','".$cin."','".$fileDestination.'-'."')";
                        mysqli_query($db,$query);
                    }
                 }else{
                      $query = "insert into wanted (name,cin,imagename) values('".$name."','".$cin."','".$fileDestination.'-'."')";
                      mysqli_query($db,$query);
                 }
            } else{
                echo "Your file is too big.";
            }
        }else{
            echo "There was an error uploading your file.";
        }
    } else{
        echo "You cannot upload files of this type.";
    }
  }

  $db->close();
  header("Location: /add_a_person.php");
?>