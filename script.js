//MENU select
function showMenu() { //displays menu items, price, description via dropdown menu selection on menu page
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
        { name: "JavaScript Jolt", price: "$2.50", description:"A powerful espresso shot with a zesty citrus twist — energizing for those who thrive on callbacks and pushing async boundaries."},
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
        { name: "Hot Matcha Latte", price: "$4.50", description: "Green-powered like your clean energy hosting — focused, balanced, and sharp." },
        { name: "Iced Chai Latte", price: "$5.00", description: "A perfectly spiced brew, ideal for when your code is compiling, but you need a little more chill." },
        { name: "Iced Matcha Latte", price: "$5.00", description: "Chilled matcha and milk — a refreshing, energizing drink to power through your tasks." },
      ]
  };
    const selectedType = document.getElementById("drinkType").value; //Grabs the value of the <select> element with ID drinkType
    const menuContainer = document.getElementById("menu");//Gets the HTML element where the menu will be displayed (with ID menu).
    menuContainer.innerHTML = ""; // Clear previous menu

    if (selectedType) {//Checks if a drink type is selected.
        const drinks = menu[selectedType]; //uses the selected type to pull a corresponding array of drinks from menu object
        const sectionTitle = selectedType.replace(/([A-Z])/g, ' $1').toUpperCase();
         //^uses regex to add space before capitalize letter& convert entire string to upper, used as section header
        menuContainer.innerHTML = `<h2>${sectionTitle}</h2>`; //adds header to menu area     
        
        drinks.forEach(drink => { //Loops over each drink in the list.
            const drinkElement = document.createElement("div"); //Creates a new <div> for each drink with the class menu-item.
            drinkElement.classList.add("menu-item");
            drinkElement.innerHTML = `
              <strong>${drink.name}</strong> - <span>${drink.price}</span>  
              <p class="menu-desc">${drink.description || ""}</p>
            `;// Adds the drink’s name and price in bold. If description exists, shown — if not just blank ("").
            menuContainer.appendChild(drinkElement); //Appends each drink element to the menu so they appear on the page.
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
//This makes sure all the required HTML elements exist before the calendar logic runs:
if (monthYearDisplay && prevMonthBtn && nextMonthBtn && calendarBody) {
  let currentDate = new Date();  // Gets today's date

  function renderCalendar() {
    const year = currentDate.getFullYear();//extract year from  current date
    const month = currentDate.getMonth(); //extract month from current date
    monthYearDisplay.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`; 
    //^ Displays the current month and year like April 2025.
    calendarBody.innerHTML = '';
    
    //Building the Calendar Grid
    const firstDay = new Date(year, month, 1); //1st day of calander month
    const lastDay = new Date(year, month + 1, 0); //last dat of month
    const startDay = firstDay.getDay(); //Sun,Mon,Tues...
    const totalDays = lastDay.getDate();//how many days in the month?

    let day = 1;
    for (let i = 0; i < 6; i++) { //Creates up to 6 rows (weeks) in the calendar
      const row = document.createElement('tr');

      for (let j = 0; j < 7; j++) { //Each row gets 7 columns (Sunday to Saturday)
        const cell = document.createElement('td');
      
        if (i === 0 && j < startDay) {
          cell.textContent = '';
        } else if (day <= totalDays) { //The first row may have empty cells until the first day of the month, Then it starts filling in day numbers
          
          const cellDate = new Date(year, month, day); //Creates an ISO string like 2025-04-24 for comparing with events
          const dateString = cellDate.toISOString().split('T')[0];
          cell.textContent = day;
          cell.dataset.date = dateString; //Saves the date into a data-date attribute for reference

          const eventForDay = events.filter(event => event.date === dateString);
          if (eventForDay.length > 0) {
            cell.style.backgroundColor = '#78ada5'; //If any event matches this day, the cell is highlighted and gets a tooltip
            cell.title = eventForDay.map(event => event.title).join(', ');
          }
          cell.addEventListener('click', () => showEventsForDate(dateString)); //Adds a click listener that shows the events for that day
          day++;
        }
        row.appendChild(cell);
      }
      calendarBody.appendChild(row);
    }
  }

function showEventsForDate(date) { 
  const eventForDate = events.filter(event => event.date === date);
  const eventsList = document.getElementById('events-list'); //Finds all events for the clicked day
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
  } //Updates the event list or shows a "no events" message
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

//UPCOMING EVENT LIST
function renderUpcomingEvents() {
  const today = new Date();
  const upcomingEvents = events.filter(event => new Date(event.date) > today); //Filters events that are after today
  
  const eventsList = document.getElementById('events-list');
  if (!eventsList) return;
  eventsList.innerHTML = '';
  upcomingEvents.forEach(event => {
    const li = document.createElement('li');
    li.textContent = event.title;
    eventsList.appendChild(li);
  }); //Populates an upcoming events list
}
  
document.addEventListener('DOMContentLoaded', renderUpcomingEvents); //Ensures the upcoming events list loads when the page is ready


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


/*LIMIT RES TIME TO BUSINESS HOURS -1H FOR CLOSING
The code inside the DOMContentLoaded event handler ensures that the script runs after the HTML is loaded and parsed
It won't execute before the DOM is ready, so you won't run into issues with elements not being available yet*/
document.addEventListener('DOMContentLoaded', function() { 
  const resDateInput = document.getElementById('resDate');
  const resTimeInput = document.getElementById('resTime');

  if (!resDateInput || !resTimeInput) return; //Exit if not on reservation page

  const today = new Date().toISOString().split('T')[0]; 
  //.toISOString() convert the date and time to an ISO 8601 string format.
  //.split('T') method splits the ISO string at the character 'T', which separates the date and time parts.
  resDateInput.setAttribute('min', today);
//The resDate input's minimum date (min attribute) is set to today's date, meaning users cannot select a date in the past.

  function updateTimeLimits() { //function triggered when user changes date, first checks if a date is selected.
    if (!resDateInput.value) return;

    const selectedDate = new Date(resDateInput.value + "T00:00");
    const dayOfWeek = selectedDate.getUTCDay();
//converts into Date object and retrieves the day of the week (dayOfWeek), which is a number from 0 (Sunday) to 6 (Saturday).
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
  //The minimum and maximum time values are set for the resTime input element based on the selected date

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
var acc = document.getElementsByClassName("accordionHeader"); //accordionHeader—clickable headers
var i;

for (i = 0; i < acc.length; i++) { //Loops through each accordion header.
  acc[i].addEventListener("click", function() { //Adds a click event listener 
    this.classList.toggle("active"); //Toggles the active class 
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
function formatCardNumber(input) {
  // Remove all non-digit characters
  let cleaned = input.value.replace(/\D/g, '');
  // Group digits into chunks of 4
  let formatted = cleaned.match(/.{1,4}/g);
  // Join with a space
  input.value = formatted ? formatted.join(' ') : '';
}