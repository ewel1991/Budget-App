document.addEventListener("DOMContentLoaded", function () {
  const dateInput = document.getElementById("date");
  if (dateInput) {
    const today = new Date().toISOString().split("T")[0];
    dateInput.value = today;
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const periodSelect = document.getElementById("periodSelect");
  const customDateRange = document.getElementById("customDateRange");

  periodSelect.addEventListener("change", function () {
    if (periodSelect.value === "custom") {
      customDateRange.style.display = "block";
    } else {
      customDateRange.style.display = "none";
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const incomeForm = document.querySelector("form");

  if (incomeForm) {
    incomeForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const amount = document.getElementById("amount").value;
      const date = document.getElementById("date").value;
      const category = document.getElementById("category").value;
      const comment = document.getElementById("comment").value;

      if (!amount || !date || !category) return;

      const newIncome = {
        amount: parseFloat(amount),
        date,
        category,
        comment
      };

      const existingIncomes = JSON.parse(localStorage.getItem("incomes")) || [];
      existingIncomes.push(newIncome);
      localStorage.setItem("incomes", JSON.stringify(existingIncomes));

      window.location.href = "balance.html";
    });
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const incomeTable = document.querySelector("#incomeTableBody");
  const expenseTable = document.querySelector("#expenseTableBody");
  const balanceHeader = document.querySelector("#balanceAmount");
  const totalIncomeElement = document.getElementById("totalIncome");
  const totalExpenseElement = document.getElementById("totalExpense");

  // Obliczenie i wyświetlenie danych przychodów
  if (incomeTable) {
    const incomes = JSON.parse(localStorage.getItem("incomes")) || [];
    let totalIncome = 0;

    incomeTable.innerHTML = ""; // Wyczyść tabelę przed dodaniem nowych danych

    incomes.forEach(income => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${income.category}</td>
        <td>${income.amount.toFixed(2)} PLN</td>
      `;
      incomeTable.appendChild(row);
      totalIncome += income.amount;
    });

    // Wyświetlenie sumy przychodów
    totalIncomeElement.textContent = `${totalIncome.toFixed(2)} PLN`;
  }

  // Obliczenie i wyświetlenie danych wydatków
  if (expenseTable) {
    const expenses = JSON.parse(localStorage.getItem("expenses")) || [];
    let totalExpense = 0;

    expenseTable.innerHTML = ""; // Wyczyść tabelę przed dodaniem nowych danych

    expenses.forEach(expense => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${expense.category}</td>
        <td>${expense.amount.toFixed(2)} PLN</td>
      `;
      expenseTable.appendChild(row);
      totalExpense += expense.amount;
    });

    // Wyświetlenie sumy wydatków
    totalExpenseElement.textContent = `${totalExpense.toFixed(2)} PLN`;
  }

  // Obliczenie bilansu
  if (balanceHeader) {
    const incomes = JSON.parse(localStorage.getItem("incomes")) || [];
    const expenses = JSON.parse(localStorage.getItem("expenses")) || [];

    const totalIncome = incomes.reduce((acc, income) => acc + income.amount, 0);
    const totalExpense = expenses.reduce((acc, expense) => acc + expense.amount, 0);

    const balance = totalIncome - totalExpense;
    balanceHeader.textContent = `Bilans: ${balance.toFixed(2)} PLN`;

    const balanceMessage = document.querySelector("#balanceMessage");
    if (balance > 0) {
      balanceMessage.textContent = "Gratulacje. Świetnie zarządzasz finansami!";
      balanceMessage.classList.add("text-success");
      balanceMessage.classList.remove("text-danger");
    } else if (balance < 0) {
      balanceMessage.textContent = "Uważaj! Twój bilans jest na minusie!";
      balanceMessage.classList.add("text-danger");
      balanceMessage.classList.remove("text-success");
    } else {
      balanceMessage.textContent = "Bilans wynosi zero!";
      balanceMessage.classList.remove("text-danger", "text-success");
    }
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const expenseForm = document.querySelector("form");

  if (expenseForm) {
    expenseForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const amount = document.getElementById("amount").value;
      const date = document.getElementById("date").value;
      const category = document.getElementById("category").value;
      const comment = document.getElementById("comment").value;

      if (!amount || !date || !category) return;

      const newExpense = {
        amount: parseFloat(amount),
        date,
        category,
        comment
      };

      const existingExpenses = JSON.parse(localStorage.getItem("expenses")) || [];
      existingExpenses.push(newExpense);
      localStorage.setItem("expenses", JSON.stringify(existingExpenses));

      window.location.href = "balance.html";
    });
  }
});
