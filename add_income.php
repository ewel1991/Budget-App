<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

// Połączenie z bazą danych
require_once 'connect.php';

// Sprawdzenie, czy formularz został wysłany
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pobranie danych z formularza
    $user_id = $_SESSION['userId'];  
    $amount = $_POST['amount'];  
    $date_of_income = $_POST['date'];  
    $category = $_POST['category'];  
    $income_comment = $_POST['comment'];  

    // Przygotowanie zapytania do sprawdzenia, czy użytkownik ma przypisaną kategorię
    $stmt = $conn->prepare("SELECT id FROM incomes_category_assigned_to_users WHERE user_id = ? AND name = ?");
    $stmt->bind_param("is", $user_id, $category);
    
    // Wykonanie zapytania
    $stmt->execute();
    
    // Pobranie wyników
    $result = $stmt->get_result();
    
    // Sprawdzanie, czy kategoria została przypisana
    if ($result->num_rows == 0) {
        echo "Nie znaleziono przypisanej kategorii dla użytkownika.<br>";
        echo "Sprawdź dostępne kategorie dla tego użytkownika.";
    } else {
        // Pobranie ID przypisanej kategorii
        $category_id = $result->fetch_assoc()['id'];
        
        // Kategoria została przypisana, więc dodajemy dochód
        $stmt = $conn->prepare("INSERT INTO incomes (user_id, income_category_assigned_to_user_id, amount, income_comment, date_of_income) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $user_id, $category_id, $amount, $income_comment, $date_of_income);
        
        if ($stmt->execute()) {
            // Po zapisaniu dochodu, przekieruj na stronę z bilansami
            header("Location: balance.php"); 
            exit();
        } else {
            echo "Błąd podczas dodawania dochodu: " . $stmt->error;
        }

        $stmt->close();
    }

    $stmt->close();
}

// Zamknięcie połączenia z bazą danych
$conn->close();
?>
