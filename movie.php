<?php
    

    if(isset($_POST['submit'])){
        session_start();
        
        $output = shell_exec("/usr/bin/python3 /var/www/html/movie/python/find.py"." "."'".$_POST["search"]."'");
        $result = json_decode($output, true);
        $_SESSION['yourData'] = $result;
        $_SESSION['yourSearch'] = $_POST["search"];

        header('Location: index.php');
    }
    
?>