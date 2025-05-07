document.addEventListener("DOMContentLoaded", () => {
  const dateInput = document.getElementById("date");
  if (dateInput) {
    const today = new Date().toISOString().split("T")[0];
    dateInput.value = today;
  }

  const incomeForm = document.querySelector("form");
  if (incomeForm) {
    incomeForm.addEventListener("submit", (e) => {
    

      const amount = document.getElementById("amount")?.value;
      const date = document.getElementById("date")?.value;
      const category = document.getElementById("category")?.value;
      const comment = document.getElementById("comment")?.value;

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

      
    });
  }
});