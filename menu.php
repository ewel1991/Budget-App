
<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu główne</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="./style.css" >
</head>
<body>

   
  <div class="container-half">
    <header class="navbar navbar-expand-sm p-3 custom-navbar">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a href="logout.php" class="nav-link px-2 me-2 btn-brown"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
              <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
            </svg></a></li>
            <li class="nav-item"><a href="income.php" class="nav-link px-2 me-2 btn-brown">Dodaj przychód</a></li>
            <li class="nav-item"><a href="expenses.php" class="nav-link px-2 me-2 btn-brown">Dodaj wydatek</a></li>
            <li class="nav-item"><a href="balance.php" class="nav-link px-2 me-2 btn-brown">Przeglądaj bilans</a></li>
            <li class="nav-item"><a href="settings.php" class="nav-link px-2 me-2 btn-brown">Ustawienia</a></li>
            <li class="nav-item"><a href="logout.php" class="nav-link px-2 me-2 btn-brown">Wyloguj się</a></li>
          </ul>
        </div>
      </div>
    </header>

  <div class="centered-container rounded-3">
    <h2 class="text-white mb-4 ">Wybierz jedną z opcji w menu, aby rozpocząć pracę.</h2>
    <h2 class="text-white">Wybierz odpowiednią opcję, aby dodać przychód, wydatek lub przeglądać bilans. Kliknij na menu na górze.</h2>
  </div></div>

  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="index.js"></script>
</body>
</html>