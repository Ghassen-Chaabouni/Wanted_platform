<?php
    $pyscript = 'C:/Users/admin/Desktop/9raya/"machine learning"/movie_face_detection_project_php/wanted.py';
    $python = 'C:/Users/admin/AppData/Local/Programs/Python/Python37/python.exe';
    $cmd = "$python $pyscript";
    exec("$cmd", $output);
    header("Location: /index.php");
?>