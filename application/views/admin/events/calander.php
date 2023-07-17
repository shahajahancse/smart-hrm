
  <!-- TOAST UI Calendar CSS -->
  <link rel="stylesheet" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />

  <!-- TOAST UI Calendar JavaScript dependencies -->
  <script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.min.js"></script>
  <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
  <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>

  <!-- TOAST UI Calendar JavaScript -->
  <script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>


  <!-- Year and month selection -->
  <label for="year">Year:</label>
  <select id="year"></select>

  <label for="month">Month:</label>
  <select id="month"></select>

  <!-- Navigation buttons -->
  <button id="prevBtn">←</button>
  <button id="nextBtn">→</button>

  <!-- Calendar container -->
  <div id="calendar"></div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Get current year and month
      const currentDate = new Date();
      let currentYear = currentDate.getFullYear();
      let currentMonth = currentDate.getMonth() + 1; // January is month 0

      // Function to update the calendar based on the selected year and month
      function updateCalendar() {
        const selectedYear = parseInt(document.getElementById("year").value);
        const selectedMonth = parseInt(document.getElementById("month").value);

        calendar.setDate(new Date(selectedYear, selectedMonth - 1, 1));
        calendar.changeView("month", true);
      }

      // Populate year dropdown with options
      const yearDropdown = document.getElementById("year");
      for (let year = currentYear - 5; year <= currentYear + 5; year++) {
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        if (year === currentYear) {
          option.selected = true;
        }
        yearDropdown.appendChild(option);
      }

      // Populate month dropdown with options
      const monthDropdown = document.getElementById("month");
      for (let month = 1; month <= 12; month++) {
        const option = document.createElement("option");
        option.value = month;
        option.textContent = new Date(currentYear, month - 1, 1).toLocaleString('default', { month: 'long' });
        if (month === currentMonth) {
          option.selected = true;
        }
        monthDropdown.appendChild(option);
      }

      // Initialize the calendar with the current year and month
      const calendar = new tui.Calendar("#calendar", {
        defaultView: "month",
        useDetailPopup: true,
      });

      // Update the calendar when a new year or month is selected
      yearDropdown.addEventListener("change", updateCalendar);
      monthDropdown.addEventListener("change", updateCalendar);

      // Handle navigation with arrow buttons
      const prevBtn = document.getElementById("prevBtn");
      const nextBtn = document.getElementById("nextBtn");

      prevBtn.addEventListener("click", function () {
        const prevDate = new Date(calendar.getDate().getTime());
        prevDate.setMonth(prevDate.getMonth() - 1);
        const prevYear = prevDate.getFullYear();
        const prevMonth = prevDate.getMonth() + 1;
        yearDropdown.value = prevYear;
        monthDropdown.value = prevMonth;
        updateCalendar();
      });

      nextBtn.addEventListener("click", function () {
        const nextDate = new Date(calendar.getDate().getTime());
        nextDate.setMonth(nextDate.getMonth() + 1);
        const nextYear = nextDate.getFullYear();
        const nextMonth = nextDate.getMonth() + 1;
        yearDropdown.value = nextYear;
        monthDropdown.value = nextMonth;
        updateCalendar();
      });

      // Fetch holidays and events from CI controller using AJAX
      fetchHolidaysAndEvents();

      function fetchHolidaysAndEvents() {
        // Make an AJAX request to your CI controller to get the data
        // Adjust the URL to the actual URL of your CI controller that provides the data
        fetch("<?= base_url( 'admin/events/data')?>")
          .then(response => response.json())
          .then(data => {
            // Add the fetched holidays and events to the calendar
            console.log(data);
            calendar.createSchedules(data);
          })
          .catch(error => {
            console.error("Error fetching data:", error);
          });
      }
    });
  </script>

