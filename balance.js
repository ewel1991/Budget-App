document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("dateFilterForm");
  const dateRange = document.getElementById("dateRange");
  const customDateSection = document.getElementById("customDateRange");
  const startInput = document.getElementById("startDate");
  const endInput = document.getElementById("endDate");

  if (!form || !dateRange || !customDateSection || !startInput || !endInput) {
   
    return;
  }

  function toggleCustomDateFields() {
    if (dateRange.value === "custom") {
      customDateSection.style.display = "block";
    } else {
      customDateSection.style.display = "none";
    }
  }

  toggleCustomDateFields();

  dateRange.addEventListener("change", toggleCustomDateFields);

  form.addEventListener("submit", function (e) {
    if (dateRange.value === "custom") {
      const start = startInput.value;
      const end = endInput.value;

      if (!start || !end) {
        e.preventDefault();
        alert("Proszę uzupełnić obie daty w zakresie niestandardowym.");
        return;
      }

      if (start > end) {
        e.preventDefault();
        alert("Data początkowa nie może być późniejsza niż końcowa.");
      }
    }
  });
});
