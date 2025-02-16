<!DOCTYPE html>
<html>
<head>
    <title>Contact</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">
</head>
<body>
<div style="position: absolute; top: 10px; left: 10px;">
                  <a href="index"><img src="images/shoes/goback.png" style="width: 50px; height: auto;"></a>
               </div>

               
               <div class="contact-form" id="cont-form"data-aos="fade-up">
           
           <form action="send_mail.php" method="POST" id="contact-form">
       <label for="name">Naam:</label><br>
       <input type="text" id="name" name="name" required><br><br>

       <label for="email">E-mailadres:</label><br>
       <input type="email" id="email" name="email" required><br><br>

       <label for="message">Bericht:</label><br>
       <textarea id="message" name="message" rows="5" required placeholder=""></textarea><br><br>

       <button type="submit">Verstuur</button>
   </form>
           </div>
       </section>
</body>
</html>