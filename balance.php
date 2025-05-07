<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['userId'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['userId'];

// Domyślny zakres dat
$dateRange = $_POST['dateRange'] ?? 'current';

switch ($dateRange) {
    case 'previous':
        $startDate = date('Y-m-01', strtotime('first day of last month'));
        $endDate = date('Y-m-t', strtotime('last day of last month'));
        break;
    case 'year':
        $startDate = date('Y-01-01');
        $endDate = date('Y-12-31');
        break;
    case 'custom':
        $startDate = $_POST['start_date'] ?? date('Y-m-01');
        $endDate = $_POST['end_date'] ?? date('Y-m-t');
        break;
    case 'current':
    default:
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');
        break;
}

// Przychody
$incomeSql = "SELECT iatuc.name AS category, SUM(i.amount) AS total
              FROM incomes i
              JOIN incomes_category_assigned_to_users iatuc ON i.income_category_assigned_to_user_id = iatuc.id
              WHERE i.user_id = ? AND date_of_income BETWEEN ? AND ?
              GROUP BY iatuc.name
              ORDER BY total DESC;
";

$incomeStmt = $conn->prepare($incomeSql);
$incomeStmt->bind_param("iss", $userId, $startDate, $endDate);
$incomeStmt->execute();
$incomeResult = $incomeStmt->get_result();
$incomes = $incomeResult->fetch_all(MYSQLI_ASSOC);

// Wydatki
$expenseSql = "SELECT eatuc.name AS category, SUM(e.amount) AS total
                FROM expenses e
                JOIN expenses_category_assigned_to_users eatuc ON e.expense_category_assigned_to_user_id = eatuc.id
                WHERE e.user_id = ? AND date_of_expense BETWEEN ? AND ?
                GROUP BY eatuc.name
                ORDER BY total DESC;";

$expenseStmt = $conn->prepare($expenseSql);
$expenseStmt->bind_param("iss", $userId, $startDate, $endDate);
$expenseStmt->execute();
$expenseResult = $expenseStmt->get_result();
$expenses = $expenseResult->fetch_all(MYSQLI_ASSOC);

// Bilans
$sumIncome = array_sum(array_column($incomes, 'total'));
$sumExpense = array_sum(array_column($expenses, 'total'));
$balance = $sumIncome - $sumExpense;
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
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

<!-- Główna zawartość strony balance.php -->
<div class="centered-container rounded-3">
        <h2 class="text-white mb-4 text-center">Bilans przychodów i wydatków</h2>

        <form method="post" id="dateFilterForm" class="mb-4">
            <label for="dateRange" class="form-label">Zakres dat:</label>
            <select id="dateRange" name="dateRange" class="form-select mb-3">
                <option value="current" <?= $dateRange === 'current' ? 'selected' : '' ?>>Bieżący miesiąc</option>
                <option value="previous" <?= $dateRange === 'previous' ? 'selected' : '' ?>>Poprzedni miesiąc</option>
                <option value="year" <?= $dateRange === 'year' ? 'selected' : '' ?>>Bieżący rok</option>
                <option value="custom" <?= $dateRange === 'custom' ? 'selected' : '' ?>>Niestandardowy</option>
            </select>

            <div id="customDateRange" style="<?= $dateRange === 'custom' ? 'display: block;' : 'display: none;' ?>">
                <label for="startDate" class="form-label">Od:</label>
                <input type="date" id="startDate" name="start_date" class="form-control mb-3" value="<?= htmlspecialchars($startDate) ?>">

                <label for="endDate" class="form-label">Do:</label>
                <input type="date" id="endDate" name="end_date" class="form-control mb-3" value="<?= htmlspecialchars($endDate) ?>">
            </div>

            <button type="submit" class="btn btn-brownish w-100">Filtruj</button>
        </form>

        <h4 class="mt-5">Przychody:</h4>
        <?php if (!empty($incomes)): ?>
            <table class="table table-bordered table-dark">
                <thead>
                    <tr>
                        <th>Kategoria</th>
                        <th>Kwota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($incomes as $income): ?>
                        <tr>
                            <td><?= htmlspecialchars($income['category']) ?></td>
                            <td><?= number_format($income['total'], 2, ',', ' ') ?> zł</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Brak przychodów w wybranym okresie.</p>
        <?php endif; ?>

        <h4 class="mt-5">Wydatki:</h4>
        <?php if (!empty($expenses)): ?>
            <table class="table table-bordered table-dark">
                <thead>
                    <tr>
                        <th>Kategoria</th>
                        <th>Kwota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($expenses as $expense): ?>
                        <tr>
                            <td><?= htmlspecialchars($expense['category']) ?></td>
                            <td><?= number_format($expense['total'], 2, ',', ' ') ?> zł</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Brak wydatków w wybranym okresie.</p>
        <?php endif; ?>

        <h4 class="mt-5">Bilans:</h4>
        <p class="fs-4"><?= number_format($balance, 2, ',', ' ') ?> zł</p>
        <p class="fs-6 fw-bold">
            <?= $balance >= 0
                ? 'Gratulacje. Świetnie zarządzasz finansami!'
                : 'Uważaj, wpadasz w długi!' ?>
        </p>
    </div>
</div></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="balance.js"></script>

</body>
</html>
