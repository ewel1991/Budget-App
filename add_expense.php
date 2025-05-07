<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['userId'];
    $amount = $_POST['amount'];
    $date_of_expense = $_POST['date'];
    $category_name = $_POST['category'];
    $payment_method_name = $_POST['payment'];
    $expense_comment = $_POST['comment'];

    // Pobierz ID kategorii wydatku przypisanej do użytkownika
    $stmt = $conn->prepare("SELECT id FROM expenses_category_assigned_to_users WHERE user_id = ? AND name = ?");
    $stmt->bind_param("is", $user_id, $category_name);
    $stmt->execute();
    $category_result = $stmt->get_result();

    if ($category_result->num_rows === 0) {
        echo "Nie znaleziono przypisanej kategorii wydatków.";
        exit();
    }

    $expense_category_id = $category_result->fetch_assoc()['id'];
    $stmt->close();

    // Pobierz ID metody płatności przypisanej do użytkownika
    $stmt = $conn->prepare("SELECT id FROM payment_methods_assigned_to_users WHERE user_id = ? AND name = ?");
    $stmt->bind_param("is", $user_id, $payment_method_name);
    $stmt->execute();
    $payment_result = $stmt->get_result();

    if ($payment_result->num_rows === 0) {
        echo "Nie znaleziono przypisanej metody płatności.";
        exit();
    }

    $payment_method_id = $payment_result->fetch_assoc()['id'];
    $stmt->close();

    // Zapisz wydatek do bazy danych
    $stmt = $conn->prepare("INSERT INTO expenses (user_id, expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiidss", $user_id, $expense_category_id, $payment_method_id, $amount, $date_of_expense, $expense_comment);

    if ($stmt->execute()) {
        header("Location: balance.php");
        exit();
    } else {
        echo "Błąd podczas dodawania wydatku: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
