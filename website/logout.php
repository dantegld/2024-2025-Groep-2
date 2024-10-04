<?php
// Start de sessie.  Begin hier telkens mee op elke pagina!
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php

session_start(); 
session_destroy(); 
header("Location: login.php"); 

?>


    
</body>
</html>