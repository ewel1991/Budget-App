<?php

session_start();

if(!isset($_SESSION['registerSuccess']))
{
  header('Location:index.php');
  exit();
}
else
{
unset($_SESSION['registerSuccess']);
}

//Usuwanie zmiennych pamiętających wartości wpisane do formularza
if(isset($_SESSION['formName'])) unset($_SESSION['formName']);
if(isset($_SESSION['formEmail'])) unset($_SESSION['formEmail']);
if(isset($_SESSION['formPassword1'])) unset($_SESSION['formPassword1']);
if(isset($_SESSION['formPassword2'])) unset($_SESSION['formPassword2']);

//Usuwanie błędów rejestracji
if(isset($_SESSION['errorName'])) unset($_SESSION['errorName']);
if(isset($_SESSION['errorMail'])) unset($_SESSION['errorMail']);
if(isset($_SESSION['errorPassword'])) unset($_SESSION['errorPassword']);

?>


<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Success</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./style.css" >
</head>
<body>



  <div class="container-half">
  <div class="d-flex justify-content-center align-items-center px-4 w-100">
  <div class="w-50 px-4 py-5">
    <div class="text-overlay p-5 rounded-5">
        <h1 class="display-5 fw-bold text-white lh-1 mb-5 text-center">Udana rejestracja!</h1>
        <p class="lead text-white text-center">Dziękujemy za rejestrację w serwisie! Teraz możesz zalogować się na swoje konto</p>
        <div class="d-grid gap-1 gap-md-5 d-md-flex justify-content-md-center">
          <a href="login.php" class="lead btn btn-brown btn-lg px-4 me-md-2">Zaloguj się</a>
        </div>
      </div>
    </div>
  </div>
  </div>
  
  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>


</body>
</html>