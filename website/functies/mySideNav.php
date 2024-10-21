<?php
                  echo '<div id="mySidenav" class="sidenav">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                  <a href="index.php">Home</a>';

                  if ($_SESSION["klant_id"]){
                  $sql = "SELECT type FROM tblklant WHERE klant_id = ?";
                  $stmt = $mysqli->prepare($sql);
                  $stmt->bind_param("i", $_SESSION['klant_id']);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  $row = $result->fetch_assoc();
                  $type = $row['type'];
                  }else{
                  $type = "guest";
                  }


                  if ($type == "customer" || $type == "admin"){
                  echo '<a href="profile.php">My Profile</a>';
                  }elseif($type == "guest"){
                  echo '<a href="login.php">Login</a>';
                  }
                  if ($type == "admin"){
                     echo '<a href="admin.php">Admin Page</a>';
                  }
                  if ($type == "customer" || $type == "admin"){
                     echo '<a class="logout" href="logout.php">Logout</a>';
                  }
               echo '</div>';



?>

<script>
         function openNav() {
           document.getElementById("mySidenav").style.width = "250px";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }
      </script>