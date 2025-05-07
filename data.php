

<?php

session_start();

if ((!isset($_POST['emailLogin'])) || (!isset($_POST['passwordLogin'])))
{
  header('Location: login.php');
  exit();
}


require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

try{
$connection = new mysqli($host, $db_user, $db_password, $db_name);

  if($connection->connect_errno!=0)
  {
  throw new Exception(mysqli_connect_errno());
  }
  else
  {
  $login = $_POST['emailLogin'];
  $password = $_POST['passwordLogin'];

  $login = htmlentities($login, ENT_QUOTES, "UTF-8");

    if($result = $connection->query(
    sprintf("SELECT * FROM users WHERE email='%s'",
    mysqli_real_escape_string($connection, $login))))
    {
    $userCount = $result->num_rows;

      if($userCount>0){

    
      $row = $result->fetch_assoc();

        if(password_verify($password, $row['password']))
        {

        $_SESSION['isLogged'] = true;
        $_SESSION['userId'] = $row['id'];
        $_SESSION['userName'] = $row['username'];
        $_SESSION['userPassword'] = $row['password'];
        $_SESSION['userMail'] = $row['email'];

        unset($_SESSION['error']);
        $result->close();
        header('Location: menu.php');
        }
        else
        {

          $_SESSION['error'] = '<span style="color:red; font-size:1.2rem">Nieprawidłowy login lub hasło!</span>';
          header('Location:login.php');
        }
      } else{

      $_SESSION['error'] = '<span style="color:red; font-size:1.2rem">Nieprawidłowy login lub hasło!</span>';
      header('Location:login.php');
      }
    }

      else{
      throw new Exception($connection->error);
      }   
  
    $connection->close();
  } 
}
catch(Exception $error)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
		echo '<br />Informacja developerska: '.$error;
	}



?>
