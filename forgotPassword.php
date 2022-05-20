<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="/ProyectoFinal/styles/index.css">
    <link rel="stylesheet" href="/ProyectoFinal/styles/virtual.css">
    <link rel="stylesheet" href="/ProyectoFinal/styles/forgotPassword.css">
  </head>
  <body>
    <header>

    <a href="/ProyectoFinal/index.html" class="logo">
      <img src="/ProyectoFinal/images/logo.png" alt="logo de la empresa">
      <h2 class="company-name">Spanish Academy <br> El Faro</h2>
    </a>
    <nav class="header-menu">
      <ul>
        <li><a href="index.html" class="nav-link">Inicio</a></li>
        <li><a href="/ProyectoFinal/templates/courses.html" class="nav-link">Cursos</a></li>
        <li><a href="/ProyectoFinal/templates/aboutus.html" class="nav-link">Sobre Nosotros</a></li>
        <li><a href="/ProyectoFinal/templates/contact.html" class="nav-link">Contacto</a></li>
        <li><a href="/ProyectoFinal/templates/virtual.html" class="nav-link">Aula Virtual</a></li>
        <li class="menu-languages">Cambiar idioma<span class="down-arrow">▼</span>
        <ul class="submenu-languages">
          <li> <a href="/ProyectoFinal/forgotPassword.php"> <img src="/ProyectoFinal/images/espana.png" alt="Bandera de España"> <span>Español</span> </a></li>
          <li> <a href="/ProyectoFinal/forgotPasswordEN.php"> <img class="reino-unido-image" src="/ProyectoFinal/images/gran-bretana.png" alt="Bandera de Inglaterra"><span>English</span></a></li>
          <li> <a href="/ProyectoFinal/forgotPasswordDE.php"> <img  src="/ProyectoFinal/images/alemania.png" alt="Bandera de Alemania"><span>Deutsch</span></a></li>
          <li> <a href="/ProyectoFinal/forgotPasswordFR.php"><img  src="/ProyectoFinal/images/francia.png" alt="Bandera de Francia"><span>Français</span></a></li>
        </ul>
      </li>
    </ul>
    </nav>

      <a href="#" class="button-burguer-menu mostrar" id="buttonburguermenu"><img src="/ProyectoFinal/images/burguer-menu.png" alt="icono menu responsive"> </a>


    </header>
    <nav class="header-menu-responsive">
      <ul>
        <li><a href="index.html" class="nav-link">Inicio</a></li>
        <li><a href="/ProyectoFinal/templates/courses.html" class="nav-link">Cursos</a></li>
        <li><a href="/ProyectoFinal/templates/aboutus.html" class="nav-link">Sobre Nosotros</a></li>
        <li><a href="/ProyectoFinal/templates/contact.html" class="nav-link">Contacto</a></li>
        <li><a href="/ProyectoFinal/templates/virtual.html" class="nav-link">Aula Virtual</a></li>
        <li class="menu-languages-responsive">Cambiar idioma<span class="down-arrow">▼</span>
        <ul class="submenu-languages-responsive">
          <li> <a href="/ProyectoFinal/forgotPassword.php">Español</a></li>
          <li> <a href="/ProyectoFinal/forgotPasswordEN.php">English</a></li>
          <li> <a href="/ProyectoFinal/forgotPasswordDE.php">Deutsch</a></li>
          <li> <a href="/ProyectoFinal/forgotPasswordFR.php">Français</a></li>
        </ul>
      </li>
    </ul>
    </nav>

    <?php
    include('conexion.php');
    if(isset($_POST['submit'])){

    $mail = $_POST['Mail'];

    $notfound = "";
    //Se realizan las consultas necesarias para almacenar datos en diferentes variables.
    $email_exist = $mysqli->query("SELECT * FROM `alumnos`,`profesores`");
    $email_query_alumnos = $mysqli->query("SELECT Password FROM `alumnos` WHERE Mail = '$mail'");
    $email_query_profesores = $mysqli->query("SELECT Password FROM `profesores` WHERE Mail = '$mail'");

    //For each para iterar sobre la consulta y almacenar un conjunto de valores en un array.
    for ($y=0; $y < $email_exist->num_rows; $y++) {
      $exist_email = $email_exist->fetch_assoc();
    }

    //Si la consulta tiene más de una fila de datos se realizan diferentes funciones.
    if (mysqli_num_rows($email_query_alumnos) > 0) {

      for ($i=0; $i < $email_query_alumnos->num_rows; $i++) {
        $Password_alumnos=$email_query_alumnos->fetch_assoc();
      }
      //Se emplea la función email para enviar un correo electrónico con los datos de la contraseña para poder recuperarla.
      $content_alumnos = "Su contraseña es:: ".$Password_alumnos['Password'];
      mail($mail,"Recuperación de contraseña",$content_alumnos);
      $message_password_alumnos = "Contraseña enviada al correo introducido";
      //Se realiza el mismo procedimiento con la tabla de profesores.
    }elseif (mysqli_num_rows($email_query_profesores) > 0) {

      for ($i=0; $i < $email_query_profesores->num_rows; $i++) {
        $Password_profesores=$email_query_profesores->fetch_assoc();
      }
      $content_profesores = "La contraseña con la cuál se registró es: ".$Password_profesores['Password'];
      mail($mail,"Recuperación de contraseña",$content_profesores);
      $message_password_profesores = "Contraseña enviada al correo introducido";

    }elseif(!empty($mail)){
      $notfound = "Correo no encontrado";
    }else{

    }
  }else{

  }


     ?>

    <div class="contain-form">
      <div class="form">
        <form action="forgotPassword.php" method="post">
          <h3>Recuperar contraseña</h3>
          <div class="contain-label"><label for="Mail"> <img src="/ProyectoFinal/images/icono-email.png" alt="icono de email">Ingresa tu correo de registro</label></div>
          <input type="text" name="Mail" required><br>
          <p class="email-sent"><?php
            if (isset($message_password_alumnos)) {
              echo $message_password_alumnos;
            };
            if (isset($message_password_profesores)) {
              echo $message_password_profesores;
            };?></p>
            <p class="not-found"><?php
            if(isset($notfound)){
              echo $notfound;
            };

           ?></p>
          <div class="contain-submit"><div class="submit" onclick="mostrar();"><input type="submit" name="submit" value="Ingresar" class="text-button"></div></div>
        </form>
      </div>
    </div>



    <div class="background-final-contain">

      <div class="final-contain">
        <div class="final-contain-contact">
          <p> C.Álamos, 42 - Málaga. 29012 <br> elfaroacedemy@gmail.com </p>
        </div>
        <div class="final-contain-DELE">
          <img src="/ProyectoFinal/images/DELE.png" alt="logo DELE">
          <img class="cervantes-logo" src="/ProyectoFinal/images/Cervantes.png" alt="logo Instituto Cervantes">
        </div>
        <div class="final-contain-socialmedia">
          <p>¡Síguenos en nuestras redes sociales!</p>
          <a href="https://twitter.com/"> <img src="/ProyectoFinal/images/twitter.png" alt="logo de twitter"> </a>
          <a href="https://facebook.com/"> <img src="/ProyectoFinal/images/facebook.png" alt="logo de facebook"> </a>
          <a href="https://instagram.com/"> <img src="/ProyectoFinal/images/instagram.png" alt="logo de instagram"> </a>
        </div>

      </div>

      </div>



      <script src="/ProyectoFinal/scripts/jquery-3.6.0.min.js"></script>
      <script src="/ProyectoFinal/scripts/menuresponsive_buttons.js"></script>
  </body>

</html>
