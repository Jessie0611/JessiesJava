//MENU select
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
const monthYearDisplay = document.getElementById('month-year');
const prevMonthBtn = document.getElementById('prev-month');
const nextMonthBtn = document.getElementById('next-month');
const calendarBody = document.querySelector('#calendar tbody');
const eventsList = document.getElementById('events-list');

if (monthYearDisplay && prevMonthBtn && nextMonthBtn && calendarBody && eventsList) {
  let currentDate = new Date();
  const events = [
    // your events...
  ];

  function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    monthYearDisplay.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;
    calendarBody.innerHTML = '';
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDay = firstDay.getDay();
    const totalDays = lastDay.getDate();
    
    let day = 1;
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

          const eventForDay = events.filter(event => event.date === dateString);
          if (eventForDay.length > 0) {
            cell.style.backgroundColor = '#78ada5';
            cell.title = eventForDay.map(event => event.title).join(', ');
          }
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
        li.textContent = event.title;
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

  prevMonthBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
  });

  nextMonthBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
  });

  renderCalendar();
  renderUpcomingEvents();
}


//BREWGLE -- AI CHATBOT
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



//LIMIT RES TIME TO BUSINESS HOURS -1H FOR CLOSING
document.addEventListener('DOMContentLoaded', function() {
  const resDateInput = document.getElementById('resDate');
  const resTimeInput = document.getElementById('resTime');

  if (!resDateInput || !resTimeInput) return; // 🚫 Exit if not on reservation page

  const today = new Date().toISOString().split('T')[0];
  resDateInput.setAttribute('min', today);

  function updateTimeLimits() {
    if (!resDateInput.value) return;

    const selectedDate = new Date(resDateInput.value + "T00:00");
    const dayOfWeek = selectedDate.getUTCDay();

    let minTime = "06:00", maxTime = "22:00", timeMessage = "";

    switch (dayOfWeek) {
      case 0:
        minTime = "09:00";
        maxTime = "20:00";
        timeMessage = "9:00 a.m. - 8:00 p.m";
        break;
      case 1:
      case 2:
      case 3:
      case 4:
        minTime = "06:00";
        maxTime = "21:00";
        timeMessage = "6:00 a.m. - 9:00 p.m";
        break;
      case 5:
      case 6:
        minTime = "06:00";
        maxTime = "22:00";
        timeMessage = "6:00 a.m. - 10:00 p.m";
        break;
    }

    resTimeInput.setAttribute('min', minTime);
    resTimeInput.setAttribute('max', maxTime);

    if (resTimeInput.value && (resTimeInput.value < minTime || resTimeInput.value > maxTime)) {
      resTimeInput.value = "";
      alert(`Please select a time between ${timeMessage}.`);
    }
  }

  resDateInput.addEventListener('change', updateTimeLimits);
  resTimeInput.addEventListener('change', function () {
    const minTime = resTimeInput.getAttribute('min');
    const maxTime = resTimeInput.getAttribute('max');
    let timeMessage = ""; // You can define this here too if needed

    if (resTimeInput.value < minTime || resTimeInput.value > maxTime) {
      alert(`Please select a time between ${timeMessage}.`);
      resTimeInput.value = "";
    }
  });

  resDateInput.dispatchEvent(new Event('change'));
});

//DISCLOSURE ACCORDION
var acc = document.getElementsByClassName("accordionHeader");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}