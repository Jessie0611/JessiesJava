function showMenu() {
    const menu = {
        hotLattes: [
            { name: "Caramel Latte", price: " $4.50" },
            { name: "Chai Latte", price: "$4.50" },
            { name: "Cinnamon Latte", price: "$4.50" },
            { name: "Hazelnut Latte", price: " $4.50" },
            { name: "Lavender Latte", price: " $4.50" },
            { name: "Matcha Latte", price: " $4.50" },
            { name: "Pistachio Latte", price: " $4.50" },
            { name: "Pumpkin Spice Latte", price: " $4.50" },
            { name: "Vanilla Latte", price: " $4.50" }



        ],
        icedLattes: [
            { name: "Iced Caramel Latte", price: "$5.00" },
            { name: "Iced Chai Latte", price: "$5.00" },
            { name: "Iced Hazelnut Latte", price: "$5.00" },
            { name: "Iced Honey Lavender Latte", price: " $5.00" },
            { name: "Iced Matcha Latte", price: " $5.00" },
            { name: "Iced Pistachio Latte", price: " $5.00" },
            { name: "Iced Pumpkin Spice Latte", price: " $5.00" },
            { name: "Iced Vanilla Latte", price: "$5.00"}

        ],
        hotEspresso: [
            { name: "Americano", price: "$3.00" },
            { name: "Affogato", price: "$3.00" },
            { name: "Cappuccino", price: "$3.50" },
            { name: "Cortado", price: "$3.50" },
            { name: "Espresso", price: "$2.50" },
        ],
        icedEspresso: [
            { name: "Iced Americano", price: "$3.30" },
            { name: "Iced Cappuccino", price: "$3.80" },
            { name: "Iced Cortado", price: "$3.80" },
            { name: "Iced Espresso", price: "$2.80" },
            { name: "Iced Nitro Cold Brew", price: "$4.00" },

        ]
    };
    const selectedType = document.getElementById("drinkType").value;
    const menuContainer = document.getElementById("menu");

    menuContainer.innerHTML = ""; // Clear previous menu

    if (selectedType) {
        const drinks = menu[selectedType];
        const sectionTitle = selectedType.replace(/([A-Z])/g, ' $1').toUpperCase(); // Capitalize words
        menuContainer.innerHTML = `<h3>${sectionTitle}</h3>`;
        
        drinks.forEach(drink => {
            const drinkElement = document.createElement("div");
            drinkElement.classList.add("menu-item");
            drinkElement.innerHTML = `${drink.name} - <span>${drink.price}</span>`;
            menuContainer.appendChild(drinkElement);
        });
    }
}

//CALANDER
document.addEventListener('DOMContentLoaded', function() {
    const monthYearDisplay = document.getElementById('month-year');
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');
    const calendarBody = document.querySelector('#calendar tbody');
    const eventsList = document.getElementById('events-list');
  
    let currentDate = new Date();
    
    const events = [
      { date: '2025-03-17', title: 'St. Patricks Day: $1.00 Irish Cream Lattes all day' },
      { date: '2025-03-29', title: 'Peer Code Review: Clean Code Practices [10:00a.m - 6:00p.m]' },
      { date: '2025-04-11', title: 'Code Breaker Trivia: Test Your Developer Knowledge! [4:00p.m - 8:00p.m.]' },
    ];
  
    function renderCalendar() {
      const year = currentDate.getFullYear();
      const month = currentDate.getMonth();
      monthYearDisplay.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;
      
      // Clear previous calendar
      calendarBody.innerHTML = '';
  
      // Get the first day of the month
      const firstDay = new Date(year, month, 1);
      const lastDay = new Date(year, month + 1, 0);
      const startDay = firstDay.getDay();
      const totalDays = lastDay.getDate();
      
      let day = 1;
  
      // Create the calendar grid
      for (let i = 0; i < 6; i++) { // 6 rows to cover all weeks
        const row = document.createElement('tr');
        for (let j = 0; j < 7; j++) {
          const cell = document.createElement('td');
          if (i === 0 && j < startDay) {
            cell.textContent = '';
          } else if (day <= totalDays) {
            const cellDate = new Date(year, month, day);
            const dateString = cellDate.toISOString().split('T')[0];
            cell.textContent = day;
            cell.dataset.date = dateString;
  
            // Highlight days with events
            const eventForDay = events.filter(event => event.date === dateString);
            if (eventForDay.length > 0) {
              cell.style.backgroundColor = '#b0907b';
              cell.title = eventForDay.map(event => event.title).join(', ');
            }
  
            // Add click event to show events for that date
            cell.addEventListener('click', () => showEventsForDate(dateString));
            
            day++;
          }
          row.appendChild(cell);
        }
        calendarBody.appendChild(row);
      }
    }
  
    function showEventsForDate(date) {
      const eventForDate = events.filter(event => event.date === date);
      eventsList.innerHTML = '';
      if (eventForDate.length > 0) {
        eventForDate.forEach(event => {
          const li = document.createElement('li');
          li.textContent = `${event.title} - ${event.date}`;
          eventsList.appendChild(li);
        });
      } else {
        eventsList.innerHTML = '<li>No events for this day.</li>';
      }
    }
  
    function renderUpcomingEvents() {
      const today = new Date();
      const upcomingEvents = events.filter(event => new Date(event.date) > today);
  
      eventsList.innerHTML = '';
      upcomingEvents.forEach(event => {
        const li = document.createElement('li');
        li.textContent = `${event.title} - ${event.date}`;
        eventsList.appendChild(li);
      });
    }
  
    // Event listeners for buttons
    prevMonthBtn.addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() - 1);
      renderCalendar();
    });
  
    nextMonthBtn.addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() + 1);
      renderCalendar();
    });
  
    // Initial render
    renderCalendar();
    renderUpcomingEvents();
  });
  