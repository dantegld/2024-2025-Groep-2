<!DOCTYPE html>
<html>
<body>

<?php

session_start(); 
session_destroy();
if(isset($_GET['delete'])){
    header("Location: login?delete=1");
    exit();
}
header("Location: login"); 

?>


    
</body>
</html>