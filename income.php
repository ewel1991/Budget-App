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
  <title>Dodaj przychód</title>
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
            <li class="nav-item"><a href="./index.php" class="nav-link px-2 me-2 btn-brown"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
              <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
            </svg></a></li>
            <li class="nav-item"><a href="income.php" class="nav-link px-2 me-2 btn-brown">Dodaj przychód</a></li>
            <li class="nav-item"><a href="expenses.php" class="nav-link px-2 me-2 btn-brown">Dodaj wydatek</a></li>
            <li class="nav-item"><a href="balance.php" class="nav-link px-2 me-2 btn-brown">Przeglądaj bilans</a></li>
            <li class="nav-item"><a href="settings.php" class="nav-link px-2 me-2 btn-brown">Ustawienia</a></li>
            <li class="nav-item"><a href="index.php" class="nav-link px-2 me-2 btn-brown">Wyloguj się</a></li>
          </ul>
        </div>
      </div>
    </header>
  
    <div class="small-container text-white rounded-3">
      <form class="form-wrapper" action="add_income.php" method="POST">
    
        <!-- Kwota -->
        <div class="form-group row mb-4">
          <label for="amount" class="form-label input1">Kwota:</label>
          <input type="number" class="form-control rounded-3 py-2" id="amount" name="amount" step="0.01" min="0" placeholder="Wpisz kwotę">
        </div>
    
        <!-- Data -->
        <div class="form-group row mb-4">
          <label for="date" class="form-label input1">Data:</label>
          <input type="date" class="form-control rounded-3 py-2" id="date" name="date">
        </div>
    
        <!-- Kategoria -->
        <div class="form-group row mb-4">
          <label for="category" class="form-label input1">Kategoria:</label>
          <select class="form-select rounded-3 py-2" id="category" name="category">
            <option value="wynagrodzenie">Wynagrodzenie</option>
            <option value="odsetki bankowe">Odsetki bankowe</option>
            <option value="sprzedaż na allegro">Sprzedaż na Allegro</option>
            <option value="inne">Inne</option>
          </select>
        </div>
    
        <!-- Komentarz -->
        <div class="form-group row mb-4">
          <label for="comment" class="form-label input1">Komentarz:</label>
          <textarea class="form-control rounded-3 py-2" id="comment" name="comment" rows="3" placeholder="Dodaj komentarz..."></textarea>
        </div>
    
           <!-- Przyciski: Zapisz i Anuluj -->
      
           <div class="row g-3 justify-content-center">
            <div class="col-12 col-sm-auto">
              <button type="submit" class="btn btn-brown py-3 px-4 rounded-3 w-100">Zapisz</button>
            </div>
            <div class="col-12 col-sm-auto">
              <a href="index.php" class="btn btn-brown py-3 px-4 rounded-3 w-100">Anuluj</a>
            </div>
          </div>
      </form>
    </div>
    
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="income.js"></script>
</body>
</html>