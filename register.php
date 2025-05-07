<?php

session_start();

if(isset($_POST['email']))
{
  //Udana walidacja?
  $everythingOK=true;

  //Sprawdzenie poprawności imienia
  $name = $_POST['name'];
  $name = ucfirst(strtolower($name));

  if((strlen($name)<3) || (strlen($name)>20))
  {
    $everythingOK = false;
    $_SESSION['errorName']="Imię musi posiadać od 3 do 20 znaków!";
  }

  if (!preg_match("/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ ]+$/u", $name)) {
    $everythingOK = false;
    $_SESSION['errorName'] = "Imię może zawierać tylko litery (bez cyfr i znaków specjalnych)";
  }

  // Sprawdź poprawność adresu email
  $email=$_POST['email'];
  $emailCorrect=filter_var($email, FILTER_SANITIZE_EMAIL);
  if((filter_var($emailCorrect, FILTER_VALIDATE_EMAIL)==false) || ($emailCorrect!=$email))
  {
    $everythingOK = false;
    $_SESSION['errorMail']="Podaj poprawny adres e-mail!";
  }

  //Sprawdż poprawność hasła
  $password1 = $_POST['password1'];
  $password2 = $_POST['password2'];

  if((strlen($password1)<3) || (strlen($password1)>20))
  {
    $everythingOK = false;
    $_SESSION['errorPassword']="Hasło musi posiadać od 3 do 20 znaków!";
  }

  if ($password1 != $password2)
  {
    $everythingOK = false;
    $_SESSION['errorPassword']="Podane hasła nie są identyczne";
  }

  $passwordHash = password_hash($password1, PASSWORD_DEFAULT);
  
  //Zapamiętaj wprowadzone dane
  $_SESSION['formName'] = $name;
  $_SESSION['formEmail'] = $email;
  $_SESSION['formPassword1'] = $password1;
  $_SESSION['formPassword2'] = $password2;

  require_once "connect.php";
  mysqli_report(MYSQLI_REPORT_STRICT);

  try
  {
   $connection = new mysqli($host, $db_user, $db_password, $db_name);
   if($connection->connect_errno!=0)
    {
      throw new Exception(mysqli_connect_errno());
    }

    else 
    {
      //Czy email już istnieje?

      $result = $connection->query("SELECT id FROM users WHERE email='$email'");

      if (!$result) throw new Exception($connection->error);
      $mailsNumber = $result->num_rows;
      if($mailsNumber>0)
      {
        $everythingOK = false;
        $_SESSION['errorMail']="Istnieje już konto przypisane do tego adresu e-mail!";
      }

      if($everythingOK ==true)
      {

      if ($connection->query("INSERT INTO users VALUES (NULL, '$name','$passwordHash', '$email')"))
        {

          // Pobierz ID nowo dodanego użytkownika
          $newUserId = $connection->insert_id;

          // Skopiuj domyślne kategorie przychodów do tabeli przypisanej użytkownikowi
          $copyIncomeCategories = "INSERT INTO incomes_category_assigned_to_users (user_id, name)
                           SELECT '$newUserId', name FROM incomes_category_default";

        if (!$connection->query($copyIncomeCategories)) {
        throw new Exception("Błąd podczas kopiowania kategorii przychodów: " . $connection->error);
        }

        // Skopiuj domyślne kategorie wydatków
        $copyExpenseCategories = "INSERT INTO expenses_category_assigned_to_users (user_id, name)
        SELECT '$newUserId', name FROM expenses_category_default";

        if (!$connection->query($copyExpenseCategories)) {
        throw new Exception("Błąd podczas kopiowania kategorii wydatków: " . $connection->error);
        }

        // Skopiuj domyślne metody płatności
        $copyPaymentMethods = "INSERT INTO payment_methods_assigned_to_users (user_id, name)
        SELECT '$newUserId', name FROM payment_methods_default";

        if (!$connection->query($copyPaymentMethods)) {
        throw new Exception("Błąd podczas kopiowania metod płatności: " . $connection->error);
        }


          $_SESSION['registerSuccess']=true;
          header('Location:welcome.php');
        }
        else
        {
          throw new Exception(mysqli_connect_errno());
          
        }

      }

      $connection->close();
    }
  }
  catch(Exception $error)
  {
    echo '<span class=error>Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie! </span>';
    echo '<br/> Informacja deweloperska: '.$error;
  }

  



}

