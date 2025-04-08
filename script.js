//MENU select
function showMenu() {
  const menu = {
      hotLattes: [
        { name: "Caramel Cache", price: "$4.50", description: "As smooth as your final commit — buttery caramel that refactors your mood." },
        { name: "Cinnamon Command", price: "$4.50", description: "That legacy warmth with just the right spice — perfect for long coding sessions." },
        { name: "Hazelnut Hack", price: "$4.50", description: "Nutty notes for devs running on edge cases — classic, dependable, never deprecated." },
        { name: "Lavender Logic", price: "$4.50", description: "Soothing syntax for the overworked coder — calm commits start here." },
        { name: "Pistachio Node", price: "$4.50", description: "A little extra, like that one plugin you *don’t* need but love anyway." },
        { name: "Pumpkin Spice Stack ", price: "$4.50", description: "The seasonal pull request nobody asked for, but everybody approves." },
        { name: "SQL Syrup Latte", price: "$3.50", description: "Vanilla bean latte with structured sweetness — perfectly joined flavors that always return results." },
       
      ],
      icedLattes: [
        { name: "Iced Caramel Cache", price: "$5.00", description: "Your front-end may be sweet, but this buttery caramel espresso is smoother than your CSS transitions." },
        { name: "Iced Hazelnut Hack", price: "$5.00", description: "Nutty, chill, and full of flavor — like that one guy who pushes to main on Friday." },
        { name: "Iced Honey Lavender Logic", price: "$5.00", description: "For the full-stack dev with soft energy and sharp code — floral notes with a sweet calming finish." },
        { name: "Iced Pistachio Node", price: "$5.00", description: "Nutty, niche, and slightly unexpected — like using Notepad++ instead of VS Code." },
        { name: "Iced Pumpkin Spice Stack ", price: "$5.00", description: "Because even hardcore devs deserve seasonal flavor. PSL: Preferred Syntax Latte." },
        { name: "Iced SQL Syrup Latte", price: "$5.00", description: "Vanilla bean latte with structured sweetness — perfectly chilled and joined flavors that always return results."  }
      ],
      hotEspresso: [
        { name: "Americano", price: "$3.00", description: "Espresso with hot water — pure and strong, like your cleanest code." },
        { name: "Affogato", price: "$3.00", description: "Espresso poured over vanilla ice cream — the perfect crash course in sweet indulgence." },
        { name: "Boolean Buzz", price: "$3.50", description: "Half coffee, half energy drink — a true/false way to stay up coding all night. Use with caution. May cause unexpected behavior." },
        { name: "Caffeinated Compiler", price: "$3.50", description: "Iced dark roast with a shot of hazelnut and oat milk — processes smoothly and never throws errors (unless you skip breakfast)." },
        { name: "Cappuccino", price: "$3.50", description: "A perfect balance of espresso, steamed milk, and foam — like your workflow: smooth and efficient." },
        { name: "CoffeeScript Cream", price: "$3.50", description: "Caramel cold brew topped with sweet foam — clean, lightweight, and prettier than it should be. Unlike the real CoffeeScript." },
        { name: "Cortado", price: "$3.50", description: "Equal parts espresso and milk, no distractions — for developers who like their code clean and simple." },
        { name: "Debugger", price: "$3.50", description: "Espresso + mint + dark chocolate. Cuts through brain fog like stepping through breakpoints." },
        { name: "Git Push Pull", price: "$3.50", description: "Classic mocha with an extra dark twist — sync up your energy levels whether you’re merging branches or merging deadlines." },
        { name: "JavaScript Jolt", price: "$2.50", description: "A bold espresso shot with a citrusy finish — perfect for asynchronous minds who love event loops and coffee loops." },
        { name: "Stack Overflow", price: "$3.00", description: "Triple espresso layered with vanilla cream and cinnamon — like your brain at 3AM: overloaded, but delicious." }
      ],
      icedEspresso: [
        { name: "Iced Americano", price: "$3.30", description: "Chilled espresso, cool and simple — the MVP for fast debugging." },
        { name: "Iced Cappuccino", price: "$3.80", description: "A refreshing chill on a classic — espresso, cold milk, and foam, for when the code is heating up." },
        { name: "Cool Commit", price: "$2.80", description: "Pure espresso, iced down for the coder on the go. Sometimes less is more." },
        { name: "Iced Nitro Node", price: "$4.00", description: "Supercharged cold brew — nitrogen-infused for a smooth, creamy finish. Perfect for staying up through code sprints." }
      ],
      teaOptions: [
        { name: "Bug-Free Brew", price: "$3.50", description: "Chamomile and lavender tea latte — for when you finally squash that last bug and deserve some serenity." },
        { name: "Hot Chai Latte", price: "$4.50", description: "Spiced like your debugging rants — cozy, bold, and full of complex flavor." },
        { name: "Iced Chai Latte", price: "$5.00", description: "A perfectly spiced brew, ideal for when your code is compiling, but you need a little more chill." },
        { name: "Hot Matcha Latte", price: "$4.50", description: "Green-powered like your clean energy hosting — focused, balanced, and sharp." },
        { name: "Iced Matcha Latte", price: "$5.00", description: "Chilled matcha and milk — a refreshing, energizing drink to power through your tasks." },
      ]
  };
    const selectedType = document.getElementById("drinkType").value;
    const menuContainer = document.getElementById("menu");
    menuContainer.innerHTML = ""; // Clear previous menu

    if (selectedType) {
        const drinks = menu[selectedType];
        const sectionTitle = selectedType.replace(/([A-Z])/g, ' $1').toUpperCase(); // Capitalize words
        menuContainer.innerHTML = `<h2>${sectionTitle}</h2>`;      
        drinks.forEach(drink => {
            const drinkElement = document.createElement("div");
            drinkElement.classList.add("menu-item");
            drinkElement.innerHTML = `
              <strong>${drink.name}</strong> - <span>${drink.price}</span>
              <p class="menu-desc">${drink.description || ""}</p>
            `;
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
let currentDate = new Date();
//events
const events = [
{ date: '2025-03-29', title: 'March 29 @ 11a - 7p: Peer Code Review: Clean Code Practices'},
{ date: '2025-04-01', title: 'April 1: April Fools Mystery Coffee $1.00'},
{ date: '2025-04-11', title: 'April 11 @ 4p - 9p: CodeBreaker Trivia: Test Your Dev Knowledge!'},
{ date: '2025-04-20', title: 'April 20: CLOSED FOR EASTER SUNDAY! Take a screen break :) '},
{ date: '2025-05-04', title: 'May 4: May the 4th be with you! Star Wars Latte art!'},
{ date: '2025-05-05', title: 'May 5: Cinco de Mayo: Café de Olla TODAY ONLY $5'},
{ date: '2025-06-11', title: 'June 11: ☕Bugs & Beans: A Code & Coffee Birthday Bash! Code & Chill Lounge Open all day'},
{ date: '2025-06-11', title: 'Fix the Bug Challenge, Latte Art Showdown 6A-6P, Coffee+Code Trivia 6p-8p -Swag Giveaway'},
{ date: '2025-06-19', title: 'June 19: Juneteenth Art: Commemorate the emancipation of enslaved people in the US.'},
{ date: '2025-06-20', title: 'June 20: Summer Solistice: Create digital art inspired by the solistice.'},
{ date: '2025-07-04', title: 'July 4: CLOSED FOR 4TH OF JULY! Take a screen break! :) '}
];

if (monthYearDisplay && prevMonthBtn && nextMonthBtn && calendarBody) {
  let currentDate = new Date();
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
    const eventsList = document.getElementById('events-list');
    if (!eventsList) return;

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

  prevMonthBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
  });

  nextMonthBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
  });

  renderCalendar();
}
  function renderUpcomingEvents() {
    const today = new Date();
    const upcomingEvents = events.filter(event => new Date(event.date) > today);
  
    const eventsList = document.getElementById('events-list');
    if (!eventsList) return;
  
    eventsList.innerHTML = '';
    upcomingEvents.forEach(event => {
      const li = document.createElement('li');
      li.textContent = event.title;
      eventsList.appendChild(li);
    });
  }
  
  document.addEventListener('DOMContentLoaded', renderUpcomingEvents);
  document.addEventListener('DOMContentLoaded', function () {
    // All your DOM-related code here:
    
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');
  
    if (prevMonthBtn) {
      prevMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
      });
    }
  
    if (nextMonthBtn) {
      nextMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
      });
    }
  
  });
  
renderUpcomingEvents();


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