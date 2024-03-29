<style>
    #delete{
        margin-left:35%;
    }
    #run{
        margin-top:-54px;
        margin-left:50px;
    }
    #upload{
        margin-top:20px;
        margin-right:130px;
    }
    .btn:hover{
        border-radius: 10px;
        border-color: blue;
    }
    #name{
        width:300px;
    }
    #epoch{
        margin-top:-115px;
        width:200px;
    }
    #card{
        display: inline-block;
        margin-top:20px;
        margin-right:200px;
    }
    .content2{
        margin-left:18%;
    }
    hr{
        color:black;
    }
    #title{
        color:#343a40;
        margin-top:20px;
    }
    #name_title{
        color:#343a40;
    }
    #camera_navbar{
        margin-left:20px
    }
    #employee_navbar{
        margin-left:20px
    }
    #live_navbar{
        margin-left:20px
    }
    #junk_navbar{
        margin-left:20px
    }
    #navbar{
        z-index:1;
    }
    .sticky {
        position: fixed;
        top: 0;
        width: 100%;
    }
    .sticky + .content {
        padding-top: 60px;
    }
    .content {
        padding: 16px;
    }
</style

<!DOCTYPE html>
<html>
<head>
    <title>Wanted</title>
</head>
<body style="background-color: #eee;">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <div id="navbar">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#" id="navbar_title">Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse navbar-fixed-top" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active" id="camera_navbar">
                        <a class="nav-link" href="#">Wanted</a>
                    </li>
                    <li class="nav-item" id="employee_navbar">
                        <a class="nav-link" href="add_a_person.php">Add a person</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="content">
        <div id="main" align="center">
            <h3 id="title">Upload a picture</h3>
            <br/>

            <form action="upload_2.php" method="POST" enctype="multipart/form-data">
                <div><input type="file" name="file" accept="image/*"></div>
                <br/>
                <div><button id="upload" type="submit" name="submit" class="btn btn-outline-dark">Upload</button></div>
            </form>

            <a href="run.php"><button id="run" type="submit" name="run" class="btn btn-outline-info">Run</button></a>

        </div>
    </div>
    <br/><br/><br/><br/><br/>
    <hr>
    <div class="content2">
        <?php
            $servername = "localhost:3306";
            $username = "root";
            $password = "root";
            $databaseName = "wanted";

            $conn = new mysqli($servername,$username,$password,$databaseName);

            if($conn->connect_error!=""){
                $conn = new mysqli($servername, $username, $password);
                $sql = "CREATE DATABASE `".$databaseName."`";
                mysqli_query($conn, $sql);
                $conn = new mysqli($servername, $username, $password,$databaseName);

                $sql = "CREATE TABLE `wanted` (id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name text NOT NULL, cin VARCHAR(10000) NOT NULL, imagename VARCHAR(10000) NOT NULL)";
                mysqli_query($conn, $sql);

                $sql = "CREATE TABLE `wanted_result` (name text NOT NULL, cin VARCHAR(10000) NOT NULL, imagename VARCHAR(10000) NOT NULL)";
                mysqli_query($conn, $sql);

                echo '<meta http-equiv="refresh" content="0">';
            }

            $dir_path = "wanted/";
            $extensions_array = array('jpg','png','jpeg','JPG','bmp');
            $k = 0;
            if(is_dir($dir_path)){
                $files = scandir($dir_path);
                $files = array_diff($files, array('.', '..',' ',''));
                $list=array();
                for($i = 2; $i < count($files)+2; $i++){
                    $file = pathinfo($files[$i]);
                    $extension = $file['extension'];
                    if(in_array($extension, $extensions_array)){
                        array_push($list, $dir_path.'/'.$files[$i]);
                        if(count($list)>=2){
                            $list = array_reverse($list);
                            unlink($list[1]);
                            $remove = array_pop($list);
                            echo '<meta http-equiv="refresh" content="0">';

                            $sql = "DELETE FROM `wanted_result`";
                            mysqli_query($conn, $sql);
                        }

                        $k = $k+1;
                        echo '<div class="card" id="card" style="width: 18rem;" name="card1">';
                        echo "<img class ='card-img-top' src='$dir_path/$files[$i]' name='picture'><br>";
                        echo '<div class="card-body" name="card2">';
                        echo '<a href="delete_pic_2.php?pic='.$dir_path.'/'.$files[$i].'"><button type="submit" id="delete" class="btn btn-outline-danger" name="delete">Delete</button></a>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }

            $sql = "SELECT * FROM `wanted_result`";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $row_name = $row["name"];
                    $row_cin = $row["cin"];
		            $row_imagename = $row["imagename"];
                    echo '<div class="card" id="card" style="width: 18rem;" name="card1">';
                    echo "<img class ='card-img-top' src='$row_imagename' name='picture'><br>";
                    echo '<div class="card-body" name="card2">';
    	            echo "<h4>".$row_name."</h4>";
		            echo "<h4>CIN: ".$row_cin."</h4>";
                    echo '</div>';
                    echo '</div>';

                }
            }
            $conn->close();
        ?>
    </div>

    <script>
        window.onscroll = function() {myFunction()};

        var navbar = document.getElementById("navbar");

        var sticky = navbar.offsetTop;

        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }
    </script>

</body>
</html>
