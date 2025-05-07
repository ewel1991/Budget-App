<?php

	$host="localhost"; // Nazwa hosta
	$db_user="root"; // Nazwa uzytkownika mysql
	$db_password=""; // Haslo do bazy
	$db_name="budget"; // Nazwa bazy

// Połączenie z bazą danych
$conn = new mysqli($host, $db_user, $db_password, $db_name);

// Sprawdzanie połączenia
if ($conn->connect_errno) {
    die("Nie udało się połączyć z bazą danych: " . $conn->connect_error);
}





?>
