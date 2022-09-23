<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">

    <!-- Link CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <script src="https://kit.fontawesome.com/a81368914c.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title & Icon -->
    <title>Connexion - HD Technology</title>
    <link rel="icon" type="image/x-icon" href="../../img/hd_techno.png">
</head>
<body>
   <div class="animation-area">
      <ul class="box-area">
         <li></li>
         <li></li>
         <li></li>
         <li></li>
         <li></li>
         <li></li>
      </ul>
   
  <div class="container">
    <div class="login-content">
    <form action="php/login.php" method="POST"> 
        <img src="img/avatar.png">
        <h2 class="title">CONNEXION</h2>
          <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error'];?></p>
          <?php } ?>
              <div class="input-div one">
                 <div class="i">
                    <i class="fas fa-user"></i>
                 </div>
                 <div class="div">
                    <h5>Utilisateur</h5>
                    <input type="text" name="uname" class="input">
                 </div>
              </div>
              <div class="input-div pass">
                 <div class="i"> 
                    <i class="fas fa-lock"></i>
                 </div>
                 <div class="div">
                    <h5>Mot de passe</h5>
                    <input type="password" name="password" class="input" id="mdp">
                    <span class="eye" onclick="myFunction()">
                       <i id="hide1" class="fa fa-eye"></i>
                       <i id="hide2" class="fa fa-eye-slash"></i>
                    </span>
                 </div>
              </div>
              <br>
              <input type="submit" class="btn" value="Login" name="connexion">
    </form>
    </div>
    </div>
    <script>
       function myFunction(){
         var x = document.getElementById("mdp");
         var y = document.getElementById("hide1");
         var z = document.getElementById("hide2");

         if(x.type === 'password') {
            x.type = "text";
            y.style.display = "block";
            z.style.display = "none";
         }
         else{
            x.type = "password";
            y.style.display = "none";
            z.style.display = "block";
         }
      }
    </script>

    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/intro.js"></script>
    </div>
</body>