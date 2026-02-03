document.addEventListener("alpine:init", () => {
    Alpine.data("filterLeedsTable", () => ({
      form: {
        dateRange: "",
        status: "",
        project: ""
      },
      errors: {},
      isFormSubmitted: false,
      filteredData: [],
  
      init() {
        flatpickr(document.getElementById("range-calendar"), {
          mode: "range",
          dateFormat: "Y-m-d",
          onChange: (selectedDates, dateStr) => {
            this.form.dateRange = dateStr;
          }
        });
      },
  
      validateDateRange(dateRange) {              
        const date = dateRange.split(" to ");
        return date.length !== 0 && date[0];
      },
      validateLeedStatus(status) {
        return true;
      },
      validateProject(project) {
        return true;
      },
  
      async handleSubmit(event) {
        event.preventDefault();
        this.isFormSubmitted = true;
  
        if (this.validateDateRange(this.form.dateRange) && this.validateLeedStatus(this.form.status) && this.validateProject(this.form.project)) {
          const [startDate, endDate] = this.form.dateRange.split(" to ");
          const status = this.form.status;
          const project = this.form.project;
  
          try {
            const response = await fetch("/api/leeds/filter", {
              method: "POST",
              headers: {
                "Content-Type": "application/json"
              },
              body: JSON.stringify({ startDate, endDate, status, project })
            });
  
            if (!response.ok) throw new Error("Failed to fetch data");
  
            const data = await response.json();
            this.filteredData = data; // Store returned data
            this.updateTable(); // Update table with new data
          } catch (error) {
            alert("An error occurred while fetching data.");
            console.error("Error:", error.message);
          }
        }
      },
  
      updateTable() {
        console.log("Update table")
      }
    }));
  });
  