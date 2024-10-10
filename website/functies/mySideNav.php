<?php
                  echo '<div id="mySidenav" class="sidenav">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                  <a href="index.php">Home</a>';

                  if ($_SESSION["klant"]){
                  echo '<a href="profile.php">My Profile</a>';
                  }else{
                  echo '<a href="login.php">Log In</a>';
                  }
                  if ($_SESSION["admin"]){
                     echo '<a href="admin.php">Admin Pagina</a>';
                  }
                  if ($_SESSION["klant"]){
                     echo '<a class="logout" href="logout.php">Log Uit</a>';
                  }
               echo '</div>';



?>