?>


<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zarejestruj się</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="./style.css" >
</head>
<body>
  
  <div class="container-form">
  <div class=" d-flex align-items-center rounded-4" >

    <div class="me-auto vol-lg-8 rounded-4">
      <div class="text-overlay rounded-4 shadow">
        <div class=" p-5 pb-4 border-bottom-0">
          <h1 class="fw-bold mb-0 fs-2 text-white">Zarejestruj się</h1>
          <button type="button" class="btn-close custom-close ms-auto"  onclick="window.location.href='logout.php'" aria-label="Close"></button>
        </div>
  
        <div class=" p-5 pt-0">
          <form method="post" id="registerForm">
            <div class="form-floating mb-3">
              <input type="text" name ="name" class="form-control rounded-3" id="floatingText" placeholder="Ewelina" required minlength="3" maxlength="20" pattern="[A-Za-zĄąĆćĘęŁłŃńÓóŚśŹźŻż]{3,20}" title="Imię może zawierać tylko litery (bez cyfr i znaków specjalnych) od 3 do 20 znaków" 
              <?php 
              if (isset($_SESSION['formName']))
              {
                echo 'value="'.htmlspecialchars($_SESSION['formName']).'"';
                unset($_SESSION['formName']);
              } ?>
              >
              <label for="floatingText"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person me-3" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
              </svg>Imię</label>
            </div>

            <?php

                if (isset($_SESSION['errorName']))
                {
                  echo '<div class="error">'.$_SESSION['errorName'].'</div>';
                  unset($_SESSION['errorName']);
                }

            ?>




            <div class="form-floating mb-3">
              <input type="email" name="email" class="form-control rounded-3" id="floatingInput" placeholder="name@example.com" 
              <?php 
              if (isset($_SESSION['formEmail']))
              {
                echo 'value="'.htmlspecialchars($_SESSION['formEmail']).'"';
                unset($_SESSION['formEmail']);
              } ?>>
              <label for="floatingInput"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-envelope me-3" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
              </svg>Adres e-mail</label>
            </div>

            <?php
          if (isset($_SESSION['errorMail']))
            {
              echo '<div class="error">'.$_SESSION['errorMail'].'</div>';
              unset($_SESSION['errorMail']);
            }
            ?>

            <div class="form-floating mb-3">
              <input type="password" name="password1" class="form-control rounded-3" id="password1" placeholder="Password" required minlength="3" maxlength="20" pattern=".{3,20}" title="Hasło musi mieć od 3 do 20 znaków" 
              <?php 
              if (isset($_SESSION['formPassword1']))
              {
                echo 'value="'.htmlspecialchars($_SESSION['formPassword1']).'"';
                unset($_SESSION['formPassword1']);
              } ?> >
              <label for="floatingPassword1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-lock me-3" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
              </svg>Hasło</label>
            </div>


            <div class="form-floating mb-3">
              <input type="password" name="password2" class="form-control rounded-3" id="password2" placeholder="Password"
              <?php 
              if (isset($_SESSION['formPassword2']))
              {
                echo 'value="'.htmlspecialchars($_SESSION['formPassword2']).'"';
                unset($_SESSION['formPassword2']);
              } ?>>
              <label for="floatingPassword2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-lock me-3" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
              </svg>Powtórz hasło</label>
            </div>

            <?php
          if (isset($_SESSION['errorPassword']))
            {
              echo '<div class="error">'.$_SESSION['errorPassword'].'</div>';
              unset($_SESSION['errorPassword']);
            }
            ?>


            <button class="w-100 py-3 mb-2 btn btn-brown rounded-3" type="submit" name="submitRegister">Zarejestruj się</button>
            
          

          </form>
        </div>
      </div>
    </div>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="register.js"></script>
</body>
</html>