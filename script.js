

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
      { date: '2025-03-08', title: '11a-3p 3/8: International Womens Day Coffee Break, 1 free coffee any flavor'},
      { date: '2025-03-17', title: 'ALL DAY 3/17: St. Patricks Day: $1.00 Irish Cream Lattes '},
      { date: '2025-03-20', title: '[11a - 6p] Spring Equinox: Create digital art inspired by the equinox using programs like Photoshop, GIMP, or using a tablet to paint or draw.'},
      { date: '2025-03-29', title: '[11a - 6p] Peer Code Review: Clean Code Practices'},
      { date: '2025-04-01', title: 'ALL DAY 4/1: April Fools Mystery Coffee $1.00'},
      { date: '2025-04-11', title: '[4p - 8p] CodeBreaker Trivia: Test Your Dev Knowledge!'},
      { date: '2025-04-20', title: 'ALL DAY 4/20: CLOSED FOR EASTER SUNDAY'},
      { date: '2025-05-05', title: 'ALL DAY 5/5: Cinco de Mayo: Café de Olla TODAY ONLY $5'}

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
      for (let i = 0; i < 6; i++) { 
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
              cell.style.backgroundColor = '#78ada5';
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
        li.textContent = event.title; 
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
  
  function toggleChatbot() {
    var chatbot = document.getElementById("chatbotContainer");
    var button = document.getElementById("chatbotButton");
    if (chatbot.style.display === "none" || chatbot.style.display === "") {
      chatbot.style.display = "block";
      button.style.display = "none"; // Hide button when chatbot is open
    } else {
      chatbot.style.display = "none";
      button.style.display = "block"; // Show button when chatbot is closed
    }
  }

  document.querySelectorAll('.accordion-header').forEach(button => {
    button.addEventListener('click', () => {
        const isActive = button.classList.contains('active');
        
        // Close all accordions
        document.querySelectorAll('.accordion-header').forEach(item => {
            item.classList.remove('active');
        });
        document.querySelectorAll('.accordion-content').forEach(content => {
            content.style.display = 'none';
        });

        // Open the clicked one if it was not already active
        if (!isActive) {
            button.classList.add('active');
            button.nextElementSibling.style.display = 'block';
        }
    });
});

document.getElementById("agreeCheckbox").addEventListener("change", function() {
  let button = document.getElementById("continueButton");
  if (this.checked) {
      button.disabled = false;
      button.classList.add("enabled");
  } else {
      button.disabled = true;
      button.classList.remove("enabled");
  }
});
