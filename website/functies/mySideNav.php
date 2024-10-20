<?php
                  echo '<div id="mySidenav" class="sidenav">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                  <a href="index.php">Home</a>';

                  if ($_SESSION["klant"]){
                  echo '<a href="profile.php">My Profile</a>';
                  }else{
                  echo '<a href="login.php">Login</a>';
                  }
                  if ($_SESSION["admin"]){
                     echo '<a href="admin.php">Admin Page</a>';
                  }
                  if ($_SESSION["klant"]){
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