<?php

session_start();

if((isset($_SESSION['isLogged'])) && ($_SESSION['isLogged']==true))
{
  header('Location:menu.php');
  exit();
}

?>


<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Budget Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./style.css" >
</head>
<body>



  <div class="container-half">
  <div class="d-flex justify-content-center align-items-center px-4 w-100">
  <div class="w-50 px-4 py-5">
    <div class="text-overlay p-5 rounded-5">
        <h1 class="display-5 fw-bold text-white lh-1 mb-5 text-center">Ogarnij swój budżet</h1>
        <p class="lead text-white text-center">Zadbaj o swoje finanse w prosty i przejrzysty sposób. Nasza aplikacja pomoże Ci śledzić wydatki, planować budżet i osiągać finansowe cele. Niezależnie od tego, czy oszczędzasz na wakacje, czy po prostu chcesz mieć kontrolę nad domowym budżetem – jesteś we właściwym miejscu.</p>
        <div class="d-grid gap-1 gap-md-5 d-md-flex justify-content-md-center">
          <a href="login.php" class="lead btn btn-brown btn-lg px-4 me-md-2">Zaloguj się</a>
          <a href="register.php" class="lead btn btn-brown btn-lg">Zarejestruj się</a>
        </div>
      </div>
    </div>
  </div>
  </div>
  
  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="index.js"></script>

</body>
</html>