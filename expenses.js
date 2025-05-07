document.addEventListener("DOMContentLoaded", () => {
  const dateInput = document.getElementById("date");
  if (dateInput) {
    const today = new Date().toISOString().split("T")[0];
    dateInput.value = today;
  }

  const expenseForm = document.querySelector("form");
  if (expenseForm) {
    expenseForm.addEventListener("submit", (e) => {
      

      const amount = document.getElementById("amount")?.value;
      const date = document.getElementById("date")?.value;
      const category = document.getElementById("category")?.value;
      const payment = document.getElementById("payment")?.value;
      const comment = document.getElementById("comment")?.value;

      if (!amount || !date || !category || !payment) return;

      const newExpense = {
        amount: parseFloat(amount),
        date,
        category,
        payment,
        comment
      };

      
      const existingExpenses = JSON.parse(localStorage.getItem("expenses")) || [];
      existingExpenses.push(newExpense);
      localStorage.setItem("expenses", JSON.stringify(existingExpenses));

      
    });
  }
});
